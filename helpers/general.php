<?php

class General
{
    private static $base = 'http://localhost/nnl-news.com.vn/';

    public static function view($url, $cond = false)
    {
        return header('Location: ' . self::view_link($url, $cond));
    }

    public static function view_link($url, $cond = false)
    {
        return $cond ? self::$base . $url : self::$base . 'Admin/' . $url;
    }

    public static function view_link_location($url, $cond = false)
    {
        echo "<script>window.location = '" . self::view_link($url, $cond) . "'</script>";
    }

    public function get_check_page($page, $total_records, $number_page)
    {
        $ratio = $total_records / $number_page;

        if ($page <= 1) {
            return 1;
        } else if ($page >= $ratio) {
            return ceil($ratio);
        } else {
            return $page;
        }
    }

    public static function check_error_image($params_image, $path_image, $width_image, $height_image, $option, &$check_error)
    {
        $permited  = array('jpg', 'jpeg', 'png', 'gif');

        $file_name = $_FILES[$params_image]['name'];
        $file_size = $_FILES[$params_image]['size'];
        $file_temp = $_FILES[$params_image]['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = $path_image . $unique_image;

        $alert = "";

        if (!empty($file_name)) {
            if (in_array($file_ext, $permited) === false) {
                $alert .= '<li class="error">Bạn chỉ có thể tải tệp đuôi mở rộng:-' . implode(', ', $permited) . '</li>';
                $check_error++;
            } else if ($file_size > 3145728) {
                $alert .= '<li class="error">Kích thước hình ảnh phải nhỏ hơn 3MB!</li>';
                $check_error++;
            }
        } else {
            $alert .= '<li class="error">Hình ảnh không được để trống</li>';
            $check_error++;
        }

        if ($check_error == 0) {
            move_uploaded_file($file_temp, $uploaded_image);
            $resizeObj = new resize($uploaded_image);
            $resizeObj->resizeImage($width_image, $height_image, $option);
            // $resizeObj -> resizeImage(728, 180, 'exact');
            // $resizeObj->resizeImage(150, 150, 'auto');
            $resizeObj->saveImage($uploaded_image, 100);
        }

        $result = array(
            "error_image" => $check_error,
            "alert" => $alert,
            "unique_image" => $unique_image
        );

        return $result;
    }

    public function search($string)
    {
        $str = implode(" ", explode("_", $string));
        $array = explode(" ", strtolower($str));

        if (in_array("password", $array)) {
            $str = "pass";
        } else if (in_array("exprired", $array)) {
            $str = "exprired";
        } else {
            $str = false;
        }

        return $str;
    }

    public static function list_sql($link, $data, $params_array)
    {
        $output = '';

        for ($i = 0; $i < count($params_array); $i++) {

            $variable = $params_array[$i];

            if (self::search($variable) == "pass") {
                $variable = mysqli_real_escape_string($link, md5("123"));
            } else if (self::search($variable) == "exprired") {
                $date = date_format(date_create($data[$params_array[$i]]), "Y-m-d");
                $date = empty($date) ? false : $date;
                $variable = mysqli_real_escape_string($link, $date);
            } else if ($variable == "created_at" || $variable == "updated_at") {
                $variable = mysqli_real_escape_string($link, date('Y-m-d H:i:s'));
            } else {
                $variable = mysqli_real_escape_string($link, $data[$params_array[$i]]);
            }

            $output .= "\$$params_array[$i] = \"$variable\";";
        }

        return $output;
    }

    public function check_length_max($name, $value, &$check_error, $min = null, $max = null)
    {
        $alert = "";
        if ($min != null && strlen($value) < $min) {
            $alert .= "<li class='error'>$name có độ dài ít nhất là $min </li>";
            $check_error++;
        } else if ($max != null && strlen($value) > $max) {
            $alert .= "<li class='error'>$name có độ dài nhiều nhất là $max </li>";
            $check_error++;
        }
        return $alert;
    }

    private function makeAvatar($fontPath, $path, $char)
    {
        $image = imagecreate(200, 200);
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        imagecolorallocate($image, $red, $green, $blue);
        $textcolor = imagecolorallocate($image, 255, 255, 255);

        imagettftext($image, 225, 0, 150, 150, $textcolor, $fontPath, $char);
        // $font = imageloadfont($fontPath);
        // imagestring($image, 50, 50, 50, $char, $textcolor);

        imagejpeg($image, $path);
        imagedestroy($image);
        return $path;
    }


    public function avatar($name)
    {
        $sep = DIRECTORY_SEPARATOR;
        $dir = realpath(dirname(__DIR__));

        $path = $dir . $sep . 'upload' . $sep . 'avatar' . $sep;
        $fontPath = $dir . $sep . 'fonts' . $sep . 'poppins-v5-latin-900.ttf';

        $char = substr(ucfirst($name), 0, 2);
        $newAvatarName = rand(12, 34353) . time() . '_ ' . $name . '.png';
        $dest = $path . $sep . $newAvatarName;
        $createAvatar = self::makeAvatar($fontPath, $dest, $char);
        return $createAvatar == true ? $newAvatarName : '';
    }

    public static function getParam($index = 1)
    {
        $url = $_GET['url'];
        $array = explode("/", $url);
        $len = count($array);

        if (($index > 0 and $index < 5)) {
            return $array[$len - $index];
        } else {
            return false;
        }
    }

    //Lấy ra chuỗi bất kỳ với độ dài length
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Chuyển kết quả ấy được từ mysql thành mảng
    public static function getArrayFetchAssoc(object $object_result)
    {
        $getNewArray = [];
        if (is_object($object_result) && $object_result->num_rows) {
            while ($row = $object_result->fetch_assoc()) {
                $getNewArray[] = $row;
            }
            return $getNewArray;
        } else {
            return "Đối tượng truyền vào không hợp lệ";
        }
    }

    public static function limitContent(String $string, Int $limit = 12)
    {
        $array = explode(" ", $string);
        if (count($array) > $limit) {
            $new_arr = [];

            for ($i = 0; $i < $limit; $i++) {
                array_push($new_arr, $array[$i]);
            }

            $str = trim(implode(" ", $new_arr)) . "...";
            return $str;
        } else {
            return $string;
        }
    }
}