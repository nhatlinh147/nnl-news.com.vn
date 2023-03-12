<?php
if (!session_id()) {
    session_start();
}

interface Target
{
    public function check_email($key, $redirect, $method);
}
class Redirect
{
    public function receive($redirect): void
    {
        General::view($redirect);
    }
}
class Middleware implements Target
{
    protected $redirect;
    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }
    public function check_email($key, $redirect, $method)
    {
        if (!Session::get($key) && $method == 'session') {
            $this->redirect->receive($redirect);
        } else if (empty($_GET[$key]) && $method == 'get') {
            $this->redirect->receive($redirect);
        }
    }
}
class Email
{
    public function check_confirm()
    {
        $target = new Middleware(new Redirect);
        $target->check_email('Register', 'dang-nhap.html', 'session');
    }
    public function check_success()
    {
        $target = new Middleware(new Redirect);
        $target->check_email('token', 'dang-nhap.html', 'get');
    }
}
class M_Category
{
    public function check_child()
    {
        $target = new Middleware(new Redirect);
        $target->check_email('Child_ID', 'error-404.html', 'get');
        unset($get['Child_ID']);
    }
}
class M_Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function check_delete_product($slug)
    {
        $slug = explode("_", $slug)[0];
        $query = "SELECT Product_Slug FROM tbl_product WHERE Product_Slug = '$slug'";
        $result = $this->db->select($query);
        if (!$result) {
            General::view_link_location("error-404");
        }
    }
}
