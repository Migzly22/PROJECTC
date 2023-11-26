<?php
    ob_start();
    session_start();
    require("../Database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuestFolio</title>

    <style>
        table{
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
           font-weight: bolder;
           font-style: italic;
        }
        th, td{
            border: 1px solid black;
            padding: 1em;
        }
        td:nth-child(3),td:nth-child(5),td:nth-child(4),.totalprice{
           text-align: end;
        }
        td:nth-child(1){
            text-align: center;
        }
        
        thead th,tfoot td{
            border: 2px solid black;
        }
        tbody td:nth-child(1){
            border-left: 2px solid black;
        }
        tbody td:nth-child(5){
            border-right: 2px solid black;
        }


    </style>
</head>
<body>

<?php
    $sqlcode = "SELECT  a.Item, a.Price,  DATE(a.Date) as ODATE, CONCAT(b.GuestLname , ', ', b.GuestFname, ' ', LEFT(b.GuestMname,1), '.') AS Name, b.InitialRoomPay, b.TotalRoomPay, c.Room_No FROM servicev2 a LEFT JOIN guest b ON a.Guest_ID = b.GuestID LEFT JOIN reservation c ON a.Guest_ID = c.GuestID 
            WHERE a.Guest_ID = '36'";
    $queryrun = mysqli_query($conn,$sqlcode);
    $bodyrow = "";

    $counter = "";
    $bool1 = true;
    $breakdown = 0;
    $sum = 0;
    $name = mysqli_fetch_assoc($queryrun)["Name"];
    $rooomnum = mysqli_fetch_assoc($queryrun)["Room_No"];

    
    $sqlcode2 = "SELECT SUM(PaidAmount) AS TOTALTHING FROM `payments` WHERE GuestID = '36';";
    $queryrun2 = mysqli_query($conn,$sqlcode2);
    $breakdowntotal = mysqli_fetch_assoc($queryrun2)["TOTALTHING"];

    while ($result = mysqli_fetch_assoc($queryrun)){

        if($bool1){
            $breakdowntotal -=$result["InitialRoomPay"];
            $bodyrow .= "<tr>
                <td></td>
                <td>Initial Room Pay</td>
                <td>1</td>
                <td>".number_format($result["InitialRoomPay"], 2)."</td>
                <td>$breakdowntotal</td>
            </tr>";
            
            $breakdowntotal -=($result["TotalRoomPay"]-$result["InitialRoomPay"]);
            $bodyrow .="<tr>
                <td></td>
                <td>Total Room Pay</td>
                <td>1</td>
                <td>".number_format($result["TotalRoomPay"]-$result["InitialRoomPay"], 2)."</td>
                <td>$breakdowntotal</td>
            </tr>";

            $sum += $result["TotalRoomPay"];
            $bool1 = !$bool1;
        }


        if($counter != $result["ODATE"]){
            $bodyrow .="<tr>
                <td>".$result["ODATE"]."</td>
            ";
            $counter = $result["ODATE"];
        }else{
            $bodyrow .="<tr><td></td>";
        }

      
        $jsondata = json_decode($result["Item"]);

        $i = 0;//simple counter
        foreach($jsondata as $keys => $value){


            $quantity =$value-> Quantity;
            $price =  number_format($value-> Price, 2);
            $product = number_format($quantity *  $price, 2);

            $sum += $product;
            $breakdowntotal -= $product;

            if($i == 0){
                $bodyrow .= "<td>$keys</td>
                <td>$quantity</td>
                <td>$product</td>
                <td>$breakdowntotal</td>
                </tr>";
            }else{
                $bodyrow .= "<tr>
                    <td></td>
                    <td>$keys</td>
                    <td>$quantity</td>
                    <td>$product</td>
                    <td>$breakdowntotal</td>
                </tr>";
            }
            $i++;
        }

    }

?>
    <div>
        <p>Name : <?php echo $name;?></p>
        <p>Room No. : <?php echo $rooomnum;?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Items</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Breakdown</th>
            </tr>
        </thead>
        <tbody>
            {{TABLEDATA}}
        <?php
                echo $bodyrow;
                echo $sum
        ?>
   
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="totalprice">{{TOTALPRICE}}</td>
                <td>{{TOTALREMAINS}}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>