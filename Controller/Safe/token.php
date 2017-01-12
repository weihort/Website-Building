<?php

namespace Controller\Safe;

use \Controller\Common as Common;

include dirname(dirname(dirname(__FILE__))) . '/Controller/Common/randomStr.php';       //引入 Customer.php 文件

session_start();
$_SESSION['token'] = Common\randomStr(20);
echo $_SESSION['token'];
