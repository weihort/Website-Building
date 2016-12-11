<?php

namespace Controller;

use Model\DataBase;

include '../Model/Customer.Class.php';
header('Content-Type:text/html;charset=utf-8');
session_start();
$token      = $_POST['token'];
if ($token !== $_SESSION['token']) die('登陆失败');
$username   = $_POST['username'];
$password   = $_POST['password'];
$email      = $_POST['email'];
$ip         = $_POST['ip'];
$latitude   = $_POST['longitude'];
$longitude  = $_POST['latitude'];
$customer   = new Customer(false);
$selectAttr = array(
    'role' => 'registerSelect',
    'data' => array(
        'username' => $username,
    ),
);
$insertAttr = array(
    'role' => 'registerInsert',
    'data' => array(
        'username'  => $username,
        'password'  => $password,
        'email'     => $email,
        'ip'        => $ip,
        'latitude'  => $latitude,
        'longitude' => $longitude,
    ),
);
try {
    // $customer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->beginTransaction();
    $result = $customer->selectDB($selectAttr);
    if ($result) die('该用户名已被使用，请使用其他用户名');
    $flag   = $customer->insertDB($insertAttr);
    if (!$flag) {
        $customer->rollBack();
        die('注册失败，请重试');
    }
    $customer->commit();
}
catch (Exception $e) {
    $customer->rollBack();
    die('Error!: '.$e->getMessage().'<br />');
}
echo '注册成功';
 ?>
