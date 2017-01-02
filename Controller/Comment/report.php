<?php

namespace \Controller\Comment;

use Model\Tables\Forum;
use PDO;

$id         = $_POST['id'];

$forum      = new Forum(false);
$reportArgs = array(
    'role' => 'commentReport',
    'data' => array(
        'id' => $id,
    ),
);
try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();
    $result = $forum->executeBase($reportArgs);
    $forum->base->commit();
    if (!$result) {
        $forum->base->rollBack();
        die('评论举报失败');
    }
} catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
