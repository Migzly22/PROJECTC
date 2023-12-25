<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];


function PRINTING($conn,  $sqlcode = "SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE Access = 'STAFF' ORDER BY Lastname, Firstname, Middlename;"){
    $queryrun1 = mysqli_query($conn,$sqlcode);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        $data1 .= "
        <tr>
            <td>
                <p>".$result["fullname"]."</p>
            </td>
            <td>".$result["Email"]."</td>
            <td class='TableBtns'>
                <div class='DeleteBTN' onclick='DELETION(this, `".$result["userID"]."`)'>
                    <i class='bx bx-trash-alt' ></i>
                </div>
            </td>
        </tr>
        ";
    }

    if(mysqli_num_rows($queryrun1) <= 0){
        $data1 .= "
        <tr>
            <td>No Data</td>
            <td></td>
            <td></td>
        </tr>";
    }
    echo $data1;
}

switch ($_POST["Process"]) {
    case 'Search':
        PRINTING($conn, $sqlcode);
        break;
    case 'Reset':
        PRINTING($conn);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn);
        break;   
    case 'AccessUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn);
        break;             
    default:
        # code...
        break;
}