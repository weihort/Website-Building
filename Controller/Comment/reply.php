<?php
namespace Controller\Comment;

use Modal\Tables\Forum;
use PDO;

include $_SESSION["ROOT_PATH"] . '/Model/Forum.class.php ';
header('Content-Type:text/html;charset=utf-8');

$fid     = $_POST['fid'];
$uid     = $_POST['uid'];
$content = $_POST['content'];
$forum   = new Forum(false);
$insertArgs = array(        //设置属性
    'role' => 'replyInsert',
    'data' => array(
        'fid'     => $fid,
        'uid'     => $uid,
        'content' => $content
    )
);
try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();      //开启事务
    $forum->executeBase($insertArgs);
} catch (Exception $e) {
    $forum->base->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}

 ?>
