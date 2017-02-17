<?php
    $uid = 2;//$_POST['uid'];
    $fid = 3;//$_POST['fid'];
    $comment = "第六条评论！";//$_POST['comment'];
    $dsn = "mysql:host=localhost;dbname=test2";
    $dbuser = "root";
    $dbpass = "";

    try {
        $conn = new PDO($dsn, $dbuser, $dbpass);
        $sqlin = "INSERT INTO forum (uid, fid, comment) VALUES ('$uid', '$fid', '$comment');";
        $conn->exec($sqlin);
        echo "插入成功！";
    } catch (PDOException $e) {
      die("插入数据失败：" . $e->getMessage());
    }
    $conn = null;
 ?>
