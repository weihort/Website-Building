<?php
/**
 * description  temp表数据库sql预处理架设，
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 10:34:13+080
 */
namespace Model\Tables;

use \Model\DateBase;
use PDO;

/**
 * 数据库处理类.
 * @className DateBase
 * @version 1.0
 * @datetime 2017-1-7T11:47:06+080
 * @author uponstars
 */
class Temp extends DateBase
{

    /**
     * [__construct 连接数据库]
     * @method   __construct
     * @param    [boolean]                  $mark [false/调试环境，true/生产环境]
     * @version  [1.0]
     * @author uponstars
     * @datetime 2017-01-07T11:50:58+080
     */
    function __construct($mark)
    {
        $this->arguments = array(           //数据库需外部填入的所有字段
            'username'  => null,
            'password'  => null,
            'email'     => null,
            'mobile'    => null,
            'ip'        => null,
            'longitude' => null,
            'latitude'  => null,
        );
        $this->goals     = array(           //数据库预处理状态名称
            'preRegistInsert'       => null,                //预注册时插入预注册用户信息
            'preRegistSelect'       => null,                //预注册时查询预注册用户信息
            'preRegistDeleteDelay'  => null,                //预注册时立刻删除预注册用户信息
        );
        $this->device    = array(           //数据库预处理状态明细
            'preRegistInsert'       => array(         //将注册数据插入temp表
                'mark' => true,
                'sql'  => '
                    INSERT INTO temp (username, password, email, ip, longitude, latitude)
                    VALUES (:username, :password, :email, :ip, :longitude, :latitude);
                ',
                'data' => array('username', 'password', 'email', 'ip', 'longitude', 'latitude'),
            ),
            'preRegistSelect'       => array(         //查询token
                'mark' => true,
                'sql'  => 'SELECT * FROM temp WHERE username = :username OR email = :email;',
                'data' => array('username', 'email'),
            ),
            'preRegistDeleteDelay'  => array(         //定时删除预注册数据
                'mark' => false,
                'sql'  => null,
                'data' => array('username'),
            ),
        );
        $this->chooseBase($mark);
        $this->connectBase();
        $this->disposeEffect();
    }

    /**
     * [preRegistEvent 定时删除预注册用户信息]
     * @method   preRegistEvent
     * @param    [string]                  $Username [用户名]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2017-01-12T10:32:08+080
     */
    public function preRegistEvent($Username)
    {
        $this->device['preRegistDeleteDelay']['sql'] = "
            CREATE EVENT delete" . $Username . "
                ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 30 MINUTE
                ON COMPLETION NOT PRESERVE
                DO DELETE FROM temp WHERE username = :username;
        ";
        $this->loadSQL('preRegistDeleteDelay', $this->device['preRegistDeleteDelay']);
    }

}
