<?php
    require("../Database.php");
    session_start();
    ob_start();

    $jsonString = $_GET["sqlcode"];
    $datafromclient = json_decode($jsonString, true);

    $uids = $_SESSION["USERID"];

    $usersql = "SELECT FirstName as firstName, LastName as lastName, MiddleName as middleName, CONCAT(Address, ' ', City) as address,  Email AS email  FROM userscredentials WHERE userID = '$uids';";
    $userquery = mysqli_query($conn,$usersql);
    $userresultdata = mysqli_fetch_assoc($userquery);
    

    $arraynew = array_merge($datafromclient, $userresultdata);
    print_r($arraynew);

    $expendituresvalues = $arraynew["EXPENDITURES"];
    $cottagearr = array();
    $cottagequanarr = array();
    $roomarr = array();
    $roomquanarr = array();
    $evtnquan = array();
    $cottagecounter = 0;
    $roomcounter = 0;
    $arraynew["evplace"] = "None";

    for ($i=0; $i < count($expendituresvalues); $i++) { 
        switch ($expendituresvalues[$i]["TYpeofR"]) {
            case ' Room ':
                    $roomcounter++;
                    $roomarr[] = $expendituresvalues[$i]["nameitem"];
                    $roomquanarr[] = $expendituresvalues[$i]["total"];
                break;
            case ' Cottage ':
                    $cottagecounter++;
                    $cottagearr[] = $expendituresvalues[$i]["nameitem"];
                    $cottagequanarr[] = $expendituresvalues[$i]["total"];
                break;
            case ' Pavilion ':
                # code...
                    $arraynew["evplace"] =$expendituresvalues[$i]["nameitem"];
                    $evtnquan[] = $expendituresvalues[$i]["total"];
                break;
            default:

                break;
        }
    }
    $arraynew["numromocu"] = $roomcounter;


    $dateTime = new DateTime($arraynew["Checkin"]);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');

    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($arraynew["Checkin"]));

    if($dayOfWeekName >= 4){
        $columnstring = "Weekdays".$arraynew["TND"];
    }else{
        $columnstring = "WeekendsHolidays".$arraynew["TND"];
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
                                    $sum += $arraynew["noAdult"] * $adultresult[$columnstring];
                                    $sum += $arraynew["noKid"] * $kidsresult[$columnstring];
                                    $sum += $arraynew["noSenior"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));
                                ?>
                                <tr>
                                    <th style='text-align:start;'>No. of Adults</th>
                                    <td style='text-align:center;'><?php echo $arraynew["noAdult"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo $arraynew["noAdult"] * $adultresult[$columnstring];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Kids</th>
                                    <td style='text-align:center;'><?php echo $arraynew["noKid"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo $arraynew["noKid"] * $kidsresult[$columnstring];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Senior</th>
                                    <td style='text-align:center;'><?php echo $arraynew["noSenior"]?></td>
                                    <td style='text-align:end;'>₱ <?php echo $arraynew["noSenior"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));?></td>
                                </tr>


<?php

                                for ($i=0; $i < $cottagecounter ; $i++) { 
                                    $sql1 = "SELECT * FROM cottagetypes WHERE ServiceTypeName = '".$cottagearr[$i]."';";
                                    $sqlquery1 = mysqli_query($conn,$sql1);
                                    while($result = mysqli_fetch_assoc($sqlquery1)){
                                        if($arraynew["TND"] == "DayPrice"){
                                            $number = $result["DayPrice"];
                                        }else{
                                            $number = $result["NightPrice"];
                                        }
                                        $number = $number*$cottagequanarr[$i];
                                        $sum += $number;
                                        echo "<tr>
                                            <th style='text-align:start;'>".$cottagearr[$i]."</th>
                                            <td style='text-align:center;'>".$cottagequanarr[$i]."</td>
                                            <td style='text-align:end;'>₱ $number</td>
                                        </tr>";
                                    }
                                }

    if($arraynew["numromocu"] > 0 ){
        $roomnumberlist = array();
        for ($i=0; $i < $arraynew["numromocu"] ; $i++) { 
            $autopicroom = "SELECT a.*
            FROM rooms a
            LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num
            LEFT JOIN reservations c ON b.greservationID = c.ReservationID
            WHERE (c.CheckInDate IS NULL OR c.CheckInDate >= '".$arraynew['Checkin']."' AND c.CheckOutDate <= '".$arraynew['Checkout']."')AND a.RoomType = '".$roomarr[$i]."';";
            $autochoose = mysqli_query($conn,$autopicroom);

            $countertoreturn = 1;
            while($result = mysqli_fetch_assoc($autochoose)){
                $roomnumberlist[] = $result["RoomNum"];

                if($countertoreturn == $roomquanarr[$i]){
                    break;
                }
            }
            # code...
        }
        //$roomnumberlist = explode("@", $arraynew["roomnumbers"]);
        $roomname = array();
        for ($i=0; $i < count($roomnumberlist) ; $i++) { 
            # code...
            $sqlloop = "SELECT a.*, b.* FROM rooms a LEFT JOIN roomtypes b ON a.RoomType = b.RoomType  WHERE a.RoomNum = '".$roomnumberlist[$i]."';";
            $sqlqueryloop = mysqli_query($conn,$sqlloop);
            $resultloop = mysqli_fetch_assoc($sqlqueryloop);

            if($arraynew["TND"] == "DayPrice"){
                $number = $resultloop["DayTimePrice"];
            }else if ($arraynew["TND"] == "NightPrice"){
                $number = $resultloop["NightTimePrice"];
            }else{
                $number = $resultloop["Hours22"];
            }
            $roomname[] = $resultloop["RoomType"];
            $sum += $number;
            echo "<tr>
                <th style='text-align:start;'>ROOM-".$resultloop["RoomNum"]." ".$resultloop["RoomType"]."</th>
                <td style='text-align:center;'>1</td>
                <td style='text-align:end;'>₱ $number</td>
            </tr>";

        }

        $arraynew['ROOM'] = join(", ", $roomname);

    }else{
        $arraynew['ROOM'] = "";
    }



                        if($arraynew["evplace"] != "None" ){
                                $pax = $arraynew["noAdult"] + $arraynew["noKid"] + $arraynew["noSenior"];
                                # code...
                                $sqlloop2 = "SELECT `".$arraynew["evplace"]."` FROM eventplace WHERE PAX >= $pax ORDER BY PAX ASC LIMIT 1";

    
                                $sqlqueryloop = mysqli_query($conn,$sqlloop2);
                                $resultloop2 = mysqli_fetch_assoc($sqlqueryloop);


                                $number = $resultloop2[$arraynew["evplace"]] *$evtnquan[0] ;
                                $sum += $number;
                                echo "<tr>
                                    <th style='text-align:start;'>".$arraynew["evplace"]."</th>
                                    <td style='text-align:center;'>1</td>
                                    <td style='text-align:end;'>₱ $number</td>
                                </tr>";

                        }

    $arraynew['TOTAL'] = $sum;
    $arraynew['DPAYMENT'] = $sum*.5;
    $_SESSION["Newcustomerappointment"] = json_encode($arraynew, JSON_PRETTY_PRINT);

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
                        <input type="button" value="Continue" class="submitbtn addbtn" onclick="SAVE()">
                </div>
            </div>

<script>
    async function SAVE() {
        let Dpayment = document.getElementById("Dpayment").innerText.replace('₱', '')
        Dpayment = Dpayment.replace(',', '')
        
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Total</label>
                <input type ="text" id="swal-input3" class="SWALinput" readonly value='${Dpayment}'>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Payment</label>
                <input type ="text" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Type of Payment</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value='CASH'>Cash</option>
                    <option value='ONLINE'>Online Payment</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Filters",design,3)

        if (formValues) {
            let conditions = [];

            conditions.push(`${formValues[1]}`);

            if(formValues[0] !== "" && parseFloat(formValues[0]) >= parseFloat(Dpayment)){
                conditions.push(`${Dpayment}`);
                let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod) VALUES (':ID:', CURRENT_DATE , '${conditions[1]}', '${conditions[0]}');`;
                Inputtime(sqlcodepayment)
            }else{
                await Swal.fire({
                    title: "",
                    text: "Wrong Payment Value",
                    icon: "warning"
                });
                SAVE();
            }
    
            
        }

    }

    async function Inputtime(sqlcodepayment){
   
        const savevalues = document.getElementById("savevalues").value;
        var jsonObject = JSON.parse(savevalues);

        let insertguest = `INSERT INTO guests (GuestID, FirstName, MiddleName, LastName, Email, Phone, Address) VALUES 
        (NULL, '${jsonObject["firstName"]}', '${jsonObject["middleName"]}' , '${jsonObject["lastName"]}', '${jsonObject["email"]}', '${jsonObject["phoneNumber"]}', '${jsonObject["address"]}')`

        let selectguest = `SELECT GuestID FROM guests WHERE FirstName = '${jsonObject["firstName"]}' AND LastName = '${jsonObject["lastName"]}' AND Email = '${jsonObject["email"]}' ORDER BY GuestID DESC LIMIT 1;`
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

        let insertreservation = `INSERT INTO reservations (ReservationID, GuestID, CheckInDate, CheckOutDate, RoomNumber, CottageTypeID, NumAdults, NumChildren, NumSeniors, NumExcessPax, timapackage, Eventplace, TotalPrice, Downpayment) 
        VALUES (NULL, '${dataid}', '${dateOnly}', '${dateOnly2}', '${roomnumbers}', '${jsonObject["Cottage"]}', '${jsonObject["noAdult"]}', '${jsonObject["noKid"]}', '${jsonObject["noSenior"]}', '0', '${jsonObject["TND"]}', '${jsonObject["evplace"]}', '${TPrice}', '${Dpayment}');`

        let selectreservation = `SELECT ReservationID FROM reservations WHERE CheckInDate = '${dateOnly}' AND GuestID = '${dataid}' ORDER BY ReservationID DESC LIMIT 1;`

        const dataid2 =await AjaxSendv3(insertreservation,"BREAKDOWNLOGIC",`&Process=UpdateReservation&sqlcode2=${selectreservation}`)


        let roomnumbersarray = jsonObject["roomnumbers"].split("@")

        for (let index = 0; index < roomnumbersarray.length; index++) {
            let insertrooms = `INSERT INTO roomsreservation (greservationID, Room_num) VALUES ('${dataid2}', '${roomnumbersarray[index]}');`
            await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
        }

        let paymentdone = sqlcodepayment.replace(':ID:', `${dataid2}`)

        await AjaxSendv3(paymentdone,"BREAKDOWNLOGIC",`&Process=Insertmore`)

        //location.href = "../Admins/Composer/docxphp.php";

        $.ajax({
            url:`./Composer/docxphp.php`,
            type:"GET",
            beforeSend:function(){
                location.href = "../Admins/Composer/docxphp.php";
            },
            error: function(e) 
            {

            },
            success:function(){
                location.href = "../Admins/Mainpage.php?nzlz=booking&plk=2";
            }
        }); 

    }


</script>