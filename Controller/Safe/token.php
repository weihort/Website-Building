<?php
namespace \Controller\Safe;
session_start();
$token = setToken(20);
$_SESSION["token"] = $token;
echo $token;

function setToken($Length)
{
    // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $_token = '';
    for ($i = 0; $i < $Length; ++$i) {
        $_token .= $_chars[rand(0,strlen($_chars) - 1)];
    }
    return $_token;
}
 ?>
