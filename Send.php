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
  $mail ->Subject = "Password Reset";
  $mail ->AddAddress($to,'');
  $mail ->Body = $html;
  
  $mail ->send();

}

//sending($_POST['to'],$_POST['subject'],$_POST['message']);
$array1 = array("text"=>"Sent Successfully","icon"=>"success");
$email = $_POST['Email'];
$randomnum = rand(1000000, 9999999);


$sqlcode =  "SELECT * FROM userscredentials WHERE Email = '$email';";
$queryrun = mysqli_query($conn, $sqlcode);

if(mysqli_num_rows($queryrun) == null){
  $array1["text"] = "Email Doesnt Exist";
  $array1["icon"] = "error";
}else{

  $otp = $randomnum;
  // Set the duration for the cookie (10 minutes = 600 seconds)
  $duration = 600;

  // Calculate the expiration time by adding the duration to the current time
  $expirationTime = time() + $duration;

  // Set the cookie with the name "OTP", the value of the OTP, and the expiration time
  setcookie('OTP', $otp, $expirationTime);
  setcookie('EMAIL', $email, $expirationTime);


  

  $html = file_get_contents("./Client/Template/OTPTemplate.html");
  $needtochange = [
      "{{ACCOUNT}}",
      "{{CODE}}"
  ];
  $valuetochange = [
      $email,
      $otp
  ];

  $html = str_replace($needtochange, $valuetochange, $html);
  sending($email,$html);
}


echo json_encode($array1);

?>