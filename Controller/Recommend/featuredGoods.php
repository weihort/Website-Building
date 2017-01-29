<?php
namespace Controller\Recommend;

use \Controller\Common;
use PDO;

include dirname(dirname(dirname(__FILE__))) . "/Controller/Common/Object.php";

$recommendJson = null;
$genre = $_POST['genre'];
$selectArgs = array(        //设置属性
    'role' => 'recommendSelect',
    'data' => array(
        'genre' => $genre,
    ),
);
$getRecommend = function ($SelectArgs) use ($article, &$recommendJson)
{
    $_result = $article->getAllData($SelectArgs);       //查询6条推荐文章数据
    if ($_result) {                                     //查询到值
        $recommendJson = $_result;
    }
};

try {
    $article->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $article->base->beginTransaction();      //开启事务
    $getRecommend($selectArgs);            //罗列事务
    echo json_encode($recommendJson);
}
catch (Exception $e) {
    $article->base->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}
 ?>
