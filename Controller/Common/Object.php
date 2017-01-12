<?php

namespace Controller\Common;

use \Model\Tables\Customer;
use \Model\Tables\Temp;
use \Model\Tables\Forum;

include dirname(dirname(dirname(__FILE__))) . "/Model/class.datebase.php";           //引入 class.datebase.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.customer.php';    //引入 class.customer.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.temp.php';        //引入 class.temp.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.forum.php';       //引入 class.forum.php 文件
$customer = new Customer(true);          //实例化 Customer 对象
$temp     = new Temp(true);
$forum    = new Forum(true);
