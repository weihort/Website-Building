<?php

namespace Controller\Comment;

use \Controller\Common;
use PDO;

// include_once $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';

$id        = $_POST['id'];
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
    if (!$result) {
        $forum->base->rollBack();
        die('赞同失败');
    }
    $forum->base->commit();
} catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
