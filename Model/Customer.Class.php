<?php

namespace Model\Tables;
use Model\DataBase, PDO;
include 'DataBase.class.php';
/**
 * 数据库处理类.
 * @className DateBase
 * @version 1.0
 * @datetime 2016-11-28T17:40:06+080
 * @author liyusky
 */
class Customer extends DataBase
{

    /**
     * [__construct 连接数据库].
     * @method   __construct
     * @param [boolean] $mark [false/调试环境，true/生产环境]
     * @return PDO OBJECT
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:33:51+080
     */
    public function __construct($mark)
    {
        $this->sqlAttr = array('username'=>null, 'password'=>null, 'email'=>null, 'mobile'=>null, 'ip'=>null, 'longitude'=>null, 'latitude'=>null);
        $this->prepareObj = array('loginSelect'=>null, 'loginUpdate'=>null,'registerSelect'=>null, 'registerInsert'=>null);
        $this->chooseDB($mark);
        $this->connect();
        $this->loginSelect();
        $this->loginUpdate();
        $this->registerSelect();
        $this->registerInsert();
    }

    /**
     * [loginSelect 设置登陆查询预处理]
     * @method   loginSelect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T20:57:10+080
     */
    private function loginSelect()
    {
        try {
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL         = 'SELECT * FROM user WHERE username = ? AND password = ?';
            $loginSelect = $this->dbObj->prepare($SQL);
            $loginSelect->bindParam(1, $this->sqlAttr['username']);
            $loginSelect->bindParam(2, $this->sqlAttr['password']);
            $loginSelect->setFetchMode(PDO::FETCH_ASSOC);
            $this->dbObj->commit();
            $this->prepareObj['loginSelect'] = $loginSelect;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    /**
     * [loginUpdate 设置登陆更改预处理]
     * @method   loginUpdate
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T20:58:19+080
     */
    private function loginUpdate()
    {
        try {
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL         = "
                UPDATE user SET
                preview_ip        = SELECT now_ip FROM user WHERE username = :username,
                preview_longitude = SELECT now_longitude FROM user WHERE username = :username,
                preview_latitude  = SELECT now_latitude FROM user WHERE username = :username,
                preview_date      = SELECT now_date FROM user WHERE username = :username,
                logintimes        = SELECT logintimes FROM user WHERE username = :username,
                now_ip            = :now_ip,
                now_longitude     = :now_longitude,
                now_latitude      = :now_latitude
                WHERE username    = :username;
            ";
            $loginUpdate = $this->dbObj->prepare($SQL);
            $loginUpdate->bindParam(':username', $this->sqlAttr['username']);
            $loginUpdate->bindParam(':now_ip', $this->sqlAttr['ip']);
            $loginUpdate->bindParam('now_longitude', $this->sqlAttr['longitude']);
            $loginUpdate->bindParam('now_latitude:', $this->sqlAttr['latitude']);
            $this->dbObj->commit();
            $this->prepareObj['loginUpdate'] = $loginUpdate;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    /**
     * [registerSelect 设置注册查询预处理]
     * @method   registerSelect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T21:01:57+080
     */
    private function registerSelect()
    {
        try {
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL            = 'SELECT * FROM user WHERE username = ?';
            $registerSelect = $this->dbObj->prepare($SQL);
            $registerSelect->bindParam(1, $this->sqlAttr['username']);
            $registerSelect->setFetchMode(PDO::FETCH_ASSOC);
            $this->dbObj->commit();
            $this->prepareObj['registerSelect'] = $registerSelect;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    /**
     * [registerInsert 设置注册插入预处理]
     * @method   registerInsert
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-10T21:02:43+080
     */
    private function registerInsert()
    {
        try {
            $this->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbObj->beginTransaction();
            $SQL            = 'INSERT INTO user(username, password, email, now_ip, now_longitude, now_latitude) VALUES(?, ?, ?, ?, ?, ?);';
            $registerInsert = $this->dbObj->prepare($SQL);
            $registerInsert->bindParam(1, $this->sqlAttr['username']);
            $registerInsert->bindParam(2, $this->sqlAttr['password']);
            $registerInsert->bindParam(3, $this->sqlAttr['email']);
            $registerInsert->bindParam(4, $this->sqlAttr['ip']);
            $registerInsert->bindParam(5, $this->sqlAttr['longitude']);
            $registerInsert->bindParam(6, $this->sqlAttr['latitude']);
            $this->dbObj->commit();
            $this->prepareObj['registerInsert'] = $registerInsert;
        }
        catch (Exception $e) {
            $this->dbObj->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }
}
