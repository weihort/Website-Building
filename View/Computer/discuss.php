<?php
namespace View;
use Controller;
session_start();
define("ROOT_PATH",dirname(dirname(dirname(__FILE__))));
$_SESSION['ROOT_PATH'] = ROOT_PATH;
include ROOT_PATH . "/Controller/forum.php";
 ?>
 <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <title>评论页面</title>
      <link rel="stylesheet" href="../Computer/css/bootstrap.min.css">
      <link rel="stylesheet" href="../Computer/css/forum.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-6 panel panel-default">
                    <div class="row search">
                      <div class="col-md-1"></div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-2">
                            <img src="#" />
                          </div>
                          <div class="col-md-8">
                            <textarea class="content"></textarea>
                          </div>
                          <div>
                            <button class="btn btn-primary searchbtn inner"><p>发表<br/>评论</p></button>
                          </div>
                        </div>
                        <div class="col-md-2"></div>
                      </div>
                    </div>

                    <hr/>

                    <?php echo $contentStr; ?>

                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </body>
 </html>
