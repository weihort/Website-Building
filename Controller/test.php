<?php

try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=liyusky','root','111111');
    $sql = "SELECT * FROM user WHERE username = 'aaaaaa' AND password = '111111';";
    $rs = $db->query($sql);
    $re = $rs->fetch();
    var_dump($re);
    if ($re) {
        echo "1";
    }
    else {
        echo "0";
    }
} catch (Exception $e) {
    die('Error!: '.$e->getMessage().'<br />');
}
?>
