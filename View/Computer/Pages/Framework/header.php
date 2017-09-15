<?php
namespace View\Computer\Pages\Framework;

 ?>
<!-- start header -->
<header class="container-fluid bd" style="background-image: url();">
  <!-- start nav -->
  <nav class="navbar container-control">
    <div class="container relative">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" id="new-page">
          <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=new">NEWS</a>
        </li>
        <li role="presentation" id="comic-page">
          <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=comic">COMICS</a>
        </li>
        <li role="presentation" id="skill-page">
          <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=skill">IT SKILLS</a>
        </li>
        <li role="presentation" id="communication-page">
          <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=communication">GUEST BOOKS</a>
        </li>
        <li role="presentation" id="game-page">
          <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=game">GAMES</a>
        </li>
        <li role="presentation" id="party-page">
          <a href="http://127.0.0.1:8080/View/Computer/Pages/Framework/home.php?page=party">PARTYS</a>
        </li>
      </ul>
    <a href="http://127.0.0.1:8080/View/Computer/Pages/Empower/account.php" class="keep-right btn btn-primary" target="_blank">登陆</a>
    </div>
  </nav>
  <!-- end nav -->
  <div class="container">
    <div class="row">
      <!-- start logo -->
      <figure class="col-md-3" style="margin-top:15px;">
        <a href="">
          <img src="../../images/logo.svg" alt="" class="img-responsive" />
        </a>
      </figure>
      <!-- end logo -->
      <!-- start search -->
      <form class=" form col-md-3 col-md-push-6" action="index.html" method="post" style="margin-top:50px;margin-bottom:20px;">
        <div class="input-group">
          <input type="text" class="form-control">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
        </div>
      </form>
      <!-- end search -->
    </div>
  </div>
</header>
<!-- end header -->
