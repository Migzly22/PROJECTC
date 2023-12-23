<?php
header('Content-Type: text/html; charset=utf-8');

require("../../Database.php");
session_start();
ob_start();


$sqlcode = $_POST["sqlcode"];


function PRINTING($conn,  $sqlcode){
    $queryrun1 = mysqli_query($conn,$sqlcode);
    $data1 = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        # code...
        $statuscolor = $result['Access'] == "STAFF" ? "completed" :"pending";
        $data1 .= "
        <tr>
            <td>
                <p>".$result["fullname"]."</p>
            </td>
            <td>".$result["Email"]."</td>
            <td><span class='status $statuscolor'>".$result['Access']."</span></td>
            <td class='TableBtns'>
                <div class='EditBTN' onclick='EDIT(this, `".$result['userID']."`)'>
                    <i class='bx bx-edit-alt' ></i>
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
            <td></td>
        </tr>";
    }
    echo $data1;
}

$default = "SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE userID <> '".$_SESSION["USERID"]."' ORDER BY Lastname, Firstname, Middlename;";
switch ($_POST["Process"]) {
    case 'Search':
        $data = isset ($_POST["data"]) ? $_POST["data"]: "";
        $newString = str_replace("{item}", $data, $sqlcode);
        PRINTING($conn, $newString);
        break;
    case 'Reset':
        PRINTING($conn,$default);
        break;
    case 'DeleteUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn,$default);
        break;   
    case 'AccessUpdate':
        mysqli_query($conn,$sqlcode);
        PRINTING($conn,$default);
        break;             
    default:
        # code...
        break;
}