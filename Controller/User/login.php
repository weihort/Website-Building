<?php

namespace Controller\User;

use \Model\Tables\Customer;
use PDO;

session_start();

include $_SESSION['ROOT_DIRECTORY'] . '/Model/Tables/Customer.class.php';                  //引入 Customer.class.php 文件

$ip         = $_POST['ip'];
$token      = $_POST['token'];
if (($token !== md5($_SESSION['token'])) && ($ip !== $_SESSION['ip'])) die('大家井水不犯河水，兄台请绕路！');        //验证是否被攻击
$username   = $_POST['username'];
$password   = $_POST['password'];
$longitude  = $_POST["longitude"];
$latitude   = $_POST["latitude"];
$customer   = new Customer(false);          //实例化 Customer 对象
$selectArgs = array(                        //设置查询参数
    'role' => 'loginSelect',
    'data' => array(
        'username' => $username
    ),
);
$updateArgs = array(                       //设置更新参数
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
    $selectResult = $customer->getNextData($selectArgs);                            //获取对应数据
    if (!(md5($selectResult['password']) == $password)) die('您的用户名与密码不匹配！');    //密码错误
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
