<?php
    require("../Database.php");
    session_start();
    ob_start();
    //error_reporting(E_ERROR | E_PARSE);

?>
<!DOCTYPE html>
<!---Coding By CoderGirl | www.codinglabweb.com--->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reset | EliJosh Resort and Events Place</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!---Custom CSS File--->
  <link rel="stylesheet" href="css/style.css">

  
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	
  <link rel="icon" type="image/x-icon" href="../EliJosh_Dashboard/img/title_logo.ico">

</head>
<body>
  <?php
    function generateMD5($text) {
        return md5($text);
    }
    if(isset($_POST['Loginbtn'])){
      $cpass = $_POST['cpass'];
      $pass = $_POST['pass'];
      $OTP = $_POST['OTP'];
      if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/', $pass) && $pass == $cpass) {
        if( $_COOKIE['OTP'] != $OTP){
          echo "<script>
          Swal.fire({
            icon: 'error',
            text: 'Wrong OTP',
          })
          </script>";
        }else{
            $passwords = generateMD5($pass);
            $sqlcode = "UPDATE `userscredentials` SET `Password` = '$passwords' WHERE Email = '".$_COOKIE['EMAIL']."';";
            mysqli_query($conn,$sqlcode);
            echo "<script>
            Swal.fire({
              icon: 'success',
              text: 'Updated Successfully',
            })
            </script>";
        }
      } else {
          echo "<script>
          Swal.fire({
            icon: 'error',
            text: 'Password is too weak',
          })
          </script>";
      }

    }

  ?>

  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <div class="logo">
        <img src="css/image/title_logo.png" alt="">
      </div>
      <header>Password Reset</header>
      <form action="#" method="post">
        <input type="text" placeholder="Enter OTP" id="email" required name="OTP" required>
        <input type="password" placeholder="Enter Password" id="email" required name="pass" required>
        <input type="password" placeholder="Confirm Password" id="email" required name="cpass" required>
        <input type="submit" name="Loginbtn" id="Resetpassbtn" class="button" value="Change Password">
      </form>



      <div class="signup">
        <span class="signup">Already have an account?
          <?php
            $specialcase = isset(explode('?', $_SERVER['REQUEST_URI'])[1]) ?   "?".explode('?', $_SERVER['REQUEST_URI'])[1] : "";
            echo "<a class='link' href='../EliJosh_Login/index.php$specialcase'>Sign in</a>  ";
          ?>   
        </span>
      </div>
    </div>
  </div>


</body>
</html>
