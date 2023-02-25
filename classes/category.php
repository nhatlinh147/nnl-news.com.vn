<?php

/**
 * 
 */
class category
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database(); // lấy dữ liệu
		$this->fm = new Format(); // lấy định dạng format
	}
	public function all_category()
	{
	}
	public function cateproTitleAdmin()
	{
		$meta = array(
			'title_add' => 'Thêm danh mục sản phẩm - NNLShop',
			'title_list' => 'Quản lý danh mục sản phẩm - NNLShop',
			'title_edit' => 'Sửa danh mục sản phẩm - NNLShop'
		);
		return $meta;
	}

	public function search_category($tukhoa, $start_from, $record_per_page)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		$query = "SELECT * FROM tbl_category_product WHERE Cate_Pro_Name LIKE '%$tukhoa%' LIMIT $start_from, $record_per_page";
		$result = $this->db->select($query);
		return $result;
	}
	public function list_search_category($tukhoa)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		$query = "SELECT * FROM tbl_category_product WHERE Cate_Pro_Name LIKE '%$tukhoa%'";
		$result = $this->db->select($query);
		return $result;
	}

	public function category_parent()
	{
		$query = "SELECT * FROM tbl_category_product  WHERE Cate_Pro_Parent = 0  order by Cate_Pro_ID DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function category_child_by_parent($parent)
	{
		$query = "SELECT * FROM tbl_category_product WHERE Cate_Pro_Parent = '$parent' ";
		$result = $this->db->select($query);
		return $result;
	}

	public function category_parent_by_child($child)
	{
		$query = "SELECT * FROM tbl_category_product WHERE Cate_Pro_ID IN (SELECT DISTINCT Cate_Pro_Parent FROM tbl_category_product WHERE Cate_Pro_ID = '$child') LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}

	public function insert_category($data)
	{

		$get_data = General::list_sql($this->db->link, $data, ["cate_pro_name", "cate_pro_slug", "meta_keywords_catepro", "cate_pro_parent", "cate_pro_status"]);
		eval($get_data);


		$alert = '<ul class="notification_panel">';
		$new_arr = array(
			'cate_pro_name' => 'Tên danh mục sản phẩm',
			'cate_pro_slug' => 'Slug danh mục sản phẩm',
			'meta_keywords_catepro' => 'Từ khóa tìm kiếm',
		);
		$check_error = 0;
		foreach ($new_arr as $key => $value) {
			if (empty($$key)) {
				$alert .= '<li class="error">' . $value . ' không được để trống</li>';
				$check_error++;
			}
		}
		if ($check_error <= 0) {
			$query = "INSERT INTO tbl_category_product(Cate_Pro_Name,Cate_Pro_Slug,Cate_Pro_Parent,Meta_Keywords_CatePro,Cate_Pro_Status) VALUES('$cate_pro_name','$cate_pro_slug','$cate_pro_parent','$meta_keywords_catepro','$cate_pro_status')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert .= "<li class='success'>Thêm danh mục sản phẩm thành công</li>";
			} else {
				$alert .= "<li class='error'>Thêm danh mục sản phẩm không thành công</li>";
			}
		}
		$alert .= '</ul>';
		return $alert;
	}

	public function show_category($start_from, $record_per_page)
	{
		$query = "SELECT * FROM tbl_category_product order by Cate_Pro_ID desc LIMIT $start_from, $record_per_page";
		$result = $this->db->select($query);
		return $result;
	}

	public function list_category()
	{
		$query = "SELECT * FROM tbl_category_product order by Cate_Pro_ID desc";
		$result = $this->db->select($query);
		return !$result ? false : $result;
	}

	public function update_category($data)
	{

		$get_data = General::list_sql($this->db->link, $data, ["cate_pro_name", "cate_pro_slug", "meta_keywords_catepro", "cate_pro_parent"]);
		eval($get_data);

		$alert = '<ul class="notification_panel">';
		$new_arr = array(
			'cate_pro_name' => 'Tên danh mục sản phẩm',
			'cate_pro_slug' => 'Slug danh mục sản phẩm',
			'meta_keywords_catepro' => 'Từ khóa tìm kiếm'
		);

		$check_error = 0;
		foreach ($new_arr as $key => $value) {
			if (empty($$key)) {
				$alert .= '<li class="error">' . $value . ' không được để trống</li>';
				$check_error++;
			}
		}
		if ($check_error <= 0) {
			// Truy vấn update
			$query = "UPDATE tbl_category_product SET Cate_Pro_Name = '$cate_pro_name',Cate_Pro_Slug = '$cate_pro_slug',Meta_Keywords_CatePro = '$meta_keywords_catepro', Cate_Pro_Parent = '$cate_pro_parent'  WHERE Cate_Pro_ID = '$id'";
			// Tiến hành update
			$result = $this->db->update($query);

			if ($result) {
				echo "<script>window.location = '" . General::view_link('danh-sach-danh-muc-san-pham.html') . "'</script>";
				$alert .= '<li class="success">Cập nhật danh mục sản phẩm thành công</li>';
			} else {
				$alert .= '<li class="error">Cập nhật danh mục sản phẩm không thành công</li>';
			}
		}

		$alert .= '</ul>';
		return $alert;
	}

	public function delete_category($id, $page, $number_page)
	{
		$query = "DELETE FROM tbl_category_product where Cate_Pro_ID = '$id'";
		$result = $this->db->delete($query);
		$alert = '<ul class="notification_panel">';
		if ($result) {
			$alert .= "<li class='success'>Xóa danh mục sản phẩm thành công</li>";
		} else {
			$alert .= "<li class='error'>Xóa danh mục sản phẩm không thành công</li>";
		}
		$alert .= '</ul>';

		General::view("danh-sach-danh-muc-san-pham.html?page=$page&number_page=$number_page");

		return $alert;
	}

	public function update_category_status($status, $id)
	{
		$query = "UPDATE tbl_category_product SET Cate_Pro_Status = '$status' WHERE Cate_Pro_ID = '$id'";
		$result = $this->db->update($query);

		$query_get = "SELECT * FROM tbl_category_product  WHERE Cate_Pro_ID = '$id' ";
		$select = $this->db->select($query_get);
		$get_data = $select->fetch_assoc()["Cate_Pro_Name"];
		echo "danh mục: <i><u>$get_data</u></i>";
	}

	public function active_category_product($id)
	{
		$query = "UPDATE tbl_category_product SET Cate_Pro_Status = 1 WHERE Cate_Pro_ID = '$id'";
		// Tiến hành update
		$result = $this->db->update($query);
		$alert = '<ul class="notification_panel">';
		if ($result) {
			$alert .= '<li class="success">Kích hoạt danh mục sản phẩm thành công</li>';
		}
		$alert .= '</ul>';
		return $alert;
	}
	public function inactive_category_product($id)
	{
		$query = "UPDATE tbl_category_product SET Cate_Pro_Status = 0 WHERE Cate_Pro_ID = '$id'";
		// Tiến hành update
		$result = $this->db->update($query);
		$alert = '<ul class="notification_panel">';
		if ($result) {
			$alert .= '<li class="success">Hủy kích hoạt danh mục sản phẩm thành công</li>';
		}
		$alert .= '</ul>';
		return $alert;
	}

	public function getcatbyId($id)
	{
		$query = "SELECT * FROM tbl_category_product where Cate_Pro_ID  = '$id'";
		$result = $this->db->select($query);
		return $result;
	}

	public function get_category_by_slug($slug)
	{
		$query = "SELECT Cate_Pro_Slug,Cate_Pro_ID,Cate_Pro_Name FROM tbl_category_product
		WHERE Cate_Pro_Slug= '$slug' LIMIT 1";
		$result = $this->db->select($query);
		return $result;
	}
}
