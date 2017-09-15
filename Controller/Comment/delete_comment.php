<?php

namespace \Controller\Comment;

use \Controller\Common;
use PDO;

// include_once $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';

$id         = $_POST['id'];
$flag       = $_POST['flag'];

$deleteArgs = array(
    'role' => 'commentDelete',
    'data' => array(
        'id' => $id,
    ),
);
$selectArgs = array(        //设置属性
    'role' => 'replySelectDESC',
    'data' => array(
        'fid' => $id,
    ),
);

try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();
    deleteComment($forum, $deleteArgs, $selectArgs, $flag);
    if (!$result) {
        $forum->base->rollBack();
        die('评论赞同失败');
    }
    $forum->base->commit();
}
catch (PDOException $e) {
    $forum->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}

function deleteComment($Forum, $DeleteArgs, $SelectArgs, $Flag)
{
    if ($Flag) {
        $Forum->executeBase($DeleteArgs);
    }
    else {
        $Forum->executeBase($DeleteArgs);
        $_result = $Forum->getData($SelectArgs);
        if ($_result) {
            foreach ($_result as $_row) {
                $SelectArgs['data']['fid'] = $_row['id'];
                deleteComment($Forum, $DeleteArgs, $SelectArgs, $Flag);
            }
        }
    }
}
