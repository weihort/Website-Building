<?php
    $id = 2;//$_POST['id'];
    $dsn = "mysql:host=localhost;dbname=test2";
    $dbuser = "root";
    $dbpass = "";

    try {
      $conn = new PDO($dsn, $dbuser, $dbpass);
      $sqlin = "UPDATE forum SET agree=agree+1 WHERE id='$id'";
      $conn -> exec($sqlin);
      echo "操作成功！";
    } catch (PDOException $e) {
      die("数据库插入数据失败：" . $e->getMessage());
    }
    $conn = null;
 ?>
