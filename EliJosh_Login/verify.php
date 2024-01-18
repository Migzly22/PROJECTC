<?php
    require("../Database.php");
    session_start();
    ob_start();
    error_reporting(E_ERROR | E_PARSE);
    $id = $_GET['id'];

    $sqlcode = "UPDATE userscredentials SET Verified = 'TRUE' WHERE Email = '$id';";
    mysqli_query($conn,$sqlcode);

?>
<!DOCTYPE html>
<!---Coding By CoderGirl | www.codinglabweb.com--->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login | EliJosh Resort and Events Place</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!---Custom CSS File--->
  <link rel="stylesheet" href="css/style.css">

  
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	
  <link rel="icon" type="image/x-icon" href="../EliJosh_Dashboard/img/title_logo.ico">
</head>
<body>

  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <div class="logo">
        <img src="css/image/title_logo.png" alt="">
      </div>
      <header>Successful</header>
      <form action="" method="post">
        <small><strong>Email verified successfully!</strong> You're all set to enjoy our services. 🎉 </small>
        <small><a href="./index.php">Click here to redirect to login. </a></small> 

      </form>

    </div>
  </div>

</body>
</html>
