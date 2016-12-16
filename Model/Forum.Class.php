<?php
namespace Model\Tables;
use Model\DataBase, PDO;
header('Content-Type:text/html;charset=utf-8');
include "DataBase.class.php";

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
    function __construct($mark)
    {
        $this->sqlAttr = array('fid'=>null, 'uid'=>null, 'content'=>null);
        $this->prepareObj = array('replySelectASC'=>null, 'replySelectDESC'=>null, 'replyInsert'=>null);
        $this->chooseDB($mark);
        $this->connect();
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
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL          = 'SELECT * FROM forum WHERE fid = ? ORDER BY id ASC';
            $replySelect = $this->dbObj->prepare($SQL);
            $replySelect->bindParam(1, $this->sqlAttr['fid']);
            $this->dbObj->commit();
            $this->prepareObj['replySelectASC'] = $replySelect;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    private function replySelectDESC()
    {
        try {
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL          = 'SELECT * FROM forum WHERE fid = ? ORDER BY id DESC';
            $replySelect = $this->dbObj->prepare($SQL);
            $replySelect->bindParam(1, $this->sqlAttr['fid']);
            $this->dbObj->commit();
            $this->prepareObj['replySelectDESC'] = $replySelect;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    private function replyInsert()
    {
        try {
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL          = "INSERT INTO forum(fid, uid, content) VALUES (?, ?, ?)";
            $replyInsert = $this->dbObj->prepare($SQL);
            $replyInsert->bindParam(1, $this->sqlAttr['fid']);
            $replyInsert->bindParam(2, $this->sqlAttr['uid']);
            $replyInsert->bindParam(3, $this->sqlAttr['content']);
            $this->dbObj->commit();
            $this->prepareObj['replyInsert'] = $replyInsert;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }
}

 ?>
