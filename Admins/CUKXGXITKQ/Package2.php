<?php
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

  <link rel="stylesheet" href="./CSS/settingsv3v22.css">


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
          <h1 class="text-center">Rooms </h1> 

        </header>

        <div class="SOitemlist" id="SOITEMList">
                <?php
                                $sqlcottage = "SELECT a.*, f.*, CONCAT(a.RoomType, '-', a.RoomNum) AS roomname, g.TOTAL FROM 
                                (SELECT b.RoomID, b.RoomNum , c.* FROM rooms b LEFT JOIN roomtypes c ON b.RoomType = c.RoomType) a
                                LEFT JOIN
                                (SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate FROM roomsreservation d LEFT JOIN reservations e ON d.greservationID = e.ReservationID 
                                WHERE e.CheckInDate = '".$_GET['cin']."' AND (e.timapackage = '".$_GET['tRANGE']."' OR e.timapackage = '22Hrs')) f ON a.RoomNum = f.Room_num 
                                LEFT JOIN 
                                (SELECT  a.RoomType, SUM(a.MaxPeople) AS TOTAL FROM (SELECT b.RoomID, b.RoomNum , c.* FROM rooms b LEFT JOIN roomtypes c ON b.RoomType = c.RoomType) a
                                LEFT JOIN
                                (SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate FROM roomsreservation d LEFT JOIN reservations e ON d.greservationID = e.ReservationID 
                                WHERE e.CheckInDate = '".$_GET['cin']."' AND (e.timapackage = '".$_GET['tRANGE']."' OR e.timapackage = '22Hrs')) f ON a.RoomNum = f.Room_num WHERE f.RR_ID IS NULL  GROUP BY a.MaxPeople) g ON a.RoomType = g.RoomType
                                WHERE f.RR_ID IS NULL AND g.TOTAL >= '$guesttotalnumber';";
                                $query1 = mysqli_query($conn, $sqlcottage);
                                $datainsertedCottages = "";

                                $recommend = " <div class='Recommentd'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z'/></svg>
                            </div>";


                                $recochoice = 0;
                                while ($result = mysqli_fetch_assoc($query1)) {

                                    if($_GET['tRANGE'] == "22Hrs"){
                                      $pricename = "Hours22";
                                    }else{
                                      $pricename = $_GET['tRANGE']."TimePrice";
                                    }
                                    
                                    $datainsertedCottages .= "
                                      <div class='SO-item'>
                                          <input type='checkbox' id='".$result["roomname"]."' value='".$result["roomname"]."-".$result[$pricename]."-".$result['MaxPeople']."' name='SOItemSelect'>
                                          <div class='addtocart2' onclick='activateClick(`".$result["RoomType"]."`)'>
                                              <img src='../Client/RoomsEtcImg/Rooms/".$result['RoomType'].".jpeg' alt=''>
                                              <div class='textareapart'>
                                                  <h2>".$result["roomname"]."</h2>
                                                  <div class='smallinfos'>
                                                      <small>Good for ".$result["MinPeople"]." - ".$result["MaxPeople"]." people</small>
                                                      <small>Price ".$result[$pricename]."</small>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class='spawnerbtn' style='display: flex;justify-content: center;padding:0.5em 1em;'>
                                            <button type='button' class='ADDMEBTN' onclick='activateClick(this,`".$result["roomname"]."`)'>Add To List</button>
                                          </div>
                                      </div>";

                                    
                                }
                                echo $datainsertedCottages;

                            ?>
                </div>

                <div class="specials123" style="display: flex;justify-content: center;margin-top:1.5em;">
          <button type="submit" >Continue</button>
        </div>

      </form>

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
              text: "The max people in the room is less than the guest numbers",
              icon: "info"
            });
            return;
          }

          //location.href = `./${REGFORM.noSenior.value}.php?cin=${Checkin}&package=${REGFORM.noSenior.value}`;
          let TOTALINIT = document.getElementById('TOTALINIT').innerText.replace("Total : ₱ ", "");
          let stringedJSON = JSON.stringify(datacontainer);

          location.href = `./Mainpage.php?nzlz=addonCottage&plk=2&cin=<?php echo $_GET["cin"];?>&ETIME=<?php echo $_GET["ETIME"];?>&package=<?php echo $_GET["package"];?>&tRANGE=<?php echo $_GET["tRANGE"];?>&na=<?php echo $_GET["na"];?>&nk=<?php echo $_GET["nk"];?>&ns=<?php echo $_GET["ns"];?>&tinit=${TOTALINIT}&roomlist=${stringedJSON}`;


        })
    </script>

