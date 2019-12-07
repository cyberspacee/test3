<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once "../Model/DBManager.php";
define("USERNAME_MIN_LENGTH", 8);

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
if(isset($_POST["addPost"])){
    if(!isset($_SESSION["logged_user_id"])){
        header("Location: login.php");
    }
    else {
        $price = $_POST["price"];
        $text = $_POST["text"];
        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
            $file_name_parts = explode(".", $_FILES["file"]["name"]);
            $extension = $file_name_parts[count($file_name_parts) - 1];
            $filename = $_SESSION["logged_user_id"] . "-" . time() . "." . $extension;
            $img_url = "uploads" . DIRECTORY_SEPARATOR . $filename;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $img_url)) {
                $owner_id = $_SESSION["logged_user_id"];
                $post = [];
                $post["text"] = $text;
                $post["price"] = $price;
                $post["img_url"] = $img_url;
                $post["owner_id"] = $owner_id;
                addPost($post);
                header("Location: main.php");
            }
            else{
                echo "file not moved '". $_FILES['file']['tmp_name'] . "'.";
//                header("Location: addPost.php");
            }
        }
        else{
            echo "file not uploaded '". $_FILES['file']['tmp_name'] . "'.";
//            header("Location: addPost.php");
        }

    }

}