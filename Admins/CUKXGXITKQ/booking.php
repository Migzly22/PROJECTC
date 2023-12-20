<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Bookings</h1>
                    <button class="addbtn" onclick="ADDSTAFF()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                    </button>
                </div>
                <div class="SEARCHANDFILTRATION">
                    <div class="box">
                            <div class="searchingDIV">
                                <input type="search" name="" id="SEARCHITEMINPUT" class="Searchinput">
                                <button class="addbtn" onclick="SEARCHING()">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                </button>
                            </div>
                            <button class="Editbtn" onclick="FILTERING()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
                            </button>
                            <button class="Editbtn" onclick="RESETTABLE()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z"/></svg>
                            </button>

                    </div>
                </div>
                <div class="stafflistbox">
                    <div class="box">
                        <div class="box2">
                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2>List of Reservations</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col' style="text-align: center;">Reservation</th>
                                    <th scope='col' style="text-align: center;">Checkout</th>
                                    <th scope='col' style="text-align: center;">Status</th>
                                    <th scope='col' style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="TBODYELEMENT">
                               
<?php
    $sqlbooking = "SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID AND a.ReservationStatus != 'CANCELLED' ORDER BY a.CheckInDate DESC;";
    $querybooking = mysqli_query($conn,$sqlbooking);
    $tbodydata = "";
    while ($result = mysqli_fetch_assoc($querybooking)) {
        # code...


        $RESERVATIONDETAILS = "
        <td scope='col' >
            ".$result['ReservationStatus']."
            <select>
                <option value='BOOKED'>Booked</option>
                <option value='CHECKIN'>Check-in</option>
                <option value='CANCELLED'>Cancelled</option>
            </select>
        </td>";
        $select1 = "";$select2 = "";$select3 = "";
        switch ($result['ReservationStatus']) {
            case 'BOOKED':
                $select1 = "selected";
                break;
            case 'CHECKIN':
                $select2 = "selected";
                break;
            case 'CANCELLED':
                $select3 = "selected";
                break;
        }
        $RESERVATIONDETAILS = "
        <td scope='col' >
            <div class='ACCESSTABLE'>
                <select  onchange='CHANGESTATE(this,`".$result['ReservationID']."`)'>
                    <option value='BOOKED' $select1>Booked</option>
                    <option value='CHECKIN' $select2>Check-in</option>
                    <option value='CANCELLED' $select3>Cancelled</option>
                </select>                   
            </div>
        </td>";
        $PAYMENTBUTTON = "<button class='addbtn' onclick='PAYMENT(`".$result['ReservationID']."`)'>
                <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M64 0C46.3 0 32 14.3 32 32V96c0 17.7 14.3 32 32 32h80v32H87c-31.6 0-58.5 23.1-63.3 54.4L1.1 364.1C.4 368.8 0 373.6 0 378.4V448c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V378.4c0-4.8-.4-9.6-1.1-14.4L488.2 214.4C483.5 183.1 456.6 160 425 160H208V128h80c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H64zM96 48H256c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16zM64 432c0-8.8 7.2-16 16-16H432c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm48-168a24 24 0 1 1 0-48 24 24 0 1 1 0 48zm120-24a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM160 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM328 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM256 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM424 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM352 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48z'/></svg>
            </button>";
        if($result['ReservationStatus'] == "CHECKOUT"){
            $RESERVATIONDETAILS = "<td scope='col' >Check out</td>";
            $PAYMENTBUTTON = "";
        }

        $tbodydata .= "
            <tr>
                <td>".$result['Name']."</td>
                <td>".$result['Email']."</td>
                <td scope='col' style='text-align: center;'>".$result['eCheckin']."</td>
                <td scope='col' style='text-align: center;'>".$result['finalCheckout']."</td>
                $RESERVATIONDETAILS
                <td class='ActionTABLE' id='".$result['ReservationID']."'>
                    <button class='addbtn' onclick='VIEW(`".$result['ReservationStatus']."`,`".$result['GuestID']."`)'>
                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 576 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z'/></svg>
                    </button>
                    $PAYMENTBUTTON
                </td>
        </tr>
        ";
    }

    if (mysqli_num_rows($querybooking) == 0) {
        $tbodydata = "     <tr>
            <td colspan='7' style='text-align:center; font-weight:bolder;'>No data </td>
        </tr> ";
    }
    echo $tbodydata;

?>
                             
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

            </div>

<script>
    const SEARCHITEMINPUT = document.getElementById("SEARCHITEMINPUT");
    const mainquery = `SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID WHERE [CONDITION]  ORDER BY a.CheckInDate DESC;`
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')

    async function SEARCHING() {
        let item = SEARCHITEMINPUT.value;
        
         let searchcondition = `(
            a.ReservationID LIKE '%${item}%' OR
            a.GuestID LIKE '%${item}%' OR
            a.ReservationStatus LIKE '%${item}%' OR
            b.FirstName LIKE '%${item}%' OR
            b.LastName LIKE '%${item}%' OR
            b.Email LIKE '%${item}%' OR
            b.Phone LIKE '%${item}%' OR
            CONCAT(b.LastName,', ', b.FirstName) LIKE '%${item}%' 
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)
        const Tabledata =await AjaxSendv3(formattedText,"BOOKINGLOGIC","&Process=Search")
        TBODYELEMENT.innerHTML = Tabledata

    }
    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","BOOKINGLOGIC","&Process=Reset")
        console.log(Tabledata)
        SEARCHITEMINPUT.value = "";
        TBODYELEMENT.innerHTML = Tabledata
    }

    async function FILTERING(){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Search</label>
                <input type ="text" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Check in</label>
                <input type ="date" id="swal-input2" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Reservation Status</label>
                <select class='SWALinput swalselect' id='swal-input3' aria-label='Floating label select example'>
                    <option value="-">-</option>
                    <option value='BOOKED'>Booked</option>
                    <option value='CHECKIN'>Checked in</option>
                    <option value='CHECKOUT'>Checked out</option>
                    <option value='CANCELLED'>Cancelled</option>
                </select>
            </div>
 

        </div>`

        let formValues =await POPUPCREATE("Filters",design,3)

        if (formValues) {
            let conditions = [];

            if(formValues[0] !== ""){
                conditions.push(`(
                    a.ReservationID LIKE '%${formValues[0]}%' OR
                    a.GuestID LIKE '%${formValues[0]}%' OR
                    a.RoomNumber LIKE '%${formValues[0]}%' OR
                    a.CottageTypeID LIKE '%${formValues[0]}%' OR
                    a.ReservationStatus LIKE '%${formValues[0]}%' OR
                    b.FirstName LIKE '%${formValues[0]}%' OR
                    b.LastName LIKE '%${formValues[0]}%' OR
                    b.Email LIKE '%${formValues[0]}%' OR
                    b.Phone LIKE '%${formValues[0]}%' OR
                    CONCAT(b.LastName,', ', b.FirstName) LIKE '%${formValues[0]}%' 
                )`);
            }
            if(formValues[1] !== ""){
                conditions.push(`
                    a.CheckInDate  = '${formValues[1]}'
                `);
            }
            if(formValues[2] !== "-"){
                conditions.push(`a.ReservationStatus = '${formValues[2]}'`)
            }

            const joinedString = conditions.join(' AND ');
            const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);

            const Tabledata =await AjaxSendv3(formattedText,"BOOKINGLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
    async function CHANGESTATE(e,id){
        let sqlcode123 =`UPDATE reservations SET ReservationStatus = '${e.value}' WHERE ReservationID = '${id}';`
        const Tabledata =await AjaxSendv3(sqlcode123,"BOOKINGLOGIC","&Process=AccessUpdate")
        TBODYELEMENT.innerHTML = Tabledata
    }
    async function VIEW(status,e){
        location.href = `./Mainpage.php?nzlz=reservationview&plk=2&ISU=${e}`;
    }


    async function ADDSTAFF(){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Check-in</label>
                <input type ="datetime-local" id="swal-input1" class="SWALinput" required value="">
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Package</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value="Package1">Swimming Only</option>
                    <option value='Package2'>Room + Swimming</option>
                    <option value='Package3'>Pavilions</option>
                </select>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Time Range</label>
                <select class='SWALinput swalselect' id='swal-input3' aria-label='Floating label select example'>
                    <option value="Day">08:00 AM - 05:00 PM</option>
                    <option value='Night'>07:00 PM - 07:00 AM</option>
                    <option value='22Hrs'>02:00 PM - 12:00 PM</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Walk-in Registration",design,3)
        if (formValues) {
            if(!formValues[0]){
                await Swal.fire({
                    text: "Please enter check-in time",
                    icon: "info"
                });
                return 
            }
            let values1 = formValues[0].split("T")


            let  senddata = await AjaxSendv3(formValues[1],"Availability",`&cin=${values1[0]}&tday=${formValues[2]}`)  
                if(senddata == "true"){
                    await Swal.fire({
                        text: "There's an available slot",
                        icon: "success"
                    });
                    location.href = `./Mainpage.php?nzlz=bookingv2&plk=2&cin=${values1[0]}&package=${formValues[1]}&tRANGE=${formValues[2]}&ETIME=${values1[1]}`;
                }else{
                    await Swal.fire({
                        text: "The date has been fully booked",
                        icon: "info"
                    });
                }

        }


        //location.href = `./Mainpage.php?nzlz=reservationform&plk=2&cin=2023-12-10&ETIME=12:00&adultval=200&kidval=150&package=Package1&tRANGE=Day&na=4&nk=3&ns=3&tinit=1730.00`;
    }

    function DATEDATATODAY() {
        var today = new Date();

        var year = today.getFullYear();
        var month = today.getMonth() + 1; // Month is zero-based, so add 1
        var day = today.getDate();
        var hours = today.getHours();
        var minutes = today.getMinutes();
        var seconds = today.getSeconds();

        // Add leading zero if needed
        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        return formattedDate;
    }
    async function PAYMENT(e){

        let balance = await AjaxSendv3(e,"GUESTLOGIC","&Process=Specialmention")
        console.log(balance)
        //location.href = `./Mainpage.php?nzlz=reservationform&plk=2`;

        let design =  `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Balance</label>
                <input type ="text" id="swal-input3" class="SWALinput" readonly value='${balance}'>
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

        let formValues =await POPUPCREATE("Checkout Payment",design,3)

        if (formValues) {
            let conditions = [];

            conditions.push(`${formValues[1]}`);
            console.log(DATEDATATODAY())

            if(formValues[0] !== "" && parseFloat(formValues[0]) >= parseFloat(balance)){
                conditions.push(`${balance}`);
                let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod, Description) VALUES ('${e}', CURRENT_DATE , '${conditions[1]}', '${conditions[0]}', 'CHECKOUT');`;
                await AjaxSendv3(sqlcodepayment,"GUESTLOGIC",`&Process=Insertmore`)
                
                let update12 =`UPDATE reservations SET ReservationStatus = 'CHECKOUT', finalCheckout = '${DATEDATATODAY()}' WHERE ReservationID = '${e}';`
                await AjaxSendv3(update12,"GUESTLOGIC","&Process=Insertmore")


                await Swal.fire({
                    title: "",
                    text: `Change : ₱ ${(parseFloat(formValues[0]) - parseFloat(balance)).toFixed(2)}`,
                    icon: "info"
                });
                RESETTABLE()
            }else{
                await Swal.fire({
                    title: "",
                    text: "Wrong Payment Value",
                    icon: "warning"
                });
            }


            
        }
    }


    async function CheckoutChecking(){
        let datetoday = DATEDATATODAY();

        let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod, Description) VALUES ('${e}', CURRENT_DATE , '${conditions[1]}', '${conditions[0]}', 'CHECKOUT');`;
        await AjaxSendv3(sqlcodepayment,"GUESTLOGIC",`&Process=CheckingOUT`)
    }
</script>