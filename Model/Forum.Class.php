<?php
namespace Modal\Forum;
use Modal\DataBase as DataBase;
header('Content-Type:text/html;charset=utf-8');
include "DataBase.Class.php";

class Forum extends DataBase
{
    function __construct($mark)
    {
        $this->sqlAttr = array('fid'=>null);
        $this->prepareObj = array('reviewSelect'=>null);
        $this->chooseDB($mark);
        $this->connect();
        $this->reviewSelect();
        return $this->dbObj;
    }

    private function reviewSelect()
    {
        try {
            $this->dbObj->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL          = 'SELECT * FROM forum WHERE fid = ?';
            $reviewSelect = $this->dbObj->prepare($SQL);
            $reviewSelect->bindParam(1, $this->sqlAttr['fid']);
            $this->dbObj->commit();
            $this->prepareObj['reviewSelect'] = $reviewSelect;
        }
        catch (Exception $e) {
            $forum->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }
}

 ?>
