<?php
session_start();
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
    <form action="../Collector/backend.php" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
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
            echo "<td>".$post["id"]."</td>";
            echo "<td>".$post["text"]."</td>";
            echo "<td><img width='150px' src='../Collector/".$post["image_url"]."' alt=''></td>";
            echo "<td>".$post["price"]."</td>";
            if($owner_logged){
                echo "<td><form action='../View/editPost.php' method='post'>
                            <input type='hidden' name='post_id' value='".$post["id"]."'>
                            <input type='submit' value='Edit' name='editPost'>
                          </form></td>";
                echo "<td><form action='../Collector/backend.php' method='post'>
                            <input type='hidden' name='post_id' value='".$post["id"]."'>
                            <input type='submit' value='Delete' name='deletePost'>
                          </form></td>";
            }
            else {
                echo "<td></td>";
                echo "<td></td>";
            }
            echo "</tr>";

        } ?>
</table>
    <a href="../Collector/backend.php?page=<?= $page-1 < 1 ? 1 : $page-1 ?>">Prev</a>
    <a href="../Collector/backend.php?page=<?= $page+1 ?>">Next</a>
    <a href="../View/addPost.php"><button>Add post</button></a>

</body>
</html>

