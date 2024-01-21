<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require('./Database.php');


function sending($to,$html){
  $mail = new PHPMailer();
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "tls"; //ssl
  $mail->Host       = "smtp.gmail.com";
  $mail->Port       = 587;
  $mail->IsHTML(true);
  $mail->IsSMTP();
  $mail->SMTPDebug  = 2;  
  $mail->CharSet='UTF-8';
  //$mail->Host       = "smtp.mail.yahoo.com";
  $mail->Username   = "noncre123@gmail.com";
  $mail->Password   = "cajbokiljmnuzgow";
  $mail->SetFrom("elijosh111923@gmail.com",'ElijoshResort&EventPlace');
  $mail->SMTPOptions = array(
  'ssl' => [
  'verify_peer' => false,
  'verify_depth' => false,
  'allow_self_signed' => false,
  'verify_peer_name' => false,
  ]
  );
  $mail ->Subject = "Email Verification";
  $mail ->AddAddress($to,'');
  $mail ->Body = $html;
  
  //$mail ->send();
  $sent = $mail->send();


}






//sending($_POST['to'],$_POST['subject'],$_POST['message']);
$array1 = array("text"=>"Sent Successfully","icon"=>"success");
$email = $_POST['email'];
  
  $html = file_get_contents("./Client/Template/Email.html");
  $needtochange = [
      "{{WEBSITE}}"
  ];
  $valuetochange = [
      "https://elijoshresortandeventsplace.com/EliJosh_Login/verify.php?id=$email"
  ];

$html = str_replace($needtochange, $valuetochange, $html);
sending($email,$html);



echo "https://elijoshresortandeventsplace.com/EliJosh_Login/verify.php?id=$email";

?>