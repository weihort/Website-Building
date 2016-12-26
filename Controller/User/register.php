<?php

namespace \Controller\User;

use \Model\Tables\Customer;
use \PDO;

// include '../Model/Customer.class.php';
header('Content-Type:text/html;charset=utf-8');
// $token = $_POST['token'];
// // if ($token !== $_SESSION['token']) {
// //     die('登陆失败');
// // }
$username   = $_POST['username'];
$password   = $_POST['password'];
$email      = $_POST['email'];
$ip         = $_POST['ip'];
$longitude  = $_POST['latitude'];
$latitude   = $_POST['longitude'];
$customer   = new Customer(false);
$selectArgs = array(
    'role' => 'registerSelect',
    'data' => array(
        'username' => $username
    )
);
$insertArgs = array(
    'role' => 'registerInsert',
    'data' => array(
        'username'  => $username,
        'password'  => $password,
        'email'     => $email,
        'ip'        => $ip,
        'longitude' => $longitude,
        'latitude'  => $latitude
    )
);
try {
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $result = $customer->getData($selectArgs);
    if ($result) die('该用户名已被使用，请使用其他用户名');
    $flag = $customer->executeBase($insertArgs);
    if (!$flag) {
        $customer->base->rollBack();
        die('注册失败，请重试');
    }
    $this->base->commit();
} catch (Exception $e) {
    $customer->base->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
echo '注册成功';
?>
