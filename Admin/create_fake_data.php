<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    </link>
    <title>Tạo dữ liệu</title>

    <script type="text/javascript" src=""></script>

    <style type="text/css">
        .body-content-center {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center">

        <h1 class="text-success">Tạo dữ liệu giả thành công</h1>

    </div>
    <div class="container">
        <pre>
            <?php
            $path = '\helpers\path.php';
            $dir = realpath(dirname(__DIR__) . $path);
            require($dir);

            Path::path_file_include('Autoload', 'Database', 'General');

            $faker = Faker\Factory::create();
            $carbon = new Carbon\Carbon;
            $db = new Database();
            class Init
            {
                protected $db;
                function __construct()
                {
                    $this->db = new Database();
                }
                //Tạo dữ liệu tag , keywords
                public function words($min, $max)
                {
                    global $faker;
                    $words = '';
                    $down_line = "\n";
                    for ($i = 0; $i <= $faker->numberBetween($min, $max); $i++) {
                        if ($i == 0) {
                            $words .= $faker->word;
                        } else {
                            $words .= ", " . $faker->word;
                        }
                    }
                    return  $words;
                }
                //Tạo dữ liệu các đoạn văn nhưng không xuống dòng
                public function paragraphs()
                {
                    global $faker;
                    $paragraphs = "";
                    for ($i = 0; $i <= $faker->numberBetween($min = 3, $max = 5); $i++) {
                        if ($i == 0) {
                            $paragraphs .= "<p>" . $faker->paragraph($nbSentences = 4, $variableNbSentences = true) . "</p>";
                        } else {
                            $paragraphs .= '<h3>' . $faker->sentence($nbWords = 6, $variableNbWords = true) . "</h3>"
                                . '<div class="image-content"><img src="https://loremflickr.com/700/300?random=' . $faker->biasedNumberBetween(1, 10) . '" height="300px"/></div>'
                                . "<p>" .
                                implode("</p><p>", $faker->paragraphs($nb = $faker->numberBetween($min = 3, $max = 6), $asText = false))
                                . "</p>";
                        }
                    }
                    return $paragraphs;
                }
                public function getRandomCateId()
                {
                    //truy vấn lấy những category là con của category khác hoặc category không có child
                    $query = "SELECT Cate_Pro_ID FROM tbl_category_product WHERE Cate_Pro_Parent != 0 OR Cate_Pro_ID NOT IN ( SELECT DISTINCT Cate_Pro_Parent FROM tbl_category_product WHERE Cate_Pro_Parent > 0 ) AND Cate_Pro_Parent = 0;";

                    $get_result = $this->db->select($query);
                    $new_array = [];
                    while ($result = $get_result->fetch_assoc()) {
                        array_push($new_array, $result['Cate_Pro_ID']);
                    }
                    $selected = rand(0, count($new_array) - 1);
                    return $new_array[$selected];
                }
                public function removeImage($link)
                {
                    foreach (glob($link . DIRECTORY_SEPARATOR . "*") as $file) { // iterate files
                        if (is_file($file)) {
                            unlink($file); // delete file
                        }
                    }
                }
            }
            class Factory extends Init
            {
                function __construct()
                {
                    parent::__construct();
                }

                public function visitor($condition)
                {
                    global $faker;

                    $ip = $faker->localIpv4;

                    $jeans = $faker->numberBetween($min = 100, $max = 300);
                    $sweater = $faker->numberBetween($min = 200, $max = 400);
                    $men_shirt = $faker->numberBetween($min = 300, $max = 500);

                    $date = $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d h:m:s');

                    $query = $condition ? "INSERT INTO tbl_visitor(Visitor_IP,Visitor_Jeans,Visitor_Sweater,Visitor_Men_Shirt,Visitor_Date) VALUES('$ip','$jeans','$sweater','$men_shirt','$date')" : "DELETE FROM tbl_visitor";

                    return $query;
                }

                public function customer($condition)
                {
                    global $faker;

                    $faker->addProvider(new \Faker\Provider\vi_VN\PhoneNumber($faker));
                    $faker->addProvider(new \Faker\Provider\vi_VN\Address($faker));

                    $name = $faker->unique()->userName;
                    $email = $faker->unique()->freeEmail;
                    $password = md5("123");
                    $address = $faker->randomElement([$faker->province, $faker->city]);
                    $phone = $faker->phoneNumber;
                    $login = $faker->randomElement(["Admin", "Admin", "Google", "Facebook"]);
                    $date = $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d h:m:s');

                    $query = $condition ? "INSERT INTO tbl_customer(Customer_Name,Customer_Email,Customer_Password,Customer_Address,Customer_Phone,Customer_Login,Customer_Date) VALUES('$name','$email','$password','$address','$phone','$login','$date')" : "DELETE FROM tbl_customer";
                    return $query;
                }

                public function order($condition)
                {
                    global $faker;
                    $expense = $faker->randomNumber(8);
                    $delivery = $faker->numberBetween($min = 0, $max = 9) * 500000;
                    $discount = $faker->numberBetween($min = 0, $max = 9) * 1000000;

                    $date = $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d h:m:s');
                    $query = $condition ? "INSERT INTO tbl_order(Order_Expense,Order_Discount,Order_Delivery,Order_Date) VALUES('$expense','$discount','$delivery','$date')" : "DELETE FROM tbl_order";
                    return $query;
                }

                public function sales($condition)
                {
                    global $faker;

                    $quantity = $faker->randomNumber(2);

                    $date = $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d h:m:s');

                    $query = $condition ? "INSERT INTO tbl_sales(Sales_Quantity , Sales_Date) VALUES('$quantity','$date')" : "DELETE FROM tbl_sales";
                    return $query;
                }

                public function slide($condition)
                {
                    global $faker;

                    $image = $faker->image('D:\xampp\htdocs\Projec PHP thuần\Admin\upload\slide', 550, 425, null, false);
                    $title = $faker->sentence($nbWords = 5, $variableNbWords = true);
                    $slug = $faker->slug();
                    $paragraph =  $faker->paragraph($nbSentences = 5, $variableNbSentences = true);

                    $query = $condition ? "INSERT INTO tbl_slide(Slide_Image , Slide_Title,Slide_Slug , Slide_Desc,Slide_Status)VALUES('$image' , '$title','$slug' , '$paragraph',1)" : "DELETE FROM tbl_slide";
                    return $query;
                }

                private function category($condition)
                {
                    global $faker;

                    $name = $faker->sentence($nbWords = rand(3, 5), $variableNbWords = true);
                    $slug = $faker->slug();
                    $parent = 0;
                    $keywords  = $this->words(3, rand(5, 8));
                    $status = 1;

                    $query = $condition ? "INSERT INTO tbl_category_product(Cate_Pro_Name , Cate_Pro_Slug,Cate_Pro_Parent , Meta_Keywords_CatePro,Cate_Pro_Status)
                    VALUES('$name' , '$slug','$parent' , '$keywords','$status')" : "DELETE FROM tbl_category_product";
                    return $query;
                }

                private function product($condition)
                {
                    global $faker, $carbon;

                    $username = $faker->userName;
                    $name = $faker->paragraph($nbSentences = rand(2, 4));
                    $slug = $faker->slug;
                    $image = $faker->image("D:/xampp/htdocs/Projec PHP thuần/Admin/upload/product", 500, 400, null, false);
                    $content = $this->paragraphs();
                    $view = rand(200, 600);
                    $keywords  = $this->words(3, rand(5, 8));
                    $desc = $faker->paragraph($nbSentences = rand(4, 7));
                    $cate_id = $this->getRandomCateId();
                    $status = 1;
                    $created = $carbon->now('Asia/Ho_Chi_Minh');
                    $upadated = $carbon->now('Asia/Ho_Chi_Minh')->addHours(10);

                    $query = $condition ? "INSERT INTO tbl_product(Product_UserName , Product_Name,Product_Slug ,
                    Product_Image , Product_Content , Product_View , Meta_Keywords_Product , Meta_Desc_Product ,
                    Cate_Pro_ID , Product_Status , created_at , updated_at)
                    VALUES('$username' , '$name','$slug' , '$image','$content','$view' , '$keywords','$desc' ,
                    '$cate_id','$status','$created' , '$upadated')" : "DELETE FROM tbl_product";
                    return $query;
                }

                public function factory($params_loop, $params_function)
                {
                    global $db;

                    $range = range(0, (int)$params_loop - 1);

                    $this->db->delete($this->$params_function(false));

                    foreach ($range as $key => $value) {
                        $query = $this->$params_function(true);
                        $result =  $this->db->insert($query);
                    }
                }
            }
            ?>

            <?php
            $factory = new Factory();

            // Tiến hành tạo dữ liệu đồng thời xóa dữ liệu trước đó
            $factory->factory(6000, 'visitor');
            $factory->factory(3000, 'customer');
            $factory->factory(6000, 'order');
            $factory->factory(1000, 'sales');

            // Xóa image
            // ini_set('max_execution_time', '3000');
            // $factory->removeImage("D:/xampp/htdocs/Projec PHP thuần/Admin/upload/product");
            // $factory->factory(1000, 'product');

            ?>
        </pre>

    </div>

    <div class="container">
        <?php

        // $content = file_get_contents("../Admin/content.php");

        // $array = array(
        //     'login' => 'Đăng nhập',
        //      'remember' => 'Lưu mật khẩu'
        // );

        // foreach ($array as $key => $value) {
        //     $pattern = '/\{{2}(\s{0,}\$'. $key .'\s{0,}\;{0,1})\}{2}/';

        //     // echo $pattern;

        //     if(preg_match($pattern, $content)){
        //         $content = preg_replace($pattern, $value , $content);
        //     }else {
        //         echo "Không hợp lệ";
        //     }

        // }
        // $pattern_php = '/\<\?php(.|\n)*\?\>/';

        // if(preg_match($pattern_php, $content, $match)){
        //     print_r($match);
        // }

        // echo $content;

        ?>
    </div>

</body>

</html>