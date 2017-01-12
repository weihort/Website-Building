<?php
/**
 * description  customer表数据库sql预处理架设，
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 10:34:58+080
 */
namespace Model\Tables;

use \Model\DateBase;
use PDO;

/**
 * customer表处理类
 * @className DateBase
 * @version 1.0
 * @datetime 2016-11-28T17:40:06+080
 * @author liyusky
 */
class Customer extends DateBase
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
        $this->arguments = array(                   //数据库需外部填入的所有字段
            'username'     => null,
            'password'     => null,
            'email'        => null,
            'mobile'       => null,
            'ip'           => null,
            'longitude'    => null,
            'latitude'     => null,
            'verification' => null,             //验证码
            'account'      => null,             //账号  = email or username
        );
        $this->goals     = array(                   //数据库预处理状态名称
            'loginSelect'         => null,                  //登陆状态下查询已有用户信息
            'loginUpdate'         => null,                  //登陆状态下更新已有用户信息
            'registerSelect'      => null,                  //注册状态下查询已有用户信息
            'registerInsert'      => null,                  //注册状态下插入新用户信息
            'verificationSelect'  => null,                  //忘记密码状态下查询预注册用户信息
            'verificationUpdate'  => null,                  //忘记密码状态下更新预注册用户信息
            'resetPasswordSelect' => null,                  //更改密码状态下查询已有用户信息
            'resetPasswordUpdate' => null,                  //更改密码状态下更新已有用户信息
        );
        $this->device = array(                      //数据库预处理状态明细
            'loginSelect' => array(         //登录时查询该用户名是否存在
                'mark' => true,
                'sql' => 'SELECT * FROM customer WHERE username = :account OR email = :account',
                'data' => array('account'),
            ),
            'loginUpdate' => array(         //登录时更新用户数据为当前登陆状态信息
                'mark' => true,
                'sql' => "
                    UPDATE customer SET
                    preview_ip        = now_ip,
                    preview_longitude = now_longitude,
                    preview_latitude  = now_latitude,
                    preview_date      = now_date,
                    logintimes        = logintimes + 1,
                    now_date          = now(),
                    now_ip            = :ip,
                    now_longitude     = :longitude,
                    now_latitude      = :latitude
                    WHERE username    = :username;
                ",
                'data'=> array('ip', 'longitude', 'latitude', 'username'),
            ),
            'registerSelect' => array(                    //注册时查询用户名与邮箱是否被注册
                'mark' => true,
                'sql' => 'SELECT * FROM customer WHERE username = :username OR email = :email',
                'data'=> array('username', 'email'),
            ),
            'registerInsert' => array(                   //注册时插入用户必须信息
                'mark' => true,
                'sql' => '
                    INSERT INTO customer(username, password, email, now_ip, now_longitude, now_latitude)
                    VALUES(:username, :password, :email, :ip, :longitude, :latitude);
                ',
                'data'=> array('username', 'password', 'email', 'ip', 'longitude', 'latitude'),
            ),
            'verificationSelect' => array(              //忘记密码时查询是否存在该用户
                'mark' => true,
                'sql' => 'SELECT * FROM customer WHERE email = :email',
                'data'=> array('email'),
            ),
            'verificationUpdate' => array(              //忘记密码时将对应用户数据添加验证码
                'mark' => false,
                'sql' => null,
                'data'=> array('email', 'verification'),
            ),
            'resetPasswordSelect' => array(             //更改密码时查询有无该用户
                'mark' => true,
                'sql' => 'SELECT * FROM customer WHERE email = :email',
                'data'=> array('email'),
            ),
            'resetPasswordUpdate' => array(            //更改密码时更新用户信息（密码）
                'mark' => false,
                'sql' => null,
                'data'=> array('email', 'password'),
            ),
        );
        $this->chooseBase($Mark);                   //选择数据库
        $this->connectBase();                       //连接数据库
        $this->disposeEffect();                     //架设sql预处理语句
    }

    /**
     * [verificationEvent 忘记密码状态下设置customer表定时删除验证码任务]
     * @method   verificationEvent
     * @param    [string]                  $Email [处理过的邮箱名 号码+邮箱类型]
     * @version  [3.0]
     * @author liyusky
     * @datetime 2017-01-10T16:46:24+080
     */
    public function verificationEvent($Email)
    {
        $this->device['verificationUpdate']['sql'] = "
            UPDATE customer SET verification = :verification WHERE email  = :email;
            CREATE EVENT delete" . $Email . "
                ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 30 MINUTE
                ON COMPLETION NOT PRESERVE
                DO UPDATE customer SET verification = NULL WHERE email = :email;
        ";
        $this->loadSQL('verificationUpdate', $this->device['verificationUpdate']);
    }

    /**
     * [resetPasswordEvent 忘记密码状态下重设密码且删除customer表定时任务]
     * @method   resetPasswordEvent
     * @param    [string]                  $Email [处理过的邮箱名 号码+邮箱类型]
     * @version  [3.0]
     * @author liyusky
     * @datetime 2017-01-12T10:13:26+080
     */
    public function resetPasswordEvent($Email)
    {
        $this->device['resetPasswordUpdate']['sql'] = "
            UPDATE customer SET password = :password, verification = NULL WHERE email  = :email;
            DROP EVENT delete". $Email .";
        ";
        $this->loadSQL('resetPasswordUpdate', $this->device['resetPasswordUpdate']);
    }

}
