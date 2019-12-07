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
<h1>Add post</h1>
<form action="../Collector/backend.php" method="post" enctype="multipart/form-data">

    Text<input type="text" name="text" required><br>
Image<input type="file" name="file" required><br>
Price<input type="number" name="price" required><br>
    <input type="submit" value="Add" name="addPost">
</form>
</body>
</html>