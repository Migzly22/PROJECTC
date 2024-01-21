<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require('./Database.php');

session_start();
ob_start();




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
  $mail ->Subject = "Message from $to";
  $mail ->AddAddress("elijosh111923@gmail.com",'');
  $mail ->Body = $html;
  
  $mail->send();
}

//sending($_POST['to'],$_POST['subject'],$_POST['message']);
$array1 = array("text"=>"Sent Successfully","icon"=>"success");

$data1 = $_POST['data1'];//subject
$data2 = $_POST['data2'];//message
$data3 = $_POST['data3'];//name
$data4 = $_POST['data4'];//email

if($_POST["data1"] === "" && $_POST["data2"] === ""){
  $data3 = $_SESSION["BasicContactinfo"]["NAME"];
  $data4 = $_SESSION["BasicContactinfo"]["Email"];
}

  $html = file_get_contents("./Client/Template/contactus.html");
  $needtochange = [
      "{{SENDERNAME}}",
      "{{SENDERSUBJECT}}",
      "{{SENDEREMAIL}}",
      "{{SENDERMSG}}",
  ];
  $valuetochange = [
      $data1,
      $data3,
      $data2,
      $data4,
  ];

$html = str_replace($needtochange, $valuetochange, $html);
sending($data2,$html);


echo json_encode($array1);

?>