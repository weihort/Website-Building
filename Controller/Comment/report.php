<?php

namespace \Controller\Comment;

use \Controller\Common;
use PDO;

// include_once $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';

$id         = $_POST['id'];

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
    if (!$result) {
        $forum->base->rollBack();
        die('评论举报失败');
    }
    $forum->base->commit();
} catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
