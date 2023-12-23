<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = json_decode($_POST["sqlcode"], true);
$_SESSION["Walkinuser"] = $sqlcode;


if(isset($_POST["Process"])){
    if (isset($_SESSION["Walkinuser"])) {
        // Unset the session variable
        unset($_SESSION["Walkinuser"]);
    }
}