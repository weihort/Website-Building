<?php

namespace \Controller\Comment;

use Model\Tables\Forum;
use PDO;

$uid        = $_POST['uid'];
$fid        = $_POST['fid'];
$content    = $_POST['content'];

$forum      = new Forum(false);
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
    $forum->base->commit();
    if (!$result) {
        $forum->base->rollBack();
        die('评论插入失败');
    }
} catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
