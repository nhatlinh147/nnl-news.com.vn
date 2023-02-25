<?php

/**
 * 
 */
class Home
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function show_home()
	{
		$query_array = array(
			'slide' => "SELECT * FROM tbl_slide",
			'category_parent' => "SELECT * FROM tbl_category_product WHERE Cate_Pro_Parent = 0",
			'category' => "SELECT * FROM tbl_category_product",
			'product_popular' => "SELECT * FROM `tbl_product` ORDER BY Product_View DESC LIMIT 4",
			'recent_product' => "SELECT * FROM `tbl_product` ORDER BY created_at DESC LIMIT 4",
			'banner' => "SELECT * FROM `tbl_banner` ORDER BY Created_At DESC LIMIT 1",
			'info' => "SELECT * FROM `tbl_info` ORDER BY Info_ID DESC LIMIT 1"
		);

		$new_arr = [];

		foreach ($query_array as $key => $value) {
			$new_arr[$key] = $this->db->select($value);
		}
		return $new_arr;
	}
	public function productOfCateChild($cate_id, $limit = false)
	{
		//Query để check category nào có category_parent
		$query = "SELECT * FROM tbl_category_product WHERE Cate_Pro_Parent = " . $cate_id;
		$result = $this->db->select($query);

		//Query chung (select cùng sát nhập 2 bảng)
		$query_other = "SELECT tbl_product.* , tbl_category_product.* FROM tbl_product 
		INNER JOIN tbl_category_product ON tbl_product.Cate_Pro_ID = tbl_category_product.Cate_Pro_ID";

		//2 trường hợp có child và không child
		if ($result) {
			$query = $query_other . " WHERE tbl_product.Cate_Pro_ID IN (SELECT Cate_Pro_ID FROM tbl_category_product WHERE Cate_Pro_Parent = '$cate_id')";
		} else {
			$query = $query_other . " WHERE tbl_product.Cate_Pro_ID = " . $cate_id;
		}

		if ($limit) {
			$query = $query . " ORDER BY Product_ID DESC LIMIT " . $limit;
		} else {
			$query = $query . " ORDER BY Product_ID DESC";
		}

		$result = $this->db->select($query);
		return General::getArrayFetchAssoc($result);
	}

	public function search_product()
	{
		$get_query = $_GET["query"];
		$query = "SELECT * FROM tbl_product WHERE Product_Name LIKE '%$get_query%' ORDER BY Product_ID DESC LIMIT 10";
		$result = $this->db->select($query);
		$result = General::getArrayFetchAssoc($result) ?? "false";
		return $result;
	}
}
