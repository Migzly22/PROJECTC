<?php
    require("../Database.php");
    session_start();
    ob_start();

    $usertoken = !isset($_SESSION["USERID"]) ?  null : $_SESSION["USERID"];
    $linksref = !isset($_SESSION["USERID"]) ?  "./login.php" : "./booking.php";


    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        header("Location: ./index.php");
        ob_end_flush();
        exit;
    }


    $cin = isset($_GET["cin"]) ? $_GET["cin"] : "" ;
    $cout = isset($_GET["cout"]) ? $_GET["cout"] : "" ;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliJosh Resort & Event</title>

    <link rel="stylesheet" href="./CSS/Admin12.css">
    <link rel="stylesheet" href="./CSS/Table.css">
    <link rel="stylesheet" href="./CSS/style34.css">

    <link href="./CSS/style.scss" rel="stylesheet/scss" type="text/css">

    <script src="./JS/script1.js" defer></script>
    <script src="./Calendar/app.js" defer></script>

        <!--SweetAlert-->
        <script src="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <!--Jquery-->
        <script src="../Jquery/node_modules/jquery/dist/jquery.js"></script>
        <script src="../Jquery/node_modules/jquery/dist/jquery.min.js"></script>
    
             
</head>
<body>
    <nav class="Mainnavigation glassylink">
        <ul class="smoothmenu">
            <li class="creator">
                <a href="./index.php#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="./booking.php#COTTAGES" class="textkainit">COTTAGES</a>
            </li>
            <li>
                <a href="./booking.php#ROOMS" class="textkainit">ROOMS</a>
            </li>
            <li>
                <a href="./booking.php#EVENTPLACE" class="textkainit">EVENTPLACE</a>
            </li>
            <li>
                <a href="./booking.php#EXPENDITURES" class="textkainit">EXPENDITURES</a>
            </li>
        </ul>
        <div class="USERVALUE USERVALUE2 dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
            <ul class="dropdown-menu">
                <li><a href="#">Account</a></li>
                <li><a href="#">Booking Information</a></li>
                <li><a href="./logOut.php">Logout</a></li>
            </ul>
        </div>
    </nav>


    <section class="BOOKINGSECTION about top" id="ABOUT" style="padding-bottom: 2em;">
        <section class="mainbodycontainer" id="EXPENDITURES">
            <div class="classHeader">
            </div>
            <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                <div class="box">
                    <div class="credentialinfo">
                        <div class="form-column">
                            <label for="Checkin">Checkin</label>
                            <input type="date" name="Checkin" id="Checkin" value="<?php  echo $cin;?>">
                        </div>
                        <div class="form-column">
                            <label for="Checkout">Checkout</label>
                            <input type="date" name="Checkout" id="Checkout" value="<?php echo $cout;?>">
                        </div>
                        <div class="form-column">
                            <label for="noAdult">No of Adults</label>
                            <input type="number" name="noAdult" id="noAdult" value="1" onchange="changeTotalGuess()">
                        </div>
                        <div class="form-column">
                            <label for="noKid">No. of Kids</label>
                            <input type="number" name="noKid" id="noKid" value="0" onchange="changeTotalGuess()">
                        </div>
                        <div class="form-column">
                            <label for="noSenior">No of Seniors</label>
                            <input type="number" name="noSenior" id="noSenior" value="0" onchange="changeTotalGuess()">
                        </div>
                        <div class="form-column">
                            <label for="noSenior">Time</label>
                            <select name="TND" id="TND" onchange="ResetFilter()">
                                <option value="DAY">Day Time (8:00 AM - 5:00 PM)</option>
                                <option value="NIGHT">Night Time (7:00 PM - 7:00 AM)</option>
                                <option value="WHOLE">22 Hrs (2:00 PM - 12:00 PM)</option>
                            </select>
                        </div>
                    </div>
                    <div class="buttonclass">
                        <div style="text-align: center;margin-bottom:1em;">
                            <input type="button" value="Proceed" class="submitbtn addbtn" onclick="Proceed()">
                        </div>
                        <div style="text-align: center;margin-bottom:1em;">
                            <input type="button" value="Expenditures" class="submitbtn addbtn" onclick="SHOWNHIDE()">
                        </div>
                    </div>
                    <div class="box2 specialboxjquery">
                        <div>
                            <h3>-List of Expenditures-</h3>
                        </div>
                        <table class="table" style="border-collapse: collapse;">
                            <thead>
                                <tr></tr>
                                    <th scope='col'></th>
                                    <th scope='col' style='text-align:center;'>Price</th>
                                    <th scope='col' style='text-align:center;'>Quantity</th>

                                    <th scope='col' style='text-align:center;'>Total</th>
                                    <th scope='col' style='text-align:center;'>Action</th>
                                </tr>
                            </thead>

                            <tbody id="TBODY">




                            </tbody>
                        </table>
                    </div>

                   
                </div>
                
            </form>
            
        </section>
        <div id="CHOICEBODY">
            <section class="mainbodycontainer contianermain2" id="COTTAGES">
                <h1>-Cottages-</h1>
                <div class="SOitemlist" id="SOITEMList">
                <?php
                                $sqlcottage = "SELECT *, CONCAT(MinPersons, ' - ', MaxPersons) as Counthead,
                                IF(MaxPersons>= 1, 'YES', 'NO') as Suggested
                                FROM cottagetypes;";
                                $query1 = mysqli_query($conn, $sqlcottage);
                                $datainsertedCottages = "";

                                $recommend = " <div class='Recommentd'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z'/></svg>
                            </div>";


                                $recochoice = 0;
                                while ($result = mysqli_fetch_assoc($query1)) {

                                    $recohandler = "";
                                    if($result["Suggested"] == "YES" && $recochoice == 0){
                                        $recohandler = $recommend;
                                        $recochoice++;
                                    }
                                    $datainsertedCottages .= "
                                    <div class='SO-item'>
                                        <input type='checkbox' id='".$result["ServiceTypeName"]."' value='".$result['ServiceTypeName']."||".$result['ServiceTypeID']."||".$result['DayPrice']."||".$result['NightPrice']."||".$result['NightPrice']."' name='SOItemSelect'>
                                        <div class='addtocart2' onclick='activateClick(`".$result["ServiceTypeName"]."`)'>
                                            <img src='./Images/c1.jpg' alt=''>
                                            <div class='textareapart'>
                                                <h2>".$result["ServiceTypeName"]."</h2>
                                                <div class='smallinfos'>
                                                    <small>Day Price : ₱ ".$result["DayPrice"]."</small>
                                                    <small>Night Price : ₱ ".$result["NightPrice"]."</small>
                                                </div>
                                            </div>
                                            $recohandler
                                        </div>
                                    </div>";

                                    
                                }
                                echo $datainsertedCottages;

                            ?>
                    
                </div>
            </section>
            <section class="mainbodycontainer contianermain2" id="ROOMS">
                <h1>-Rooms-</h1>
                <div class="SOitemlist" id="SOITEMList">

                <?php
                    $sqlcottage = "SELECT * ,CONCAT(MinPeople, ' - ', MaxPeople) as Counthead,
                    IF(MaxPeople>= 1, 'YES', 'NO') as Suggested FROM roomtypes;";
                    $query1 = mysqli_query($conn, $sqlcottage);
                    $datainsertedCottages = "";

                    $recommend = " <div class='Recommentd'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z'/></svg>
                </div>";


                    $recochoice = 0;
                    while ($result = mysqli_fetch_assoc($query1)) {

                        $recohandler = "";
                        if($result["Suggested"] == "YES" && $recochoice == 0){
                            $recohandler = $recommend;
                            $recochoice++;
                        }
                        $datainsertedCottages .= "
                            <div class='SO-item'>
                                <input type='checkbox' id='".$result["RoomType"]."' value='".$result['RoomType']."||".$result['id']."||".$result['DayTimePrice']."||".$result['NightTimePrice']."||".$result['Hours22']."' name='SOItemSelect'>
                                <div class='addtocart2' onclick='activateClick(`".$result["RoomType"]."`)'>
                                    <img src='./Images/c1.jpg' alt=''>
                                    <div class='textareapart'>
                                        <h2>".$result["RoomType"]."</h2>
                                        <div class='smallinfos'>
                                            <small>Day Price : ₱ ".$result["DayTimePrice"]."</small>
                                            <small>Night Price : ₱ ".$result["NightTimePrice"]."</small>
                                        </div>
                                    </div>
                                    $recohandler
                                </div>
                            </div>";
                    }
                    echo $datainsertedCottages;

                ?>

                </div>
            </section>
            <section class="mainbodycontainer contianermain2" id="EVENTPLACE">
                <h1>-Event Place-</h1>
                <div class="SOitemlist" id="SOITEMList">
                <?php
                    $sqlcottage = "SELECT * FROM eventplace WHERE PAX >= 1 LIMIT 1;";
                    $query1 = mysqli_query($conn, $sqlcottage);
                    $result = mysqli_fetch_assoc($query1);
                    
                    echo "
                    <div class='SO-item'>
                        <input type='checkbox' id='Pavilion' value='Pavilion||".$result['Evntid']."||".$result['Pavilion']."||".$result['Pavilion']."||".$result['Pavilion']."' name='SOItemSelect'>
                        <div class='addtocart2' onclick='activateClick(`Pavilion`)'>
                            <img src='./Images/c1.jpg' alt=''>
                            <div class='textareapart'>
                                <h2>Pavilion</h2>
                                <div class='smallinfos'>
                                    <small>Max Pax : ".$result["PAX"]."</small>
                                    <small>Price : ₱ ".$result["Pavilion"]."</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='SO-item'>
                        <input type='checkbox' id='Grand Pavilion' value='Grand Pavilion||".$result['Evntid']."||".$result['Grand Pavilion']."||".$result['Grand Pavilion']."||".$result['Grand Pavilion']."' name='SOItemSelect'>
                        <div class='addtocart2' onclick='activateClick(`Grand Pavilion`)'>
                            <img src='./Images/c1.jpg' alt=''>
                            <div class='textareapart'>
                                <h2>Grand Pavilion</h2>
                                <div class='smallinfos'>
                                    <small>Max Pax : ".$result["PAX"]."</small>
                                    <small>Price : ₱ ".$result["Grand Pavilion"]."</small>
                                </div>
                            </div>
                        </div>
                    </div>";
                ?>
                </div>
            </section>

        </div>

    </section>



    <script>
        // Get references to all input elements with the class "input-box"
        const inputElements = document.querySelectorAll("input[type='number']");
        
        // Add event listeners to all selected input elements
        inputElements.forEach(input => {
            input.addEventListener("input", function() {
                // Parse the input value as a number
                const value = parseFloat(input.value);
                
                // Check if the value is less than 0
                if (value < 0) {
                    // Set the value to 0
                    input.value = 0;
                }
            });
        });
    </script>

    <script>
        function activateClick(checkboxId) {
            // Find the checkbox element by its ID
     
            var checkbox234 = document.getElementById(checkboxId);

            if(!checkbox234.checked){
                checkbox234.click()
            }else{
                checkbox234.click()
            }
            

        }
    </script>
<script>

    let checkboxes = document.querySelectorAll('input[name="SOItemSelect"]');
    let CheckItemsinbox = {}
    let lastCheckedCheckbox = null;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("click", function(event) {
            const checkedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
            const checkedValues = checkedCheckboxes.map(cb => cb.value);
            CheckItemsinbox = checkedValues

            if (event.target.checked) {
                
                if (CheckItemsinbox.includes(event.target.value)) {
                    lastCheckedCheckbox = event.target;
                }
            } else {
                let idname = event.target.value.split("||")[1]                
                const targetedTDid = document.getElementById(idname)

                targetedTDid.parentElement.remove()

            }
            ONUPDATE()
        });
    });


    function ListReset(){
        //to reset the hidden box
        const hiddenLabels = document.querySelectorAll('.SO-item[style="display: none;"]');
        hiddenLabels.forEach(label => {
            label.style.display = "block";
        });
    }
    async function ResetFilter(){
        await SweetSuccess("Reset")

        ListReset()
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        CheckItemsinbox = {}
        ONUPDATE()


    }

    ONUPDATE()
    function ONUPDATE(){
        data = ""
        if (Object.keys(CheckItemsinbox).length === 0) {
            data = `<tr><td style="text-align: center;" colspan="6">No Data</td></tr>`
            totalpayment = "0.00"
            $('#TBODY').html(data);
        } else {
            if(lastCheckedCheckbox !== null){
                let [name, STID, dayp,nightp, wholep] = lastCheckedCheckbox.value.split("||")

                let containerrows = `
                            <tr>
                                <td scope='row' id="${STID}" >${name}</td>
                                <td scope='row' style='text-align:end'>${dayp}</td>
                                <td scope='row' style='text-align:center'>
                                    <input type="number" name="" id="" value ="1" class="Inputnumbercss" onchange="Inputnum(this)">
                                </td>
    
                                <td scope='row' style='text-align:end'>
                                    ${dayp}
                                </td>
                                <td scope='row' style='display:flex;justify-content:center;'>
                                    <button onclick='Deletebtn(this,"${name}||${STID}||${dayp}||${nightp}||${wholep}")' class='Deletebtn'>
                                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z'/></svg>
                                    </button>
                                </td>
                            </tr>
                            `

                data = containerrows

                if (Object.keys(CheckItemsinbox).length === 1) {
                    $('#TBODY').html(null);
                }
            }

            $('#TBODY').append(data);
            lastCheckedCheckbox = null
        }


    }

    function Deletebtn(data,value12){
  
            let Rowparent = data.parentElement.parentElement
            Rowparent.id = "TOBEDELETED"
        
        
        
        const checkbox = document.querySelector(`input[value="${value12}"]`);
        const TOBEDELETED = document.getElementById('TOBEDELETED')

        console.log(checkbox)
        if (checkbox) {
        
            checkbox.checked = false; 
            //reset the value in correctform
            checkboxes.forEach(checkbox => {
                const checkedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
                const checkedValues = checkedCheckboxes.map(cb => cb.value);
                CheckItemsinbox = checkedValues
            });
        }

        if (TOBEDELETED) {
            TOBEDELETED.remove();
        }

        ONUPDATE()
    }

    function Inputnum(data){
        let targetrow = data.parentElement.parentElement

        if(parseFloat(data.value) > 4){
            data.value = 4
            let product = parseFloat(targetrow.cells[1].innerText)* parseFloat(data.value) 
            targetrow.cells[3].innerText = parseFloat(product).toFixed(2)
        }

        if(parseFloat(data.value) > 0){
            let product = parseFloat(targetrow.cells[1].innerText)* parseFloat(data.value) 
            targetrow.cells[3].innerText = parseFloat(product).toFixed(2)
        }else{
            data.value = 1
            targetrow.cells[3].innerText = targetrow.cells[1].innerText
        }
    }

    const TBODY = document.getElementById('TBODY')



    async function SavingData(id,gid){
        let rows = TBODY.rows;

        //setting up the objectdata
        for (let i = 0; i < rows.length; i++) {
            let targetKey = rows[i].cells[0].innerText
            let Price = rows[i].cells[1].innerText
            let Quantity = rows[i].cells[2].children[0].value
            let Totalnum = rows[i].cells[3].innerText

            console.log(targetKey,Price,Quantity,Totalnum)

            let sqlcode = `INSERT INTO guestextracharges (ReservationID,ChargeDescription, quantity, ChargeAmount, ChargeDate) VALUES ('${id}','${targetKey}', '${Quantity}', '${Totalnum}', CURRENT_DATE);`;
            await AjaxSendv3(sqlcode,"GUESTLOGIC",`&Process=Insertmore`)
        }

        await Swal.fire(
            '',
            'Inserted Successfully!',
            'success'
        )

        location.href = `./Mainpage.php?nzlz=reservationview&plk=2&ISU=${gid}`
    }

    async function changeTotalGuess() {
        
        //ResetFilter()
        const checkedCheckboxes1 = Array.from(checkboxes).filter(cb => cb.checked);
        const checkedValues1 = checkedCheckboxes1.map(cb => cb.value);


        let adultnum = document.getElementById("noAdult").value
        let kidnum = document.getElementById("noKid").value
        let seniornum = document.getElementById("noSenior").value

        let sum = parseInt(adultnum)+parseInt(kidnum)+parseInt(seniornum)

        const Tabledata =await AjaxSendv3(sum,"BOOKINGLOGIC")

        const CHOICEBODY = document.getElementById("CHOICEBODY")
        CHOICEBODY.innerHTML = Tabledata

        checkboxes = document.querySelectorAll('input[name="SOItemSelect"]');
        
        checkboxes.forEach(cb => {
            // Check the checkbox if its value is in the array of checked values
            cb.checked = checkedValues1.includes(cb.value);
        });

        checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function(event) {

            const checkedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
            const checkedValues = checkedCheckboxes.map(cb => cb.value);
            CheckItemsinbox = checkedValues

            if (event.target.checked) {
                if (CheckItemsinbox.includes(event.target.value)) {
                    lastCheckedCheckbox = event.target;
                }
            }else {
                let idname = event.target.value.split("||")[1]                
                const targetedTDid = document.getElementById(idname)

                targetedTDid.parentElement.remove()

            }
            ONUPDATE()
        });
    });
    }

    function SHOWNHIDE() {
        const specialboxjquery =$(".specialboxjquery")


        // Toggle the visibility of the element
        specialboxjquery.slideToggle();

        // Optionally, you can display an alert based on the current state
        if (specialboxjquery.is(":visible")) {
            specialboxjquery.show()
        } else {
            specialboxjquery.hide()
        }

    }

    function Proceed(){
        location.href = "../Admins/Composer/mystripe.php";
    }   
</script>

</body>
</html>