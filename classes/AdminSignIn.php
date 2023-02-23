<?php
Path::path_file_include('Autoload');
const DEADLINE_EMAIL = 15; //thời hạn tồn tại của một token email xác nhận
/**
 * 
 */
class AdminSignIn
{
	private $db;
	private $fm;
	private $carbon;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
		$this->carbon = new Carbon\Carbon;
	}
	private function validate_email($id)
	{
		$query = "SELECT tbl_account.* ,tbl_token_email.* FROM tbl_account
		INNER JOIN tbl_token_email ON tbl_token_email.Token_Email_Account = tbl_account.Account_ID
		WHERE Token_Email_Account = '$id' LIMIT 1";

		$result = $this->db->select($query);
		if ($result) {
			$result = $result->fetch_assoc();
			$date = $this->carbon->parse($result['Token_Email_Date']);
			$now = $this->carbon->now();
			$result_date = $date->diffInMinutes($now);

			if ($result_date <= DEADLINE_EMAIL) {
				$alert = "Email của bạn chưa được kích hoạt. Xin hãy xác nhận email trước khi đăng nhập . Thời gian còn lại của email xác nhận là : " . (int)(DEADLINE_EMAIL - (int)$result_date) . " phút";
			} else {
				$alert = "Email kích hoạt của bạn đã hết hạn. Xin hãy đăng ký lại ! ";

				$query = "DELETE tbl_account, tbl_token_email FROM tbl_account, tbl_token_email 
				WHERE tbl_account.Account_ID = tbl_token_email.Token_Email_Account
				AND tbl_token_email.Token_Email_Account = '$id'";

				$this->db->delete($query);
			}
			return $alert;
		} else {
			return false;
		}
	}
	public function login_admin($accountEmail, $accountPassword)
	{
		$accountEmail = $this->fm->validation($accountEmail);
		$accountPassword = $this->fm->validation($accountPassword);

		$accountEmail = mysqli_real_escape_string($this->db->link, $accountEmail); // kết nối value email với csdl
		$accountPassword = mysqli_real_escape_string($this->db->link, $accountPassword); // kết nối value password với csdl

		if (empty($accountEmail) || empty($accountPassword)) {
			$alert = "Email hoặc mật khẩu không được bỏ trống";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_account WHERE Account_Email = '$accountEmail' AND Account_Password = '$accountPassword' LIMIT 1";
			$result = $this->db->select($query);
			if ($result != false) {

				$value = $result->fetch_assoc();
				$result_alert = $this->validate_email($value['Account_ID']);
				if ($result_alert) {
					$alert = $result_alert;
					return $alert;
				} else {
					Session::set('AdminLogin', true);

					Session::set('Admin_ID', $value['Account_ID']);
					Session::set('Admin_Email', $value['Account_Email']);
					Session::set('Admin_Name', $value['Account_Fullname']);

					General::view('trang-chu.html');
				}
			} else {
				$alert = "Email hoặc mật khẩu không đúng";
				return $alert;
			}
		}
	}
	public function login_admin_with_google($email, $name, $id)
	{
		$query = "SELECT * FROM tbl_account WHERE Account_User = '$id' LIMIT 1";
		$result = $this->db->select($query);
		if ($result) {
			$password = $result->fetch_assoc()['Account_Password'];
		} else {
			//Thêm dữ liệu vào bảng tbl_account
			$password =  hash('haval256,5', $id) . md5(date('Y-m-d H:i:s'));
			$query = "INSERT INTO tbl_account(Account_Fullname , Account_User , Account_Email , Account_Phone ,Account_Address , Account_Password , Account_Status , Created_At)
		VALUES('$name','$id' ,'$email','','','$password','','')";
			$this->db->insert($query);
		}
		$this->login_admin($email, $password);
	}
}
