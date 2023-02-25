<?php

/**
 * 
 */
class Dashboard
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function dashboardTitleAdmin()
	{
		$meta = array(
			'title_add' => 'Thêm slide - NNLShop',
		);
		return $meta;
	}

	public function marketUpdateStatistic()
	{

		$query_array = array(
			'visitor' => "SELECT Visitor_ID FROM tbl_visitor",
			'sales' => "SELECT Sales_ID FROM tbl_sales",
			'order' => "SELECT Order_ID FROM tbl_order",
			'customer' => "SELECT Customer_ID FROM tbl_customer"
		);

		$new_arr = [];

		foreach ($query_array as $key => $value) {
			$value = $this->db->select($value)->num_rows;
			$new_arr[$key] = number_format($value, 0, '.', ',');
		}

		return json_decode(json_encode($new_arr));
	}
	private function prev_week($str)
	{
		$result = "GROUP BY DATE_FORMAT(`" . $str . "`, '%d-%m-%Y') HAVING " . $str . " >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY AND " . $str . " < CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY ";
		return $result;
	}

	private function min_max($condition, $array)
	{

		if ($condition == 'max') {
			$data = max(array_map(function ($value) {
				return max(array_map(fn ($item) => is_numeric($item) ?  $item : 0, $value));
			}, $array));
		} else if ($condition == 'min') {
			$data = min(array_map(function ($value) {
				return min(array_map(fn ($item) => is_numeric($item) ?  $item : 'NO', $value));
			}, $array));
		}

		return $data;
	}

	public function visitorStatisticDonut($condition)
	{
		if ($condition == 1) {
			//Dữ liệu ngày cuối tuần trước
			$query = " SELECT SUM(Visitor_Jeans) as Sum_Jeans , SUM(Visitor_Sweater) as Sum_Sweater,SUM(Visitor_Men_Shirt) as Sum_Men_Shirt, Visitor_Date FROM tbl_visitor GROUP BY DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') HAVING DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') = DATE_FORMAT(CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY, '%d-%m-%Y') LIMIT 1 OFFSET 0";
		} else if ($condition == 0) {
			//Dữ liệu ngày gần đây nhâ
			$query = " SELECT SUM(Visitor_Jeans) as Sum_Jeans , SUM(Visitor_Sweater) as Sum_Sweater,SUM(Visitor_Men_Shirt) as Sum_Men_Shirt, Visitor_Date FROM tbl_visitor GROUP BY DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') HAVING DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') = DATE_FORMAT((SELECT MAX(Visitor_Date) FROM tbl_visitor), '%d-%m-%Y') LIMIT 1 OFFSET 0 ";
		}

		$result = $this->db->select($query);

		if ($result) {
			$result = $result->fetch_assoc();
			$data = [
				"id" => $condition == 0 ? "Visitor_donut_01" : "Visitor_donut_02",
				"data" => [
					['label' => 'Áo sơ mi nam', 'value' => $result['Sum_Men_Shirt']],
					['label' => 'Áo len', 'value' => $result['Sum_Sweater']],
					['label' => 'Quần jean', 'value' => $result['Sum_Jeans']]
				],
				"colors" => ['red', 'green', 'orange']
			];
			return json_encode($data);
		}
	}

	public function visitorStatisticArea()
	{

		$query = " SELECT SUM(Visitor_Jeans) as Sum_Jeans , SUM(Visitor_Sweater) as Sum_Sweater,SUM(Visitor_Men_Shirt) as Sum_Men_Shirt, Visitor_Date FROM tbl_visitor " . $this->prev_week('Visitor_Date');

		$result = $this->db->select($query);

		if ($result) {
			$new_arr = [];
			while ($row = $result->fetch_assoc()) {
				$new_arr[] = [
					'Visitor_Date' => date_format(date_create($row["Visitor_Date"]), "Y-m-d"),
					'Sum_Jeans' => $row["Sum_Jeans"],
					'Sum_Sweater' => $row["Sum_Sweater"],
					'Sum_Men_Shirt' => $row["Sum_Men_Shirt"]
				];
			}

			$data = [
				"id" => "hero-area",
				"data" => $new_arr,
				"xkey" => 'Visitor_Date',
				"ykeys" => ['Sum_Men_Shirt', 'Sum_Sweater', 'Sum_Jeans'],
				"labels" => ['Áo sơ mi nam', 'Áo len', 'Quần jean'],
				"lineColors" => ['#23ff78', '#1c9eff', '#794bff'],
				"ymax" => ceil($this->min_max('max', $new_arr) / 10000) * 10000,
				"ymin" => floor($this->min_max('min', $new_arr) / 10000) * 10000
			];

			return json_encode($data);
		}
	}

	public function orderStatistic($condition)
	{
		$query = " SELECT Order_Date , SUM(Order_Expense) - SUM(Order_Discount) - SUM(Order_Delivery) as Sum_Revenue, SUM(Order_Expense) as Sum_Expense , SUM(Order_Discount) as Sum_Discount ,SUM(Order_Delivery) as Sum_Delivery , Order_Date FROM tbl_order " . $this->prev_week('Order_Date');

		$result = $this->db->select($query);

		if ($result) {
			$new_arr = [];
			while ($row = $result->fetch_assoc()) {
				$date = date_format(date_create($row["Order_Date"]), "Y-m-d");

				if ($condition  == 0) {

					$new_arr[] = [
						'Order_Date' => $date,
						'Sum_Expense' => $row["Sum_Expense"],
						'Sum_Revenue' => $row["Sum_Revenue"]
					];
				} else {
					$new_arr[] = [
						'Order_Date' => $date,
						'Sum_Discount' => $row["Sum_Discount"],
						'Sum_Delivery' => $row["Sum_Delivery"]
					];
				}
			}

			if ($condition  == 0) {
				$data = [
					"id" => "order_statistic_morris",
					"data" => $new_arr,
					"xkey" => 'Order_Date',
					"ykeys" => ['Sum_Expense', 'Sum_Revenue'],
					"labels" => ['Giá bán', 'Doanh thu'],
					"lineColors" => ['Violet', 'blue'],
					"ymax" => ceil($this->min_max('max', $new_arr) / 1000000000) * 1000000000,
					"ymin" => floor($this->min_max('min', $new_arr) / 1000000000) * 1000000000
					// "lineColors" => ['#ff4343','#926383','#e77b7b'],
				];
			} else {
				$data = [
					"id" => "order_statistic_morris_01",
					"data" => $new_arr,
					"xkey" => 'Order_Date',
					"ykeys" => ['Sum_Discount', 'Sum_Delivery'],
					"labels" => ['Giảm giá', 'Giao hàng'],
					"lineColors" => ['#94ff56', '#34f5ff'],
					"ymax" => ceil($this->min_max('max', $new_arr) / 100000000) * 100000000,
					"ymin" => floor($this->min_max('min', $new_arr) / 100000000) * 100000000
					// "lineColors" => ['#ff4343','#926383','#e77b7b'],
				];
			}


			return json_encode($data);
		}
	}

	public function customerStatisticLine()
	{

		$query = "SELECT Customer_Date , Count(Customer_ID ) as Count_ID FROM tbl_customer " . $this->prev_week('Customer_Date');


		$result = $this->db->select($query);

		if ($result) {
			$new_arr = [];
			while ($row = $result->fetch_assoc()) {
				$new_arr[] = [
					'Customer_Date' => date_format(date_create($row["Customer_Date"]), "Y-m-d"),
					'Count_ID' => $row["Count_ID"],
				];
			}

			$data = [
				"data" => $new_arr,
				"xkey" => 'Customer_Date',
				"ykeys" => ['Count_ID'],
				"labels" => ['Số lượng người dùng'],
				"lineColors" => ['blue'],
				"ymax" => ceil($this->min_max('max', $new_arr) / 10) * 10,
				"ymin" => floor($this->min_max('min', $new_arr) / 10) * 10
			];

			return json_encode($data);
		}
	}

	public function salesStatisticLine()
	{

		$query = " SELECT Sales_Date , SUM(Sales_Quantity) as Sum_Quantity FROM tbl_sales " . $this->prev_week('Sales_Date');

		$result = $this->db->select($query);

		if ($result) {
			$new_arr = [];
			while ($row = $result->fetch_assoc()) {
				$new_arr[] = [
					'Sales_Date' => date_format(date_create($row["Sales_Date"]), "Y-m-d"),
					'Sum_Quantity' => $row["Sum_Quantity"],
				];
			}

			$data = [
				"data" => $new_arr,
				"xkey" => 'Sales_Date',
				"ykeys" => ['Sum_Quantity'],
				"labels" => ['Doanh số bán hàng'],
				"lineColors" => ['green'],
				"ymax" => ceil($this->min_max('max', $new_arr) / 1000) * 1000,
				"ymin" => floor($this->min_max('min', $new_arr) / 1000) * 1000
			];

			return json_encode($data);
		}
	}
}
