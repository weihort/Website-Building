<?php
/**
 * description  forum表数据库sql预处理架设，
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 10:34:42+080
 */
namespace Model\Tables;

use \Model\DateBase;
use PDO;

/**
 * forum表处理类
 * @className Forum
 * @version 1.0
 * @datetime 2016-11-28T17:40:06+080
 * @author liyusky
 */
class Forum extends DateBase
{
    /**
     * [__construct 连接数据库].
     * @method   __construct
     * @param [boolean] $mark [false/调试环境，true/生产环境]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-12T11:08:33+080
     */
    function __construct($Mark)
    {
        $this->arguments = array(           //数据库需外部填入的所有字段
            'id'      => null,
            'fid'     => null,
            'uid'     => null,
            'content' => null,
        );
        $this->goals     = array(           //数据库预处理状态名称
            'replySelectASC'  => null,              //正序查找评论信息
            'replySelectDESC' => null,              //逆序查找评论信息
            'commentInsert'   => null,              //插入评论
            'commentDelete'   => null,              //删除评论
            'commentAgree'    => null,              //赞同评论
            'commentReport'   => null,              //举报评论
        );
        $this->device    = array(           //数据库预处理状态明细
            'replySelectASC'  => array(                 //正序查找评论信息
                'mark' => true,
                'sql'  => 'SELECT * FROM forum WHERE fid = :fid ORDER BY id ASC',
                'data' => array('fid'),
            ),
            'replySelectDESC' => array(                 //逆序查找评论信息
                'mark' => true,
                'sql'  => 'SELECT * FROM forum WHERE fid = :fid ORDER BY id DESC',
                'data' => array('fid'),
            ),
            'commentInsert'   => array(                 //插入评论
                'mark' => true,
                'sql'  => "INSERT INTO forum(fid, uid, content) VALUES (:fid, :uid, :content)",
                'data' => array('fid', 'uid', 'content'),
            ),
            'commentDelete'   => array(                 //删除评论
                'mark' => true,
                'sql'  => "DELETE FROM forum WHERE id = :id",
                'data' => array('id'),
            ),
            'commentAgree'    => array(                 //赞同评论
                'mark' => true,
                'sql'  => "UPDATE forum SET agree = agree + 1 WHERE id = :id",
                'data' => array('id'),
            ),
            'commentReport'   => array(                 //举报评论
                'mark' => true,
                'sql'  => "UPDATE forum SET report = report + 1 WHERE id = :id",
                'data' => array('id'),
            ),
        );
        $this->chooseBase($Mark);                       //选择数据库
        $this->connectBase();                           //连接数据库
        $this->disposeEffect();                         //架设sql预处理语句
    }
}

 ?>
