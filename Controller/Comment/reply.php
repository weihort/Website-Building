<?php

namespace \Controller\Comment;

use \Controller\Common;
use PDO;

// include_once $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';

$fid        = $_POST['fid'];
$uid        = $_POST['uid'];
$content    = $_POST['content'];
$insertArgs = array(        //设置属性
    'role' => 'replyInsert',
    'data' => array(
        'fid'     => $fid,
        'uid'     => $uid,
        'content' => $content,
    ),
);
try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();      //开启事务
    $result = $forum->executeBase($insertArgs);
    if (!$result) {
        dirname('插入失败！');
    }
    $forum->base->commit();
} catch (Exception $e) {
    $forum->base->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}
