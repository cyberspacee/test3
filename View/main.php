<?php
if(!isset($_SESSION["logged_user_id"])){
    header("Location: login.php");
}
include_once "../Model/DBManager.php";
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$posts = getPosts($page);

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
    <table>
        <tr>
            <th>ID</th>
            <th>Text</th>
            <th>Image</th>
            <th>Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
<?php foreach ($posts as $post) {
    $owner_logged = $post["owner_id"] == $_SESSION["logged_user_id"];
    echo "<tr>";
    echo "<td>" . $post["id"] . "</td>";
    echo "<td>" . $post["text"] . "</td>";
    echo "<td><img width='150px' src='" . $post["image_url"] . "' alt=''></td>";
    echo "<td>" . $post["price"] . "</td>";
}?>
</table>
    <a href="../Collector/backend.php?page=<?= $page-1 < 1 ? 1 : $page-1 ?>">Prev</a>
    <a href="../Collector/backend.php?page=<?= $page+1 ?>">Next</a>
    <a href="../View/addPost.php"><button>Add post</button></a>
</body>
</html>

