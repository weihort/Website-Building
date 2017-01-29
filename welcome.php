<?php
session_start();
$_SESSION['ROOT_DIRECTORY'] = dirname(__FILE__);
$_SESSION['WEB_SITE'] = 'localhost:8080';
$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
 ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>HOME&nbsp;&middot;&nbsp;Liyusky</title>
  <link rel="stylesheet" href="./View/Computer/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./View/Computer/css/general.min.css" />
  <script src="./View/Computer/javascript/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid bg" style="background-image: url(./View/Computer/images/bg.jpg)">
    <!-- start logo -->
    <header class="row margin-top-lg">
      <figure class="col-md-6 col-md-push-3 margin-top-lg margin-vertical-extension">
        <img src="./View/Computer/images/logo.svg" class="img-responsive horizontal-center" alt="logo" />
      </figure>
    </header>
    <!-- end logo -->

    <hr class="split-line-md border-line-write margin-vertical-extension" />

    <!-- start page link -->
    <div class="row margin-vertical-extension">
      <nav class="col-md-6 col-md-push-3">
        <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=new" class="col-md-6 btn btn-lg btn-link write-color">NEWS</a>
        <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=comic" class="col-md-6 btn btn-lg btn-link write-color">COMICS</a>
        <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=skill" class="col-md-6 btn btn-lg btn-link write-color">IT SKILLS</a>
        <!-- <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=communication" class="col-md-6 btn btn-lg btn-link write-color">GUEST BOOKS</a> -->
        <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=game" class="col-md-6 btn btn-lg btn-link write-color">GAMES</a>
        <!-- <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=party" class="col-md-6 btn btn-lg btn-link write-color">PARTYS</a> -->
      </nav>
    </div>
    <!-- start page link -->

    <!-- start footer -->
    <footer class="row text-center fixed-bottom">
      <hr class="split-line-lg border-line-write" />
      <p class="write-color">liyusky是一个个人兴趣分享网站,欢迎志同道合的朋友一起寻找快乐。</p>
      <hr class="split-line-md border-line-write" />
      <p class="write-color">liyusky版权&copy;2016-2017&nbsp;liyusky保留所有权利。备案号：皖ICP备16021919号-1</p>
    </footer>
    <!-- start footer -->

    </div>

    <script type="text/javascript">
        //版本1.0  在鼠标移动到按钮上时获取文章信息
        // var mark = {
        //     comic: true,
        //     skill: true,
        //     game: true,
        //     party: true
        // };
        // var flag = true;
        //
        // function getArticle(thisDom) {
        //     var genre = thisDom.attr("data-genre");
        //     if (thisDom.attr("data-unloaded") && flag) {
        //         switch (genre) {
        //             case 'all':
        //                 for (var key in mark) {
        //                     getArticleStr(key);
        //                 }
        //                 flag = false;
        //                 break;
        //             default:
        //                 getArticleStr(genre);
        //                 mark[genre] = false;
        //                 flag = false;
        //                 for (var key in mark) {
        //                     if (mark[key]) {
        //                         flag = true;
        //                     }
        //                 }
        //         }
        //     }
        //     thisDom.attr("data-unloaded", false);
        // }
        //
        // function getArticleStr (genre) {
        //     jQuery.post(
        //             "http://127.0.0.1:8080/Controller/Recommend/featuredGoods.php",
        //             {"genre": genre},
        //             function (data) {
        //                 if (typeof(Storage)) {
        //                     localStorage[genre] = data;
        //                 }
        //             },
        //             'text'
        //         );
        // }

        //版本2.0  页面一加载就获取文章信息
        for (var genre of ['comic', 'skill', 'game']) {
            (function(genre) {
                jQuery.post(
                    "http://127.0.0.1:8080/Controller/Recommend/featuredGoods.php",
                    {"genre": genre},
                    function (data) {
                        if (typeof(Storage)) {
                            localStorage[genre] = data;
                        }
                    },
                    'text'
                );
            })(genre);
        }
    </script>
</body>

</html>
