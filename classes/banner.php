<?php

/**
 * 
 */
class banner
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function bannerTitleAdmin()
	{
		$meta = array(
			'title_add' => 'Thêm banner - NNLShop',
			'title_list' => 'Quản lý banner - NNLShop'
		);
		return $meta;
	}

	public function search_banner($tukhoa, $start_from, $record_per_page)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		$query = "SELECT * FROM tbl_banner WHERE Banner_Title LIKE '%$tukhoa%' LIMIT $start_from, $record_per_page";
		$result = $this->db->select($query);
		return $result;
	}

	public function list_search_banner($tukhoa)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		$query = "SELECT * FROM tbl_banner WHERE Banner_Title LIKE '%$tukhoa%'";
		$result = $this->db->select($query);
		return $result;
	}

	public function insert_banner($data, $files)
	{
		$get_data = General::list_sql($this->db->link, $data, ["banner_title", "banner_slug", "banner_exprired", "banner_status", "created_at"]);
		eval($get_data);

		$alert = '<ul class="notification_panel">';
		$new_arr = array(
			'banner_title' => 'Tiêu đề banner',
			'banner_slug' => 'Slug banner',
			'banner_exprired' => 'Thời hạn banner'
		);

		$check_error = 0;

		foreach ($new_arr as $key => $value) {
			if (empty($$key)) {
				$alert .= '<li class="error">' . $value . ' không được để trống</li>';
				$check_error++;
			}
		}

		//Trích xuất dữ liệu image
		$get_data = General::check_error_image("banner_image", 'Admin/upload/banner/', 720, 180, 'exact', $check_error);

		$alert .= $get_data["alert"];
		$unique_image = $get_data["unique_image"];

		if ($check_error == 0) {
			$query = "INSERT INTO tbl_banner(Banner_Title,Banner_Slug,Banner_Exprided,Banner_Image,Banner_Status,Created_At) VALUES('$banner_title','$banner_slug','$banner_exprired','$unique_image','$banner_status','$created_at')";

			$result = $this->db->insert($query);
			if ($result) {
				$alert .= "<li class='success'>Thêm sản phẩm thành công</li>";
			} else {
				$alert .= "<li class='error'>Thêm sản phẩm không thành công</li>";
			}
		}

		$alert .= '</ul>';
		return $alert;
	}

	public function show_banner($start_from, $record_per_page)
	{
		$query = "SELECT * FROM tbl_banner order by Banner_ID desc LIMIT $start_from, $record_per_page";
		$result = $this->db->select($query);
		return $result;
	}
	public function showBannerLimitFront($record_per_page)
	{
		$query = "SELECT * FROM tbl_banner order by created_at desc LIMIT $record_per_page";
		$result = $this->db->select($query);
		return $result;
	}

	public function list_banner()
	{
		$query = "SELECT * FROM tbl_banner order by Banner_ID desc";
		$result = $this->db->select($query);
		return !$result ? false : $result;
	}
	public function delete_banner($id, $page, $number_page)
	{
		$query_select = "SELECT * FROM tbl_banner where Banner_ID = '$id'";
		$result = $this->db->select($query_select);
		$result = $result->fetch_assoc();
		$result = $result['Banner_Image'];
		unlink(Path::file_upload('Upload_banner_' . $result));

		$query = "DELETE FROM tbl_banner where Banner_ID = '$id'";
		$result = $this->db->delete($query);

		$alert = '<ul class="notification_panel">';

		if ($result) {
			$alert .= "<li class='success'>Xóa slide thành công</li>";
		} else {
			$alert .= "<li class='error'>Xóa slide không thành công</li>";
		}

		$alert .= '</ul>';

		General::view("danh-sach-anh-bia.html?page=$page&number_page=$number_page");

		//Sau khi xóa trở lại địa
		// General::view_link_location('danh-sach-anh-bia.html');

		return $alert;
	}
	public function update_banner_status($status, $id)
	{
		$query = "UPDATE tbl_banner SET Banner_Status = '$status' WHERE Banner_ID = '$id'";
		$result = $this->db->update($query);

		$query_get = "SELECT * FROM tbl_banner WHERE Banner_ID = '$id' ";
		$select = $this->db->select($query_get);
		$get_data = $select->fetch_assoc()["Banner_Title"];
		echo "ảnh bìa: <i><u>$get_data</u></i>";
	}
}
