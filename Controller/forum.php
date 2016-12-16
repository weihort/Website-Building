<?php

namespace Controller;

use Model\Tables\Forum, PDO;

//引入要实例化的类
include '../Model/Forum.class.php ';
header('Content-Type:text/html;charset=utf-8');
$floor      = 0;    //需要缩进的数
$contentStr = '';
$forum      = new Forum(false);     //实例化
$selectAttr = array(        //设置属性
    'role' => 'replySelectDESC',
    'data' => array(
        'fid' => 0,
    ),
    "level" => 0
);
try {
    $forum->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->dbObj->beginTransaction();      //开启事务
    $floor = sizeof($forum->selectDB($selectAttr));
    getContent($forum, $selectAttr);           //罗列事务
}
catch (Exception $e) {
    $forum->dbObj->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}

function getContent($forum, $selectAttr)
{
    $selectAttr['level']++;
    $selectResult = $forum->selectDB($selectAttr);      //查询事务
    if ($selectResult) {            //查询到值
        foreach ($selectResult as $row) {       //选取每条数据
            $fid                       = $row['fid'];
            $selectAttr['data']['fid'] = $row['id'];        //设置递归属性
            $selectAttr['role'] = "replySelectASC";
            if (!$fid) {
                $GLOBALS['contentStr'] .= "
                <div class='row' data-goal='comment'>
                <div class='col-md-2'><a><img src='#' /></a></div>
                <div class='col-md-8'>
                <div class='row'>
                <a>" . $row["uid"] . "</a>
                </div>
                <div class='row'>
                <p>".$row['content']."</p>
                </div>
                <div class='row'>
                <p class='inner'>#". $GLOBALS['floor']-- . "</p>
                <p class='inner'>" . $row["sendtime"] . "</p>
                <button class='zan btn btn-default inner'>赞（<span>" . $row['agree'] . "</span>）</button>
                <button type='button' class='btn btn-default dropdown-toggle inner review article' data-toggle='dropdown' data-open='1'>回复</button>
                <button class='jubao btn btn-default inner'>举报</button>
                </div>
                ";
            }
            else {
                $uid = ($selectAttr['level'] > 2) ? "@" . $selectAttr['uid'] : "";
                $GLOBALS['contentStr'] .= "
                            <div class='row' data-goal='comment'>
                            <div class='col-md-2'><a><img src='#' /></a></div>
                            <div class='col-md-10'>
                            <div class='row'>
                            <a>" . $row["uid"] . "</a><span>:</span>
                            <p class='inner'><a href='#'>" . $uid . "</a></p>
                            <p class='inner'>".$row['content']."</p>
                            </div>
                            <div class='row'>
                            <p class='inner'>" . $row["sendtime"] . "</p>
                            <button class='zan btn btn-default inner'>赞（<span>" . $row['agree'] . "</span>）</button>
                            <button type='button' class='btn btn-default dropdown-toggle inner review discuss' data-toggle='dropdown' data-open='1'>回复</button>
                            <button class='jubao btn btn-default inner'>举报</button>
                            </div>
                        </div>
                    </div>
                    ";
            }
            $selectAttr['uid']         = $row['uid'];
            getContent($forum, $selectAttr);       //递归开始
            if ($fid == 0) {
                $GLOBALS['contentStr'] .= "</div><div class='col-md-4'></div></div><hr/>";
            }
        }
    }
}
  ?>
