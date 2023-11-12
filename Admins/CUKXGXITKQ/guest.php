<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Guest</h1>
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
                                <h2>List of Guest</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col'>Name</th>
                                    <th scope='col' >Email</th>
                                    <th scope='col'  style="text-align: center;">Phone</th>
                                    <th scope='col'  style="text-align: center;">Arrival</th>
                                    <th scope='col'  style="text-align: center;">Checkout</th>
                                    <th scope='col' style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="TBODYELEMENT">
                            <?php
    $sqlbooking = "SELECT a.*, b.*, CONCAT(a.LastName,', ', a.FirstName) as Name FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID ORDER BY a.Lastname, a.Firstname;";
    $querybooking = mysqli_query($conn,$sqlbooking);
    $tbodydata = "";
    while ($result = mysqli_fetch_assoc($querybooking)) {
        # code...
        $tbodydata .= "
        <tr>
            <td>".$result['Name']."</td>
            <td scope='col' >".$result['Email']."</td>
            <td scope='col' style='text-align: center;'>".$result['Phone']."</td>
            <td scope='col' style='text-align: center;'>".$result['CheckInDate']."</td>
            <td scope='col' style='text-align: center;'>".$result['CheckOutDate']."</td>
            <td class='ActionTABLE' id ='".$result['GuestID']."'>
                <button class='addbtn' onclick='VIEW(this)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 576 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z'/></svg>
                </button>
                <button class='addbtn' onclick='PAYMENT(`".$result['ReservationID']."`)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M64 0C46.3 0 32 14.3 32 32V96c0 17.7 14.3 32 32 32h80v32H87c-31.6 0-58.5 23.1-63.3 54.4L1.1 364.1C.4 368.8 0 373.6 0 378.4V448c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V378.4c0-4.8-.4-9.6-1.1-14.4L488.2 214.4C483.5 183.1 456.6 160 425 160H208V128h80c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H64zM96 48H256c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16zM64 432c0-8.8 7.2-16 16-16H432c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm48-168a24 24 0 1 1 0-48 24 24 0 1 1 0 48zm120-24a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM160 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM328 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM256 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48zM424 240a24 24 0 1 1 -48 0 24 24 0 1 1 48 0zM352 344a24 24 0 1 1 0-48 24 24 0 1 1 0 48z'/></svg>
                </button>
            </td>
        </tr>
        ";
    }

    if (mysqli_num_rows($querybooking) == 0) {
        $tbodydata = "     <tr>
            <td colspan='5' style='text-align:center; font-weight:bolder;'>No data </td>
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
    const mainquery = `SELECT a.*, b.*, CONCAT(a.LastName,', ', a.FirstName) as Name FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID WHERE [CONDITION] ORDER BY a.Lastname, a.Firstname;`
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')

    async function SEARCHING() {
        let item = SEARCHITEMINPUT.value;
        
        let searchcondition = `(
            b.ReservationID LIKE '%${item}%' OR
            b.GuestID LIKE '%${item}%' OR
            b.RoomNumber LIKE '%${item}%' OR
            b.CottageTypeID LIKE '%${item}%' OR
            b.ReservationStatus LIKE '%${item}%' OR
            a.FirstName LIKE '%${item}%' OR
            a.LastName LIKE '%${item}%' OR
            a.Email LIKE '%${item}%' OR
            a.Phone LIKE '%${item}%' OR
            CONCAT(a.LastName,', ', a.FirstName) LIKE '%${item}%' 
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)
        const Tabledata =await AjaxSendv3(formattedText,"GUESTLOGIC","&Process=Search")
        TBODYELEMENT.innerHTML = Tabledata

    }
    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","GUESTLOGIC","&Process=Reset")
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
    
    async function VIEW(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[0].innerHTML
        location.href = `./Mainpage.php?nzlz=guestview&plk=4&ISU=${targetid}&qwe=true`;
    }
    async function EDIT(status,e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[0].innerHTML

        console.log(status,targetid)
        //location.href = `./Mainpage.php?nzlz=viewuserinfo&plk=5&ISU=${targetid}`;
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

        let formValues =await POPUPCREATE("Filters",design,3)

        if (formValues) {
            let conditions = [];

            conditions.push(`${formValues[1]}`);

            if(formValues[0] !== "" && parseFloat(formValues[0]) >= parseFloat(balance)){
                conditions.push(`${balance}`);
                let sqlcodepayment = `INSERT INTO guestpayments ( ReservationID, PaymentDate, AmountPaid, PaymentMethod) VALUES ('${e}', CURRENT_DATE , '${conditions[1]}', '${conditions[0]}');`;
                await AjaxSendv3(sqlcodepayment,"GUESTLOGIC",`&Process=Insertmore`)
                
                let update12 =`UPDATE reservations SET ReservationStatus = 'CHECKOUT' WHERE ReservationID = '${e}';`
                await AjaxSendv3(update12,"GUESTLOGIC","&Process=Insertmore")


                await Swal.fire({
                    title: "",
                    text: `Change : ₱ ${(parseFloat(formValues[0]) - parseFloat(balance)).toFixed(2)}`,
                    icon: "info"
                });
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
</script>