<?php
namespace Modal\Forum;
use Modal\DataBase as DataBase;
header('Content-Type:text/html;charset=utf-8');
include "DataBase.Class.php";

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
        $this->sqlAttr = array('fid'=>null);
        $this->prepareObj = array('reviewSelectASC'=>null, 'reviewSelectDESC'=>null);
        $this->chooseDB($mark);
        $this->connect();
        $this->reviewSelectASC();
        $this->reviewSelectDESC();
    }

    /**
     * [reviewSelect 评论查询预处理]
     * @method   reviewSelect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-12T11:13:36+080
     */
    private function reviewSelectASC()
    {
        try {
            $this->dbObj->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL          = 'SELECT * FROM forum WHERE fid = ? ORDER BY id ASC';
            $reviewSelect = $this->dbObj->prepare($SQL);
            $reviewSelect->bindParam(1, $this->sqlAttr['fid']);
            $this->dbObj->commit();
            $this->prepareObj['reviewSelectASC'] = $reviewSelect;
        }
        catch (Exception $e) {
            $forum->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    private function reviewSelectDESC()
    {
        try {
            $this->dbObj->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL          = 'SELECT * FROM forum WHERE fid = ? ORDER BY id DESC';
            $reviewSelect = $this->dbObj->prepare($SQL);
            $reviewSelect->bindParam(1, $this->sqlAttr['fid']);
            $this->dbObj->commit();
            $this->prepareObj['reviewSelectDESC'] = $reviewSelect;
        }
        catch (Exception $e) {
            $forum->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }
}

 ?>
