<!DOCTYPE html>
<html lang="zh-cn">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <title>Page Title</title>
  <script src="./javascript/jquery.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="./javascript/bootstrap.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    register
  </button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">注册</h4>
        </div>
        <div class="modal-body">
          <form role="form" id="register">
            <div class="form-group">
              <label for="register-username">username</label>
              <input type="text" class="form-control" placeholder="请输入用户名" id="register-username" />
            </div>
            <div class="form-group">
              <label for="register-password">password</label>
              <input type="password" class="form-control" placeholder="请输入密码" id="register-password" />
            </div>
            <div class="form-group">
              <label for="register-confirm-password">confirm password</label>
              <input type="password" class="form-control" id="register-confirm-password" placeholder="请确认密码">
            </div>
            <div class="form-group">
              <label for="register-email"></label>
              <input type="email" class="form-control" id="register-email" placeholder="请输入邮箱">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary pull-right" data-dismiss="modal" id="register-submit">注册</button>
        </div>
      </div>
    </div>
  </div>
  <div id="allmap"></div>
</body>
<script type="text/javascript">
  jQuery('#register-submit').click(function() {
    var username = jQuery("#register-username").val();
    var password = jQuery("#register-password").val();
    var confirmPassword = jQuery("#register-confirm-password").val();
    var email = jQuery("#register-email").val();
    // var longitude,latitude;
    if (!username) {
      alert("请输入用户名");
      return false;
    }
    if (!password) {
      alert("请输入密码");
      return false;
    }
    if (!email) {
      alert("请输入邮箱");
      return false;
    }
    if (password != confirmPassword) {
      alert("请保持密码一致");
      return false;
    }
    // if (!isUsername(username)) {
    //   alert("用户名格式不正确，必须以字母开头，接受字母，数字，“_”的10~20位字符串");
    //   return false;
    // }
    // if (!isPassword(password)) {
    //   alert("密码为不接受引号和空格的10~20位字符串");
    //   return false;
    // }
    // if (!isEmail(email)) {
    //   alert("邮箱格式不正确");
    //   return false;
    // }
    // getGeolocation();
    jQuery.ajax({
      type: "POST",
      url: "../../Controller/register.php",
      data: {
        username: username,
        password: password,
        email: email,
        ip: <?php echo strval("'" .$_SERVER['REMOTE_ADDR'] . "'") ?>,
        // longitude: longitude,
        // latitude : latitude
      },
      timeout: 300,
      success: function(data) {

      },
      error: function(xhr, type) {
        alert(xhr.type + "      " + xhr.status);
      }
    });
  });
  function isUsername(username){
    var reg = /^\w{1}+[\w|\d]{7,19}/;
    return reg.test(username);
  }
  function isPassword(password){
    var reg = RegExp("^[\S\b|\d]{1}+[\w|\d\|[~!@#$%^&*(){}[].,<>?_+-=]");
    return reg.test(password);
  }
  function isEmail(email){
    var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    return reg.test(email);
  }
  function getGeolocation(longitude,latitude) {
    var map = new BMap.Map("allmap");
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(
      function(r) {
        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
          longitude = r.point.lng;
          latitude = r.point.lat;
        }
        else {
          alert('failed' + this.getStatus());
        }
      },
      {
        enableHighAccuracy: true
      }
    );
  }
</script>

</html>
