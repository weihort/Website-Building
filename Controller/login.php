<?php
namespace Controller;
use Model\DataBase;
include '../Model/Customer.Class.php';
session_start();
$token      = $_POST["token"];
if ($token !== $_SESSION["token"]) die("登陆失败");
$username   = $_POST["username"];
$password   = $_POST["password"];
$ip         = $_POST["ip"];
$longitude  = $_POST["longitude"];
$latitude   = $_POST["latitude"];
$customer   = new Customer(false);
$selectAttr = array(
    "role" => "loginSelect",
    "data" => array(
        "username" => $username,
        "password" => $password
    )
);
$updateAttr = array(
    "role" => "loginUpdate",
    "data" => array(
        "ip"        => $ip,
        "latitude"  => $latitude,
        "longitude" => $longitude,
        "username"  => $username
    )
);
try {
    $customer->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $customer->beginTransaction();
    $selectResult = $customer->selectDB($selectAttr);
    $updateResult = $customer->updateDB($updateAttr);
    if (!$selectResult || !$updateResult) {
        $customer->rollBack();
        die("登陆失败");
    }
    $customer->commit();
}
catch (PDOException $e) {
    $customer->rollBack();
    die("Error!: " . $e->getMessage() . "<br />");
}
echo "登陆成功";
 ?>
