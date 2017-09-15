<?php
namespace View\Computer\Pages\Composition;
 ?>
<!-- start content -->
<div class="container">
  <div class="row">
    <ul class="col-md-7 col-md-offset-1 media-list" id="skill-list">
    </ul>
    <ul class="col-md-3 col-md-offset-1 media-list">
      <li class="media row">
        <a href="#" class="media-left col-md-5">
          <img src="./images/it-sign.jpg" alt="" class="img-thumbnail" />
        </a>
        <div class="media-body col-md-7">
          <h4 class="media-heading text-center">HTML</h4>
          <hr class="split-line-lg border-charcoal" />
          <div class="row">
            <a href="" class="btn btn-default col-md-6">svg</a>
            <a href="" class="btn btn-default col-md-6">svg</a>
            <a href="" class="btn btn-default col-md-6">svg</a>
            <a href="" class="btn btn-default col-md-6">....</a>
          </div>
        </div>
      </li>
      <li class="media row">
        <a href="#" class="media-left col-md-5">
          <img src="./images/it-sign.jpg" alt="" class="img-thumbnail" />
        </a>
        <div class="media-body col-md-7">
          <h4 class="media-heading text-center">CSS</h4>
          <hr class="split-line-lg border-charcoal" />
          <div class="row">
            <a href="" class="btn btn-default col-md-6">ID</a>
            <a href="" class="btn btn-default col-md-6">ID</a>
            <a href="" class="btn btn-default col-md-6">ID</a>
            <a href="" class="btn btn-default col-md-6">....</a>
          </div>
        </div>
      </li>
      <li class="media row">
        <a href="#" class="media-left col-md-5">
          <img src="./images/it-sign.jpg" alt="" class="img-thumbnail" />
        </a>
        <div class="media-body col-md-7">
          <h4 class="media-heading text-center">JAVASCRIPT</h4>
          <hr class="split-line-lg border-charcoal" />
          <div class="row">
            <a href="" class="btn btn-default col-md-6">dom</a>
            <a href="" class="btn btn-default col-md-6">dom</a>
            <a href="" class="btn btn-default col-md-6">dom</a>
            <a href="" class="btn btn-default col-md-6">....</a>
          </div>
        </div>
      </li>
      <li class="media row">
        <a href="#" class="media-left col-md-5">
          <img src="./images/it-sign.jpg" alt="" class="img-thumbnail" />
        </a>
        <div class="media-body col-md-7">
          <h4 class="media-heading text-center">BOOTSTRAP</h4>
          <hr class="split-line-lg border-charcoal" />
          <div class="row">
            <a href="" class="btn btn-default col-md-6">组件</a>
            <a href="" class="btn btn-default col-md-6">组件</a>
            <a href="" class="btn btn-default col-md-6">组件</a>
            <a href="" class="btn btn-default col-md-6">....</a>
          </div>
        </div>
      </li>
      <li class="media row">
        <a href="#" class="media-left col-md-5">
          <img src="./images/it-sign.jpg" alt="" class="img-thumbnail" />
        </a>
        <div class="media-body col-md-7">
          <h4 class="media-heading text-center">PHP</h4>
          <hr class="split-line-lg border-charcoal" />
          <div class="row">
            <a href="" class="btn btn-default col-md-6">PDO</a>
            <a href="" class="btn btn-default col-md-6">PDO</a>
            <a href="" class="btn btn-default col-md-6">PDO</a>
            <a href="" class="btn btn-default col-md-6">....</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>

<script type="text/javascript">
    jQuery("#skill-list").ready(function() {
        setRecommend("skill", "skill-list", setSkill);
    });

    function setSkill (unitRecommendMessage) {
        return "<li class='media border-exist padding-extension rounded-default'>" +
                  "<a href='" + unitRecommendMessage.content_link + "' class='media-left img-sm'>" +
                    "<img src='http://127.0.0.1:8080/" + unitRecommendMessage.image_link + "' class='img-sm img-rounded' />" +
                  "</a>" +
                  "<div class='media-body relative' style='width:100%;'>" +
                    "<h2 class='media-heading'>" +
                      unitRecommendMessage.title +
                      "<span class='badge pull-right'>" + unitRecommendMessage.agree + "</span>" +
                    "</h2>" +
                    "<p>" +
                        unitRecommendMessage.description +
                      "<a href='" + unitRecommendMessage.content_link + "'>继续阅读&rarr;</a>" +
                    "</p>" +
                    "<div class='row absolute-bottom'>" +
                      "<div class='col-md-8'>" +
                        "<span>" + unitRecommendMessage.release_date + "</span>" +
                      "</div>" +
                      "<div class='col-md-4'>" +
                        "<p class='pull-right'>" +
                          "<a href='#'>" + unitRecommendMessage.author + "</a>" +
                        "</p>" +
                      "</div>" +
                    "</div>" +
                  "</div>" +
                "</li>";
    }

</script>


<!-- end content -->
