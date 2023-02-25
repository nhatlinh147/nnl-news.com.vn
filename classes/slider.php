<?php
	/**
	 * 
	 */
	class slider
	{
		private $db;
		private $fm;
		
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function slideTitleAdmin(){
			$meta = array(
				'title_add' => 'Thêm slide - NNLShop',
				'title_list' => 'Quản lý slide - NNLShop',
				'title_edit' => 'Sửa slide - NNLShop'
			);
			return $meta;
		}

		public function search_slider($tukhoa,$start_from,$record_per_page){
			$tukhoa = $this->fm->validation($tukhoa);
			$query = "SELECT * FROM tbl_slide WHERE Slide_Title LIKE '%$tukhoa%' LIMIT $start_from, $record_per_page";
			$result = $this->db->select($query);
			return $result;

		}

		public function list_search_slider($tukhoa){
			$tukhoa = $this->fm->validation($tukhoa);
			$query = "SELECT * FROM tbl_slide WHERE Slide_Title LIKE '%$tukhoa%'";
			$result = $this->db->select($query);
			return $result;

		}

		public function insert_slider($data,$files){
			$get_data = General::list_sql($this->db->link , $data , ["slide_title","slide_slug","slide_desc","slide_status"]);
			eval($get_data);

			$alert = '<ul class="notification_panel">';
			$new_arr = array(
				'slide_title' => 'Tên slide',
				'slide_slug' => 'Slug slide',
            	'slide_desc' => 'Mô tả slide'
           );

			$check_error = 0;

			foreach ($new_arr as $key => $value) {
				if(empty($$key)){
					$alert .= '<li class="error">'.$value.' không được để trống</li>';
					$check_error++;
				}
			}

			//Trích xuất dữ liệu image
			$get_data = General::check_error_image("slide_image",'Admin/upload/slide/', 720 , 180, 'exact',$check_error);

			$alert .= $get_data["alert"];
			$unique_image = $get_data["unique_image"];

			if($check_error <= 0){

				$query = "INSERT INTO tbl_slide(Slide_Image,Slide_Title,Slide_Slug,Slide_Desc,Slide_Status) VALUES('$unique_image','$slide_title','$slide_slug','$slide_slug','$slide_status')";
				$result = $this->db->insert($query);
				if($result){
					$alert .= "<li class='success'>Thêm slide thành công</li>";
				}else{
					$alert .= "<li class='error'>Thêm slide không thành công</li>";
				}
			}
			$alert .= '</ul>';
			return $alert;
		}

		public function update_slider($data,$files){
			$get_data = General::list_sql($this->db->link , $data , ["slide_id","slide_title","slide_slug","slide_desc","slide_status"]);
			eval($get_data);

			$alert = '<ul class="notification_panel">';
			$new_arr = array(
				'slide_title' => 'Tên slide',
				'slide_slug' => 'Slug slide',
            	'slide_desc' => 'Mô tả slide'
           );

			$check_error = 0;

			foreach ($new_arr as $key => $value) {
				if(empty($$key)){
					$alert .= '<li class="error">'.$value.' không được để trống</li>';
					$check_error++;
				}
			}
			
			if($check_error <= 0){
				if(!empty($_FILES['slide_image']['name'])){

					//sau khi lưu thì xóa đi ảnh trước đó
					$query_select = "SELECT * FROM tbl_slide where Slide_ID = '$slide_id'";
					$result = $this->db->select($query_select);
					$result = $result->fetch_assoc();
					$result = $result['Slide_Image'];
					unlink(Path::file_upload('Upload_slide_'.$result));

					//Trích xuất dữ liệu image
					$get_data = General::check_error_image("slide_image",'Admin/upload/slide/', 720 , 180, 'exact',$check_error);
					
					$alert .= $get_data["alert"];
					$unique_image = $get_data["unique_image"];

					$query = "UPDATE tbl_slide SET Slide_Title = '$slide_title',Slide_Slug = '$slide_slug',Slide_Desc = '$slide_desc',Slide_Image = '$unique_image' WHERE Slide_ID = '$slide_id'";
				}else {
					$query = "UPDATE tbl_slide SET Slide_Title = '$slide_title', Slide_Slug = '$slide_slug', Slide_Desc = '$slide_desc' WHERE Slide_ID = '$slide_id'";
				}

				$result = $this->db->update($query);

				if($result){
					// $alert .= "<li class='success'>Cập nhật slide thành công</li>";
					echo "<script>window.location = '" . General::view_link('danh-sach-slide.html') . "'</script>";
				}else{
					$alert .= "<li class='error'>Cập nhật slide không thành công</li>";
				}
			}
			$alert .= '</ul>';
			return $alert;
		}
		
		public function show_slider($start_from,$record_per_page){
			$query = "SELECT * FROM tbl_slide order by Slide_ID DESC LIMIT $start_from, $record_per_page";
			$result = $this->db->select($query);
			return $result;
		}

		public function list_slider(){
			$query = "SELECT * FROM tbl_slide order by Slide_ID DESC";
			$result = $this->db->select($query);
			return !$result ? false : $result;
		}
		
		public function update_type_slider($id,$type){

			$type = mysqli_real_escape_string($this->db->link, $type);
			$query = "UPDATE tbl_slider SET type = '$type' where sliderId='$id'";
			$result = $this->db->update($query);
			return $result;
		}
		public function delete_slider($id , $page , $number_page){

			$query_select = "SELECT * FROM tbl_slide where Slide_ID = '$id'";
			$result = $this->db->select($query_select);
			$result = $result->fetch_assoc();
			$result = $result['Slide_Image'];
			unlink(Path::file_upload('Upload_slide_'.$result));

			$query = "DELETE FROM tbl_slide where Slide_ID = '$id'";
			$result = $this->db->delete($query);
			$alert = '<ul class="notification_panel">';
			if($result){
				$alert .= "<li class='success'>Xóa slide thành công</li>";
			}else{
				$alert .= "<li class='error'>Xóa slide không thành công</li>";
			}
			$alert .= '</ul>';

			//Sau khi xóa trở lại địa
			General::view_link_location("danh-sach-slide.html?page=$page&number_page=$number_page");

			return $alert;	
		}
		
		public function update_slider_status($status,$id){
			$query = "UPDATE tbl_slide SET Slide_Status = '$status' WHERE Slide_ID = '$id'";
			$result = $this->db->update($query);

			$query_get = "SELECT * FROM tbl_slide  WHERE Slide_ID = '$id'";
			$select = $this->db->select($query_get);
			$get_data = $select->fetch_assoc()["Slide_Title"];
			echo "tiêu đề slide: <i><u>$get_data</u></i>";
		}
		
		public function getsliderbyId($id){
			$query = "SELECT * FROM tbl_slide where Slide_ID = '$id'";
			$result = $this->db->select($query);
			return $result;
		}
		//END BACKEND 
		public function getproduct_feathered(){
			$query = "SELECT * FROM tbl_product where type = '0' order by RAND() LIMIT 8 ";
			$result = $this->db->select($query);
			return $result;
		} 
		
		public function getproduct_new(){
			$sp_tungtrang = 4;
			if(!isset($_GET['trang'])){
				$trang = 1;
			}else{
				$trang = $_GET['trang'];
			}
			$tung_trang = ($trang-1)*$sp_tungtrang;
			$query = "SELECT * FROM tbl_product order by productId desc LIMIT $tung_trang,$sp_tungtrang";
			$result = $this->db->select($query);
			return $result;
		} 
		public function get_all_product(){
			$query = "SELECT * FROM tbl_product";
			$result = $this->db->select($query);
			return $result;
		} 
		public function get_details($id){
			$query = "

			SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 

			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 

			INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId WHERE tbl_product.productId = '$id'

			";

			$result = $this->db->select($query);
			return $result;
		}
		


	}
?>