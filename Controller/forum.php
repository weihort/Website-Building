<?php

namespace Controller;

use Modal\Forum\Forum;
use PDO;
//引入要实例化的类
include '../Model/Forum.Class.php ';
header('Content-Type:text/html;charset=utf-8');
$tabNum     = 0;    //需要缩进的数
$forum      = new Forum(false);     //实例化
$selectAttr = array(        //设置属性
    'role' => 'reviewSelect',
    'data' => array(
        'fid' => 1,
    ),
);
try {
    $forum->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->dbObj->beginTransaction();      //开启事务
    getContent($forum, $selectAttr, $tabNum);           //罗列事务
}
catch (Exception $e) {
    $forum->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}

/**
 * [getContent 获取评论内容]
 * @method   getContent
 * @param    [Forum]                  $forum      [数据库操作对象]
 * @param    [array]                  $selectAttr [属性值]
 * @param    [int]                    $tabNum     [缩进值]
 * @version  [1.0]
 * @author liyusky
 * @datetime 2016-12-12T11:05:23+080
 */
function getContent($forum, $selectAttr, $tabNum)
{
    $selectResult = $forum->selectDB($selectAttr);      //查询事务
    $num          = $tabNum++;              //设置每层的缩进数
    if ($selectResult) {            //查询到值
        foreach ($selectResult as $row) {       //选取每条数据
            foreach ($row as $key => $value) {      //选取每条数据中的key和value
                if ($key !== 0) {           //非下标为0
                    if ($key == 'id') {
                        $selectAttr['data']['fid'] = $value;        //设置递归属性
                    }
                    if ($key == 'content') {
                        echo "<div style='margin-left:".$num * 30 ."px;'>".$value.'</div>';    //打印
                    }
                }
            }
            getContent($forum, $selectAttr, $tabNum);       //递归开始
        }
    }
}
 ?>
