<?php
require("../../Database.php");
session_start();
ob_start();



// Retrieve form data from $_POST
$roomName = $_POST['swal-input1'];
$dayPrice = $_POST['swal-input2'];
$nightPrice = $_POST['swal-input3'];
$h22price = $_POST['swal-input4'];
$maxNumber = $_POST['swal-input5'];
$description = $_POST['swal-input6'];
$amenities = $_POST['swal-input7'];
$hidid = $_POST['hidid'];


$imageFile = $_FILES['swal-input8'];
$targetDirectory = '../../RoomsEtcImg/Rooms/';
// Create the target directory if it doesn't exist
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}
// Set the desired file name
$newFileName = $roomName;

// Append the file extension from the original file name
$extension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
$targetFile = $targetDirectory . $newFileName . '.' . $extension;

if (move_uploaded_file($imageFile['tmp_name'], $targetFile)) {

    if($hidid != ""){
        $sqlcode = "UPDATE `rooms` SET `RoomType` = '$roomName', `DayTimePrice` = '$dayPrice', `NightTimePrice` = '$nightPrice', `Hours22` = '$h22price',
        `MinPeople` = '0', `MaxPeople` = '$maxNumber', `imgpath`= '".basename($targetFile)."',`Description` = '{\"AMENITIES\": \"$amenities\", \"DESCRIPTION\": \"$description\"}' WHERE `rooms`.`RoomID` = '$hidid';";    
    }else{
        $sqlcode = "INSERT INTO rooms values (NULL,'$roomName','$dayPrice', '$nightPrice', '$h22price','0', '$maxNumber','".basename($targetFile)."', '{\"AMENITIES\": \"$amenities\", \"DESCRIPTION\": \"$description\"}')";
    }
    echo $sqlcode;
    mysqli_query($conn,$sqlcode);

    header("Location: ../index.php?nzlz=facilities");
    ob_end_flush();
} else {
    // File upload failed
    echo "Error uploading file.";
}
