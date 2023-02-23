<?php

class Detail
{
	const expire_second = 15; // Khoảng thời gian để tính là 1 view
	private $db, $fm, $carbon;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
		$this->carbon = new Carbon\Carbon;
	}
	public function show_product_detail($slug)
	{
		$query = "SELECT tbl_product.*, tbl_category_product.Cate_Pro_Slug ,tbl_category_product.Cate_Pro_Name,tbl_category_product.Cate_Pro_Parent
			FROM tbl_product INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID WHERE Product_Slug = '$slug' 
			order by tbl_product.Product_ID desc LIMIT 1";
		$result = $this->db->select($query);
		return !$result ? false : $result->fetch_assoc();
	}
	public function next_prev($product_id, $condition)
	{
		$query = "SELECT Product_ID from tbl_product";
		$result = $this->db->select($query);
		$get_arr = General::getArrayFetchAssoc($result);
		$get_arr = array_column($get_arr, 'Product_ID');
		$index = array_search($product_id, $get_arr);
		if ($condition == 'next') {
			$index = $index + 1;
		} else if ($condition == 'prev') {
			$index = $index - 1;
		}
		return empty($get_arr[$index]) ? null : $get_arr[$index];
	}

	// Nếu có khoảng thời gian lớn hơn expire_second thì tăng lên 1 giá trị
	// Khoảng thời gian = Date_Start - Date_End
	private function check_view($slug)
	{
		$result = $this->db->select("SELECT * FROM tbl_view_count WHERE View_Count_Slug = '$slug'");
		if ($result) {
			$array = General::getArrayFetchAssoc($result);
			$check = 0;
			foreach ($array as $value) {
				$date = $this->carbon->parse($value["Date_Start"])->diffInSeconds($this->carbon->parse($value["Date_End"]));
				if ($date > self::expire_second) {
					$check++;
				}
			}
			return $check;
		}
	}

	//Chèn giá trị vào
	// Đồng thời update lại ngày của Date_End trước đó bằng Date_start của hiện tại
	private function insert_update_view($now, $product_slug)
	{

		$query = "INSERT INTO tbl_view_count(View_Count_Slug,Date_Start,Date_End)
		VALUES('$product_slug','$now','$now')";

		$this->db->insert($query);
		$result = $this->db->select("SELECT LAST_INSERT_ID()")->fetch_assoc();
		$get_id = $result["LAST_INSERT_ID()"];

		$query = "UPDATE tbl_view_count SET Date_End = (SELECT Date_Start FROM tbl_view_count
		WHERE View_Count_ID = '$get_id') WHERE View_Count_ID = " . (int)($get_id - 1);

		$this->db->update($query);
	}

	public function update_view($product_slug, $product_view)
	{
		$now = $this->carbon->now('Asia/Ho_Chi_Minh');
		if ($product_slug != '') {
			$this->insert_update_view($now, $product_slug);

			$get_view = $this->check_view($product_slug);

			//Cập nhật lại giá trị view
			// Xóa view dựa trên slug và max của View_Count_ID
			if ($get_view > 0) {
				$count_view = $product_view + $get_view;
				$this->db->update("UPDATE tbl_product SET Product_View = '$count_view' WHERE Product_Slug = '$product_slug'");
				$this->db->delete(
					"DELETE FROM tbl_view_count WHERE View_Count_ID < (SELECT MAX(View_Count_ID) FROM tbl_view_count)
					AND View_Count_Slug = '$product_slug'"
				);
			}
		}
	}

	//Lấy dữ liệu id lớn nhất để tiến hành bước sau là update_view
	public function getSlugViewLatest()
	{
		$query = "SELECT tbl_product.Product_Slug,tbl_product.Product_View, tbl_view_count.* FROM tbl_product
		INNER JOIN tbl_view_count ON tbl_product.Product_Slug = tbl_view_count.View_Count_Slug
		ORDER BY tbl_view_count.View_Count_ID DESC LIMIT 1";
		$result = $this->db->select($query);
		if ($result) {
			$result = $result->fetch_assoc();
			return array(
				'slug' => $result['Product_Slug'],
				'view' => $result['Product_View'],
			);
		} else {
			return false;
		}
	}

	public function getSimilarPost($cate_id, $product_slug)
	{
		$query = "SELECT * FROM tbl_product WHERE Cate_Pro_ID = '$cate_id' AND Product_Slug != '$product_slug' LIMIT 3";
		$result = $this->db->select($query);
		$output = '';

		if ($result) {
			foreach (General::getArrayFetchAssoc($result) as $result) {
				$image_name = pathinfo($result["Product_Image"])['filename'];
				$image_name = Path::path_file("Upload_product_$image_name");
				// Ảnh
				$output .= '<li><div class="media wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
				<a class="media-left related-img" href="' . General::view_link("xem-tin-tuc/" . $result["Product_Slug"], true) . '">
					<img src="' . $image_name . '" alt="' . $result["Product_Name"] . '">
				</a>';
				// Nội dung
				$output .= '<div class="media-body">
				<h4 class="media-heading"><a href="' . General::view_link("xem-tin-tuc/" . $result["Product_Slug"], true) . '">' . General::limitContent($result["Product_Name"], 8) . '</a></h4>
				<p>' . General::limitContent($result["Meta_Desc_Product"], 14) . '</p>
			</div></li>';
			}
		}

		return $output;
	}
}
