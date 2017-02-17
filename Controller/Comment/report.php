<?php
    $id     = $_POST['id'];
    $dsn    = "mysql:host=localhost;dbname=test";
    $dbuser = "root";
    $dbpass = "111111";

    try {
      $conn = new PDO($dsn, $dbuser, $dbpass);
      $sql = "UPDATE forum SET tip='1' WHERE id='$id';";
      $conn->exec($sql);
    } catch (PDOException $e) {
      die("数据库插入数据失败：" . $e->getMessage());
    }
    $conn = null;
 ?>
