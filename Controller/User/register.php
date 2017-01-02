<?php

namespace Controller\User;

use \Model\Tables\Customer;
use PDO;

header('Content-Type:text/html;charset=utf-8');
session_start();

include $_SESSION['ROOT_DIRECTORY'].'\Model\Tables\Customer.class.php';         //引入 Customer.class.php 文件

$ip         = $_POST['ip'];
$token      = $_POST['token'];
if (($token !== md5($_SESSION['token'])) && ($ip !== $_SESSION['ip'])) die('大家井水不犯河水，兄台请绕路！');      //验证是否被攻击
$username   = $_POST['username'];
$password   = $_POST['password'];
$email      = $_POST['email'];
$longitude  = $_POST['latitude'];
$latitude   = $_POST['longitude'];
$customer   = new Customer(false);
$selectArgs = array(
    'role' => 'registerSelect',
    'data' => array(
        'username' => $username,
    ),
);
$insertArgs = array(
    'role' => 'registerInsert',
    'data' => array(
        'username'  => $username,
        'password'  => $password,
        'email'     => $email,
        'ip'        => $ip,
        'longitude' => $longitude,
        'latitude'  => $latitude,
    ),
);
try {
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $result = $customer->getAllData($selectArgs);
    if ($result) die('该用户名已被使用，请使用其他用户名');      //查询是否重名
    $flag   = $customer->executeBase($insertArgs);              //更新数据库
    if (!$flag) {
        $customer->base->rollBack();
        die('注册失败，请重试');
    }
    $customer->base->commit();
}
catch (Exception $e) {
    $customer->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}

echo '注册成功';
