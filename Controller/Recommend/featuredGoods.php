<?php
namespace Controller\Recommend;

use \Controller\Common;
use PDO;

include dirname(dirname(dirname(__FILE__))) . "/Controller/Common/Object.php";

$recommendJson = null;
$genre = $_POST['genre'];
$cursor = $_POST['cursor'];
$selectTopArgs = array(        //设置属性
    'role' => 'recommendSelectTop',
    'data' => array(
        'genre' => $genre,
    ),
);
$selectLaterArgs = array(
    'role' => 'recommendSelectLater',
    'data' => array(
        'genre' => $genre,
        'aid'   => $cursor,
    ),
);
$getRecommend = function ($SelectArgs) use ($article, &$recommendJson)
{
    $_result = $article->getAllData($SelectArgs);       //查询6条推荐文章数据
    if ($_result) {                                     //查询到值
        $recommendJson = $_result;
    }
};
// $a = array(
//     'role' => 'recommendInsert',
//     'data' => array(
//         'author'       => 'liyusky',
//         'genre'        => 'game',
//         'title'        => 'game-title-',
//         'description'  => 'game-description-',
//         'content_link' => null,
//         'image_link'   => 'View/Computer/images/new-section-test.jpg',
//         'agree'        => 10,
//         'oppose'       => 10,
//         'favorite'     => 10,
//         'report'       => 10,
//     ),
// );

try {
    $article->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $article->base->beginTransaction();      //开启事务
    if ($cursor) {
        $getRecommend($selectLaterArgs);            //罗列事务
    }
    else {
        $getRecommend($selectTopArgs);            //罗列事务
    }

    echo json_encode($recommendJson);
    // for ($i=1; $i < 25; $i++) {
    //     $a['data']['title'] .= $i;
    //     $a['data']['description'] .= $i;
    //     $article->executeBase($a);
    //     $a['data']['title'] = 'game-title-';
    //     $a['data']['description'] = 'game-description-';
    // }
    // $article->base->commit();
}
catch (Exception $e) {
    $article->base->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}
 ?>
