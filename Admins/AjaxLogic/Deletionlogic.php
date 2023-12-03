<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];



switch ($_POST["Process"]) {
    case 'check':
        $rowquery = mysqli_query($conn,$sqlcode);
        if(mysqli_num_rows($rowquery) > 0){
            echo "success";
        }else{
            echo "failed";
        }
        break;
    case 'delete':
        mysqli_query($conn,$sqlcode);
        break;   
}