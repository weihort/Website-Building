<?php
namespace View\Computer\Pages\Composition;
 ?>


<div class="container">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-6 panel panel-default">
          <!--头部搜索框-->
          <div class="container-fluid">
            <div class="row search">
              <div class="col-md-1"></div>
              <div class="col-md-9 container-fluid">
                <div class="row">
                  <div class="col-md-2">
                    <img src="#" />
                  </div>
                  <div class="col-md-10">
                    <textarea class="content"></textarea>
                    <button class="btn btn-primary searchbtn inner"><p>发表</p></button>
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div>
            </div>
          </div>
          <!--结束头部搜索框-->
          <hr/>

          <?php echo $contentStr; ?>

        </div>
        <div class="col-md-2"></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="login">
        登陆
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var jqReviewDoms = jQuery(".review");
  var preDom = null;
  jqReviewDoms.each(function() {
    var jqThis = jQuery(this);
    jqThis.click(function() {
      if (preDom != null && !jqThis.attr('data-this')) {
        preDom.attr('data-open', "1");
        preDom.attr('data-this', "");
        preDom.parent().next().remove();
      }
      if (jqThis.attr('data-open') && !jqThis.attr('data-this')) {
        jqThis.attr('data-this', "1");
        jqThis.parent().after(
          "<div id='reply' class='container-fluid'><div class='row search'><div class='col-md-1'></div><div class='col-md-9 container-fluid'>" +
          "<div class='row'><div class='col-md-2'><img src='#' /></div><div class='col-md-10'><textarea class='content' id='midst-content'></textarea>" +
          "<button class='btn btn-primary searchbtn inner'><p click='sendReply()'>发表</p></button></div></div><div class='col-md-2'></div></div></div></div>"
        );
        jqThis.attr('data-open', "");
      } else {
        jqThis.parent().next().remove();
        jqThis.attr('data-open', "1");
        jqThis.attr('data-this', "");
      }
      preDom = jqThis;
    });
  });

  function sendReply() {
    var content = jQuery("#midst-content").val();
    var fatherUserName = preDom.parent().parent().find("data-reply='father-username'").html();
    jQuery.ajax({
      type: 'POST',
      url: '../../Controller/get_reply.php',
      data: {
        fatherUserName: fatherUserName,
        content: content
      },
      dataType: 'json',
      timeout: 300,
      success: function(data) {
        token = null;
      },
      error: function(xhr, type) {
        alert('Ajax error!');
      }
    });
  }
</script>
