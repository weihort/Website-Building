<?php
namespace Model\Tables;

use Model\DataBase;
use PDO;

// include 'DataBase.class.php';
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
    public function __construct($Mark)
    {
        $this->arguments = array('username'=>null, 'password'=>null, 'email'=>null, 'mobile'=>null, 'ip'=>null, 'longitude'=>null, 'latitude'=>null);
        $this->goals  = array('loginSelect'=>null, 'loginUpdate'=>null,'registerSelect'=>null, 'registerInsert'=>null);
        $this->chooseBase($Mark);
        $this->connectBase();
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
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql         = 'SELECT * FROM user WHERE username = ? AND password = ?';
            $_login_select = $this->base->prepare($_sql);
            $_login_select->bindParam(1, $this->arguments['username']);
            $_login_select->bindParam(2, $this->arguments['password']);
            $_login_select->setFetchMode(PDO::FETCH_ASSOC);
            $this->base->commit();
            $this->goals['loginSelect'] = $_login_select;
        }
        catch (Exception $e) {
            $this->base->rollBack();
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
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql = "
                UPDATE user SET
                preview_ip        = now_ip,
                preview_longitude = now_longitude,
                preview_latitude  = now_latitude,
                preview_date      = now_date,
                logintimes        = logintimes + 1,
                now_date          = now(),
                now_ip            = ?,
                now_longitude     = ?,
                now_latitude      = ?
                WHERE username    = ?;
            ";
            $_login_update = $this->base->prepare($_sql);
            $_login_update->bindParam(1, $this->arguments['ip']);
            $_login_update->bindParam(2, $this->arguments['longitude']);
            $_login_update->bindParam(3, $this->arguments['latitude']);
            $_login_update->bindParam(4, $this->arguments['username']);
            $this->base->commit();
            $this->goals['loginUpdate'] = $_login_update;
        }
        catch (Exception $e) {
            $this->base->rollBack();
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
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql            = 'SELECT * FROM user WHERE username = ?';
            $_register_select = $this->base->prepare($_sql);
            $_register_select->bindParam(1, $this->arguments['username']);
            $_register_select->setFetchMode(PDO::FETCH_ASSOC);
            $this->base->commit();
            $this->goals['registerSelect'] = $_register_select;
        }
        catch (Exception $e) {
            $this->base->rollBack();
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
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->beginTransaction();
            $_sql            = 'INSERT INTO user(username, password, email, now_ip, now_longitude, now_latitude) VALUES(?, ?, ?, ?, ?, ?);';
            $_register_insert = $this->base->prepare($_sql);
            $_register_insert->bindParam(1, $this->arguments['username']);
            $_register_insert->bindParam(2, $this->arguments['password']);
            $_register_insert->bindParam(3, $this->arguments['email']);
            $_register_insert->bindParam(4, $this->arguments['ip']);
            $_register_insert->bindParam(5, $this->arguments['longitude']);
            $_register_insert->bindParam(6, $this->arguments['latitude']);
            $this->base->commit();
            $this->goals['registerInsert'] = $_register_insert;
        }
        catch (Exception $e) {
            $this->base->rollBack();
            die('Error!: '.$e->getMessage().'<br />');
        }
    }
}
