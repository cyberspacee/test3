<?php
session_start();
include_once "../Model/DBManager.php";

if(!isset($_SESSION["logged_user_id"])){
    echo "ne si lognat";
//    header("Location: login.php");
//    die();
}

if(isset($_POST["editPost"])){

    $post_id = $_POST["post_id"];
    $logged_id = $_SESSION["logged_user_id"];
    $post = postOwnedBy($post_id, $logged_id);
    if($post){
        $edit = true;
    }
    else{
        echo "wtf";
//        header("Location: login.php");
//        die();
    }

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Edit post</h1>
<form action="../Collector/backend.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $post["id"] ?>">
    Text<input type="text" name="text" value="<?= $post["text"] ?>" required><br>
    Image<input type="file" name="file" value="<?= $post["image_url"] ?>" required><br>
    Price<input type="number" name="price" value="<?= $post["price"] ?>" required><br>
    <input type="submit" value="Edit" name="editPost">
</form>
</body>
</html>

