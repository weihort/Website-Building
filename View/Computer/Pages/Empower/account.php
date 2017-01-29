<?php

namespace View\Computer\Pages\Empower;

use \Controller\Common;

session_start();
include $_SESSION['ROOT_DIRECTORY'] . "/Controller/Common/randomStr.php";

 ?>


<!DOCTYPE html>


<html>

<head>
  <meta charset="utf-8">
  <title>鲤鱼旗</title>
  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../css/iconfont.css">
  <link rel="stylesheet" type="text/css" href="../../css/general.min.css">
  <script src="../../javascript/jquery.min.js"></script>
  <script src="../../javascript/bootstrap.js"></script>
</head>

<body>
  <div class="modal fade" id="forget-password" tabindex="-1" role="dialog" aria-labelledby="forget-password-label" aria-hidden="true">
    <div class="modal-dialog" style="width:302px;">
      <div class="modal-content overflow-hidden">
        <div class="modal-header text-center">
          <span class="close" data-dismiss="modal" aria-hidden="true">&times;</span>
          <h4 class="modal-title">忘记密码</h4>
          <p>验证码会发送至您的邮箱</p>
        </div>
        <div class="clearfix" id="modal-wrap" style="width:600px;margin-bottom:-47px;">
          <!-- start 输入邮箱 -->
          <div class="pull-left" style="width:300px;">
            <div class="modal-body form margin-vertical-extension">
              <div class="form-group margin-vertical-extension">
                <label for="verification-email" class="sr-only">邮箱</label>
                <input class="form-control" id="verification-email" type="text" placeholder="请输入您的邮箱">
              </div>
              <div class="form-group has-feedback">
                <label for="allow-send" class="sr-only">确认码</label>
                <input class="form-control" id="allow-send-code" type="text" placeholder="请输入右侧文字">
                <span id="allow-send-message" class="form-control-feedback" style="margin-right:10px;">
                    <?php echo Common\randomStr(4); ?>
                </span>
              </div>
            </div>
            <div class="modal-footer text-center">
              <a href="javascript:void(0);" onclick="javascript:sendVerificationCode();" class="btn btn-primary">发送邮箱验证码</a>
            </div>
          </div>
          <!-- end 输入邮箱 -->
          <!-- start 输入验证码 -->
          <div class="pull-left" style="width:300px;">
            <div class="modal-body form margin-vertical-extension">
              <div class="form-group">
                <label for="customer-email" class="sr-only">邮箱</label>
                <input class="form-control margin-vertical-extension" id="customer-email" type="email" placeholder="请输入注册的邮箱">
              </div>
              <div class="form-group">
                <label for="new-password" class="sr-only">新密码</label>
                <input class="form-control margin-vertical-extension" id="new-password" type="password" placeholder="请输入新密码">
              </div>
              <div class="form-group margin-vertical-extension">
                <label for="verification-code" class="sr-only">验证码</label>
                <div class="input-group">
                  <input class="form-control" id="verification-code" type="text" placeholder="请输入邮箱中的验证码">
                  <a class="input-group-btn">
                    <span class="btn btn-default" onclick="javascript:limitTimeSend(jQuery(this));" role="button"><span id="remain-time"></span>重发</span>
                </a>
                </div>
              </div>
            </div>
            <div class="modal-footer text-center">
              <a href="javascript:void(0);" onclick="javascript:resetPassword();" class="btn btn-primary">重设密码</a>
            </div>
          </div>
          <!-- end 输入验证码 -->
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 text-center">
        <img class="row margin-top-lg" src="http://127.0.0.1:8080/View/Computer/images/logo.svg">
        <h4>相同的兴趣，创造不同的快乐！</h4>
        <div class="nav nav-pills margin-vertical-extension text-center">
          <a class="btn btn-link btn-control active" id="switch-login" data-switch="1" data-toggle="tab" href="#login" style="color:#0f88eb;">登录</a>
          <a class="btn btn-link btn-control" id="switch-regist" data-switch="0" data-toggle="tab" href="#regist" style="color:#9bd0d0;">注册</a>
        </div>
        <ul class="tab-content margin-vertical-extension list-unstyled">
          <li class="tab-pane fade in active" id="login">
            <input class="form-control margin-vertical-extension" id="login-username" type="text" placeholder="用户名">
            <input class="form-control margin-vertical-extension" id="login-password" type="password" placeholder="密码">
            <a class="btn btn-primary form-control margin-vertical-extension" onclick="javascript:login();">登录</a>
            <p class="text-left">
              <a href="javascript:void(0);">手机验证码登录</a>
              <a class="pull-right"  href="javascript:void(0);" data-toggle="modal" data-target="#forget-password">忘记密码？</a>
            </p>
            <div class="row">
              <div class="col-md-4">
                <a class="pull-left" href="javascript:void(0);" onclick="javascript:showOtherLogin();" style="line-height:31px;">社交账号登录</a>
              </div>
              <div class="col-md-4">
                <div class="overflow-hidden none row" id="hide" style="height:25px;width:0;">
                    <a class="iconfont icon-111 icon col-md-4" href="#" target="_blank"></a>
                    <a class="iconfont icon-zliconweibo01 icon col-md-4" href="#" target="_blank"></a>
                    <a class="iconfont icon-weixin icon col-md-4" href="#" target="_blank"></a>
                </div>
              </div>
            </div>
          </li>
          <li class="tab-pane fade" id="regist">
            <input class="form-control margin-vertical-extension" id="regist-username" type="text" placeholder="用户名">
            <input class="form-control margin-vertical-extension" id="regist-email" type="email" placeholder="邮箱">
            <input class="form-control margin-vertical-extension" id="regist-password" type="text" placeholder="密码">
            <a class="btn btn-primary form-control margin-vertical-extension" onclick="javascript:regist();">注册</a>
            <p>
              <span>点击&#91;注册&#93;按钮，即代表你同意</span>
              <a href="#" target="_blank">《本站协议》</a>
            </p>
          </li>
        </ul>
        <a class="btn btn-default form-control margin-vertical-extension hidden">下载APP</a>
      </div>
    </div>
  </div>
  <script src="./javascript/jquery.min.js"></script>
  <script src="./javascript/bootstrap.js"></script>
  <script type="text/javascript" src="./javascript/md5-min.js"></script>
  <script>
    var ip                   = "<?php echo $_SESSION['ip']; ?>";
    var wrapDom              = jQuery("#modal-wrap");
    var modelHeaderDom       = wrapDom.prev();
    var verificationEmailDom = jQuery('#verification-email');
    var customerEmailDom     = jQuery('#customer-email');
    var allowSendCodeDom     = jQuery('#allow-send-code');


    /**
     * [sendVerificationCode 通过邮件发送验证码]
     * @method   sendVerificationCode
     * @version  [1.1]
     * @author 闻国庆
     * @Proofreader liyusky
     * @datetime 2017-01-16T17:42:21+080
     */
    function sendVerificationCode () {
      var verificationEmail = verificationEmailDom.val();
      var allowSendCode     = allowSendCodeDom.val();
      var allowSendMessage  = jQuery.trim(jQuery('#allow-send-message').html());
      if (!verificationEmail) {
        alert("请填写邮箱地址！");
        return false;
      }
      if (!allowSendCode) {
        alert("请填写右侧文字！");
        return false;
      }
      if (allowSendCode != allowSendMessage) {
        alert('请正确输入右侧文字');
        return false;
      }
      if (!isEmail(verificationEmail)) {
        alert("邮箱地址不正确！");
        return false;
      }
      sendVerificationEmail(verificationEmail, nextForm);
    }

    function sendVerificationEmail (verificationEmail, callback) {
        jQuery.ajax({ //提交数据
            type: "POST",
            url: "../../Controller/User/sendVerificationCode.php",
            data: {
                email: verificationEmail
            },
            dataType: 'text',
            datetime: 300,
            success: function(data) {
                if(callback)callback();
            },
            error: function(xhr, status, error) {
                alert('邮件发送失败，请重新点击');
            }
        });
    }

    /**
     * [nextForm 跳转到修改新密码表单]
     * @method      nextForm
     * @version     [1.0]
     * @author liyusky
     * @Proofreader liyusky
     * @datetime    2017-01-17T11:59:18+080
     */
    function nextForm () {
        wrapDom.slideUp("slow", function() {
            modelHeaderDom.prepend("<span onclick='javascript:previousForm();' class='glyphicon text-primary glyphicon-arrow-left pull-left'></span>");
            wrapDom.css('margin', '0 0 0 -300px');
        });
        wrapDom.slideDown("slow");
        jQuery('#allow-send-message').html("<?php echo Common\randomStr(4); ?>");
        customerEmailDom.val(verificationEmailDom.val());
    }

    /**
     * [back 切换回到填写邮箱页面]
     * @method      back
     * @version     [1.0]
     * @author liyusky
     * @Proofreader liyusky
     * @datetime    2017-01-16T17:48:30+080
     */
    function previousForm() {
      wrapDom.slideUp("slow", function() {
        modelHeaderDom.children('.text-primary').remove();
        wrapDom.css('margin', '0 0 -47px 0');
      });
      wrapDom.slideDown("slow");
      allowSendCodeDom.val("");
    }

    /**
     * [resetPassword 发送新密码]
     * @method      resetPassword
     * @version     [1.0]
     * @author 闻国庆
     * @Proofreader liyusky
     * @datetime    2017-01-16T17:49:54+080
     */
    function resetPassword() {
      var customerEmail    = customerEmailDom.val();
      var newPassword      = jQuery('#new-password').val();
      var verificationCode = jQuery('#verification-code').val();
      if (!customerEmail) {
        alert("邮箱账户不能为空！");
        return false;
      }
      if (!newPassword) {
        alert("请填写新密码！");
        return false;
      }
      if (!verificationCode) {
        alert("邮箱验证码不能为空！");
        return false;
      }
      if (!isEmail(customerEmail)) {
        alert("邮箱格式不正确！");
        return false;
      }
      if (!isPassword(newPassword)) {
        alert("密码格式不正确！");
        return false;
      }
      jQuery.ajax({ //提交数据
        type: "POST",
        url: "../../Controller/User/resetPassword.php",
        data: {
          email: customerEmail,
          password: newPassword,
          verification: verificationCode
        },
        dataType: 'text',
        success: function(data) {
          alert("data");
        },
        error: function() {
          alert('邮件发送失败，请重试！');
        }
      });
    }

    /**
     * [limitTimeSend 一分钟内限制点击按键发送新验证码]
     * @method      limitTimeSend
     * @param       jqDom                 thisDom [当前按钮（重新发送按钮）]
     * @version     [1.0]
     * @author liyusky
     * @Proofreader liyusky
     * @datetime    2017-01-17T12:01:27+080
     */
    function limitTimeSend (thisDom) {
        var verificationEmail = jQuery('#verification-email').val();
        var remainTimeDom     = jQuery("#remain-time");
        var remainTime        = 60;
        thisDom.addClass("disabled");
        sendVerificationEmail(verificationEmail);
        var delay = setInterval(function() {
            remainTimeDom.html(remainTime-- + '秒后');
            if (remainTime == 0) {
                clearInterval(delay);
                thisDom.removeClass('disabled');
                remainTimeDom.html("");
            }
        },1000);
    }

    /**
     * [login 用户登录]
     * @method      login
     * @version     [1.1]
     * @author 闻国庆
     * @Proofreader liyusky
     * @datetime    2017-01-16T17:51:35+080
     */
    function login() {
      var username = jQuery('login-username').val(); //获取用户名
      var password = jQuery('login-password').val(); //获取密码
      if (!username) { //判断用户名是否为空
        alert("用户名不允许为空！");
        return false;
      }
      if (!password) { //判断密码是否为空
        alert("密码不允许为空！");
        return false;
      }
      if (!isUsername(username)) { //判断用户名是否符合格式
        alert("用户名不正确！")
        return false;
      }
      if (!isPassword(password)) { //判断密码是否符合格式
        alert("密码不正确！")
        return false;
      }
      var token = getToken(); //获取令牌
      emptySafeMsg(ip, token); //判断ip和token是否为空
      jQuery.ajax({ //提交数据
        type: "POST",
        url: "../../Controller/User/login.php",
        data: {
          token: token,
          username: username,
          password: hex_md5(password),
          ip: ip,
          longitude: 0, //"longitude",
          latitude: 0 //"latitude"
        },
        dataType: 'html',
        timeout: 300,
        // TODO: 该页面悬浮于主页上方，返回html代码，修改登录样式
        success: function(data) {
          token = null;
          alert(data);
        },
        error: function(xhr, status, error) {
          alert("登录失败！");
        }
      });
    }

    /**
     * [regist 用户注册]
     * @method      regist
     * @return      [type]                  [description]
     * @version     [1.1]
     * @author 闻国庆
     * @Proofreader liyusky
     * @datetime    2017-01-16T18:00:32+080
     */
    function regist() {
      var username = jQuery('regist-username').val(); //获取用户名
      var password = jQuery('regist-password').val(); //获取密码
      var email    = jQuery('regist-email').val();
      if (!username) { //判断用户名是否为空
        alert("用户名不允许为空！");
        return false;
      }
      if (!password) { //判断密码是否为空
        alert("密码不允许为空！");
        return false;
      }
      if (!email) { //判断邮箱是否为空
        alert("邮箱不允许为空！");
        return false;
      }
      if (!isUsername(username)) {
        alert("用户名不正确！");
        return false;
      }
      if (!isPassword(password)) {
        alert("密码不正确！");
        return false;
      }
      if (!isEmail(email)) {
        alert("邮箱地址不正确！");
        return false;
      }
      var token = getToken(); //获取令牌
      emptySafeMsg(ip, token); //判断ip和token是否为空
      jQuery.ajax({ //提交数据
        type: "POST",
        url: "../../Controller/User/register.php",
        data: {
          token: token,
          username: username,
          password: password,
          email: email,
          ip: ip,
          longitude: 0, //"longitude",
          latitude: 0 //"latitude"
        },
        dataType: 'html',
        timeout: 300,
        success: function(data) {
          token = null;
          alert(data);
        },
        error: function(xhr, status, error) {
          console.log(xhr); 
          console.log(status);
          console.log(error);
        }
      });
    }

    /**
     * [showOtherLogin 隐藏或开启社交媒体登录选项框]
     * @method   showOtherLogin
     * @version  [1.0]
     * @author uponstars
     * @datetime 2017-01-01T15:39:28+080
     */
    function showOtherLogin() {
      var hideDom = jQuery("#hide");
      if (hideDom.attr('class') == "overflow-hidden none row") {
        hideDom.attr("class", "overflow-hidden inline-block");
        hideDom.animate({
          width: '150px'
        }, "slow");
      }
      else {
        hideDom.animate({
          width: '0'
        }, "slow");
        hideDom.attr("class", "overflow-hidden none row");
      }
    }

    /**
     * [typeSwitch 点击登录、注册两按钮时颜色切换]
     * @method   typeSwitch
     * @version  [1.0]
     * @author uponstars
     * @datetime 2017-01-01T15:40:49+080
     */
    (function typeSwitch() {
      var loginDom = jQuery("#switch-login");
      var registDom = jQuery("#switch-regist");
      loginDom.click(function() { //点击登录按钮后所执行
        $(this).attr({
          "data-switch": "1",
          "style": "color:#0f88eb;"
        });
        registDom.attr({
          "data-switch": "0",
          "style": "color:#9bd0d0;"
        });
      });
      registDom.click(function() { //点击注册按钮后所执行
        jQuery(this).attr({
          "data-switch": "1",
          "style": "color:#0f88eb;"
        });
        loginDom.attr({
          "data-switch": "0",
          "style": "color:#9bd0d0;"
        });
      });
    })();

    /**
     * [getToken 获取令牌]
     * @method   getToken
     * @return   [string]                  [返回md5加密的令牌]
     * @version  [1.0]
     * @author 闻国庆
     * @datetime 2017-01-01T14:12:09+080
     */
    function getToken() {
      var token;
      jQuery.ajaxSetup({ //设置同步
        async: false
      });
      jQuery.post( //post 获取数据
        "../../Controller/Safe/token.php", //url
        function(data, status, xhr) { //获得令牌
          if (status == "success") {
            token = data;
          } else {
            alert("server error!");
            return false;
          }
        },
        "text"
      );
      token = hex_md5(token); //md加密令牌
      return token;
    }

    /**
     * [isPassword 检查用户名是否符合格式]
     * @method   isPassword
     * @param    [type]                  password [从用户名输入框获得的值]
     * @return   boolean                          [true(符合) / false(不符合)]
     * @version  [1.0]
     * @author uponstars
     * @datetime 2017-01-01T15:50:07+080
     */
    function isUsername(username) {
      var reg = /(^[a-zA-Z])([a-zA-Z0-9]{5,11})/; // 开头所有字母，中间字母数字
      return reg.test(username);
    }

    /**
     * [isPassword 检查密码是否符合格式]
     * @method   isPassword
     * @param    [type]                  password [从密码输入框获得的值]
     * @return   boolean                          [true(符合) / false(不符合)]
     * @version  [1.0]
     * @author uponstars
     * @datetime 2017-01-01T15:50:07+080
     */
    function isPassword(password) {
      var reg = /[a-zA-Z0-9]{6,12}/; // 数字字母
      return reg.test(password);
    }

    /**
     * [isPassword 检查email地址是否正确]
     * @method   isPassword
     * @param    [type]                  password [从email输入框获得的值]
     * @return   boolean                          [true(符合) / false(不符合)]
     * @version  [1.0]
     * @author uponstars
     * @datetime 2017-01-01T15:50:07+080
     */
    function isEmail(email) {
      var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
      return reg.test(email);
    }

    /**
     * [emptySafeMsg 判断ip和token是否为空]
     * @method   emptySafeMsg
     * @param    [string]                  ip    [ip]
     * @param    [string]                  token [token]
     * @return   boolean                       [false]
     * @version  [1.0]
     * @author liyusky
     * @datetime 2017-01-01T14:48:35+080
     */
    function emptySafeMsg(ip, token) {
      if (!ip || !token) {
        alert("server error");
        return false;
      }
    }

  </script>
</body>

</html>
