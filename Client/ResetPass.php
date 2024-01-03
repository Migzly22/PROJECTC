<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <link rel="stylesheet" href="./CSS/Resetpass12.css">

    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <section>
        <form class="form form-1" method="post">
            <header>
              <h1 class="text-center">Reset Password</h1>
            </header>
            <div class="form-group">
              <input type="text" id="email" required>
              <label for="email">Email address</label>
            </div>
            <button type="submit" id="EmailSendbtn">Send</button>

        </form>
        <form class="form form-2" method="post">
            <header>
              <h1 class="text-center">Reset Password</h1>
            </header>
            <div class="form-group">
                <input type="text" id="OTP" required>
                <label for="OTP">OTP</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" required>
                <label for="password">New Password</label>
            </div>
            <div class="form-group">
                <input type="password" id="cpassword" required>
                <label for="cpassword">Confirm Password</label>
            </div>
            <button type="submit" id="Resetpassbtn">Send</button>

        </form>

    </section>
    
</body>


</html>