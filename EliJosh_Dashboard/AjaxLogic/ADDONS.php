<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];


switch ($_POST["Process"]) {
    case 'COTTAGE':
        # code...
        break;
    case 'ROOM':
        # code...
        break;
    
}