<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

mysqli_query($conn, $sqlcode);

//echo $sqlcode;