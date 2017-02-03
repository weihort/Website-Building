<?php

namespace Controller\Common;

use \Model\Tables\Article;
use \Model\Tables\User;
use \Model\Tables\Comment;
use \Model\Tables\Temp;
use \Model\Tables\Viewpoint;

include dirname(dirname(dirname(__FILE__))) . "/Model/class.datebase.php";          //引入 class.datebase.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.Article.php';    //引入 class.forum.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.User.php';       //引入 class.customer.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.Comment.php';    //引入 class.forum.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.Temp.php';       //引入 class.temp.php 文件
include dirname(dirname(dirname(__FILE__))) . '/Model/Tables/class.Viewpoint.php';  //引入 class.viewpoint.php 文件

$article   = new Article(true);                  //实例化 Article   对象
$customer  = new User(true);                 //实例化 Customer  对象
$forum     = new Comment(true);                    //实例化 Forum     对象
$temp      = new Temp(true);                     //实例化 Temp      对象
$viewpoint = new Viewpoint(true);                //实例化 Viewpoint 对象
