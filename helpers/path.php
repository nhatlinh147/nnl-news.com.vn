<?php

class Path
{

    private static $parent = [
        DIRECTORY_SEPARATOR, 'lib', 'helpers', 'inc', 'classes', 'js', 'vendor',
        'css', 'Admin\inc', 'Admin\js', 'Admin\css',
        'Admin\ckeditor',
        'Admin\images',
        'Admin\upload\banner', 'Admin\upload\slide', 'Admin\upload\product',
        'Admin\view\banner', 'Admin\view\brand', 'Admin\view\category', 'Admin\view\put',
        'Admin\view\login', 'Admin\view\product', 'Admin\view\slide',
        'vendor\phpmailer\phpmailer\src',
        'view', 'view\assets\css', 'view\assets\js', 'classes\User',
        'view\ckeditor-user',
        'view\category', 'view\assets\js\custom', 'view\upload\comment'
    ];

    public static $sep = DIRECTORY_SEPARATOR;

    private function getNameOrgionalFolder($str)
    {
        $arr = explode(DIRECTORY_SEPARATOR, $str);
        for ($i = 0; $i < count($arr); $i++) {
            if ($i > 0) {
                $new_arr[] = $arr[$i];
            }
        }
        return implode("_", $new_arr);
    }

    public static function get_data($condition)
    {
        $parent = self::$parent;
        $sep = self::$sep;

        foreach ($parent as $item) {

            $mydir = realpath(dirname(__DIR__) . $sep . $item);

            $myfiles = array_diff(scandir($mydir), array('.', '..', '.htaccess'));

            // $myfiles = array_filter(scandir($mydir . $sep .'vendor'), function($item) {
            //     return !is_dir($mydir . $sep .'vendor' . $sep . $item);
            // });
            foreach ($myfiles as $value) {

                if (!is_dir($mydir . $sep . $value)) {
                    $filename = pathinfo($value)['filename'];
                    $key_array = strpos($item, $sep) ? self::getNameOrgionalFolder($item) . "_" . $filename : $filename;
                    //2 trường hợp
                    // th1: xuất đường dẫn đến thư mục
                    // th2 xuất đường dẫn dirname dùng cho ghép link mã nguồn
                    $new_arr[ucfirst($key_array)] = $condition ? $mydir . $sep  . $value : $sep . $item . $sep  . $value;
                }
            }
        }


        return $new_arr;
    }

    public static function path_file_include()
    {
        $arg_list = func_get_args();
        $new_arr = [];
        for ($i = 0; $i < func_num_args(); $i++) {
            // lấy mảng tập hợp đường dẫn
            $path = self::get_data(true);

            // lấy dữ liệu trong mảng theo tham số
            include($path[$arg_list[$i]]);
        }
    }

    public function file_upload($param)
    {

        $path = self::get_data(true);

        $name = pathinfo($param)['filename'];

        // lấy dữ liệu trong mảng theo tham số
        return $path[$name];
    }

    //Lấy link đường dẫn theo http
    public static function path_file($param)
    {
        $path = self::get_data(false);

        $uri = explode('/', "$_SERVER[REQUEST_URI]");
        $actual_link = "http://$_SERVER[HTTP_HOST]" . '/' . $uri[1];
        $directory = str_replace(DIRECTORY_SEPARATOR, "/",  $path[$param]);

        return $actual_link . $directory;
    }

    //Lấy link đường dẫn theo đường dẫn local resource (máy tính)
    public static function path_file_local($param)
    {
        $path = self::get_data(true);
        return $path[$param];
    }


    public function file_upload_image($param)
    {

        $path = self::get_data(true);

        $name = pathinfo($param)['filename'];

        // lấy dữ liệu trong mảng theo tham số
        return $path[$name];
    }
}
