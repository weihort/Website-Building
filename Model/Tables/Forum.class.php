<?php
namespace Model\Tables;

use Model\DataBase;
use PDO;

header('Content-Type:text/html;charset=utf-8');
// include "DataBase.class.php";

class Forum extends DataBase
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
        $this->arguments = array('fid'=>null, 'uid'=>null, 'content'=>null);
        $this->goals     = array('replySelectASC'=>null, 'replySelectDESC'=>null, 'replyInsert'=>null);
        $this->chooseBase($Mark);
        $this->connectBase();
        $this->replySelectASC();
        $this->replySelectDESC();
        $this->replyInsert();
    }

    /**
     * [replySelect 评论查询预处理]
     * @method   replySelect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-12T11:13:36+080
     */
    private function replySelectASC()
    {
        try {
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql          = 'SELECT * FROM forum WHERE fid = ? ORDER BY id ASC';
            $_reply_select = $this->base->prepare($_sql);
            $_reply_select->bindParam(1, $this->arguments['fid']);
            $this->base->commit();
            $this->goals['replySelectASC'] = $_reply_select;
        }
        catch (Exception $e) {
            $this->base->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    private function replySelectDESC()
    {
        try {
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql         = 'SELECT * FROM forum WHERE fid = ? ORDER BY id DESC';
            $_reply_select = $this->base->prepare($_sql);
            $_reply_select->bindParam(1, $this->arguments['fid']);
            $this->base->commit();
            $this->goals['replySelectDESC'] = $_reply_select;
        }
        catch (Exception $e) {
            $this->base->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    private function replyInsert()
    {
        try {
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql          = "INSERT INTO forum(fid, uid, content) VALUES (?, ?, ?)";
            $_reply_insert = $this->base->prepare($_sql);
            $_reply_insert->bindParam(1, $this->arguments['fid']);
            $_reply_insert->bindParam(2, $this->arguments['uid']);
            $_reply_insert->bindParam(3, $this->arguments['content']);
            $this->base->commit();
            $this->goals['replyInsert'] = $_reply_insert;
        }
        catch (Exception $e) {
            $this->base->rollBack();
            die('Error!: ' . $e->getMessage() . '<br />');
        }
    }
}

 ?>
