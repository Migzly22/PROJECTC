<?php
    require("./Database.php");
    //error_reporting(E_ERROR | E_PARSE);
    session_start();
    ob_start();

    date_default_timezone_set('Asia/Shanghai');

    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        header("Location: ../Client/login.php");
        ob_end_flush();
        exit;
    }

    $targetlinks= isset($_GET["nzlz"]) ? $_GET["nzlz"] :"dashboard" ;
    $num =  isset($_GET["plk"]) ? $_GET["plk"] :"1" ;


    $sqlcodeUSERDATA = "SELECT CONCAT(LastName,', ', FirstName, ' ', MiddleName ) AS staffname, userID AS StaffID FROM userscredentials WHERE userID = '".$_SESSION['USERID']."';";
    $USERDATA = mysqli_query($conn,$sqlcodeUSERDATA);
    $resultUSERDATA = mysqli_fetch_assoc($USERDATA);
    $_SESSION["STAFFNAME"] = $resultUSERDATA["staffname"];
    $_SESSION["STAFFID"] = $resultUSERDATA["StaffID"];



    include "./Admin.php";

?>