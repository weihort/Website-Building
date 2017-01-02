<?php
require 'PHPMailerAutoload.php';// 加载这1个文件和加载下面2个文件的作用是等同的
//require_once 'class.phpmailer.php';
//require_once 'class.smtp.php';

$mail = new PHPMailer();

$mail->isSMTP();// 使用SMTP服务
$mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
$mail->Host = "smtp.qq.com";// 发送方的SMTP服务器地址
$mail->SMTPAuth = true;// 是否使用身份验证
$mail->Username = "452082031@qq.com";// 发送方的邮箱用户名
$mail->Password = "iaclranrvgwfbgfd";// 发送方的邮箱密码，注意用客户端授权密码
$mail->SMTPSecure = "ssl";// 使用ssl协议方式
$mail->Port = 465;// qq邮箱的ssl协议方式端口号是465/587

$mail->setFrom("452082031@qq.com","Mailer");// 设置发件人信息，如邮件格式说明中的发件人，Mailer是当做名字显示
$mail->addAddress("1746572317@qq.com",'Liang');// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@qq.com)
$mail->addReplyTo("452082031@qq.com","Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
// $mail->addCC("aaaa@qq.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址
// $mail->addBCC("bbbb@qq.com");// 设置秘密抄送人
// $mail->addAttachment("bug0.jpg");// 添加附件


$mail->Subject = "This is a test mailxx";// 邮件标题
$mail->Body = "
    http://www.liyusky.com
";// 邮件正文
//$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

if(!$mail->send()){// 发送邮件
    echo "Message could not be sent.";
    echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
}else{
    echo 'Message has been sent.';
}
