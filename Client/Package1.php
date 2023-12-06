<?php
require("./Database.php");
session_start();
ob_start();

$usertoken = !isset($_SESSION["USERID"]) ?  null : $_SESSION["USERID"];
$linksref = !isset($_SESSION["USERID"]) ?  "./Registration.php" : "./breakdownv2.php";

//error_reporting(E_ERROR | E_PARSE);
$pacvalue = "";
$timevalue = "";

switch ($_GET['package']) {
  case 'Package1':
    $pacvalue = "Swimming Only";
    break;
  case 'Package2':
    $pacvalue = "Rooms + Swimming";
    break;
  case 'Package3':
    $pacvalue = "Pavilions";
    break;
}

switch ($_GET['tRANGE']) {
  case 'Day':
    $timevalue = "8:00 - 17: 00";
    break;
  case 'Night':
    $timevalue = "19:00 - 7: 00";
    break;
  case '22Hrs':
    $timevalue = "14:00 - 12: 00";
    break;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EliJosh Resort & Event</title>


  <link rel="stylesheet" href="./CSS/Table.css">
  <link rel="stylesheet" href="./CSS/Admin12.css">

  <link rel="stylesheet" href="./CSS/settings.css">

  <link rel="stylesheet" href="./CSS/style343v2.css">

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
                <a href="#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="#ABOUT" class="textkainit">ABOUT</a>
            </li>
            <li>
                <a href="#TOUR" class="textkainit">TOUR</a>
            </li>
            <li>
                <a href="#SERVICE" class="textkainit">SERVICES</a>
            </li>
            <li>
                <a href="#CONTACT" class="textkainit">CONTACT</a>
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



<?php
    $dateTime = new DateTime($_GET['cin']);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');

    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($_GET['cin']));



    if($dayOfWeekNumber <= 4){
        $columnstring = "Weekdays".$_GET['tRANGE']."Price";
    }else{
        $columnstring = "WeekendsHolidays".$_GET['tRANGE']."Price";
    }


    $sql1 = "SELECT * FROM poolrate ORDER BY RateID ASC;";
    $sql1query = mysqli_query($conn, $sql1);
    $entrance = array();

    while ($result = mysqli_fetch_assoc($sql1query)) {
      $entrance[] = $result[$columnstring];
    }

?>
  <main>
    <section class="mainbody" style="padding: 1em 3em;">
      <div class="box">
        <header>
          <h1 class="text-center">Booking Information</h1>
        </header>
        <table style="padding-left: 2em;">
            <tr>
              <td><b> Checkin Date</b> </td>
              <td><b>:</b></td>
              <td><?php echo $_GET["cin"]; ?></td>
            </tr>
            <tr>
              <td><b>Time Range</b></td>
              <td><b>:</b></td>
              <td><?php echo $timevalue; ?></td>
            </tr>
            <tr>
              <td><b>Packages</b></td>
              <td><b>:</b></td>
              <td><?php echo $pacvalue; ?></td>
            </tr>
            <tr>
              <td><b>No. of Paxs</b></td>
              <td><b>:</b></td>
              <td><?php echo $_GET['na']+$_GET['nk']+$_GET['ns']; ?></td>
            </tr>
        </table>
      </div>
      <form action="" class="form" method="post" id="REGFORM">
        <header style="display: flex;flex-wrap:wrap;justify-content:space-between;align-items:center;">
          <h1 class="text-center">Cottages </h1> 

        </header>

        <div class="SOitemlist" id="SOITEMList">
                <?php
                                $sqlcottage = "SELECT b.*, CONCAT(b.CottageType, '-', b.Cottagenum) AS cottagename,d.* ,c.* FROM cottage b 
                                LEFT JOIN cottagetypes d ON b.CottageType = d.ServiceTypeName LEFT JOIN cottagereservation c ON b.Cottagenum = c.cottagenum 
                                LEFT JOIN reservations a ON c.reservationID = a.ReservationID AND a.CheckInDate = '".$_GET['cin']."' AND a.timapackage = '".$_GET['tRANGE']."' 
                                WHERE c.cr_id IS NULL;";

                                $query1 = mysqli_query($conn, $sqlcottage);
                                $datainsertedCottages = "";

                                $recommend = " <div class='Recommentd'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z'/></svg>
                            </div>";


                                $recochoice = 0;
                                while ($result = mysqli_fetch_assoc($query1)) {
                                    if($_GET['tRANGE'] == "22Hrs"){
                                      $pricename = "NightPrice";
                                    }else{
                                      $pricename = $_GET['tRANGE']."Price";
                                    }
                                    $datainsertedCottages .= "
                                      <div class='SO-item'>
                                          <input type='checkbox' id='".$result["cottagename"]."' value='".$result["cottagename"]."-".$result[$pricename]."' name='SOItemSelect'>
                                          <div class='addtocart2' onclick='activateClick(`".$result["ServiceTypeName"]."`)'>
                                              <img src='./RoomsEtcImg/Cottages/".$result['ServiceTypeName'].".jpg' alt=''>
                                              <div class='textareapart'>
                                                  <h2>".$result["cottagename"]."</h2>
                                                  <div class='smallinfos'>
                                                      <small>Good for ".$result["MinPersons"]." - ".$result["MaxPersons"]." people</small>
                                                      <small>Price ".$result[$pricename]."</small>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class='specialinputcontainer' style='display: flex;justify-content: center;'>
                                            <button type='button' onclick='activateClick(`".$result["cottagename"]."`)'>Add Me</button>
                                          </div>
                                      </div>";

                                    
                                }
                                echo $datainsertedCottages;

                            ?>
                </div>
        <div class="box3">
          <h1>Total : ₱ <span id="TOTALINIT"><?php echo $entrance[0];?></span></h1>
        </div>

        <div class="specials123" style="display: flex;justify-content: center;">
          <button type="submit" >Continue</button>
        </div>

      </form>
    </section>
  </main>
  <script>
        function activateClick(checkboxId) {
            // Find the checkbox element by its ID
            var checkbox234 = document.getElementById(checkboxId);
            checkbox234.click()
        }

        var datacontainer = {}

        let checkboxes = document.querySelectorAll('input[name="SOItemSelect"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("click", function() {
                console.log(checkbox.id);

                if (checkbox.checked) {
                  let arrval = checkbox.value.split("-")
                  datacontainer[checkbox.id] = {
                    price :  arrval[2],
                    name :  arrval[0],
                    num :  arrval[1],
                  }
                  console.log(datacontainer)
                  updatePrice()
                } else {
                  delete datacontainer[checkbox.id];
                  updatePrice()
                }
            });
        });

        function updatePrice() {
          let basesum = <?php echo $entrance[0]?>;

          let total = 0 
          for (let key in datacontainer) {
            if (datacontainer.hasOwnProperty(key)) {
              // Convert the price to a number and add it to the total
              total += parseFloat(datacontainer[key].price);
            }
          }

          document.getElementById("TOTALINIT").innerText = (parseFloat(basesum)+parseFloat(total)).toFixed(2)
        }


        const REGFORM = document.getElementById('REGFORM')
        REGFORM.addEventListener('submit', async (e) => {
          console.log(123)
          e.preventDefault();

          if(Object.keys(datacontainer).length <= 0){
            await Swal.fire({
              text: "Pick a Cottage First",
              icon: "info"
            });
            return;
          }

          //location.href = `./${REGFORM.noSenior.value}.php?cin=${Checkin}&package=${REGFORM.noSenior.value}`;
          let TOTALINIT = document.getElementById('TOTALINIT').innerText.replace("Total : ₱ ", "");
          let stringedJSON = JSON.stringify(datacontainer);

          let reflink = `<?php echo $linksref;?>`;
          if(reflink.includes("Registration")){
            await Swal.fire({
              text: "You dont have an account. Please Create one",
              icon: "info"
            });
          }


          location.href = `${reflink}?cin=<?php echo $_GET["cin"];?>&package=<?php echo $_GET["package"];?>&tRANGE=<?php echo $_GET["tRANGE"];?>&na=<?php echo $_GET["na"];?>&nk=<?php echo $_GET["nk"];?>&ns=<?php echo $_GET["ns"];?>&tinit=${TOTALINIT}&cotlist=${stringedJSON}`;


        })
    </script>

</body>

</html>
