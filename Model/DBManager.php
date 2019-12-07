<?php
define("ROWS_PER_PAGE", 5);

function getPDO(){
    try{
        $dsn = 'mysql:host=localhost;dbname=test3';
        $username = 'root';
        $password = '';
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );
        $db = new PDO($dsn, $username, $password, $options);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    catch (PDOException $e){
        echo "Ops .. greshka: " . $e->getMessage();
    }
}

function addUser(array &$user){
   try{
       $pdo = getPDO();
       $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?);";
       $params = [];
       $params[] = $user['username'];
       $params[] = $user['password'];
       $params[] = $user['email'];
       $statement = $pdo->prepare($sql);
       $statement->execute($params);
       $user_id = $pdo->lastInsertId();
       $user['user_id'] = $user_id;
   }
   catch (PDOException $e){
       echo $e->getMessage();
   }
}

function existsUser($username){
try{
    $pdo = getPDO();
    $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$username]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}
catch (PDOException $exception){
    echo $exception->getMessage();
}
}

function getPosts($page){
    try{
        $pdo = getPDO();
        $sql = "SELECT id, text, image_url, price, owner_id FROM posts ORDER BY price DESC 
                LIMIT ".ROWS_PER_PAGE." 
                OFFSET " . ($page-1)*ROWS_PER_PAGE;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function addPost(array &$post){
    try{

        $pdo = getPDO();
        $sql = "INSERT INTO posts (text, image_url, price, owner_id) VALUES (?, ?, ?, ?);";
        $params = [];
        $params[] = $post["text"];
        $params[] = $post["img_url"];
        $params[] = $post["price"];
        $params[] = $post["owner_id"];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $post_id = $pdo->lastInsertId();
        $post["id"] = $post_id;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function postOwnedBy($post_id, $user_id){
    try{
        $pdo = getPDO();
        $sql = "SELECT * FROM posts WHERE id = ? AND owner_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$post_id, $user_id]);
        if($stmt->rowCount() == 0) {
            return false;
        }
        else{
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function editPost(array $post){
    try{
        $pdo = getPDO();
        $sql = "UPDATE posts SET text = ?, image_url = ?, price = ? WHERE owner_id = ? AND id = ?";
        $params = [];
        $params[] = $post["text"];
        $params[] = $post["img_url"];
        $params[] = $post["price"];
        $params[] = $post["owner_id"];
        $params[] = $post['id'];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function deletePost(array $post){
    $pdo = getPDO();
    $sql = "DELETE FROM posts WHERE owner_id = ? AND id = ?;";
    $params = [];
    $params[] = $post['owner_id'];
    $params[] = $post['id'];
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
}