<?php
namespace Controller\Recommend;

use \Controller\Common;
use PDO;

include dirname(dirname(dirname(__FILE__))) . "/Controller/Common/Object.php";

$uid = $_POST['uid'];
$view = $_POST['view'];

$articleUpdateAppraiseArgs = array(
    'role' => null,
    'data' => array(
        'aid' => null,
    ),
);
$viewpointInsertArgs = array(
    'role' => 'viewInsert',
    'data' => array(
        'uid'      => $uid,
        'aid'      => null,
        'agree'    => 0,
        'oppose'   => 0,
        'favorite' => 0,
        'report'   => 0,
    ),
);
$viewpointSelectArgs = array(
    'role' => 'viewSelect',
    'data' => array(
        'aid' => null,
        'uid' => $uid,
    ),
);

try {
    $viewpoint->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $article->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $viewpoint->base->beginTransaction();
    $article->base->beginTransaction();
    foreach ($view as $aid => $opinion) {
        $articleUpdateAppraiseArgs['data']['aid'] = $aid;
        foreach ($opinion as $type => $attitude) {
            if ($attitude !== '0') {
                switch ($type) {
                    case 'agree':
                    $articleUpdateAppraiseArgs['role'] = 'articleAgreeUpdate';
                    break;
                    case 'oppose':
                    $articleUpdateAppraiseArgs['role'] = 'articleOpposeUpdate';
                    break;
                    case 'favorite':
                    $articleUpdateAppraiseArgs['role'] = 'articleFavoriteUpdate';
                    break;
                    case 'report':
                    $articleUpdateAppraiseArgs['role'] = 'articleReportUpdate';
                    break;
                }
                $result = $article->executeBase($articleUpdateAppraiseArgs);
                if (!$result) {
                    $article->base->rollBack();
                    die('用户态度数据插入失败');
                }
            }
        }
    }
    if ($uid !== false) {
        $viewpointInsertArgs['data']['uid'] = $uid;
        foreach ($view as $aid => $opinion) {
            $viewpointSelectArgs['data']['aid'] = $aid;
            $viewpointSelectResult = $viewpoint->getNextData($viewpointSelectArgs);
            if (!$viewpointSelectResult) {
                $viewpointInsertArgs['data']['aid'] = $aid;
                foreach ($opinion as $type => $attitude) {
                    $viewpointInsertArgs['data'][$type] = $attitude;
                }
                $result = $viewpoint->executeBase($viewpointInsertArgs);
                if (!$result) {
                    $viewpoint->base->rollBack();
                    die('用户态度数据插入失败');
                }
                $viewpointInsertArgs['data']['agree'] = 0;
                $viewpointInsertArgs['data']['oppose'] = 0;
                $viewpointInsertArgs['data']['favorite'] = 0;
                $viewpointInsertArgs['data']['report'] = 0;
            }
        }
    }
    $viewpoint->base->commit();
    $article->base->commit();
}
catch (PDOException $e) {
    $viewpoint->base->rollBack();
    $article->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
 ?>
