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
class Contact
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function exeContact()
	{
		try {
			// Gửi mail liên hệ
			$this->sending_email($_POST['contact_name'], $_POST['contact_email'], $_POST['contact_subject'], $_POST['contact_message']);
			return true;
		} catch (Throwable $e) {
			return false;
		}
	}

	private function sending_email($to_name, $to_email, $to_subject, $to_message)
	{
		//Đưa biến env vào 
		$base_name = pathinfo(Path::path_file_local(""))["dirname"];
		$dotenv = Dotenv\Dotenv::createImmutable($base_name);
		$dotenv->load();

		$mail = new PHPMailer(true);

		$mail->CharSet = "utf-8";
		$mail->isSMTP(); // Set mailer to use SMTP

		$mail->Host = $_ENV['EMAIL_HOST'];
		$mail->SMTPAuth = true;
		$mail->Username = $_ENV['EMAIL_USERNAME'];
		$mail->Password = $_ENV['EMAIL_PASSWORD'];
		$mail->SMTPSecure = $_ENV['EMAIL_SMTP'];
		$mail->Port = $_ENV['EMAIL_PORT'];

		$mail->setFrom('nguyennhatlinh1711@gmail.com', 'Madara');    // Địa chỉ email và tên người gửi
		$mail->addAddress($to_email, $to_name);     // Địa chỉ người nhận
		$mail->isHTML(true); // Set email format to HTML
		$mail->Subject = $to_subject;
		$mail->Body = $to_message; // Nội dung

		$mail->send();
	}
}
