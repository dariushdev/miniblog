<?php


namespace App\Core;

use App\Controllers\Login;

class Session extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function set($userId, $name)
    {
        $_SESSION['userid'] = $userId;
        $_SESSION['name'] = $name;
        $_SESSION['loggedin'] = true;
    }

    public function addError($error)
    {
        $_SESSION['flash']['error'] = $error;
    }

    public function addSuccess($success)
    {
        $_SESSION['flash']['success'] = $success;
    }

    public function flash($type)
    {
        if(isset($_SESSION[$type]))
        {
            unset($_SESSION[$type]);
        }

    }

    public function isLoggedin()
    {
        if ($_SESSION['loggedin'] == false) {
            header("Location: http://{$_SERVER['HTTP_HOST']}/user/login");
            die();
        }
    }

}