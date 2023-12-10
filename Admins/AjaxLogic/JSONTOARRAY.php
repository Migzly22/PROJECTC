<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = json_decode($_POST["sqlcode"], true);
$_SESSION["Walkinuser"] = $sqlcode;


