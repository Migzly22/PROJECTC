<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

function generateMD5($text) {
    return md5($text);
}
if(isset($_POST["other"])){
    switch ($_POST["other"]) {
        case 'ENCRYPTION':
            $md5Hash = generateMD5($sqlcode);
            echo $md5Hash;
            break;
        case 'VALIDATION':
            $validationsql = "SELECT * FROM userscredentials WHERE Email = '$sqlcode';";
            $queryrun = mysqli_query($conn, $validationsql);
            if(mysqli_num_rows($queryrun) > 0){
                echo "NOT";
            }else{
                echo "VALID";
            }
            break;
    }
}else{
    mysqli_query($conn, $sqlcode);//INPUT NEW DATA
}



//echo $sqlcode;