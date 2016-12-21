<?php
session_start();
$token = setToken(20);
$_SESSION["token"] = $token;
echo $token;

function setToken($length)
{
    // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#%^&*~`+=?';
    $token = '';
    for ($i = 0; $i < $length; ++$i) {
        $token .= $chars[rand(0,strlen($chars) - 1)];
    }
    return $token;
}
 ?>
