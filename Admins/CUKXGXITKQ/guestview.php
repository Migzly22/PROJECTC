<?php
    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_GET["ISU"])) ? $_GET["ISU"]: $_SESSION["USERID"];

    $sqlcodeGuestinfo = "SELECT a.* FROM guests a WHERE a.GuestID = '$userid';";
    $GuestQuesry = mysqli_query($conn,$sqlcodeGuestinfo);
    $GuestInfo = mysqli_fetch_assoc($GuestQuesry);

?>


<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Guest</h1>
                   
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
                            <div class="form-column">
                                <label for="address">Address :</label>
                                <input type="text" name="address" id="address" readonly value="<?php echo $GuestInfo["Address"]?>">
                            </div>
                            <div class="form-column">
                                <label for="email">Email :</label>
                                <input type="email" name="email" id="email" readonly value="<?php echo $GuestInfo["Email"]?>">
                            </div>
                            <div class="form-column">
                                <label for="phoneNumber">Phone Number :</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber" readonly value="<?php echo $GuestInfo["Phone"]?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Payments</h1>
                </div>
                <div class="stafflistbox">
                    <div class="box">

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
            </div>

<script>

    const RoomNUMBERMULTI = document.getElementById('RoomNUMBERMULTI')

    var duplicatedinnerhtml = `<div class="form-column">
                                    <label for="">Room Number:</label>
                                    <select name="RNUM" id="">
                                        <option value="None">-</option>
                                    </select>
                                </div>`
    
    //RoomNUMBERMULTI.innerHTML


    const FCONTAIN = document.getElementById("FCONTAIN")

    var sqlc = `SELECT a.*,d.*, b.*, c.* FROM rooms a LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num LEFT JOIN greservations c ON b.greservationID = c.ReservationID LEFT JOIN roomtypes d ON a.RoomType = d.RoomType
    WHERE c.CheckInDate > '[chosen_checkout_datetime]'
    OR c.CheckOutDate < '[chosen_checkin_datetime]'
    OR c.CheckInDate IS NULL
    OR c.CheckOutDate IS NULL
    ORDER BY a.RoomID`


    var dataholder = ""

    function handleInputChange1(event) {
      const inputElement = event.target;
      let value = parseFloat(inputElement.value);

      if(value >= 0){
        RoomNUMBERMULTI.innerHTML = "" //reset the innerhtml
        for (let i = 0; i < value; i++) {
            RoomNUMBERMULTI.innerHTML += `<div class="form-column">
                                    <label for="">Room Number:</label>
                                    <select name="RNUM" id="">
                                        ${dataholder}
                                    </select>
                                </div>`
        }
      }
    }


    async function datachange() {
        const FCONTAIN2 = document.getElementById("FCONTAIN")
        if(FCONTAIN2.Checkin.value !== "" && FCONTAIN2.Checkout.value !== ""){
             sqlc = `SELECT a.*,d.*, b.*, c.* FROM rooms a LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num LEFT JOIN greservations c ON b.greservationID = c.ReservationID LEFT JOIN roomtypes d ON a.RoomType = d.RoomType
                WHERE c.CheckInDate > '${FCONTAIN2.Checkout.value}'
                OR c.CheckOutDate < '${FCONTAIN2.Checkin.value}'
                OR c.CheckInDate IS NULL
                OR c.CheckOutDate IS NULL
                ORDER BY a.RoomID`
            const Tabledata =await AjaxSendv3(sqlc,"RESERVATIONLOGIC","&Process=Search")
            let changeable = document.querySelector("select[name='RNUM']")
            //changeable.innerHTML = Tabledata

            dataholder = Tabledata;
            if(changeable){
                changeable.innerHTML += Tabledata
            }
        }
    }

    function hasDuplicates(arr) {
        return new Set(arr).size !== arr.length;
    }
    async function EDIT(){
        const FCONTAIN2 = document.getElementById("FCONTAIN")
        var mergedHTML = [];


        var elements = document.querySelectorAll("select[name='RNUM']");

        if(elements){
            // Loop through the elements and merge their innerHTML with "*"
            for (var i = 0; i < elements.length; i++) {
                mergedHTML.push(elements[i].value);
            }
            if(hasDuplicates(mergedHTML)){
                Swal.fire(
                    '',
                    'Duplicated room number',
                    'error'
                    )
                return 0
            }
        }


        
        let datacontroller = `{
            "firstName": "${FCONTAIN2.firstName.value}",
            "middleName": "${FCONTAIN2.middleName.value}",
            "lastName":"${FCONTAIN2.lastName.value}",
            "address":"${FCONTAIN2.address.value}",
            "email":"${FCONTAIN2.email.value}",
            "phoneNumber":"${FCONTAIN2.phoneNumber.value}",
            "No. of Adult":"${FCONTAIN2.numadult.value}",
            "No. of Kid":"${FCONTAIN2.numkid.value}",
            "No. of Seniors":"${FCONTAIN2.numsenior.value}",
            "Checkin":"${FCONTAIN2.Checkin.value}",
            "Checkout":"${FCONTAIN2.Checkout.value}",
            "timapackage":"${FCONTAIN2.timapackage.value}",
            "numromocu":"${FCONTAIN2.numromocu.value}",
            "Cottage":"${FCONTAIN2.Cottage.value}",
            "evplace":"${FCONTAIN2.evplace.value}",
            "roomnumbers":"${mergedHTML.join("@")}"
        }`;

         Swal.fire({
            title: 'Are you sure you want to add the informations?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Save',
            denyButtonText: `Cancel`,
            }).then(async (result) => { 
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                await AjaxSendv3(datacontroller,"RESERVATIONLOGIC","&Process=PaymentTime")
                location.href = "../Admins/Mainpage.php?nzlz=breakdown&plk=2";
            } 
        })
    }


    // Get references to all input elements with the class "input-box"
    const inputElements = document.querySelectorAll("input[type='number']");
    
    // Add event listeners to all selected input elements
    inputElements.forEach(input => {
        input.addEventListener("input", function() {
            // Parse the input value as a number
            const value = parseFloat(input.value);
            if( input.id=="numromocu"){
                input.addEventListener('change', handleInputChange1);
            }
            // Check if the value is less than 0
            if (value < 0) {
                // Set the value to 0
                input.value = 0;
            }
      
        });
    });
</script>