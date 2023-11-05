<?php
require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];


if (mysqli_query($conn,$sqlcode)) {
    echo "Swal.fire(
        '',
        'Added Successfully',
        'success'
      )";
} else {
    echo "SweetError('Insertion Failed')";
}