<?php
	$filepath = realpath(dirname(__FILE__));
	$path = include_once($filepath.'/../path/path.php');
	$path = new Path();

	$path->path_file_include('Database','Format');
?>

<?php
	/**
	 * 
	 */
	class brand
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function brandproTitleAdmin(){
			$meta = array(
				'title_add' => 'Thêm thương hiệu sản phẩm - NNLShop',
				'title_list' => 'Quản lý thương hiệu sản phẩm - NNLShop',
				'title_edit' => 'Sửa thương hiệu sản phẩm - NNLShop'
			);
			return $meta;
		}

		public function insert_brand($brandProName,$brandProSlug,$brandProStatus,$metaKeywordsBrandPro){

			$brandProName = $this->fm->validation($brandProName);
			$brandProSlug = $this->fm->validation($brandProSlug);
			$metaKeywordsBrandPro = $this->fm->validation($metaKeywordsBrandPro);

			$brandProName = mysqli_real_escape_string($this->db->link, $brandProName);
			$brandProSlug = mysqli_real_escape_string($this->db->link, $brandProSlug);
			$metaKeywordsBrandPro = mysqli_real_escape_string($this->db->link, $metaKeywordsBrandPro);
			$brandProStatus = mysqli_real_escape_string($this->db->link, $brandProStatus);
			
			$alert = '<ul class="notification_panel">';
			$new_arr = array(
				'brandProName' => 'Tên thương hiệu sản phẩm',
            	'brandProSlug' => 'Slug thương hiệu sản phẩm',
            	'metaKeywordsBrandPro' => 'Từ khóa tìm kiếm'
           );
			$check_error = 0; 
			foreach ($new_arr as $key => $value) {
				if(empty($$key)){
					$alert .= '<li class="error">'.$value.' không được để trống</li>';
					$check_error++;
				}
			}
			if($check_error <= 0){
				$query = "INSERT INTO tbl_brand_product(Brand_Pro_Name,Brand_Pro_Slug,Meta_Keywords_BrandPro,Brand_Pro_Status) VALUES('$brandProName','$brandProSlug','$metaKeywordsBrandPro','$brandProStatus')";
				$result = $this->db->insert($query);
				if($result){
					$alert .= "<li class='success'>Thêm thương hiệu sản phẩm thành công</li>";
				}else{
					$alert .= "<li class='error'>Thêm thương hiệu sản phẩm không thành công</li>";
				}
			}
			$alert .= '</ul>';
			return $alert;
		}
		public function show_brand($start_from,$record_per_page){
			$query = "SELECT * FROM tbl_brand_product order by Brand_Pro_ID DESC LIMIT $start_from, $record_per_page";
			$result = $this->db->select($query);
			return $result;
		}
		public function list_brand(){
			$query = "SELECT * FROM tbl_brand_product order by Brand_Pro_ID DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_product_by_brand($id){
			$query = "SELECT * FROM tbl_product WHERE brandId='$id' order by brandId desc LIMIT 8";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_name_by_brand($id){
			$query = "SELECT tbl_product.*,tbl_brand.brandName,tbl_brand.brandId FROM tbl_product,tbl_brand WHERE tbl_product.brandId=tbl_brand.brandId AND tbl_brand.brandId ='$id' LIMIT 1";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_brand_home(){
			$query = "SELECT * FROM tbl_brand order by brandId desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function getbrandbyId($id){
			$query = "SELECT * FROM tbl_brand_product where Brand_Pro_ID = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function update_brand($brandProName,$brandProSlug,$metaKeywordsBrandPro,$id){

		$brandProName = $this->fm->validation($brandProName);
		$brandProSlug = $this->fm->validation($brandProSlug);
		$metaKeywordsBrandPro = $this->fm->validation($metaKeywordsBrandPro);

		$brandProName = mysqli_real_escape_string($this->db->link, $brandProName);
		$brandProSlug = mysqli_real_escape_string($this->db->link, $brandProSlug);
		$metaKeywordsBrandPro = mysqli_real_escape_string($this->db->link, $metaKeywordsBrandPro);
		
		$alert = '<ul class="notification_panel">';
		$new_arr = array(
			'brandProName' => 'Tên thương hiệu sản phẩm',
        	'brandProSlug' => 'Slug thương hiệu sản phẩm',
        	'metaKeywordsBrandPro' => 'Từ khóa tìm kiếm'
       );
		$check_error = 0; 
		foreach ($new_arr as $key => $value) {
			if(empty($$key)){
				$alert .= '<li class="error">'.$value.' không được để trống</li>';
				$check_error++;
			}
		}
		if($check_error <= 0){
			$query = "UPDATE tbl_brand_product SET Brand_Pro_Name = '$brandProName',Brand_Pro_Slug = '$brandProSlug', Meta_Keywords_BrandPro = '$metaKeywordsBrandPro' WHERE Brand_Pro_ID = '$id'";
			$result = $this->db->update($query);
			if($result){
				$alert .= "<li class='success'>Cập nhật thương hiệu sản phẩm thành công</li>";
			}else{
				$alert .= "<li class='error'>Cập nhật thương hiệu sản phẩm không thành công</li>";
			}
		}
		$alert .= '</ul>';
		return $alert;
	}
		public function delete_brand($id){
			$query = "DELETE FROM tbl_brand_product where Brand_Pro_ID = '$id'";
			$result = $this->db->delete($query);
			$alert = '<ul class="notification_panel">';
			if($result){
				$alert .= "<li class='success'>Xóa thương hiệu sản phẩm thành công</li>";
			}else{
				$alert .= "<li class='error'>Xóa thương hiệu sản phẩm không thành công</li>";
			}
			$alert .= '</ul>';
			return $alert;
		}

		public function update_brand_status($status,$id){
			$query = "UPDATE tbl_brand_product SET Brand_Pro_Status = '$status' WHERE Brand_Pro_ID = '$id'";
			$result = $this->db->update($query);
		}

	}
?>