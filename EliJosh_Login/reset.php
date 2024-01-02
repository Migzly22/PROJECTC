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


  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <div class="logo">
        <img src="css/image/title_logo.png" alt="">
      </div>
      <header>Password Reset</header>
      <form action="#" method="post">
        <input type="text" placeholder="Enter your email" id="email" required name="email" required>
        <input type="submit" name="Loginbtn" id="EmailSendbtn" class="button" value="Send OTP">
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

  <script>
      EmailSendbtn.addEventListener('click',async (e)=>{
          e.preventDefault()
          const email = document.getElementById('email').value

          /*
          if (!(isEmailFormat(email))) {
              Swal.fire({
                  icon: 'error',
                  text: 'Please check the email format'
              })
              return 0
          } 
          */


          // Insert the loading screen
          const loadingContainer = document.createElement('div');
          loadingContainer.id = 'loading-container';
          document.body.appendChild(loadingContainer);  

          // Fetch the content of loading.html
          const response = await fetch('../Client/Template/LoadingTemplate.html');
          const loadingHtml = await response.text();

          $.ajax({    
              type: "post",
              url: "../Send.php",             
              data: "Email="+ email,    
              dataType: 'json',   
              beforeSend:function(){
                  // Set the content of the loading container
                  loadingContainer.innerHTML = loadingHtml;
              },  
              error:function(response){
                  // Remove the loading screen
                  loadingContainer.parentNode.removeChild(loadingContainer);
              },
              success: async function(response) {
                  // Remove the loading screen
                  console.log(123)
                  loadingContainer.parentNode.removeChild(loadingContainer);

                    await Swal.fire({
                        icon: response.icon,
                        text: response.text,
                    })
                    location.href = "./resettingOTP.php";
     
              }


          });

      })
  </script>
</body>
</html>
