<?php

namespace \Controller\Comment;

use \Controller\Common;
use PDO;

// include_once $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';

$uid        = $_POST['uid'];
$fid        = $_POST['fid'];
$content    = $_POST['content'];

$insertArgs = array(
    'role' => 'commentInsert',
    'data' => array(
        'uid' => $uid,
        'fid' => $fid,
        'content' => $content,
    ),
);
try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();
    $result = $forum->executeBase($insertArgs);
    if (!$result) {
        $forum->base->rollBack();
        die('评论插入失败');
    }
    $forum->base->commit();
} catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
