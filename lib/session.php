<?php

<<<<<<< HEAD
class Session
{

    public static function init()
    {
        if (version_compare(phpversion(), '5.4.0', '<')) { //Version phiên bản php hiện tại phải lớn hơn 5.4.0
            if (session_id() == '') {
                session_start();
            }
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    public static function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkSession()
    {
        self::init();
        if (self::get("AdminLogin") == false) {
            self::destroy();
            General::view('dang-nhap.html');
        }
    }

    public static function checkLogin()
    {
        self::init();
        if (self::get("AdminLogin") == true) {
            General::view('trang-chu.html');
        }
    }

    public static function destroy()
    {
        session_destroy();
        echo "<script>window.location = '" . General::view_link('dang-nhap.html') . "'</script>";
    }

    // customer session

    public static function checkSessionCustomer()
    {
        self::init();
        if (self::get("CustomerLogin") == false) {
            self::destroy();
            General::view('dang-nhap.html', true);
        }
    }

    public static function checkLoginCustomer()
    {
        self::init();
        if (self::get("CustomerLogin") == true) {
            General::view('trang-chu.html', true);
        }
    }
}
=======
class Session{
  
 public static function init(){
  if (version_compare(phpversion(), '5.4.0', '<')) { //Version phiên bản php hiện tại phải lớn hơn 5.4.0
        if (session_id() == '') {
            session_start();
        }
    } else {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
 }

 public static function set($key, $val){
    $_SESSION[$key] = $val;
 }

 public static function get($key){
    if (isset($_SESSION[$key])) {
     return $_SESSION[$key];
    } else {
     return false;
    }
 }

 public static function checkSession(){
    self::init();
    if (self::get("AdminLogin") == false) {
      self::destroy();
      General::view('dang-nhap.html');
    }
 }

 public static function checkLogin(){
    self::init();
    if (self::get("AdminLogin")== true) {
        General::view('trang-chu.html');
    }
 }

 public static function destroy(){
  session_destroy();
  echo "<script>window.location = '" . General::view_link('dang-nhap.html') . "'</script>";
 }

}
?>

>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
