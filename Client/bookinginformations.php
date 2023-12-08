<?php
    require("./Database.php");
    session_start();
    ob_start();

    error_reporting(E_ERROR | E_PARSE);

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


    <link rel="stylesheet" href="./CSS/Table.css">
    <link rel="stylesheet" href="./CSS/Admin12.css">
    
    <link rel="stylesheet" href="./CSS/styleformsettingclient.css">

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
                <a href="./index2.php#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="./index2.php#ABOUT" class="textkainit">ABOUT</a>
            </li>
            <li>
                <a href="./index2.php#TOUR" class="textkainit">TOUR</a>
            </li>
            <li>
                <a href="./index2.php#SERVICE" class="textkainit">SERVICES</a>
            </li>
            <li>
                <a href="./index2.php#CONTACT" class="textkainit">CONTACT</a>
            </li>
            <li class=" dropdown">
                <a href="<?php echo $linksref;?>" class="textkainit">ACCOUNT</a>

                <ul class="dropdown-menu">
                <?php  
                    if($usertoken != null){
                ?>

                    <li><a href="./InsideMain.php">Account Settings</a></li>
                    <?php
                        if($_SESSION["ACCESS"] != "CLIENT"){
                    ?>
                        <li><a href="../Admins/Mainpage.php">Admin</a></li>
                    <?php
                        }
                    ?>
                    <li><a href="./bookinginformations.php">Booking Information</a></li>
                    <li><a href="./logOut.php">Logout</a></li>

                <?php  
                    }else{
                ?>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./Registration.php">Register now</a></li>
                <?php  
                    }
                ?>
                </ul>
            </li>
        </ul>
  </nav>


    <main>
        <section class="mainbody" style="padding: 1em 3em;">
        <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>My Reservations</h1>
                    <button class="addbtn" onclick="ADDBOOKING()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                    </button>
                </div>
                <div class="SEARCHANDFILTRATION">
                    <div class="box">
                            <button class="Editbtn" onclick="FILTERING(`<?php echo $_SESSION['USERID']; ?>`)">
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
                                    <th scope='col' style="text-align: center;">Reservation</th>
                                    <th scope='col' style="text-align: center;">Checkout</th>
                                    <th scope='col' style="text-align: center;">Price</th>
                                    <th scope='col' style="text-align: center;">Downpament</th>
                                    <th scope='col' style="text-align: center;">Status</th>
                                    <th scope='col' style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="TBODYELEMENT">
<?php
    $sqlbooking = "SELECT  a.*, b.*, IF(b.Description = 'Pending', 'Pending', 'Done') AS STATUSHEHE FROM reservations a LEFT JOIN guestpayments b ON a.ReservationID = b.ReservationID WHERE a.UserID = '".$_SESSION["USERID"]."' AND b.Description is NOT NULL ORDER BY a.ReservationID DESC;";
    $querybooking = mysqli_query($conn,$sqlbooking);
    $tbodydata = "";
    while ($result = mysqli_fetch_assoc($querybooking)) {
        # code...
        $tbodydata .= "
            <tr>
                <td scope='col' style='text-align: center;'>".$result['CheckInDate']."</td>
                <td scope='col' style='text-align: center;'>".$result['CheckOutDate']."</td>
                <td scope='col' style='text-align: end;'>".$result['TotalPrice']."</td>
                <td scope='col' style='text-align: end;'>".$result['Downpayment']."</td>
                <td scope='col' style='text-align: center;'>".$result['STATUSHEHE']."</td>
                <td class='ActionTABLE' id='".$result['ReservationID']."'>
                    <button class='addbtn' onclick='PRINT(`".$result['ReservationID']."`)'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z'/></svg>
                    </button>
                </td>
            </tr>
        ";
    }
    if (mysqli_num_rows($querybooking) == 0) {
        $tbodydata = "     <tr>
            <td colspan='6' style='text-align:center; font-weight:bolder;'>No data </td>
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


        </section>

    </main>

<script>
        function NORETURN(e){
             // Get the <a> tag element inside the clicked <li>
            const anchorElement = e.querySelector('a');
            
            // Check if the <a> tag element exists
            if (anchorElement) {
                // Trigger a click event on the <a> tag
                anchorElement.click();
            }
        }

        function ADDBOOKING(){
            location.href = "./booking.php"
        }
</script>

<script>
    const mainquery = `SELECT  a.*, b.*, IF(b.Description = 'Pending', 'Pending', 'Done') AS STATUSHEHE FROM reservations a LEFT JOIN guestpayments b ON a.ReservationID = b.ReservationID WHERE [CONDITION] ORDER BY a.ReservationID DESC;`
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')

    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","BINFOLOGIC","&Process=Reset")  
        console.log(Tabledata)
        TBODYELEMENT.innerHTML = Tabledata
    }

    async function FILTERING(e){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Check in</label>
                <input type ="date" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Check out</label>
                <input type ="date" id="swal-input2" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Payment Status</label>
                <select class='SWALinput swalselect' id='swal-input3' aria-label='Floating label select example'>
                    <option value="-">-</option>
                    <option value='Done'>Done</option>
                    <option value='Pending'>Pending</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Filters",design,3)

        if (formValues) {
            let conditions = [`a.UserID = '${e}'`, "b.Description is NOT NULL"];

            if(formValues[0] !== ""){
                conditions.push(`
                    a.CheckInDate  <= '${formValues[0]}'
                `);
            }
            if(formValues[1] !== ""){
                conditions.push(`
                    a.CheckOutDate  >= '${formValues[1]}'
                `);
            }
            if(formValues[2] !== "-"){
                conditions.push(`IF(b.Description = 'Pending', 'Pending', 'Done') = '${formValues[2]}'`)
            }

            const joinedString = conditions.join(' AND ');
            const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);

            console.log(formattedText)

            const Tabledata =await AjaxSendv3(formattedText,"BINFOLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
    
    async function PRINT(e){
        console.log(e)
        location.href = `../Admins/Composer/docxphp2.php?id=${e}`
    }

</script>





</body>
</html>