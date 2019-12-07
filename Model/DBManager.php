<?php
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
        $sql = "SELECT id, text, image_url, price, owner_id FROM posts
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