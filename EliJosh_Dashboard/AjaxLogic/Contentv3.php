<?php

require("../../Database.php");
session_start();
ob_start();

print_r($_FILES['video']);
$uploadDir = '../../RoomsEtcImg/Videos/'; // Change the directory to your video directory
$uniqueName = time() . '_' . $_FILES['video']['name'];
$uploadFile = $uploadDir . 'feature.mp4';


if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadFile)) {
    echo "";

    $videoDirectory = "../RoomsEtcImg/Videos/feature.mp4";


    echo "<li class='Listopener'>
    <video id='myVideo' class='imagebgv2' controls>
        <source src='$videoDirectory' type='video/mp4'>
        
    </video>
<div class='buttonholder02'>
    <button class='bex EditBTN' onclick='ADDROOM()'><i class='fa-solid fa-pen'></i></button>
</div>
</li>";
} else {
    echo "Error uploading file.";
}
