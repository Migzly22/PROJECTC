<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];


switch ($_POST["Process"]) {
    case 'Deletion':
        $folderPath = '../../RoomsEtcImg/Sliders';
        $imageToDelete = $sqlcode; // Replace with the actual image file name you want to delete

        $filePath = $folderPath . '/' . $imageToDelete;

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            // Attempt to delete the file
            if (unlink($filePath)) {
                echo "";
            } else {
                echo "Error deleting file '$imageToDelete'.";
            }
        } else {
            echo "File '$imageToDelete' does not exist.";
        }
        break;
    case 'Add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $uploadDir = '../../RoomsEtcImg/Sliders/';
            $uniqueName = time().'_' . $_FILES['image']['name'];
            $uploadFile = $uploadDir . $uniqueName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                echo '';
            }
        } else {
            echo '';
        }

        break;
    default:
        break;
}

$folderPath = '../../RoomsEtcImg/Sliders';

// Get the list of all files in the folder
$files = scandir($folderPath);

// Filter out only image files (you can customize the list of allowed extensions)
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$imageFiles = array_filter($files, function ($file) use ($allowedExtensions) {
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    return in_array(strtolower($extension), $allowedExtensions);
});

$data = "";
// Generate HTML markup for each image
foreach ($imageFiles as $imageFile) {
    $imagePath = "../RoomsEtcImg/Sliders/" . $imageFile;

    $data .= "<li class='Listopener'>
    <div class='boxxy02'>
        <img src='$imagePath' alt=''>
    </div>
    <div class='buttonholder02'>
        <button class='bex EditBTN' onclick='DELETEBTN(`$imageFile`)'><i class='fa-solid fa-trash'></i></button>
    </div>
</li>";
}
echo $data;
