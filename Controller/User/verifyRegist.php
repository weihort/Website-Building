<?php
/**
 * description  验证注册
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 14:03:36+080
 */
namespace Controller\User;

use \Controller\Common;
use PDO;

session_start();
include dirname(dirname(dirname(__FILE__))) . '/Controller/Common/Object.php';  //引入 Object.php 文件

$username           = $_GET['username'];
$token              = $_GET['token'];
$email              = $_GET['email'];
$selectTempArgs = array(                        //temp表查询是否存在该用户
    'role' => 'preRegistSelect',
    'data' => array(
        'username' => $username,
    ),
);
$selectCustomerArgs = array(                        //customer表查询用户是否存在
    'role' => 'registerSelect',
    'data' => array(
        'username' => $username,
        'email'    => $email,
    ),
);
$insertCustomerArgs = array(                        //customer表插入数据
    'role' => 'registerInsert',
    'data' => array(
        'username'  => null,
        'password'  => null,
        'email'     => null,
        'ip'        => null,
        'longitude' => null,
        'latitude'  => null,
    ),
);
try {
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $temp->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $temp->base->beginTransaction();
    $customerSelectResult = $customer->getNextData($selectCustomerArgs);        //查找是否已经成为正式用户，customer表
    if ($customerSelectResult) {
        echo "该用户已完成注册";
        die();
        // include   该用户已完成注册 文件
    }
    $tempSelectResult  = $temp->getNextData($selectTempArgs);                   //查找是否为预注册用户，temp表
    if (($token != md5($_SESSION['token'])) || ($email != $tempSelectResult['email'])) {    //token不符或email不符
        include dirname(dirname(dirname(__FILE__))) . '/View/Computer/fail_regist.html';    //引入注册失败文件
        die();
    }
    foreach ($insertCustomerArgs['data'] as $key => $value) {                   //为$insertCustomerArgs设置内容
        $insertCustomerArgs['data'][$key] = $tempSelectResult[$key];
    }
    $customerInsertResult = $customer->executeBase($insertCustomerArgs);        //customer表输入数据
    if (!$customerInsertResult) {                   //插入失败引入注册失败文件
        include dirname(dirname(dirname(__FILE__))) . '/View/Computer/fail_regist.html';
        $customer->base->rollBack();
        die();
    }
    $customer->base->commit();
    $temp->base->commit();
} catch (Exception $e) {                            //发生异常，引入注册失败文件
    include dirname(dirname(dirname(__FILE__))) . '/View/Computer/fail_regist.html';
    $temp->base->rollBack();
    $customer->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}

include dirname(dirname(dirname(__FILE__))) . '/View/Computer/success_regist.html';     //注册成功，引入注册成功文件
