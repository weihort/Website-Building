<?php
/**
 * description  用户获权/登陆载入，
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 10:35:48+080
 */
namespace Controller\User;

use \Controller\Common;
use PDO;

session_start();

include $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';

$ip         = $_POST['ip'];
$token      = $_POST['token'];
if (($token !== md5($_SESSION['token'])) && ($ip !== $_SESSION['ip'])){         //验证是否被攻击
    die('大家井水不犯河水，兄台请绕路！');
}
$account   = $_POST['account'];
$password   = $_POST['password'];
$longitude  = $_POST["longitude"];
$latitude   = $_POST["latitude"];
$selectArgs = array(                        //查询customer表，判断账户是否存在
    'role' => 'loginSelect',
    'data' => array(
        'username' => $account,
        'email'    => $account,
    ),
);
$updateArgs = array(                       //更新customer表
    'role' => 'loginUpdate',
    'data' => array(
        'ip'        => $ip,
        'longitude' => $longitude,
        'latitude'  => $latitude,
        'username'  => $username,
    ),
);

try {
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $selectResult = $customer->getNextData($selectArgs);                //获取customer表中用户数据
    if (!(md5($selectResult['password']) == $password)){                //密码错误
        die('您的用户名与密码不匹配！');
    }
    $updateResult = $customer->executeBase($updateArgs);
    $customer->base->commit();
    // TODO: 该错误需要加入日志
    if (!$updateResult) {                           //更新失败回滚
        $customer->base->rollBack();
        die('登陆失败！');
    }
}
catch (PDOException $e) {
    $customer->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}

echo '登陆成功';
