<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once "../Model/DBManager.php";

if (isset($_POST['register'])){
    if(isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['email'])){
   $user = [];
   $user['username'] = $_POST['username'];
   $user['password'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);
   $user['email'] = $_POST['email'];
   addUser($user);
    $_SESSION['logged_user_id'] = $user['user_id'];
    include_once "../View/main.php";
    }
    else{
        include_once "../View/register.php";
    }
}
if(isset($_POST['login'])){
    $user = existsUser($_POST['username']);
    $err = false;
    $msg = '';
    if(!$user){
        $msg = 'Invalid username or password';
        $err = true;
    }
    else{
        if(password_verify($_POST['password'], $user['password'])){
            $_SESSION['logged_user_id'] = $user['user_id'];
        }else{
            $msg = 'Invalid username or password';
            $err = true;
        }
    }
    if($err){
        include_once "../View/login.php";
    }else{
        include_once "../View/main.php";
    }
}