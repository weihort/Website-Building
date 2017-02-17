<?php
namespace \View\Computer
 ?>

<!DOCTYPE html>
<html lang="zh-cn">

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <title>Page Title</title>
  <script src="./javascript/jquery.min.js"  type="text/javascript" charset="utf-8"></script>
  <script src="./javascript/bootstrap.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">login</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">登陆</h4>
        </div>
        <div class="modal-body">
          <form role="form" id="login" >
            <div class="form-group">
              <label for="register-username">username</label>
              <input type="text" class="form-control" name="username" placeholder="请输入用户名" id="login-username" />
            </div>
            <div class="form-group">
              <label for="register-password">password</label>
              <input type="password" class="form-control" name="password" placeholder="请输入密码" id="login-password" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary pull-right" id="login-submit" >登陆</button>
        </div>
      </div>
    </div>
  </div>
  <div id="allmap"></div>
</body>

<script type="text/javascript">
  var username = jQuery("#login-username").val();
  var password = jQuery("#login-password").val();
  var longitude,latitude,token;
  var ip = "<?echo $_SERVER[REMOTE_ADDR] ?>";
  if (!username) {
    alert("请输入用户名");
    break;
  }
  if (!password) {
    alert("请输入密码");
    break;
  }
  if (!isUsername(username)) {
    alert("用户名格式不正确，必须以字母开头，接受字母，数字，“_”的10~20位字符串");
    break;
  }
  if (!isPassword(password)) {
    alert("密码为不接受引号和空格的10~20位字符串");
    break;
  }
  // getGeolocation();
  jQuery.post(
    "../../Controller/Safe/token.php",
    function(data,status) {
        console.log(data);
    }
  );
  jQuery('#login-submit').click(function() {
    jQuery.ajax({
      type: "POST",
      url: "../../Controller/User/login.php",
      data: {
        token : token,
        username: username,
        password: password,
        ip: ip,
        longitude: "longitude",
        latitude : "latitude"
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
  });
  // function getGeolocation(longitude,latitude) {
  //   var map = new BMap.Map("allmap");
  //   var geolocation = new BMap.Geolocation();
  //   geolocation.getCurrentPosition(
  //     function(r) {
  //       if (this.getStatus() == BMAP_STATUS_SUCCESS) {
  //         longitude = r.point.lng;
  //         latitude = r.point.lat;
  //       }
  //       else {
  //         alert('failed' + this.getStatus());
  //       }
  //     },
  //     {
  //       enableHighAccuracy: true
  //     }
  //   );
  // }
</script>

</html>
