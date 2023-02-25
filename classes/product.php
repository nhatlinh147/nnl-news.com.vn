<?php

class product
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function productTitleAdmin()
	{
		$meta = array(
			'title_add' => 'Thêm sản phẩm - NNLShop',
			'title_list' => 'Quản lý sản phẩm - NNLShop',
			'title_edit' => 'Sửa sản phẩm - NNLShop'
		);
		return $meta;
	}
	public function search_product($tukhoa, $start_from, $record_per_page)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		// $query = "SELECT * FROM tbl_product WHERE Product_Name LIKE '%$tukhoa%' LIMIT $start_from, $record_per_page";
		$query = "
			SELECT tbl_product.*, tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent
			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID WHERE Product_Name LIKE '%$tukhoa%' 
			order by tbl_product.Product_ID desc LIMIT $start_from, $record_per_page";

		$result = $this->db->select($query);
		return $result;
	}

	public function list_search_product($tukhoa)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		$query = "SELECT * FROM tbl_product WHERE Product_Name LIKE '%$tukhoa%'";
		$result = $this->db->select($query);
		return !$result ? false : $result;
	}

	public function insert_product($data, $files)
	{
		$array = ["product_name", "product_slug", "product_content", "meta_keywords_product", "meta_desc_product", "cate_pro_id", "product_status", "created_at", "updated_at"];

		$get_data = General::list_sql($this->db->link, $data, $array);
		eval($get_data);

		$product_username = mysqli_real_escape_string($this->db->link, Session::get('Admin_Name'));

		$alert = '<ul class="notification_panel">';
		$new_arr = array(
			'product_name' => 'Tên sản phẩm',
			'product_slug' => 'Slug sản phẩm',
			'product_content' => 'Nội dung sản phẩm',
			'meta_keywords_product' => 'Từ khóa tìm kiếm',
			'meta_desc_product' => 'Mô tả thẻ meta',
			'cate_pro_id' => 'Lựa chọn danh mục sản phẩm'
		);

		$check_error = 0;

		foreach ($new_arr as $key => $value) {
			if (empty($$key)) {
				$alert .= '<li class="error">' . $value . ' không được để trống</li>';
				$check_error++;
			}
			// if (empty($$key)) {
			// 	$alert .= '<li class="error">' . $value . ' không được để trống</li>';
			// 	$check_error++;
			// } else if ($key == 'product_name' || $key == 'product_slug') {
			// 	$alert .= General::check_length_max($value, $$key, $check_error, 20, 120);
			// }
		}

		//Trích xuất dữ liệu image
		$get_data = General::check_error_image("product_image", 'Admin/upload/product/', 500, 500, 'auto', $check_error);

		$alert .= $get_data["alert"];
		$unique_image = $get_data["unique_image"];

		if ($check_error <= 0) {

			$query = "INSERT INTO tbl_product(Product_UserName,Product_Name,Product_Slug,Product_Image,Product_Content,Meta_Keywords_Product,Meta_Desc_Product,Cate_Pro_ID,Product_Status,created_at,updated_at) VALUES('$product_username','$product_name','$product_slug','$unique_image','$product_content','$meta_keywords_product','$meta_desc_product','$cate_pro_id','$product_status','$created_at','$updated_at')";

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


	public function update_product($data, $files, $id)
	{

		$array = ["product_name", "product_slug", "product_content", "meta_keywords_product", "meta_desc_product", "cate_pro_id", "updated_at"];

		$get_data = General::list_sql($this->db->link, $data, $array);
		eval($get_data);

		$alert = '<ul class="notification_panel">';
		$new_arr = array(
			'product_name' => 'Tên sản phẩm',
			'product_slug' => 'Slug sản phẩm',
			'product_content' => 'Nội dung sản phẩm',
			'meta_keywords_product' => 'Từ khóa tìm kiếm',
			'meta_desc_product' => 'Mô tả thẻ meta',
			'cate_pro_id' => 'Lựa chọn danh mục sản phẩm'
		);

		$check_error = 0;

		foreach ($new_arr as $key => $value) {
			if (empty($$key)) {
				$alert .= '<li class="error">' . $value . ' không được để trống</li>';
				$check_error++;
			}
			// if (empty($$key)) {
			// 	$alert .= '<li class="error">' . $value . ' không được để trống</li>';
			// 	$check_error++;
			// } else if ($key == 'product_name' || $key == 'product_slug') {
			// 	$alert .= General::check_length_max($value, $$key, $check_error, 20, 120);
			// }
		}

		if ($check_error <= 0) {
			if (!empty($_FILES['product_image']['name'])) {

				//sau khi lưu thì xóa đi ảnh trước đó
				$query_select = "SELECT * FROM tbl_product where Product_ID = '$id'";
				$result = $this->db->select($query_select);
				$result = $result->fetch_assoc();
				$result = $result['Product_Image'];
				unlink(Path::file_upload('Upload_product_' . $result));

				//Trích xuất dữ liệu image
				$get_data = General::check_error_image("product_image", 'Admin/upload/product/', 500, 500, 'auto', $check_error);

				$alert .= $get_data["alert"];
				$unique_image = $get_data["unique_image"];


				$query = "UPDATE tbl_product SET Product_Name = '$product_name' , Product_Slug = '$product_slug',Product_Image = '$unique_image',Product_Content = '$product_content' , Meta_Keywords_Product = '$meta_keywords_product' , Meta_Desc_Product = '$meta_desc_product',Cate_Pro_ID = '$cate_pro_id', updated_at = '$updated_at' WHERE Product_ID = '$id'";
			} else {
				$query = "UPDATE tbl_product SET Product_Name = '$product_name' , Product_Slug = '$product_slug',Product_Content = '$product_content' , Meta_Keywords_Product = '$meta_keywords_product' , Meta_Desc_Product = '$meta_desc_product',Cate_Pro_ID = '$cate_pro_id', updated_at = '$updated_at' WHERE Product_ID = '$id'";
			}

			$result = $this->db->update($query);
			if ($result) {
				$alert .= "<li class='success'>Cập nhật sản phẩm thành công</li>";
				//Sau khi xóa trở lại địa
				General::view_link_location("danh-sach-san-pham.html");
			} else {
				$alert .= "<li class='error'>Cập nhật sản phẩm không thành công</li>";
			}
		}

		$alert .= '</ul>';
		return $alert;
	}

	public function show_slider()
	{
		$query = "SELECT * FROM tbl_slider where type='1' order by sliderId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_slider_list()
	{
		$query = "SELECT * FROM tbl_slider order by sliderId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_product($start_from, $record_per_page)
	{

		$query = "

			SELECT tbl_product.*, tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent

			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID 

			order by tbl_product.Product_ID desc LIMIT $start_from, $record_per_page";

		$result = $this->db->select($query);
		return $result;
	}
	public function list_product()
	{

		$query = "

			SELECT tbl_product.*, tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent

			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID 

			order by tbl_product.Product_ID DESC";

		$result = $this->db->select($query);
		return !$result ? false : $result;
	}
	public function listProductByTimeDescLimit($record_per_page)
	{

		$query = "

			SELECT tbl_product.*, tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent

			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID 

			order by tbl_product.created_at DESC LIMIT $record_per_page";

		$result = $this->db->select($query);
		return $result;
	}

	public function listProductByViewDescLimit($record_per_page)
	{

		$query = "

			SELECT tbl_product.*, tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent

			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID 

			order by tbl_product.Product_View DESC LIMIT $record_per_page";

		$result = $this->db->select($query);
		return $result;
	}

	public function product_by_category_($select, $id, $record_per_page)
	{
		$selected = $select == "child" ? "tbl_product.Cate_Pro_ID = '$id'" : "tbl_category_product.Cate_Pro_Parent = '$id'";
		$query = "

			SELECT tbl_product.*, tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent,tbl_category_product.Cate_Pro_ID,tbl_category_product.Cate_Pro_Slug

			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID WHERE " . $selected . "

			order by tbl_product.created_at desc LIMIT $record_per_page";

		$result = $this->db->select($query);
		return $result;
	}
	public function productByCategoryParent($id)
	{
		// $query =  "SELECT * FROM tbl_product WHERE EXISTS (SELECT * FROM tbl_category_product WHERE tbl_product.Cate_Pro_ID IN (SELECT Cate_Pro_ID FROM tbl_category_product WHERE Cate_Pro_Parent = '$id'))";
		$query =  "SELECT * FROM tbl_product WHERE tbl_product.Cate_Pro_ID IN (SELECT Cate_Pro_ID FROM tbl_category_product WHERE Cate_Pro_Parent = '$id')";
		$result = $this->db->select($query);
		return $result;
	}


	public function delete_product($id, $page, $number_page)
	{
		$query_select = "SELECT * FROM tbl_product where Product_ID = '$id'";
		$result = $this->db->select($query_select);
		$result = $result->fetch_assoc();
		$result = $result['Product_Image'];
		unlink(Path::file_upload('Upload_product_' . $result));


		$query = "DELETE FROM tbl_product where Product_ID = '$id'";
		$result = $this->db->delete($query);
		$alert = '<ul class="notification_panel">';
		if ($result) {
			$alert .= '<li class="success">Xóa sản phẩm thành công</li>';
		} else {
			$alert .= '<li class="error">Xóa sản phẩm không thành công</li>';
		}
		$alert .= '</ul>';

		General::view("danh-sach-san-pham.html?page=$page&number_page=$number_page");

		return $alert;
	}
	public function update_product_status($status, $id)
	{
		$query = "UPDATE tbl_product SET Product_Status = '$status' WHERE Product_ID = '$id'";
		$result = $this->db->update($query);

		$query_get = "SELECT * FROM tbl_product  WHERE Product_ID = '$id' ";
		$select = $this->db->select($query_get);
		$get_data = $select->fetch_assoc()["Product_Name"];
		echo "sản phẩm: <i><u>$get_data</u></i>";
	}


	public function getproductbyId($id)
	{
		$query = "SELECT * FROM tbl_product where Product_ID = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	//END BACKEND 
	public function getproduct_feathered()
	{
		$query = "SELECT * FROM tbl_product where type = '0' order by RAND() LIMIT 8 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function get_all_product()
	{
		$query = "SELECT * FROM tbl_product";
		$result = $this->db->select($query);
		return $result;
	}
	// public function get_details($id)
	// {
	// 	$query = "

	// 		SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 

	// 		FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 

	// 		INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId WHERE tbl_product.productId = '$id'

	// 		";

	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function getLastestDell()
	// {
	// 	$query = "SELECT * FROM tbl_product WHERE brandId = '6' order by productId desc LIMIT 1";
	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function getLastestOppo()
	// {
	// 	$query = "SELECT * FROM tbl_product WHERE brandId = '3' order by productId desc LIMIT 1";
	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function getLastestHuawei()
	// {
	// 	$query = "SELECT * FROM tbl_product WHERE brandId = '4' order by productId desc LIMIT 1";
	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function getLastestSamsung()
	// {
	// 	$query = "SELECT * FROM tbl_product WHERE brandId = '2' order by productId desc LIMIT 1";
	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function get_compare($customer_id)
	// {
	// 	$query = "SELECT * FROM tbl_compare WHERE customer_id = '$customer_id' order by id desc";
	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function get_wishlist($customer_id)
	// {
	// 	$query = "SELECT * FROM tbl_wishlist WHERE customer_id = '$customer_id' order by id desc";
	// 	$result = $this->db->select($query);
	// 	return $result;
	// }
	// public function insertCompare($productid, $customer_id)
	// {

	// 	$productid = mysqli_real_escape_string($this->db->link, $productid);
	// 	$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

	// 	$check_compare = "SELECT * FROM tbl_compare WHERE productId = '$productid' AND customer_id ='$customer_id'";
	// 	$result_check_compare = $this->db->select($check_compare);

	// 	if ($result_check_compare) {
	// 		$msg = "<span class='error'>Product Already Added to Compare</span>";
	// 		return $msg;
	// 	} else {

	// 		$query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
	// 		$result = $this->db->select($query)->fetch_assoc();

	// 		$productName = $result["productName"];
	// 		$price = $result["price"];
	// 		$image = $result["image"];



	// 		$query_insert = "INSERT INTO tbl_compare(productId,price,image,customer_id,productName) VALUES('$productid','$price','$image','$customer_id','$productName')";
	// 		$insert_compare = $this->db->insert($query_insert);

	// 		if ($insert_compare) {
	// 			$alert = "<span class='success'>Added Compare Successfully</span>";
	// 			return $alert;
	// 		} else {
	// 			$alert = "<span class='error'>Added Compare Not Success</span>";
	// 			return $alert;
	// 		}
	// 	}
	// }
	// public function insertWishlist($productid, $customer_id)
	// {
	// 	$productid = mysqli_real_escape_string($this->db->link, $productid);
	// 	$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);

	// 	$check_wlist = "SELECT * FROM tbl_wishlist WHERE productId = '$productid' AND customer_id ='$customer_id'";
	// 	$result_check_wlist = $this->db->select($check_wlist);

	// 	if ($result_check_wlist) {
	// 		$msg = "<span class='error'>Product Already Added to Wishlist</span>";
	// 		return $msg;
	// 	} else {

	// 		$query = "SELECT * FROM tbl_product WHERE productId = '$productid'";
	// 		$result = $this->db->select($query)->fetch_assoc();

	// 		$productName = $result["productName"];
	// 		$price = $result["price"];
	// 		$image = $result["image"];



	// 		$query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) VALUES('$productid','$price','$image','$customer_id','$productName')";
	// 		$insert_wlist = $this->db->insert($query_insert);

	// 		if ($insert_wlist) {
	// 			$alert = "<span class='success'>Added to Wishlist Successfully</span>";
	// 			return $alert;
	// 		} else {
	// 			$alert = "<span class='error'>Added to Wishlist Not Success</span>";
	// 			return $alert;
	// 		}
	// 	}
	// }
	public function file_browser(Request $request)
	{
		$paths = glob(public_path('upload/ckeditor/*')); //  tìm kiếm tất cả các đường dẫn phù hợp với partern truyền vào

		$getFile = array();

		foreach ($paths as $path) {
			array_push($getFile, basename($path)); // đẩy từng ảnh vào
		}
		$data = array(
			'fileNames' => $getFile // tạo nên mảng với các phần tử là ảnh được tải lên
		);

		return view('admin.ckeditor-images.file-browser')->with($data);
	}
}
