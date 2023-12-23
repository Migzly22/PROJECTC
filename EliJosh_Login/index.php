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
  <title>Login | EliJosh Resort and Events Place</title>
  <link rel="icon" type="image/x-icon" href="/Resort Reservation Design_/image/title_logo.png">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!---Custom CSS File--->
  <link rel="stylesheet" href="css/style.css">

  
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	
</head>
<body>

<?php


if(isset($_POST["Loginbtn"])){

  $stmt = $pdo->prepare("SELECT * FROM userscredentials WHERE Email = :email AND Password = :pass");
  $stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
  $stmt->bindParam(':pass', $_POST["password"], PDO::PARAM_STR);
  $stmt->execute();

 // Fetch a single row from the result set
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
      // The row exists, you can access its data
      $_SESSION["USERID"] = $row["userID"];
      $_SESSION["ACCESS"] = $row["Access"];

      header("Location: ../Client/index.php");
      ob_end_flush();
      exit; // Ensure no further code is executed after the header  


  }else{
      echo "<script>Swal.fire(
        '',
        'Wrong credentials.. Please try again',
        'error'
      )</script>";
  }
}

?>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <div class="logo">
        <img src="css/image/title_logo.png" alt="">
      </div>
      <header>Login</header>
      <form action="" method="post">
        <input type="text" placeholder="Enter your email" required name="email">
        <input type="password" placeholder="Enter your password" required name="password">
        <a href="#">Forgot password?</a>
        <input type="submit" name="Loginbtn" class="button" value="Login">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
        <?php
          $specialcase = isset(explode('?', $_SERVER['REQUEST_URI'])[1]) ? "?".explode('?', $_SERVER['REQUEST_URI'])[1] : "";
          echo "<a class='link' href='../EliJosh_Registration/index.php$specialcase'>Sign up</a>  ";
        ?> 
        </span>
      </div>
    </div>
  </div>
</body>
</html>
