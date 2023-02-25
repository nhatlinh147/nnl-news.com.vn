<?php
class Content
{
   public static $base_link = __DIR__ . '/';

   public static function get_file_content()
   {
      $array_dir = array_diff(scandir(self::$base_link), array('.', '..', '.htaccess'));
      $array_dir = array_filter($array_dir, fn ($value) => $value != "content-middle.php");
      return $array_dir;
   }

   public static function rename_file($set_name)
   {
      copy(self::$base_link . "content-middle.php", self::$base_link . $set_name);

      return self::$base_link . $set_name;
   }

   public static function put_content($link_class, $var_class, $method, $set_name, $variable = false)
   {
      try {
         $link = self::rename_file($set_name);
         $dir = realpath(dirname(__DIR__) . '../../../helpers/path.php');
         // include  $dir;
         $content = array(
            "<?php",
            "include('$dir');",
            "Path::path_file_include('Database','Format','General','$link_class');",
            "$$var_class = new $var_class();",
            "\$get_method = $$var_class->$method();",
            "echo json_encode(\$get_method);",
         );

         $content = implode("\n", $content);
         file_put_contents($link, trim($content));

         return Path::path_file('View_put_' . pathinfo($set_name)['filename']);
      } catch (Throwable $e) {
         return "Giá trị truyền vào không đúng";
      }
   }
}
?>