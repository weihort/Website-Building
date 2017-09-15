<?php
/**
 * description  重置密码
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 13:30:20+080
 */
namespace Controller\User;

use \Controller\Common;
use PDO;

session_start();

include $_SESSION['ROOT_DIRECTORY'] . '/Controller/Common/Object.php';          //引入 Object.php 文件


$email            = $_POST['email'];
$password         = $_POST['password'];
$verification     = $_POST['verification'];
$selectArgs       = array(                        //查询customer表是否存在该邮箱
    'role' => 'resetPasswordSelect',
    'data' => array(
        'email' => $email,
    ),
);
$updateArgs       = array(                       //将新的密码放入customer表
    'role' => 'resetPasswordUpdate',
    'data' => array(
        'email'    => $email,
        'password' => $password,
    ),
);

try {
    $customer->resetPasswordEvent($_SESSION[$email]);
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $selectResult = $customer->getNextData($selectArgs);                    //查询是否存在该邮箱
    if (!($selectResult['verification'] == $verification)) {                //判断验证码是否相等
        die('验证码错误，修改失败！');
    }
    $updateResult = $customer->executeBase($updateArgs);
    if (!$updateResult) {                                                   //更新失败回滚
        $customer->base->rollBack();
        die('修改失败,请重试！');
    }
    $customer->base->commit();
}
catch (PDOException $e) {
    $customer->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}

echo '修改成功';
