<?php

/**
 * 
 */
class info
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function infoTitleAdmin()
	{
		$meta = array(
			'title_add_list' => 'Thông tin về website - NNLShop',
		);
		return $meta;
	}
	public function insert_info($data, $files)
	{
		$base_name = pathinfo(Path::path_file_local(""))["dirname"];

		$get_data = General::list_sql($this->db->link, $data, [
			"info_webname", "info_shopname", "info_author", "info_phone", "info_address",
			"info_social", "info_about_us"
		]);
		eval($get_data);

		$new_arr = [];
		for ($i = 0; $i < count($files['info_image']['name']); $i++) {
			$file_name = $files['info_image']['name'][$i];
			$file_temp = $files['info_image']['tmp_name'][$i];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$name_image = md5(General::generateRandomString());
			$unique_image =  $name_image . '.' . $file_ext;
			$uploaded_image = "Admin/upload/info/" . $unique_image;

			move_uploaded_file($file_temp, $uploaded_image);
			$resizeObj = new resize($uploaded_image);
			$resizeObj->resizeImage(300, 300, 'auto');
			$resizeObj->saveImage($uploaded_image, 100);

			array_push($new_arr, General::view_link('upload/info/') . $unique_image);
		}

		$info_image = json_encode($new_arr);

		$query = "INSERT INTO tbl_info(Info_Webname,Info_Shopname,Info_Author,Info_Phone,Info_Address,Info_Social,Info_Image,Info_About_Us)
			VALUES('$info_webname','$info_shopname','$info_author','$info_phone','$info_address','$info_social','$info_image','$info_about_us')";
		$alert = '<ul class="notification_panel">';

		$result = $this->db->insert($query);

		if ($result) {
			$alert .= "<li class='success'>Thêm thông tin thành công</li>";
		}

		$alert .= '</ul>';
		return $alert;
	}
	public function view_info()
	{
		$query = "SELECT * FROM tbl_info LIMIT 1";
		$result = $this->db->select($query);
		$new_info = [];
		$check = 0;
		if ($result) {
			$result = $result->fetch_assoc();
			$info_category = ["Tên website", "Tên shop", "Chủ sở hữu", "Số điện thoại", "Địa chỉ", "Mạng xã hội", "Hình ảnh", "Giới thiệu"];
			array_shift($result);

			//Tách object thành mảng đồng thời thêm giá trị text
			foreach ($result as $key => $value) {
				array_push($new_info, [
					"key" => $key,
					"value" => $value,
					"text" => $info_category[$check]
				]);
				$check++;
			}
			return json_encode($new_info);
		} else {
			return 'null';
		}
	}
	public function delete_info()
	{
		$this->db->delete("DELETE FROM tbl_info");
		$url = General::$base_local . 'Admin/upload/info/*';
		$paths = glob($url);

		foreach ($paths as $value) {
			if (is_file($value)) {
				unlink($value);
			}
		}
		return "null";
	}
}
