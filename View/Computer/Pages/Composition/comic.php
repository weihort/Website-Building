<?php
namespace View\Computer\Pages\Composition;
 ?>

<head>
    <title>Comic&nbsp;&middot;&nbsp;Liyusky</title>
</head>


<!--start content-->
<div class="container">
  <div class="row">
    <ul class="col-md-8" id="comic-list">
    </ul>
    <div class="col-md-4"></div>
  </div>
</div>
<!--end content-->

<script type="text/javascript">
    jQuery("#comic-list").ready(function() {
        setRecommend("comic", "comic-list", setComic);
    });
    function setComic (unitRecommendMessage) {
        return "<li class='thumbnail'>" +
                  "<div class='caption'>" +
                    "<h2>" +
                        unitRecommendMessage.title +
                      "<span class='badge badge-control pull-right'>" + unitRecommendMessage.agree + "</span>" +
                    "</h2>" +
                  "</div>" +
                  "<a href='" + unitRecommendMessage.content_link + "'>" +
                    "<img src='http://127.0.0.1:8080/" + unitRecommendMessage.image_link + "' class='rounded-default' style='width:96%;height:96%;margin:auto;' />" +
                  "</a>" +
                  "<div class='caption'>" +
                    "<p>" +
                        unitRecommendMessage.description +
                      "<a href='" + unitRecommendMessage.content_link + "'>继续阅读&rarr;</a>" +
                    "</p>" +
                    "<div class='row'>" +
                      "<div class='col-md-2'>" +
                          "<a href='#' class='btn'>" + unitRecommendMessage.author + "</a>" +
                      "</div>" +
                      "<div class='col-md-6' data-aid='" + unitRecommendMessage.aid + "'>" +
                          "<p class='btn-simple' data-opinion='agree' data-allow='true' onclick='javascript:agree(jQuery(this));' title='喜欢'>" +
                              "<span class='glyphicon glyphicon-heart'></span>" +
                              "<span>&nbsp;</span>" +
                              "<span>" + unitRecommendMessage.agree + "</span>" +
                          "</p>" +
                          "<p class='btn-simple' data-opinion='oppose' data-allow='true' onclick='javascript:oppose(jQuery(this));' title='反对'>" +
                              "<span class='iconfont icon-icondislike'></span>" +
                              "<span>&nbsp;</span>" +
                              "<span>" + unitRecommendMessage.oppose + "</span>" +
                          "</p>" +
                          "<p class='btn-simple' data-opinion='favorite' data-allow='true' onclick='javascript:favorite(jQuery(this));' title='收藏'>" +
                              "<span class='glyphicon glyphicon-star-empty'></span>" +
                              "<span>&nbsp;</span>" +
                              "<span>" + unitRecommendMessage.favorite + "</span>" +
                          "</p>" +
                          "<p class='btn-simple' data-opinion='report' data-allow='true' onclick='javascript:report(jQuery(this));' title='举报'>" +
                              "<span class='iconfont icon-jubao'></span>" +
                              "<span>&nbsp;</span>" +
                              "<span>" + unitRecommendMessage.report + "</span>" +
                          "</p>" +
                      "</div>" +
                      "<div class='col-md-3'>" +
                        "<p class='pull-right'>" +
                          "<span style='line-height:36px;'>" + unitRecommendMessage.release_date + "</span>" +
                        "</p>" +
                      "</div>" +
                    "</div>" +
                  "</div>" +
                "</li>";
    }
</script>
