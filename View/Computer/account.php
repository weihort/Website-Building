<?php

namespace View\Computer;

session_start();
$_SESSION['ip111'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['ROOT_DIRECTORY'] = dirname(dirname(dirname(__FILE__)));          //设置根目录常量

 ?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>鲤鱼旗</title>
  <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./fonts/iconfont.css">
  <link rel="stylesheet" type="text/css" href="./css/general.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 text-center">
        <img class="row margin-top-lg" src="./images/logo.svg" alt="">
        <h4>相同的兴趣，创造不同的快乐！</h4>
        <div class="nav nav-pills margin-vertical-extension text-center">
          <a class="btn btn-link btn-control active" id="switch-in" data-switch="1" data-toggle="tab" href="#signup" style="color:#0f88eb;">登录</a>
          <a class="btn btn-link btn-control" id="switch-up" data-switch="0" data-toggle="tab" href="#signin" style="color:#9bd0d0;">注册</a>
        </div>
        <ul class="tab-content margin-vertical-extension list-unstyled">
          <li class="tab-pane fade in active" id="signup">
            <input class="form-control margin-vertical-extension" id="login-username" type="text" placeholder="用户名">
            <input class="form-control margin-vertical-extension" id="login-password" type="password" placeholder="密码">
            <a class="btn btn-primary form-control margin-vertical-extension" onclick="javascript:login();">登录</a>
            <p class="text-left">
              <a href="#">手机验证码登录</a>
              <a class="pull-right" href="#" target="_blank">无法登录？</a>
            </p>
            <div class="row">
              <div class="col-md-4">
                <a class="pull-left" href="javascript:void(0);" onclick="javascript:showOtherLogin();" style="line-height:31px;">社交账号登录</a>
              </div>
              <div class="col-md-4">
                <div class="overflow-hidden none row" id="hide" style="height:25px;width:0;">
                  <a class="iconfont icon-weixin icon col-md-4" href="#" target="_blank"></a>
                  <a class="iconfont icon-weibo icon col-md-4" href="#" target="_blank"></a>
                  <a class="iconfont icon-qq icon col-md-4" href="#" target="_blank"></a>
                </div>
              </div>
            </div>
          </li>
          <li class="tab-pane fade" id="signin">
            <input class="form-control margin-vertical-extension" id="regist-username" type="text" placeholder="用户名">
            <input class="form-control margin-vertical-extension" id="email" type="email" placeholder="邮箱">
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
    <footer class="footer">
      <p class="text-center fixed-bottom">
        <span>&copy; 2016 鲤鱼旗</span>
        <span class="dot">·</span>
        <a href="#" target="_blank">发现</a>
        <span class="dot">·</span>
        <a target="_blank" href="#">联系我们</a>
        <br>
        <a href="#" target="_blank">京 ICP 证 110745 号</a>
        <span class="dot">·</span>
        <span>京公网安备 11010802010035 号</span>
      </p>
    </footer>
  </div>
  <script src="./javascript/jquery.min.js"></script>
  <script src="./javascript/bootstrap.js"></script>
  <script type="text/javascript" src="./javascript/md5-min.js"></script>
  <script>
    var ip = "<?php echo $_SESSION['ip']; ?>";
    typeSwitch();       //切换登陆，注册按钮

    /**
     * [login 登陆]
     * @method   login
     * @version  [1.0]
     * @author 闻国庆
     * @datetime 2017-01-01T14:07:56+080
     */
    function login() {
        var username = document.getElementById('login-username').value;       //获取用户名
        var password = document.getElementById('login-password').value;       //获取密码
        if (!username) {                                                      //判断用户名是否为空
            alert("用户名不允许为空！");
            return false;
        }
        if (!password) {                                                      //判断密码是否为空
            alert("密码不允许为空！");
            return false;
        }
        if (!isUsername(username)) {                                          //判断用户名是否符合格式
            alert("用户名不正确！")
            return false;
        }
        if (!isPassword(password)) {                                          //判断密码是否符合格式
            alert("密码不正确！")
            return false;
        }
        var token = getToken();                                               //获取令牌
        emptySafeMsg(ip, token);                                              //判断ip和token是否为空
        jQuery.ajax({                                                         //提交数据
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
     * [regist 注册]
     * @method   regist
     * @version  [1.0]
     * @author 闻国庆
     * @datetime 2017-01-01T15:35:10+080
     */
    function regist() {
        var username = document.getElementById('regist-username').value;      //获取用户名
        var password = document.getElementById('regist-password').value;      //获取密码
        var email    = document.getElementById('email').value;
        if (!username) {                                                      //判断用户名是否为空
            alert("用户名不允许为空！");
            return false;
        }
        if (!password) {                                                      //判断密码是否为空
            alert("密码不允许为空！");
            return false;
        }
        if (!email) {                                                        //判断邮箱是否为空
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
        var token = getToken();                                              //获取令牌
        emptySafeMsg(ip, token);                                            //判断ip和token是否为空
        jQuery.ajax({                                                       //提交数据
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
        var hideDom = $("#hide");
        if (hideDom.attr('class') == "overflow-hidden none row") {
            hideDom.attr("class", "overflow-hidden inline-block");
            hideDom.animate({width: '150px'}, "slow");
        }
        else {
            hideDom.animate({width: '0'}, "slow");
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
    function typeSwitch() {
        var inDom = $("#switch-in");
        var upDom = $("#switch-up");
        inDom.click(function() {            //点击登录按钮后所执行
            $(this).attr({
                "data-switch": "1",
                 "style": "color:#0f88eb;"
            });
            upDom.attr({
                "data-switch": "0",
                "style": "color:#9bd0d0;"
            });
        });
        upDom.click(function() {            //点击注册按钮后所执行
            $(this).attr({
                "data-switch": "1",
                "style": "color:#0f88eb;"
            });
            inDom.attr({
                "data-switch": "0",
                "style": "color:#9bd0d0;"
            });
        });
    }

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
        jQuery.ajaxSetup({            //设置同步
            async: false
        });
        jQuery.post(                 //post 获取数据
            "../../Controller/Safe/token.php",          //url
            function(data, status, xhr) {               //获得令牌
                if (status == "success") {
                    token = data;
                }
                else {
                    alert("server error!");
                    return false;
                }
            },
            "text"
        );
        token = hex_md5(token);                       //md加密令牌
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
    function emptySafeMsg (ip, token) {
        if (!ip || !token) {
            alert("server error");
            return false;
        }
    }
  </script>
</body>

</html>
