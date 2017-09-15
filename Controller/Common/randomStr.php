<?php

namespace Controller\Common;

/**
 * [setToken 设置token].
 * @method   setToken
 * @param [int] $Length [令牌的长度]
 * @return [string] [返回token字符串]
 * @version  [1.0]
 * @author liyuay
 * @datetime 2017-01-01T14:18:00+080
 */
function randomStr($Length)
{
    // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $_token = '';
    for ($i = 0; $i < $Length; ++$i) {
        $_token .= $_chars[rand(0, strlen($_chars) - 1)];
    }

    return $_token;
}
