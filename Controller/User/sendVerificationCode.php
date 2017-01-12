<?php
/**
 * description  发送验证码邮件
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 13:34:25+080
 */
namespace Controller\User;

use \Controller\Common as Common;
use \Controller\Mail;
use PDO;

session_start();
$_SESSION['ROOT_DIRECTORY'] = dirname(dirname(dirname(__FILE__)));
include dirname(dirname(dirname(__FILE__))) . '/Controller/Common/randomStr.php';       //引入 Customer.class.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Controller/Common/Object.php';          //引入 Object.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Controller/Mail/sendEmail.php';         //引入 Customer.class.php 文件

$email = $_POST['email'];
$_SESSION[$email] = str_ireplace('@', "", substr($email, 0, stripos($email, ".")));     //对email处理，移除 @ 和 .com
$verification = Common\randomStr(6);                                                    //摄取验证码
$selectArgs = array(                        //查询customer表是否有该账户
    'role' => 'verificationSelect',
    'data' => array(
        'email' => $email
    )
);
$updateArgs = array(                       //customer表对应账户添加验证码
    'role' => 'verificationUpdate',
    'data' => array(
        'email'        => $email,
        'verification' => $verification
    )
);

try {
    $customer->verificationEvent($_SESSION[$email]);                            //架设定时删除预处理
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $selectResult = $customer->getNextData($selectArgs);                        //查询邮箱是否存在
    if (!$selectResult) {
        die('该邮箱未注册！');
    }
    $updateResult = $customer->executeBase($updateArgs);                        //插入验证码
    if (!$updateResult) {               //更新失败回滚
        $customer->base->rollBack();
        die('发送失败！');
    }
    //设置邮件信息
    $title        = '验证码';
    $message      = 1;
    $emailResult  = $sendEmail($email, $selectResult['username'], $title, $message);
    if (!$emailResult) {                    //邮件发送失败回滚
        $customer->base->rollBack();
        die('发送失败！');
    }
    $customer->base->commit();
}
catch (PDOException $e) {
    $customer->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
