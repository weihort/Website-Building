<?php
    $id = 1;//$_POST['id'];
    $dsn = "mysql:host=localhost;dbname=test2";
    $dbuser = "root";
    $dbpass = "";

    try {
        $conn = new PDO($dsn, $dbuser, $dbpass);
        $sqldelete = "DELETE FROM forum WHERE id='$id'";
        $conn -> query($sqldelete);
    } catch (PDOException $e) {
        die("数据库插入数据失败：" . $e->getMessage());
    }

 ?>
