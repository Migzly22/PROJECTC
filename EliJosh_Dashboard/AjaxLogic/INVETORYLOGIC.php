<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

function PRINTING($conn,$sqlcode7 = "SELECT * FROM extracharges ORDER BY ItemName"){
    $queryrun1 = mysqli_query($conn,$sqlcode7);
    $data = "";
    while ($result = mysqli_fetch_assoc($queryrun1)) {
        # code...
        $data .= "
            <tr>
                <td>".$result["ItemName"]."</td>
                <td>₱ ".number_format($result["Price"], 2)."</td>
                <td>".$result["QuantityAvailable"]."</td>
                <td class='TableBtns'>
                    <div class='EditBTN' onclick='EDITFUNC( `".$result["ExtraID"]."`, `".$result["ItemName"]."`, `".$result["Price"]."`, `".$result["QuantityAvailable"]."`)'>
                        <i class='bx bx-edit-alt' ></i>
                    </div>
                    <div class='DeleteBTN' onclick='DELETION(this, `".$result["ExtraID"]."`)'>
                        <i class='bx bx-trash-alt' ></i>
                    </div>
                </td>
            </tr>
        ";
    }
    if(mysqli_num_rows($queryrun1) <= 0){
        $data  ="
            <tr>
                <td colspan='4'>No Data</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ";
    }

    echo $data;
}





switch ($_POST["Process"]) {
    case 'Search':
        $item = $_POST["number"];
        $inserts = "(
            ItemName LIKE '%$item%'
            OR Price LIKE '%$item%'
            OR QuantityAvailable LIKE '%$item%'
        )";


        $sqlcode = str_replace("[CONDITION]", $inserts, $sqlcode);
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