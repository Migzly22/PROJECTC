<?php
//error_reporting(0);
$localhost = "localhost";
$username = "root";
$pass = "";
$dbname = "elijoshresort";

$conn = mysqli_connect($localhost,$username,$pass,$dbname);
$pdo = new PDO("mysql:host=localhost;dbname=$dbname", "$username");
// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
