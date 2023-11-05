            <!--Manage User-->
<?php
    $arraynew = json_decode( $_SESSION["Newcustomerappointment"], true);
    print_r($arraynew);


    $dateTime = new DateTime($arraynew["Checkin"]);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');

    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($arraynew["Checkin"]));

    if($dayOfWeekName >= 4){
        $columnstring = "Weekdays".$arraynew["timapackage"];
    }else{
        $columnstring = "WeekendsHolidays".$arraynew["timapackage"];
    }


?>
            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Payments</h1>
                </div>
                <div class="stafflistbox">
                    <div class="box">

                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2><?php echo $arraynew["lastName"].", ".$arraynew["firstName"]?> Payment</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col'></th>
                                    <th scope='col'>Quantity</th>
                                    <th scope='col'>Price</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
<?php
    $sql2 = "SELECT Type, $columnstring FROM poolrate WHERE Type = 'Adult';";
    $sql2query = mysqli_query($conn,$sql2);
    $adultresult = mysqli_fetch_assoc($sql2query);


    $sql22 = "SELECT Type, $columnstring FROM poolrate WHERE Type = 'Kids';";
    $sql22query = mysqli_query($conn,$sql22);
    $kidsresult = mysqli_fetch_assoc($sql22query);

    $sum = 0;
    $sum += $arraynew["No. of Adult"] * $adultresult[$columnstring];
    $sum += $arraynew["No. of Kid"] * $kidsresult[$columnstring];
    $sum += $arraynew["No. of Seniors"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));
?>
                                <tr>
                                    <th style='text-align:start;'>No. of Adults</th>
                                    <td style='text-align:center;'><?php echo $arraynew["No. of Adult"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo $arraynew["No. of Adult"] * $adultresult[$columnstring];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Kids</th>
                                    <td style='text-align:center;'><?php echo $arraynew["No. of Kid"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo $arraynew["No. of Kid"] * $kidsresult[$columnstring];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Senior</th>
                                    <td style='text-align:center;'><?php echo $arraynew["No. of Seniors"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo $arraynew["No. of Seniors"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));?></td>
                                </tr>


<?php
    $sql1 = "SELECT * FROM cottagetypes WHERE ServiceTypeName = '".$arraynew["Cottage"]."';";
    $sqlquery1 = mysqli_query($conn,$sql1);
    while($result = mysqli_fetch_assoc($sqlquery1)){
        if($arraynew["Cottage"] == "DayPrice"){
            $number = $result["DayPrice"];
        }else{
            $number = $result["NightPrice"];
        }
        $sum += $number;
        echo "<tr>
            <th style='text-align:start;'>".$arraynew["Cottage"]."</th>
            <td style='text-align:center;'>1</td>
            <td style='text-align:end;'>₱ $number</td>
        </tr>";
    }

    if($arraynew["numromocu"] > 0 ){
        $roomnumberlist = explode("@", $arraynew["roomnumbers"]);

        for ($i=0; $i < count($roomnumberlist) ; $i++) { 
            # code...
            $sqlloop = "SELECT a.*, b.* FROM rooms a LEFT JOIN roomtypes b ON a.RoomType = b.RoomType  WHERE a.RoomNum = '".$roomnumberlist[$i]."';";
            $sqlqueryloop = mysqli_query($conn,$sqlloop);
            $resultloop = mysqli_fetch_assoc($sqlqueryloop);

            if($arraynew["Cottage"] == "DayPrice"){
                $number = $resultloop["DayTimePrice"];
            }else if ($arraynew["Cottage"] == "NightPrice"){
                $number = $resultloop["NightTimePrice"];
            }else{
                $number = $resultloop["Hours22"];
            }

            $sum += $number;
            echo "<tr>
                <th style='text-align:start;'>ROOM-".$resultloop["RoomNum"]." ".$resultloop["RoomType"]."</th>
                <td style='text-align:center;'>1</td>
                <td style='text-align:end;'>₱ $number</td>
            </tr>";

        }
    }

?>
                                <tr>
                                    <th style='text-align:start;' colspan="2">TOTAL</th>
                                    <td style='text-align:end;' id="TPrice">₱<?php echo  number_format($sum, 2);?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;' colspan="2">DOWNPAYMENT</th>
                                    <td style='text-align:end;' id="Dpayment">₱<?php echo  number_format($sum*.5, 2);?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="text-align: center;  ">
                        <textarea name="" id="savevalues" cols="30" rows="10" style="display:none;"><?php echo $_SESSION["Newcustomerappointment"];?></textarea>
                        <input type="button" value="Save and Submit" class="submitbtn addbtn" onclick="SAVE()">
                </div>
            </div>

<script>
    async function SAVE() {





        
        const savevalues = document.getElementById("savevalues").value;
        var jsonObject = JSON.parse(savevalues);

        let insertguest = `INSERT INTO guests (GuestID, FirstName, LastName, Email, Phone, Address) VALUES 
        (NULL, '${jsonObject["firstName"]}', '${jsonObject["lastName"]}', '${jsonObject["email"]}', '${jsonObject["phoneNumber"]}', '${jsonObject["address"]}')`

        let selectguest = `SELECT GuestID FROM guests WHERE FirstName = '${jsonObject["firstName"]}' AND LastName = '${jsonObject["lastName"]}' AND Email = '${jsonObject["email"]}' ORDER BY Lastname DESC LIMIT 1;`

   
        const dataid =await AjaxSendv3(insertguest,"BREAKDOWNLOGIC",`&Process=UpdateGuest&sqlcode2=${selectguest}`)


        var dateTimeString = jsonObject["Checkin"];
        var dateOnly = dateTimeString.split('T')[0];
        var datetime2 = jsonObject["Checkout"]; // Parse the string into a Date object
        // Create a new Date object with the same year, month, and day, but set the time to midnight (00:00:00)
        var dateOnly2 = datetime2.split('T')[0];

        let TPrice = document.getElementById("TPrice").innerText.replace(/₱/g, '')
        TPrice = TPrice.replace(/,/g, '')
        let Dpayment = document.getElementById("Dpayment").innerText.replace(/₱/g, '')
        Dpayment = Dpayment.replace(/,/g, '')
        let roomnumbers = jsonObject["roomnumbers"].replace(/@/g, ',')


        let insertreservation = `INSERT INTO reservations (ReservationID, GuestID, CheckInDate, CheckOutDate, RoomNumber, CottageTypeID, NumAdults, NumChildren, NumSeniors, NumExcessPax, TotalPrice, Downpayment) 
        VALUES (NULL, '${dataid}', '${dateOnly}', '${dateOnly2}', '${roomnumbers}', '${jsonObject["Cottage"]}', '${jsonObject["No. of Adult"]}', '${jsonObject["No. of Kid"]}', '${jsonObject["No. of Seniors"]}', '0', '${TPrice}', '${Dpayment}');`

        let selectreservation = `SELECT ReservationID FROM reservations WHERE CheckInDate = '${dateOnly}' AND RoomNumber = '${roomnumbers}' ORDER BY CheckInDate DESC LIMIT 1;`
        
        const dataid2 =await AjaxSendv3(insertreservation,"BREAKDOWNLOGIC",`&Process=UpdateReservation&sqlcode2=${selectreservation}`)


        let roomnumbersarray = jsonObject["roomnumbers"].split("@")

        for (let index = 0; index < roomnumbersarray.length; index++) {
            let insertrooms = `INSERT INTO roomsreservation (greservationID, Room_num) VALUES ('${dataid2}', '${roomnumbersarray[index]}');`
            await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
        }
      

        

    }
</script>