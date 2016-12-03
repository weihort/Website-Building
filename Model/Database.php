<?php
namespace Model;
/**
 * 数据库处理类
 * @className DateBase
 * @version 1.0
 * @datetime 2016-11-28T17:40:06+080
 * @author liyusky
 */
class Database
{
    private $dbSite;
    private $username;
    private $password;
    private $dbObj;

    /**
     * [__construct 连接数据库]
     * @method   __construct
     * @param    [boolean]                  $mark [false/调试环境，true/生产环境]
     * @return PDO OBJECT
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:33:51+080
     */
    function __construct($mark)
    {
        $this->chooseDB($mark);
        $this->connect();
        return $this->dbObj;
    }

    /**
     * [chooseDB 设置数据库参数]
     * @method   chooseDB
     * @param    [type]                  $mark [false/调试环境，true/生产环境]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:30:03+080
     */
    private function chooseDB($mark)
    {
         /* 生产环境 */
        if ($mark) {
            $dbms           = "mysql";
            $host           = "59.110.6.77:3306";
            $dbName         = "bdm252590573_db";
            $this->username = "bdm252590573";
            $this->password = "LIYUSKY19941104";
        }
        /* 调试环境 */
        else {
            $dbms           = "mysql";
            $host           = "127.0.0.1";
            $dbName         = "test";
            $this->username = "root";
            $this->password = "111111";
        }
        $this->dbSite = $dbms . ":host=" . $host . ";dbName=" . $dbName;
    }

    /**
     * [connect 创建数据库连接对象]
     * @method   connect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:35:07+080
     */
    private function connect()
    {
        try {
            $this->dbObj = new \PDO($this->dbSite,$this->username,$this->password);
        } catch (Exception $e) {
            die("Error!: " . $e->getMessage() . "<br />");
        }
    }

    private function selectDB()
    {
    }

    private function insertDB()
    {
    }

    private function updateDB()
    {
    }

    private function deleteDB()
    {
    }
}
