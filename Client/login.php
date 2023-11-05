<?php
    require("../Database.php");
    session_start();
    ob_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="./CSS/Login1.css">

    <script src="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!--Jquery-->
    <script src="../Jquery/node_modules/jquery/dist/jquery.js"></script>
    <script src="../Jquery/node_modules/jquery/dist/jquery.min.js"></script>

  

    <script src="./JS/script1.js"></script>

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

            if($row["Access"] == 'CLIENT'){
              header("Location: ./index.php");
              ob_end_flush();
              exit; // Ensure no further code is executed after the header  
            }else if($row["Access"] == 'STAFF' || $row["Access"] == 'ADMIN'){
              header("Location: ../Admins/Mainpage.php");
              ob_end_flush();
              exit; // Ensure no further code is executed after the header  
            }

        }else{
            echo "<script>Swal.fire(
              '',
              'Wrong credentials.. Please try again',
              'error'
            )</script>";
        }
      }

?>

    <section class="specials123">
        <form class="form" method="post">
            <header>
              <h1 class="text-center">Login</h1>
            </header>
            <div class="form-group">
              <input type="text" name="email"   id ="email" required>
              <label for="email">Email address</label>
            </div>
            <div class="form-group">
              <input type="password" name="password"  id="password" required>
              <label for="password">Password</label>
            </div>
            <p><a class="link" href="./ResetPass.php">Forgot password?</a></p>
            <button type="submit" name="Loginbtn" id="Loginbtn">Continue</button>
            <p class="text-center" style="display: none;">Don't have an account? 
              <a class="link" href="./Registration.php">Sign up</a>    
            </p>
        </form>
    </section>


    </div>

      
</body>
</html>