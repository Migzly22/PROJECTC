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

  <link rel="stylesheet" href="./CSS/settingsv3v22.css">


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
                <a href="./index.php#ABOUT" class="textkainit">ABOUT</a>
            </li>
            <li>
                <a href="./index.php#TOUR" class="textkainit">TOUR</a>
            </li>
            <li>
                <a href="./index.php#SERVICE" class="textkainit">SERVICES</a>
            </li>
            <li>
                <a href="./index.php#CONTACT" class="textkainit">CONTACT</a>
            </li>
            <li class=" dropdown">
                <a href="#" class="textkainit">ACCOUNT</a>

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

    $guesttotalnumber = $_GET['na']+$_GET['nk']+$_GET['ns']
?>
  <main>
    <section class="mainbody" style="padding: 1em 3em;">
      <div class="box">
        <header>
          <h1 class="text-center">Booking Information</h1>
        </header>
        <p>Checkin Date</p>
        <div class="textshowinputs">
          <b>
            <?php echo $_GET['cin']; ?>
          </b>
   
        </div>
        <p>Time Range</p>
        <div class="textshowinputs">
          <b>
            
            <?php echo $timevalue; ?>
          </b>
        </div>
        <p>Packages</p>
        <div class="textshowinputs">
          <b>
            <?php echo $pacvalue; ?>
          </b>
    
        </div>
        <p>No. of Paxs</p>
        <div class="textshowinputs">
          <b>
            <?php echo $guesttotalnumber; ?>
          </b>
    
        </div>
        <h1>Total</h1>
        <div class="textshowinputs">
          <h1>
            <b>
              ₱ <span id="TOTALINIT"><?php echo $_GET['tinit'];?>
            </b>
          </h1>
          
    
        </div>
  
      </div>
      <form action="" class="form" method="post" id="REGFORM">
        <header style="display: flex;flex-wrap:wrap;justify-content:space-between;align-items:center;">
          <h1 class="text-center">Cottages </h1> 

        </header>

        <div class="SOitemlist" id="SOITEMList">
                <?php
                                $sqlcottage = "SELECT a.*,f.*
                                FROM eventpav a 
                                LEFT JOIN (
                                    SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate 
                                    FROM eventreservation d 
                                    LEFT JOIN reservations e ON d.reservationID = e.ReservationID 
                                    WHERE e.CheckInDate = '".$_GET['cin']."' AND (e.timapackage = '".$_GET['tRANGE']."' OR e.timapackage = '22Hrs')
                                ) f ON a.Pavtype = f.eventname 
                                WHERE f.e_ID IS NULL AND a.MaxPax >= '50';";
                                $query1 = mysqli_query($conn, $sqlcottage);
                                $datainsertedCottages = "";

                                $recochoice = 0;
                                while ($result = mysqli_fetch_assoc($query1)) {
                                  $sqlqueryforprices = mysqli_query($conn, "SELECT `".$result["Pavtype"]."` FROM eventplace WHERE PAX >= '$guesttotalnumber' ORDER BY PAX ASC LIMIT 1;");
                                  $pavprice = mysqli_fetch_assoc($sqlqueryforprices);
                                    $datainsertedCottages .= "
                                      <div class='SO-item'>
                                          <input type='checkbox' id='".$result["Pavtype"]."' value='".$result["Pavtype"]."-1-".$pavprice[$result["Pavtype"]]."-".$result['MaxPax']."' name='SOItemSelect'>
                                          <div class='addtocart2' onclick='activateClick(`".$result["Pavtype"]."`)'>
                                              <img src='./RoomsEtcImg/Pavilion/".$result['Pavtype'].".jpg' alt=''>
                                              <div class='textareapart'>
                                                  <h2>".$result["Pavtype"]."</h2>
                                                  <div class='smallinfos'>
                                                      <small>Good for ".$result["MinPax"]." - ".$result["MaxPax"]." people</small>
                                                      <small>Price ".$pavprice[$result["Pavtype"]]."</small>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class='spawnerbtn' style='display: flex;justify-content: center;padding:0.5em 1em;'>
                                            <button type='button' class='ADDMEBTN' onclick='activateClick(this,`".$result["Pavtype"]."`)'>Add To List</button>
                                          </div>
                                      </div>";
                                }
                                echo $datainsertedCottages;
                                if(mysqli_num_rows($query1) <= 0){
                                  echo "<div style='width: 300px;background:#C1B086;padding:1em;border-radius:10px;text-align:center;color:#fff;'>
                                    NO AVAILABLE PAVILION
                                  </div>";
                              }
                            ?>
                </div>

                <div class="specials123" style="display: flex;justify-content: center;margin-top:1.5em;">
          <button type="submit" >Continue</button>
        </div>

      </form>
    </section>
  </main>
  <script>
        function activateClick(e, checkboxId) {
            // Find the checkbox element by its ID

            if (e.classList[0] === 'ADDMEBTN'){
                e.classList.remove('ADDMEBTN')
                e.classList.add('REMOVEMEBTN')
                e.innerText = "Remove to List"
            }else{
                e.classList.add('ADDMEBTN')
                e.classList.remove('REMOVEMEBTN')
                e.innerText = "Add to List"
            }
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
                    max : arrval[3]
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
          let basesum = <?php echo $_GET['tinit'];?>;

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
              text: "Pick a Pavilion First",
              icon: "info"
            });
            return;
          }

          let totalnumperson = 0;
          for (let key in datacontainer) {
            if (datacontainer.hasOwnProperty(key)) {
              // Convert the price to a number and add it to the total
              totalnumperson += parseFloat(datacontainer[key].max);
            }
          }
          let clientstotalnumber = parseInt(`<?php echo $guesttotalnumber; ?>`)
          console.log(totalnumperson)
          if(totalnumperson < clientstotalnumber){
            await Swal.fire({
              text: "The max people in the Pavilion is less than the guest numbers",
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


          location.href = `./addonrooms.php?cin=<?php echo $_GET["cin"];?>&ETIME=<?php echo $_GET["ETIME"];?>&package=<?php echo $_GET["package"];?>&tRANGE=<?php echo $_GET["tRANGE"];?>&na=<?php echo $_GET["na"];?>&nk=<?php echo $_GET["nk"];?>&ns=<?php echo $_GET["ns"];?>&tinit=${TOTALINIT}&eventlist=${stringedJSON}`;


        })
    </script>

</body>

</html>
