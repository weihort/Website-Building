<?php
namespace View\Compute
 ?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <title>Party&nbsp;&middot;&nbsp;Liyusky</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/general.min.css">
    <script src="./javascript/jquery.min.js"></script>
    <script src="./javascript/bootstrap.js"></script>
  </head>

  <body>

    <!-- start 引入头部 -->
    <?php include './header.php'; ?>
    <!-- end 引入头部 -->

    <!-- start content -->
    <div class="container">
      <div class="row">
        <ul class="col-md-8 media-list">
          <li class="media rounded-default padding-extension border-exist ">
            <h2 class="title-control">
                  这是一个标题
                  <span class="badge pull-right badge-control">42</span>
            </h2>
            <a class="media-left" href="#">
              <img src="./images/it-sign.jpg" alt="..." class="img-sm img-rounded">
            </a>
            <div class="media-body relative">
              <p>
                this is a content this is a conten this is a content this is a content this is a conten this is a content this is a content this is a conten this is a content this is a content this is a conten this is a content
              </p>
              <div class="row absolute-bottom">
                <div class="col-md-6">
                  <p>
                    <span>date</span>
                    <span>2016-11-30</span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="pull-right">
                    <span>author</span>
                    <span>liyusky</span>
                  </p>
                </div>
              </div>
            </div>
          </li>
        </ul>
        <div class="col-md-3"></div>
      </div>
    </div>
    <!-- end content -->


    <!-- start 引入尾部 -->
    <?php include './footer.php'; ?>
    <!-- end 引入尾部 -->
  </body>

  </html>
