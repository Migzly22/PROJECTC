<?php

error_reporting(0);
$localhost = "localhost";
$username = "u970357751_elijosh_db";
$pass = "sDau1HE3M[";
$dbname = "u970357751_elijoshresort";
//error_reporting(0);


//error_reporting(E_ERROR | E_PARSE);
/*
$localhost = "localhost";
$username = "root";
$pass = "";
$dbname = "elijosh2";//elijoshresort
*/


$conn = mysqli_connect($localhost,$username,$pass,$dbname);
$pdo = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $pass);
// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
