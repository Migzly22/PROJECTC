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
  $mail->SMTPDebug  = 0;  
  $mail->CharSet='UTF-8';
  //$mail->Host       = "smtp.mail.yahoo.com";
  $mail->Username   = "noncre123@gmail.com";
  $mail->Password   = "cajbokiljmnuzgow";
  $mail->SetFrom("elijosh111923@gmail.com",'ElijoshResort');
  $mail->SMTPOptions = array(
  'ssl' => [
  'verify_peer' => false,
  'verify_depth' => false,
  'allow_self_signed' => false,
  'verify_peer_name' => false,
  ]
  );
  $mail ->Subject = "Payment Confirmation and Documents";
  $mail ->AddAddress($to,'');
  $mail ->Body = $html;
  
  //$mail ->send();
  $sent = $mail->send();


}






//sending($_POST['to'],$_POST['subject'],$_POST['message']);
$array1 = array("text"=>"Sent Successfully","icon"=>"success");
$email = $_POST['email'];
$reservationvalue = $_POST['reservationvalue'];
$pid = $_POST['pid']; 
$ids = $_POST['ids'];
  
  $html = file_get_contents("./Client/Template/Confirmation.html");
  $needtochange = [
      "{{CODE}}",
      "{{WEBSITE}}"
  ];
  $valuetochange = [
      $pid,
      "https://elijoshresortandeventsplace.com/Admins/Composer/paypal2.php?id=$reservationvalue&uid=$ids"
  ];

  $html = str_replace($needtochange, $valuetochange, $html);
  sending($email,$html);



echo json_encode($array1);

?>