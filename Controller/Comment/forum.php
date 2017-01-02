<?php

namespace \Controller\Comment;

use Model\Tables\Forum;
use PDO;

//引入要实例化的类
// include '../Model/Forum.class.php ';
// header('Content-Type:text/html;charset=utf-8');
$floor      = 0;    //需要缩进的数
$contentStr = '';
$forum      = new Forum(false);     //实例化
$selectArgs = array(        //设置属性
    'role' => 'replySelectDESC',
    'data' => array(
        'fid' => 0,
    ),
    'level' => 0,
);
try {
    $forum->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $forum->base->beginTransaction();      //开启事务
    $floor = sizeof($forum->getData($selectArgs));
    getContent($forum, $selectArgs);           //罗列事务
} catch (Exception $e) {
    $forum->base->rollBack();                 //回滚
    die('Error!: '.$e->getMessage().'<br />');
}

function getContent($Forum, $SelectArgs)
{
    ++$SelectArgs['level'];
    $_result = $Forum->getData($SelectArgs);      //查询事务
    if ($_result) {            //查询到值
        foreach ($_result as $_row) {       //选取每条数据
            $_fid                      = $_row['fid'];
            $SelectArgs['data']['fid'] = $_row['id'];        //设置递归属性
            $SelectArgs['role']        = 'replySelectASC';
            if (!$_fid) {
                $GLOBALS['contentStr'] .= "
                <div class='row' data-goal='comment'>
                <div class='col-md-2'><a><img src='#' /></a></div>
                <div class='col-md-8'>
                <div class='row'>
                <a>".$_row['uid']."</a>
                </div>
                <div class='row'>
                <p>".$_row['content']."</p>
                </div>
                <div class='row'>
                <p class='inner'>#".$GLOBALS['floor']--."</p>
                <p class='inner'>".$_row['sendtime']."</p>
                <button class='zan btn btn-default inner'>赞（<span>".$_row['agree']."</span>）</button>
                <button type='button' class='btn btn-default dropdown-toggle inner review article' data-toggle='dropdown' data-open='1'>回复</button>
                <button class='jubao btn btn-default inner'>举报</button>
                </div>
                ";
            }
            else {
                $_uid = ($SelectArgs['level'] > 2) ? '@'.$SelectArgs['uid'] : '';
                $GLOBALS['contentStr'] .= "
                            <div class='row' data-goal='comment'>
                            <div class='col-md-2'><a><img src='#' /></a></div>
                            <div class='col-md-10'>
                            <div class='row'>
                            <a>".$_row['uid']."</a><span>:</span>
                            <p class='inner'><a href='#'>".$_uid."</a></p>
                            <p class='inner'>".$_row['content']."</p>
                            </div>
                            <div class='row'>
                            <p class='inner'>".$_row['sendtime']."</p>
                            <button class='zan btn btn-default inner'>赞（<span>".$_row['agree']."</span>）</button>
                            <button type='button' class='btn btn-default dropdown-toggle inner review discuss' data-toggle='dropdown' data-open='1'>回复</button>
                            <button class='jubao btn btn-default inner'>举报</button>
                            </div>
                        </div>
                    </div>
                    ";
            }
            $SelectArgs['uid']         = $_row['uid'];
            getContent($Forum, $SelectArgs);       //递归开始
            if ($_fid == 0) {
                $GLOBALS['contentStr'] .= "</div><div class='col-md-4'></div></div><hr/>";
            }
        }
    }
}
