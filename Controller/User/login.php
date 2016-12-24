<?php
namespace \Controller\User;

use \Model\Tables\Customer;
use \PDO;

// include '../Model/Customer.class.php';
session_start();
// $token      = $_POST["token"];
// if ($token !== $_SESSION["token"]) die("登陆失败");
// $username   = $_POST["username"];
// $password   = $_POST["password"];
// $ip         = $_POST["ip"];
// $longitude  = $_POST["longitude"];
// $latitude   = $_POST["latitude"];
$customer   = new Customer(false);
$selectArgs = array(
    "role" => "loginSelect",
    "data" => array(
        "username" => "wqwwwwww",//$username,
        "password" => "1111111111"//$password
    )
);
$updateArgs = array(
    "role" => "loginUpdate",
    "data" => array(
        "ip"        => '44444',//$ip,
        "longitude" => '44444',//$longitude,
        "latitude"  => '44444',//$latitude,
        "username"  => '44444'//$username
    )
);
try {
    $customer->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->base->beginTransaction();
    $selectResult = $customer->getData($selectArgs);
    if (!$selectResult) {
        die("登陆失败");
    }
    $updateResult = $customer->executeBase($updateArgs);
    $customer->base->commit();
    if (!$updateResult) {
        $customer->base->rollBack();
        die("登陆失败");
    }
}
catch (PDOException $e) {
    $customer->base->rollBack();
    die("Error!: " . $e->getMessage() . "<br />");
}
try {
    $to = "452082031@qq.com";
    $subject = "test";
    $message = "测试";
    $header = "From: 452082031@qq.com";
    mail($to, $subject, $message,$header);
} catch (Exception $e) {

}

echo "登陆成功";
 ?>
