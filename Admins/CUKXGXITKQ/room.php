            <!--Manage User-->
            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Rooms</h1>
                    <?php
                        if($_SESSION["ACCESS"] == "ADMIN"){
                    ?>
                        <button class="addbtn" onclick="ADDROOM()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                        </button>
                    <?php
                        }
                    ?>
                </div>
                <div class="SEARCHANDFILTRATION">
                    <div class="box">
                            <!--
                            <div class="searchingDIV">
                                <input type="search" name="" id="SEARCHITEMINPUT" class="Searchinput">
                                <button class="addbtn" onclick="SEARCHING()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                </button>
                            </div>
                            -->
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

                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2>List of Rooms</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col' style="text-align: start;">#</th>
                                    <th scope='col'>Type</th>
                                    <th scope='col'>Status</th>
                                    <th scope='col'>Date & Time</th>
                                    <?php
                                        if ($_SESSION["ACCESS"] == "ADMIN"){
                                            echo "<th scope='col' style='text-align: center;'>Action</th>";
                                        }else{
                                            $tablebuttnon = "";
                                        }
                                    ?>
                                    
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
<?php
    $sqlcode3 = "SELECT a.*, d.*, if(d.Status1 IS NULL, 'Available', d.Status1) AS Status FROM rooms a 
    LEFT JOIN (SELECT  b.*, IF(c.ReservationStatus IS NULL, 'Available', c.ReservationStatus) AS Status1, CONCAT(c.CheckInDate, ' to ', c.CheckOutDate) AS DT FROM roomsreservation b LEFT JOIN reservations c ON b.greservationID = c.ReservationID  WHERE CURDATE() BETWEEN c.CheckInDate AND c.CheckOutDate) d ON a.RoomNum = d.Room_num
    ORDER BY a.RoomID;";
    $querynum3 = mysqli_query($conn,$sqlcode3);
    $table5 = "";

    while($result3 = mysqli_fetch_assoc($querynum3)){
        if ($_SESSION["ACCESS"] == "ADMIN"){
            $tablebuttnon = "<td class='ActionTABLE' id='".$result3["RoomID"]."'>
                <button class='Deletebtn' onclick='DELETION(this)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg>
                </button>
            </td>";
        }else{
            $tablebuttnon = "";
        }
        $table5 .= "
            <tr>
                <td>".$result3["RoomNum"]."</td>
                <td>".$result3["RoomType"]."</td>
                <td>".$result3["Status"]."</td>
                <td style='text-align: center;'>".$result3["DT"]."</td>
                $tablebuttnon
            </tr>
                ";
        }

    if (mysqli_num_rows($querynum3) == 0) {
        $table5 = "     <tr>
            <td colspan='5' style='text-align:center; font-weight:bolder;'>No data </td>
        </tr> ";
    }
    echo $table5;
?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

<script>
    const SEARCHITEMINPUT = document.getElementById("SEARCHITEMINPUT");
    const mainquery = `SELECT a.*, d.*, if(d.Status1 IS NULL, 'Available', d.Status1) AS Status FROM rooms a 
    LEFT JOIN (SELECT  b.*, IF(c.ReservationStatus IS NULL, 'Available', c.ReservationStatus) AS Status1, CONCAT(c.CheckInDate, ' to ', c.CheckOutDate) AS DT FROM roomsreservation b LEFT JOIN reservations c ON b.greservationID = c.ReservationID  WHERE CURDATE() BETWEEN c.CheckInDate AND c.CheckOutDate) d ON a.RoomNum = d.Room_num
    WHERE [CONDITION]
    ORDER BY a.RoomID;;
        ;
    `
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')


    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","ROOMSLOGIC","&Process=Reset")
        if(SEARCHITEMINPUT){
            SEARCHITEMINPUT.value = "";
        }



        TBODYELEMENT.innerHTML = Tabledata
    }

    async function FILTERING(){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Room Status</label>
                <select class='SWALinput swalselect' id='swal-input1' aria-label='Floating label select example'>
                    <option value="-">-</option>
                    <option value='Available'>Available</option>
                    <option value='BOOKED'>Booked</option>
                    <option value='Checked in'>Checked in</option>
                    <option value='Checked out'>Checked out</option>
                </select>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Room Type</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value="-">-</option>
                    <option value='Superior Room'>Superior Room</option>
                    <option value='Standard Room'>Standard Room</option>
                    <option value='Family Room'>Family Room</option>
                    <option value='Barkada Room'>Barkada Room</option>
                </select>
            </div>
 

        </div>`

        let formValues =await POPUPCREATE("Filters",design,2)

        if (formValues) {
            let conditions = [];

            if(formValues[0] !== "-"){
                conditions.push(`if(d.Status1 IS NULL, 'Available', d.Status1) =  '${formValues[0]}'`);
            }
            if(formValues[1] !== "-"){
                conditions.push(`a.RoomType = '${formValues[1]}'`);
            }


            const joinedString = conditions.join(' AND ');
            const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);

            console.log(formattedText)
            const Tabledata =await AjaxSendv3(formattedText,"ROOMSLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }

    async function DELETION(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[0].innerHTML
        let targetname1 = e.parentNode.parentNode.cells[1].innerHTML

        Swal.fire({
            title: `Remove Room ${targetname} ${targetname1}?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then(async (result) => {
           
            if (result.isConfirmed) {
                let sqlcode = `DELETE FROM rooms WHERE RoomNum ='${targetname}';`
                console.log(sqlcode)
                //call for AjaxsSendv3
                const Tabledata = await AjaxSendv3(sqlcode,"ROOMSLOGIC","&Process=DeleteUpdate")
                TBODYELEMENT.innerHTML = Tabledata
                SweetSuccess()
            }

        })
    }

    async function ADDROOM(){

        const rowCount = (TBODYELEMENT.rows.length )+1;
        console.log(rowCount)

        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Room No.</label>
                <input type ="text" id="swal-input1" class="SWALinput" required readonly value='${rowCount}'>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Room Type</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value='Superior Room' selected>Superior Room</option>
                    <option value='Standard Room'>Standard Room</option>
                    <option value='Family Room'>Family Room</option>
                    <option value='Barkada Room'>Barkada Room</option>
                </select>
            </div>
 

        </div>`

        let formValues =await POPUPCREATE("Add New Room",design,2)

        if (formValues) {
            let formattedText =  `INSERT INTO rooms (RoomNum, RoomType) VALUES ( '${formValues[0]}', '${formValues[1]}');`
            const Tabledata =await AjaxSendv3(formattedText,"ROOMSLOGIC","&Process=AccessUpdate")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
</script>