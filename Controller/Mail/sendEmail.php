<?php
namespace Controller\Mail;

include 'class.phpmailer.php';
include 'class.smtp.php';

$mail = new PHPMailer();

$mail->isSMTP();// 使用SMTP服务
$mail->CharSet    = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
$mail->Host       = "smtp.qq.com";// 发送方的SMTP服务器地址
$mail->SMTPAuth   = true;// 是否使用身份验证
$mail->Username   = "1746572317@qq.com";// 发送方的邮箱用户名
$mail->Password   = "ylpgmdjgufgvfbab";// 发送方的邮箱密码，注意用客户端授权密码
$mail->SMTPSecure = "ssl";// 使用ssl协议方式
$mail->Port       = 465;// qq邮箱的ssl协议方式端口号是465/587

$mail->setFrom("1746572317@qq.com", "闻");// 设置发件人信息，如邮件格式说明中的发件人，Mailer是当做名字显示
$mail->addReplyTo("1746572317@qq.com", "Reply");// 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
// $mail->addCC("aaaa@qq.com");// 设置邮件抄送人，可以只写地址，上述的设置也可以只写地址
// $mail->addBCC("bbbb@qq.com");// 设置秘密抄送人
// $mail->addAttachment("bug0.jpg");// 添加附件

/**
 * [sendEmail 发送邮件给客户]
 * @method   sendEmail
 * @param    [string]                  $toAddress [客户邮箱地址]
 * @param    [string]                  $recipient [收件人]
 * @param    [string]                  $title     [邮件标题]
 * @param    [string]                  $message   [邮件内容]
 * @return   [string]                             [是否发送成功]
 * @version  [1.0]
 * @author uponstars
 * @datetime 2017-01-04T09:37:51+080
 */
$sendEmail = function ($ToAddress, $Recipient, $Title, $Message) use ($mail)
{
    $mail->addAddress($ToAddress, $Recipient);// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@qq.com)
    $mail->Subject = $Title;// 邮件标题
    $mail->Body    = $Message;// 邮件正文
    //$mail->AltBody = "This is the plain text纯文本";// 这个是设置纯文本方式显示的正文内容，如果不支持Html方式，就会用到这个，基本无用

    if(!$mail->send()){// 发送邮件
        echo "Mailer Error: ".$mail->ErrorInfo;// 输出错误信息
        return false;
    }
    else{
        return true;
    }
};
