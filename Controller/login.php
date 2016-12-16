<?php
namespace Controller\UserSystem;
use Model\Tables\Customer, PDO;
include '../Model/Customer.class.php';
session_start();
// $token      = $_POST["token"];
// if ($token !== $_SESSION["token"]) die("登陆失败");
// $username   = $_POST["username"];
// $password   = $_POST["password"];
// $ip         = $_POST["ip"];
// $longitude  = $_POST["longitude"];
// $latitude   = $_POST["latitude"];
$customer   = new Customer(false);
$selectAttr = array(
    "role" => "loginSelect",
    "data" => array(
        "username" => "wqwwwwww",
        "password" => "1111111111"
    )
);
$updateAttr = array(
    "role" => "loginUpdate",
    "data" => array(
        "ip"        => '313131',//$ip,
        "latitude"  => '12312',//$latitude,
        "longitude" => '31321',//$longitude,
        "username"  => 'wqwwwwww'//$username
    )
);
try {
    $customer->dbObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->dbObj->beginTransaction();
    $selectResult = $customer->selectDB($selectAttr);
    if (!$selectResult) {
        die("登陆失败");
    }
    $updateResult = $customer->updateDB($updateAttr);
    $customer->dbObj->commit();
    if (!$updateResult) {
        $customer->dbObj->rollBack();
        die("登陆失败");
    }
}
catch (PDOException $e) {
    $customer->dbObj->rollBack();
    die("Error!: " . $e->getMessage() . "<br />");
}
echo "登陆成功";
 ?>
