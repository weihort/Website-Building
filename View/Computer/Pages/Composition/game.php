<?php
namespace View\Computer\Pages\Composition;

?>
<!-- start content -->
<div class="container">
  <div class="row">
    <ul class="col-md-8 media-list" id="game-list">
    </ul>
    <div class="col-md-3"></div>
  </div>
</div>

<script type="text/javascript">
    jQuery("#game-list").ready(function() {
        setRecommend("game", "game-list", setGame);
    });

    function setGame (unitRecommendMessage) {
        return "<li class='media rounded-default padding-extension border-exist '>" +
                "<h2 class='title-control'>" +
                    "<a href='" + unitRecommendMessage.content_link + "'>" + unitRecommendMessage.title + "</a>" +
                    "<span class='badge pull-right badge-control'>" + unitRecommendMessage.agree + "</span>" +
                "</h2>" +
                "<a class='media-left' href='" + unitRecommendMessage.content_link + "'>" +
                  "<img src='http://127.0.0.1:8080/" + unitRecommendMessage.image_link + "' class='img-sm img-rounded'>" +
                "</a>" +
                "<div class='media-body relative' style='width: 100%;'>" +
                  "<p>" +
                    unitRecommendMessage.description +
                 "</p>" +
                 "<div class='row absolute-bottom' style='width: 100%;'>" +
                    "<div class='col-md-6'>" +
                        "<p>" +
                            "<a href='#'>" + unitRecommendMessage.author + "</a>" +
                        "</p>" +
                    "</div>" +
                    "<div class='col-md-6'>" +
                        "<p class='pull-right'>" +
                          "<span>" + unitRecommendMessage.release_date + "</span>"+
                        "</p>" +
                    "</div>" +
                  "</div>" +
                "</div>" +
              "</li>";
    }
</script>
<!-- end content -->
