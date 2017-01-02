<?php

namespace \Controller\Comment;

use Model\Tables\Forum;
use PDO;

$id        = $_POST['id'];

$forum     = new Forum(false);
$agreeArgs = array(
    'role' => 'commentAgree',
    'data' => array(
        'id' => $id,
    ),
);
try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();
    $result = $forum->executeBase($agreeArgs);
    $forum->base->commit();
    if (!$result) {
        $forum->base->rollBack();
        die('评论赞同失败');
    }
} catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
