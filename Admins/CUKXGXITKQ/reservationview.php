<?php
    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_GET["ISU"])) ? $_GET["ISU"]: $_SESSION["USERID"];

    $sqlcodeGuestinfo = "SELECT a.* FROM guests a WHERE a.GuestID = '$userid';";
    $GuestQuesry = mysqli_query($conn,$sqlcodeGuestinfo);
    $GuestInfo = mysqli_fetch_assoc($GuestQuesry);

?>


<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Reservation</h1>
                    <div class="">
                        <button class="addbtn" onclick="ADDPERSON()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                        </button>
                        <button class="Editbtn" onclick="EDITStatus()">
                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/></svg>
                        </button>
                    </div>
                 
                </div>

                
                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="box">
                        <div class="credentialinfo">
                            <div class="form-column">
                                <label for="firstName">First Name :</label>
                                <input type="text" name="firstName" id="firstName" readonly value="<?php echo $GuestInfo["FirstName"]?>">
                            </div>
                            <div class="form-column">
                                <label for="middleName">Middle Name :</label>
                                <input type="text" name="middleName" id="middleName" readonly value="<?php echo $GuestInfo["LastName"]?>">
                            </div>
                            <div class="form-column">
                                <label for="lastName">Last Name  :</label>
                                <input type="text" name="lastName" id="lastName" readonly value="<?php echo $GuestInfo["LastName"]?>">
                            </div>
                        </div>
                        <div>
                            <h3>-Summary-</h3>
                        </div>
                        <div class="box2">
           
                        <table class="table" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th scope='col'></th>
                                    <th scope='col'>Quantity</th>
                                    <th scope='col'>Price</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
<?php

    $sqlReservation = "SELECT * FROM reservations WHERE GuestID = '$userid';";
    $ReservationQuery = mysqli_query($conn,$sqlReservation);
    $ReservationData = mysqli_fetch_assoc($ReservationQuery);

    
    $dateTime = new DateTime($ReservationData["CheckInDate"]);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');

    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($ReservationData["CheckInDate"]));

    if($dayOfWeekName >= 4){
        $columnstring = "Weekdays".$ReservationData["timapackage"];
    }else{
        $columnstring = "WeekendsHolidays".$ReservationData["timapackage"];
    }


    $sql2 = "SELECT Type, $columnstring FROM poolrate WHERE Type = 'Adult';";
    $sql2query = mysqli_query($conn,$sql2);
    $adultresult = mysqli_fetch_assoc($sql2query);


    $sql22 = "SELECT Type, $columnstring FROM poolrate WHERE Type = 'Kids';";
    $sql22query = mysqli_query($conn,$sql22);
    $kidsresult = mysqli_fetch_assoc($sql22query);

    $sum = 0;
    $sum += $ReservationData["NumAdults"] * $adultresult[$columnstring];
    $sum += $ReservationData["NumChildren"] * $kidsresult[$columnstring];
    $sum += $ReservationData["NumSeniors"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));
?>
                                <tr>
                                    <th style='text-align:start;'>No. of Adults</th>
                                    <td style='text-align:center;'><?php echo $ReservationData["NumAdults"];?></td>
                                    <td style='text-align:end;'>₱ <?php echo  $ReservationData["NumAdults"] * $adultresult[$columnstring];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Kids</th>
                                    <td style='text-align:center;'><?php echo $ReservationData["NumChildren"];?></td>
                                    <td style='text-align:end;'>₱ <?php echo $ReservationData["NumChildren"] * $kidsresult[$columnstring];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;'>No. of Senior</th>
                                    <td style='text-align:center;'><?php echo $ReservationData["NumSeniors"];?></td>
                                    <td style='text-align:end;'>₱ <?php echo $ReservationData["NumSeniors"] * ($adultresult[$columnstring]-(($adultresult[$columnstring]*.2)));?></td>
                                </tr>


<?php
    $sql1 = "SELECT * FROM cottagetypes WHERE ServiceTypeName = '".$ReservationData["CottageTypeID"]."';";
    $sqlquery1 = mysqli_query($conn,$sql1);
    while($result = mysqli_fetch_assoc($sqlquery1)){
        if($ReservationData["timapackage"] == "DayPrice"){
            $number = $result["DayPrice"];
        }else{
            $number = $result["NightPrice"];
        }
        $sum += $number;
        echo "<tr>
            <th style='text-align:start;'>".$ReservationData["CottageTypeID"]."</th>
            <td style='text-align:center;'>1</td>
            <td style='text-align:end;'>₱ $number</td>
        </tr>";
    }


    # code...
    $sqlloop = "SELECT a.*,b.*, c.* FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomNum LEFT JOIN roomtypes c ON b.RoomType = c.RoomType WHERE a.greservationID = '".$ReservationData["ReservationID"]."';";
    $sqlqueryloop = mysqli_query($conn,$sqlloop);
    

    while ($resultloop = mysqli_fetch_assoc($sqlqueryloop)) {
        if($ReservationData["timapackage"]  == "DayPrice"){
            $number = $resultloop["DayTimePrice"];
        }else if ($ReservationData["timapackage"]  == "NightPrice"){
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




    if($ReservationData["Eventplace"] != "None" ){
            $pax = $ReservationData["NumAdults"] + $ReservationData["NumChildren"] + $ReservationData["NumSeniors"];
            # code...
            $sqlloop2 = "SELECT ".$ReservationData["Eventplace"]." FROM eventplace WHERE PAX >= $pax ORDER BY PAX ASC LIMIT 1";

            $sqlqueryloop = mysqli_query($conn,$sqlloop2);
            $resultloop2 = mysqli_fetch_assoc($sqlqueryloop);

            $number = $resultloop2[$ReservationData["Eventplace"]];
            $sum += $number;
            echo "<tr>
                <th style='text-align:start;'>".$ReservationData["Eventplace"]."</th>
                <td style='text-align:center;'>1</td>
                <td style='text-align:end;'>₱ $number</td>
            </tr>";

    }
?>

                                <tr>
                                    <th style='text-align:start;' colspan="2">TOTAL</th>
                                    <td style='text-align:end;' id="TPrice">₱<?php echo  $ReservationData["TotalPrice"];?></td>
                                </tr>
                                <tr>
                                    <th style='text-align:start;' colspan="2">DOWNPAYMENT</th>
                                    <td style='text-align:end;' id="Dpayment">₱<?php echo $ReservationData["Downpayment"];?></td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </form>
            </div>


<script>
    async function ADDPERSON(){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Search</label>
                <input type ="text" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Search</label>
                <input type ="text" id="swal-input2" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Search</label>
                <input type ="text" id="swal-input3" class="SWALinput" required>
            </div>
        
 

        </div>`

        let formValues =await POPUPCREATE("Additional Head Count",design,3)

        if (formValues) {
            let conditions = [];

            if(formValues[0] !== ""){
                conditions.push(`(
                    b.ReservationID LIKE '%${formValues[0]}%' OR
                    b.GuestID LIKE '%${formValues[0]}%' OR
                    b.RoomNumber LIKE '%${formValues[0]}%' OR
                    b.CottageTypeID LIKE '%${formValues[0]}%' OR
                    b.ReservationStatus LIKE '%${formValues[0]}%' OR
                    a.FirstName LIKE '%${formValues[0]}%' OR
                    a.LastName LIKE '%${formValues[0]}%' OR
                    a.Email LIKE '%${formValues[0]}%' OR
                    a.Phone LIKE '%${formValues[0]}%' OR
                    CONCAT(a.LastName,', ', a.FirstName) LIKE '%${formValues[0]}%' 
                )`);
            }
            if(formValues[1] !== ""){
                conditions.push(`
                    b.CheckInDate  = '${formValues[1]}'
                `);
            }
            if(formValues[2] !== "-"){
                conditions.push(`b.ReservationStatus = '${formValues[2]}'`)
            }

            const joinedString = conditions.join(' AND ');
            const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);


            console.log(formattedText)
            const Tabledata =await AjaxSendv3(formattedText,"GUESTLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }

</script>