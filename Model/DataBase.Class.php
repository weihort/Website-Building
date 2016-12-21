<?php
namespace Model;

use PDO;

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
    public $base;
    protected $site;
    protected $username;
    protected $password;
    protected $arguments;
    protected $goals;

    /**
     * [chooseDB 设置数据库参数].
     * @method   chooseDB
     * @param [type] $mark [false/调试环境，true/生产环境]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:30:03+080
     */
    protected function chooseBase($Mark)
    {
        if ($mark) {            /* 生产环境 */
            $_dbType        = 'mysql';
            $_host          = '59.110.6.77:3306';
            $_dbName        = 'bdm252590573_db';
            $this->username = 'bdm252590573';
            $this->password = 'LIYUSKY19941104';
        }
        else {                  /* 调试环境 */
            $_dbType        = 'mysql';
            $_host          = '127.0.0.1';
            $_dbName        = 'liyusky';
            $this->username = 'root';
            $this->password = '111111';
        }
        $this->site = $_dbType . ':host=' . $_host . ';dbname=' . $_dbName;
    }

    /**
     * [connect 创建数据库连接对象].
     * @method   connect
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-11-28T17:35:07+080
     */
    protected function connectBase()
    {
        try {
            $this->base = new PDO($this->site, $this->username, $this->password);
            $this->base->query("SET NAMES 'UTF8';");
        } catch (Exception $e) {
            die('Error!: '.$e->getMessage().'<br />');
        }
    }

    /**
     * [executeBase 执行对数据库的操作]
     * @method   executeBase
     * @param    [array]                  $argument [参数数组]
     * @return   [boolean]                            [执行成功：true / 执行失败：false]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2016-12-17T13:42:47+080
     */
    public function executeBase($Parameters)
    {
        $_role  = $Parameters['role'];
        foreach ($Parameters['data'] as $_key => $_value) {
            $this->arguments[$_key] = $_value;
        }
        $_flag = $this->goals[$_role]->execute();
        return $_flag;
    }

    public function getData($Parameters)
    {
        $this->executeBase($Parameters);
        $_result = $this->goals[$Parameters['role']]->fetchAll();
        return $_result;
    }
}
