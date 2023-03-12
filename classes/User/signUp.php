<?php
Path::path_file_include(
	'Autoload',
	'Phpmailer_phpmailer_src_PHPMailer',
	'Phpmailer_phpmailer_src_Exception',
	'Phpmailer_phpmailer_src_OAuth',
	'Phpmailer_phpmailer_src_POP3',
	'Phpmailer_phpmailer_src_SMTP'
);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * 
 */
class SignUp
{
	private $db;
	private $fm;
	private $login;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
		$this->login = new SignIn();
	}
	//Nhớ chỉnh lại md5 password trong AdminSignUp và general

	//Thêm dữ liệu hoặc update vào bảng tbl_token_email
	private function insert_token_email($token_email_account)
	{
		$carbon = new Carbon\Carbon;
		$query = "SELECT * FROM tbl_token_email WHERE Token_Email_Account = '$token_email_account' LIMIT 1";
		$result = $this->db->select($query);
		$code = General::generateRandomString();
		$token_email_code = hash('haval256,5', $code) . md5(date('Y-m-d H:i:s'));

		if ($result) {
			$query = "UPDATE tbl_token_email SET Token_Email_Code = '$token_email_code' WHERE Token_Email_Account = '$token_email_account'";
			$this->db->update($query);
		} else {
			$token_email_date = $carbon->now();
			$query = "INSERT INTO tbl_token_email(Token_Email_Code , Token_Email_Account ,Token_Email_Date) VALUES('$token_email_code','$token_email_account' ,'$token_email_date')";
			$this->db->insert($query);
		}
	}

	public function sign_up($data)
	{
		$get_data = General::list_sql(
			$this->db->link,
			$data,
			[
				"customer_user", "customer_email", "customer_phone", "customer_address",
				"customer_password", "customer_login", "customer_status", "customer_date"
			]
		);

		eval($get_data);

		//Thêm dữ liệu vào bảng tbl_customer
		$query = "INSERT INTO tbl_customer(Customer_User , Customer_Email , Customer_Phone ,Customer_Address , Customer_Password , Customer_Login , Customer_Status, Customer_Date)
		VALUES('$customer_user','$customer_email','$customer_phone','$customer_address','$customer_password','$customer_login','$customer_status','$customer_date')";
		$this->db->insert($query);

		//Select
		$query = "SELECT * FROM tbl_customer WHERE Customer_User = '$customer_user' AND Customer_Email = '$customer_email' LIMIT 1";
		$result = $this->db->select($query);
		$result = $result->fetch_assoc();

		$this->insert_token_email($result['Customer_ID']);

		try {
			//Gửi mail xác nhận
			$this->sending_email($data['customer_user'], $data['customer_email'], $data['customer_address']);
		} catch (Throwable $e) {
			$query = "DELETE tbl_customer, tbl_token_email FROM tbl_customer, tbl_token_email 
				WHERE tbl_customer.Customer_ID = tbl_token_email.Token_Email_Account
				AND tbl_token_email.Token_Email_Account = " . $result['Customer_ID'];
			$this->db->delete($query);
			return "Đăng ký không thành công vì email chưa được gửi ! . Xin hãy thử kiểm tra lại tốc độ mạng của bạn";
		}

		// $this->login->login_admin($data["account_email"], md5("123"));
		return General::view('gui-mail-xac-nhan', true);
	}

	public function sending_email($to_name, $to_email, $to_address)
	{
		//Đưa biến env vào 
		$base_name = pathinfo(Path::path_file_local(""))["dirname"];
		$dotenv = Dotenv\Dotenv::createImmutable($base_name);
		$dotenv->load();

		$query = "SELECT tbl_customer.* ,tbl_token_email.* FROM tbl_customer
		INNER JOIN tbl_token_email ON tbl_token_email.Token_Email_Account = tbl_customer.Customer_ID
		WHERE Customer_Email = '$to_email' AND Customer_User = '$to_name' LIMIT 1";
		$result = $this->db->select($query);
		$result = $result->fetch_assoc();

		$mail = new PHPMailer(true);

		$mail->CharSet = "utf-8";
		$mail->isSMTP(); // Set mailer to use SMTP

		$content_body = file_get_contents(General::view_link('dinh-dang-thu-gui'));

		$setting = array(
			'%header%' => 'Xác nhận địa chỉ email',
			'%link_shop%' =>  General::view_link('dang-ky.html', true),
			'%link_button%' => General::view_link('mail-xac-nhan-thanh-cong?token=' . $result['Token_Email_Code'], true),
			'%link_show%' => General::view_link('mail-xac-nhan-thanh-cong?token=' . $result['Token_Email_Code'], true),
			'%link_image%' => 'https://i.pinimg.com/originals/fb/6b/8e/fb6b8e21e5a7c57b2d929b9d7f40c148.jpg',
			'%date%' => date('d-m-Y h:i:s'),
			'%to_name%' => $to_name,
			'%to_email%' => $to_email,
			'%to_address%' => $to_address,
		);

		$mail->Host = $_ENV['EMAIL_HOST'];
		$mail->SMTPAuth = true;
		$mail->Username = $_ENV['EMAIL_USERNAME'];
		$mail->Password = $_ENV['EMAIL_PASSWORD'];
		$mail->SMTPSecure = $_ENV['EMAIL_SMTP'];
		$mail->Port = $_ENV['EMAIL_PORT'];

		$mail->setFrom('nguyennhatlinh1711@gmail.com', 'Madara');    // Địa chỉ email và tên người gửi
		$mail->addAddress($to_email, $to_name);     // Địa chỉ người nhận
		$mail->isHTML(true); // Set email format to HTML
		$mail->Subject = 'Xác nhận mã kích hoạt';

		$mail->Body = strtr($content_body, $setting); // Nội dung

		$mail->send();
	}

	// Update thuoocjc tính status trong tbl_account
	// xóa token account trong bảng tbl_token_email
	private function update_account($id, $token)
	{
		$this->db->update("UPDATE tbl_customer SET Customer_Status = 1 WHERE Customer_ID = '$id'");
		$this->db->delete("DELETE FROM tbl_token_email WHERE Token_Email_Account = '$id' AND Token_Email_Code = '$token'");
	}

	public function check_token($token)
	{
		$query = "SELECT tbl_customer.* ,tbl_token_email.* FROM tbl_customer
		INNER JOIN tbl_token_email ON tbl_token_email.Token_Email_Account = tbl_customer.Customer_ID
		WHERE Token_Email_Code = '$token' LIMIT 1";
		$result = $this->db->select($query);

		if ($result) {
			$result = $result->fetch_assoc();
			$id = $result['Token_Email_Account'];
			$this->update_account($result['Token_Email_Account'], $token);

			//lấy giá trị Customer_Status sau khi cập nhật
			$query = "SELECT * FROM tbl_customer WHERE Customer_ID = " . $id . " LIMIT 1";
			$result = $this->db->select($query);
			$result = $result->fetch_assoc();

			if ($result['Customer_Status'] == 0) {
				$alert = "Email đã quá thời hạn xác nhận email. Xin hãy đăng ký lại địa chỉ email";
				$final = false;
			} else {
				$alert = "Email đăng ký thành công.";
				$final = true;
			}
		} else {
			$alert = "Mã xác nhận cho emai không đúng, xin nhập lại địa chỉ";
			$final = false;
		}
		return array('alert' => $alert, 'final' => $final);
	}
}
