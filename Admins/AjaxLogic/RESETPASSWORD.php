<?php
    require ('../Database.php');

    $array1 = array("text"=>"Reset Successfully","icon"=>"success");

    $email = $_POST['Email'];
    $pass = $_POST['pass'];
    $OTP = $_POST['OTP'];

    if( $_COOKIE['OTP'] != $OTP){
        $array1["text"] = "Wrong OTP";
        $array1["icon"] = "error";
    }else{
        $sqlcode = "UPDATE `userscredentials` SET `Password` = '$pass' WHERE Email = '$email';";
        mysqli_query($conn,$sqlcode);

    }

    echo json_encode($array1);
?>