<?php
Path::path_file_include('Autoload');
const DEADLINE_EMAIL = 15; //thời hạn tồn tại của một token email xác nhận
/**
 * 
 */
class SignIn
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
		$query = "SELECT tbl_customer.* ,tbl_token_email.* FROM tbl_customer
		INNER JOIN tbl_token_email ON tbl_token_email.Token_Email_Account = tbl_customer.Customer_ID
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

				$query = "DELETE tbl_customer, tbl_token_email FROM tbl_customer, tbl_token_email 
				WHERE tbl_customer.Customer_ID = tbl_token_email.Token_Email_Account
				AND tbl_token_email.Token_Email_Account = '$id'";

				$this->db->delete($query);
			}
			return $alert;
		} else {
			return false;
		}
	}
	public function login_admin($customerEmail, $customerPassword)
	{
		$customerEmail = $this->fm->validation($customerEmail);
		$customerPassword = $this->fm->validation($customerPassword);

		$customerEmail = mysqli_real_escape_string($this->db->link, $customerEmail); // kết nối value email với csdl
		$customerPassword = mysqli_real_escape_string($this->db->link, $customerPassword); // kết nối value password với csdl

		if (empty($customerEmail) || empty($customerPassword)) {
			$alert = "Email hoặc mật khẩu không được bỏ trống";
			return $alert;
		} else {
			$query = "SELECT * FROM tbl_customer WHERE Customer_Email = '$customerEmail' AND Customer_Password = '$customerPassword' LIMIT 1";
			$result = $this->db->select($query);
			if ($result != false) {
				$value = $result->fetch_assoc();
				$result_alert = $this->validate_email($value['Customer_ID']);
				if ($result_alert) {
					$alert = $result_alert;
					return $alert;
				} else {
					Session::set('CustomerLogin', true);

					Session::set('Customer_ID', $value['Customer_ID']);
					Session::set('Customer_Email', $value['Customer_Email']);
					Session::set('Customer_Name', $value['Customer_Fullname']);

					General::view('trang-chu.html', true);
				}
			} else {
				$alert = "Email hoặc mật khẩu không đúng";
				return $alert;
			}
		}
	}
}
