CREATE TABLE `tbl_sales` (
  `Sales_ID` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `Sales_Quantity` int(10) NOT NULL,
  `Sales_Date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Sales_Date` DATE NOT NULL FORMAT 'YYYY-MM-DD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DELETE FROM tbl_account, tbl_token_email 
WHERE tbl_account.Account_ID = tbl_token_email.Token_Email_Account
AND tbl_token_email.Token_Email_Account = 4

SELECT * FROM tbl_category_product GROUP BY Cate_Pro_Parent HAVING Cate_Pro_Parent > 0


-- Lọc ra các ngày trong dữ liệu
SELECT  Visitor_Date FROM tbl_visitor GROUP BY DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') ORDER BY Visitor_Date DESC

-- Dữ liệu tuần trước
SELECT Order_Date , SUM(Order_Expense) - SUM(Order_Discount) - SUM(Order_Delivery) as Sum_Revenue, SUM(Order_Expense) as Sum_Expense , SUM(Order_Discount) as Sum_Discount ,SUM(Order_Delivery) as Sum_Delivery FROM tbl_order GROUP BY DATE_FORMAT(`Order_Date`, '%d-%m-%Y')
HAVING Order_Date >= CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) + 6 DAY
AND Order_Date < CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY

-- Lấy dữ liệu cuối ngày tuần trước
SELECT SUM(Visitor_Jeans) as Sum_Jeans , SUM(Visitor_Sweater) as Sum_Sweater,SUM(Visitor_Men_Shirt) as Sum_Men_Shirt, Visitor_Date FROM tbl_visitor GROUP BY DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') HAVING DATE_FORMAT(`Visitor_Date`, '%d-%m-%Y') = DATE_FORMAT((SELECT MAX(Visitor_Date) FROM tbl_visitor), '%d-%m-%Y') LIMIT 1 OFFSET 0

<<<<<<< HEAD
-- tbl_comment
CREATE TABLE `tbl_comment` (
  `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `parent` int(10) NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `attachments` text NOT NULL,
  `pings` text NOT NULL,
  `creator` int(10) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `profile_picture_url` varchar(255) NOT NULL,
  `created_by_admin` boolean NOT NULL,
  `created_by_current_user` boolean NOT NULL,
  `upvote_count` int(10) NOT NULL,
  `user_has_upvoted` boolean NOT NULL,
  `is_new` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_customer` (
  `Customer_ID` int(11) NOT NULL,
  `Customer_Fullname` varchar(255) NOT NULL DEFAULT 'Chưa có',
  `Customer_User` varchar(50) NOT NULL,
  `Customer_Email` varchar(255) NOT NULL,
  `Customer_Phone` int(50) NOT NULL,
  `Customer_Address` varchar(50) NOT NULL,
  `Customer_Password` varchar(255) NOT NULL,
  `Created_At` date NOT NULL
=======

CREATE TABLE `tbl_info` (
  `Info_ID` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `Info_Webname` varchar(50) NOT NULL,
  `Info_Shopname` varchar(50) NOT NULL,
  `Info_Phone` varchar(50) NOT NULL,
  `Info_Social` varchar(50) NOT NULL,
  `Info_Image` varchar(50) NOT NULL,
  `Info_About_Us` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tbl_contact` (
  `Contact_ID` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `Contact_Name` varchar(50) NOT NULL,
  `Contact_Email` varchar(50) NOT NULL,
  `Contact_Subject` varchar(50) NOT NULL,
  `Contact_Message` text NOT NULL
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Update auto_increment
ALTER TABLE document MODIFY COLUMN document_id INT auto_increment
SELECT Product_ID,Product_Name,Product_View,Product_Slug FROM tbl_product WHERE Product_ID IN (732,733)