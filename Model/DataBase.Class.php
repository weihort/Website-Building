<?php
namespace Modal;
header('Content-Type:text/html;charset=utf-8');
/**
 * 数据库处理类.
 * @className DateBase
 * @version 1.0
 * @datetime 2016-11-28T17:40:06+080
 * @author liyusky
 */
class DataBase
{
    public $dbObj;
    protected $dbSite;
    protected $dbUserName;
    protected $dbPassword;
    protected $sqlAttr;
    protected $prepareObj;

    /**
     * [chooseDB 设置数据库参数].
     * @method   chooseDB
     * @param [type] $mark [false/调试环境，true/生产环境]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:30:03+080
     */
    protected function chooseDB($mark)
    {
        if ($mark) {            /* 生产环境 */
            $dbms             = 'mysql';
            $host             = '59.110.6.77:3306';
            $dbName           = 'bdm252590573_db';
            $this->dbUserName = 'bdm252590573';
            $this->dbPassword = 'LIYUSKY19941104';
        }
        else {                  /* 调试环境 */
            $dbms             = 'mysql';
            $host             = '127.0.0.1';
            $dbName           = 'liyusky';
            $this->dbUserName = 'root';
            $this->dbPassword = '111111';
        }
        $this->dbSite = $dbms.':host='.$host.';dbname='.$dbName;
    }

    /**
     * [connect 创建数据库连接对象].
     * @method   connect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:35:07+080
     */
    protected function connect()
    {
        try {
            $this->dbObj = new \PDO($this->dbSite, $this->dbUserName, $this->dbPassword);
            $this->dbObj->query("SET NAMES 'UTF8';");
        } catch (Exception $e) {
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    /**
     * [selectDB 查询数据库]
     * @method   selectDB
     * @param    [array]                  $selectAttr [array("goal" => array("table" => , "role" => ,),"data" => array( => ))]
     * @return   [array]                              [数据库的结果集]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T20:44:45+080
     */
    public function selectDB($selectAttr)
    {
        $role = $this->setAttr($selectAttr);
        $this->prepareObj[$role]->execute();
        $result = $this->prepareObj[$role]->fetchAll();
        return $result;
    }

    /**
     * [updateDB 更新数据库]
     * @method   updateDB
     * @param    [array]                  $updateAttr [array("goal" => array("table" => , "role" => ,),"data" => array( => ))]
     * @return   [boolean]                              [返回执行是否成功]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T20:51:35+080
     */
    public function updateDB($updateAttr)
    {
        $role = $this->setAttr($updateAttr);
        $flag = $this->prepareObj[$role]->execute();
        return $flag;
    }

    /**
     * [insertDB 插入数据库]
     * @method   insertDB
     * @param    [array]                  $insertAttr [array("goal" => array("table" => , "role" => ,),"data" => array( => ))]
     * @return   [boolean]                              [返回执行是否成功]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T20:56:09+080
     */
    public function insertDB($insertAttr)
    {
        $role = $this->setAttr($insertAttr);
        $flag = $this->prepareObj[$role]->execute();
        return $flag;
    }

    /**
     * [setAttr 设置预处理数据]
     * @method   setAttr
     * @param    [array]                  $attrArray [array("goal" => array("table" => , "role" => ,),"data" => array( => ))]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T21:10:07+080
     */
    protected function setAttr($attrArray)
    {
        $role  = $attrArray['role'];
        foreach ($attrArray['data'] as $key => $value) {
            $this->sqlAttr[$key] = $value;
        }
        return $role;
    }

}
