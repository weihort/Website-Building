<?php
namespace Controller\Recommend;

use \Controller\Common;
use PDO;

include dirname(dirname(dirname(__FILE__))) . "/Controller/Common/Object.php";

$uid = $_POST['uid'];
$view = $_POST['view'];

$insertArgs = array(
    'role' => 'viewInsert',
    'data' => array(
        'uid'      => null,
        'aid'      => null,
        'agree'    => null,
        'oppose'   => null,
        'favorite' => null,
        'report'   => null,
    ),
);
$updateAppraiseArgs = array(
    'role' => null,
    'data' => array(
        'aid' => null,
    ),
);

try {
    $viewpoint->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $article->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $viewpoint->base->beginTransaction();
    $article->base->beginTransaction();
    if ($uid) {
        $insertArgs['data']['uid'] = $uid;
        foreach ($view as $aid => $opinion) {
            $insertArgs['data']['aid'] = $aid;
            foreach ($opinion as $type => $attitude) {
                $insertArgs['data'][$type] = $attitude;
            }
            $result = $viewpoint->executeBase($insertArgs);
            if (!$result) {
                $viewpoint->base->rollBack();
                die('用户态度数据插入失败');
            }
        }
    }
    foreach ($view as $aid => $opinion) {
        $updateAppraiseArgs['data']['aid'] = $aid;
        foreach ($opinion as $type => $attitude) {
            switch ($type) {
                case 'agree':
                    $updateAppraiseArgs['role'] = 'articleAgreeUpdate';
                    $result = $article->executeBase($updateAppraiseArgs);
                    break;
                case 'oppose':
                    $updateAppraiseArgs['role'] = 'articleOpposeUpdate';
                    $result = $article->executeBase($updateAppraiseArgs);
                    break;
                case 'favorite':
                    $updateAppraiseArgs['role'] = 'articleFavoriteUpdate';
                    $result = $article->executeBase($updateAppraiseArgs);
                    break;
                case 'report':
                    $updateAppraiseArgs['role'] = 'articleReportUpdate';
                    $result = $article->executeBase($updateAppraiseArgs);
                    break;
            }
            if (!$result) {
                $article->base->rollBack();
                die('用户态度数据插入失败');
            }
        }
    }
    $viewpoint->base->commit();
    $article->base->commit();
} catch (PDOException $e) {
    $viewpoint->base->rollBack();
    $article->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
 ?>
