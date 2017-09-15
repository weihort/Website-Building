<?php
/**
 * description  用户申请获权/注册账户，
 * @context PHP 5
 * @version 3.0
 * @author liyusky
 * @datetime 2017-1-12 10:35:48+080
 */
namespace Controller\User;

use \Controller\Common;
use \Controller\Mail;
use PDO;

session_start();
include dirname(dirname(dirname(__FILE__))) . '/Controller/Common/Object.php';        //引入 Object.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Controller/Mail/sendEmail.php';       //引入 sendEmail.php 文件

$ip         = $_POST['ip'];
$token      = $_POST['token'];
if (($token !== md5($_SESSION['token'])) && ($ip !== $_SESSION['ip'])){              //验证是否被攻击
    die('大家井水不犯河水，兄台请绕路！');
}
$username   = $_POST['username'];
$password   = $_POST['password'];
$email      = $_POST['email'];
$longitude  = $_POST['latitude'];
$latitude   = $_POST['longitude'];
$selectCustomerArgs = array(                    //customer表查询用户是否存在
    'role' => 'registerSelect',
    'data' => array(
        'username' => $username,
        'email'    => $email,
    ),
);
$selectTempArgs = array(                        //temp表查询是否已经预注册
    'role' => 'preRegistSelect',
    'data' => array(
        'username' => $username,
        'email'    => $email,
    ),
);
$insertTempArgs = array(                       //将信息存入temp表
    'role' => 'preRegistInsert',
    'data' => array(
        'username'  => $username,
        'password'  => $password,
        'email'     => $email,
        'ip'        => $ip,
        'longitude' => $longitude,
        'latitude'  => $latitude,
    ),
);
$deleteTempArgs = array(                      //延时删除预注册用户
    'role' => 'preRegistDeleteDelay',
    'data' => array(
        'username' => $username,
    ),
);
try {
    $temp->preRegistEvent($username);
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $temp->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $temp->base->beginTransaction();
    $customerSelectResult = $customer->getNextData($selectCustomerArgs);                //customer表查询是否存在
    $tempSelectResult     = $temp->getNextData($selectTempArgs);                        //temp表查询是否存在
    if ($tempSelectResult['username'] || $customerSelectResult['username']) {           //判断是否注册用户名
        die('该用户名已被使用，请使用其他用户名');
    }
    if ($tempSelectResult['email'] || $customerSelectResult['email']) {                 //判断是否注册邮箱
        die('该邮箱已被使用，请使用其他邮箱');
    }
    $tempInsertResult     = $temp->executeBase($insertTempArgs);                        //temp表插入数据
    $tempDeleteResult     = $temp->executeBase($deleteTempArgs);                        //temp表延时删除
    if (!$tempInsertResult || !$tempDeleteResult) {                                     //上两者失败回滚
        $temp->base->rollBack();
        die('注册失败，请重试');
    }
    //以下设置邮件信息
    $url     = "http://localhost:8080/Controller/User/verifyRegist.php?username=" . $username . "&&token=" . $token . "&&email=" . $email;
    $title   = "鲤鱼旗网站注册认证";
    $message = "
    尊敬的". $username ."：
    您好，感谢您注册鲤鱼旗网站，衷心希望您在本网站找到与您兴趣相关的内容。请点击以下链接完成注册。
    " . $url . "

    liyusky团队
    ";
    $flag = $sendEmail($email, $username, $title, $message);            //判断是否执行成功
    if(!$flag){                                                         //邮件发送失败，temp表回滚
        $temp->base->rollBack();
        die('邮件发送失败，请重试');
    }
    $temp->base->commit();
}
catch (Exception $e) {
    $temp->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
echo '核查邮件发送成功，请点击邮箱中的链接确认注册';
