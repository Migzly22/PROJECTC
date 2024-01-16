<?php 
    $cin = isset($_GET['cin']) ? $_GET['cin'] : "";
    $ETIME = isset($_GET['ETIME']) ? $_GET['ETIME'] : "";
    $tRANGE = isset($_GET['tRANGE']) ? $_GET['tRANGE'] : "";
    $package = isset($_GET['package']) ? $_GET['package'] : "";

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
          $timevalue = "08:00 AM - 05: 00 PM";
          $datas = "17:00";
          break;
      case 'Night':
          $timevalue = "07:00 PM - 07: 00 AM";
          $datas = "07:00";
          break;
      case '22Hrs':
          $timevalue = "02:00 PM - 12: 00 PM";
          $datas = "12:00";
          break;
      }

    $nAdult = isset($_GET['nAdult']) ? $_GET['nAdult'] : "1";
    $nKid = isset($_GET['nKid']) ? $_GET['nKid'] : "0";
    $nSenior = isset($_GET['nSenior']) ? $_GET['nSenior'] : "0";
    
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

    $guesttotalnumber = $_GET['na']+$_GET['nk']+$_GET['ns'];

    $sqlcodev1 = "SELECT a.*, a.RoomType AS roomname ,f.*
    FROM rooms a
    LEFT JOIN (
        SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate, e.finalCheckout, e.CheckOutDate
        FROM roomsreservation d
        LEFT JOIN reservations e ON d.greservationID = e.ReservationID
        WHERE (DATE(e.CheckInDate) <= '$cin' AND e.CheckOutDate >= '$cin $datas') AND e.finalCheckout is null
    ) f ON f.Room_num = a.RoomID WHERE f.RR_ID is null
    ORDER BY a.RoomID;";

    $queryrunv1 = mysqli_query($conn, $sqlcodev1);



   // Split the string by comma (",") into an array
    $array = explode("&", $_SERVER['QUERY_STRING']);
    // Remove the first element from the array
    array_shift($array);
    $newqueryparam = implode("&",$array);


    $daysofstay = $_GET["nsy"];
?>


<main>
    <div class="head-title">
        <div class="left">
            <h1>Add Room</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Booking</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="./index.php?nzlz=booking">Home</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="./index.php?nzlz=booking_walkin&<?php echo $newqueryparam;?>">Walk-ins</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Add Room</a>
                </li>
            </ul>
            
        </div>
    </div>
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Booking Information</h3>
            </div>
            <div class="layer-3">
                <div class="form-group f30">
                    <p>Check-in : <?php echo $cin?></p>
                </div>
                <div class="form-group f30">
                    <p>Time Range : <?php echo $timevalue?></</p>
                </div>
                <div class="form-group f30">
                    <p>Package : <?php echo $pacvalue?></</p>
                </div>
            </div>
        </div>

    </div>
    <form id="REGFORM" class="order">
      <div class="head head2" style="display: flex;justify-content:space-between;align-items:center;">
        <h3>Rooms</h3>
        <div class="textshowinputs">
          <h5>
              Total : ₱ <span id="TOTALINIT"><?php echo $_GET['tinit'];?>
          </h5>
        </div>
      </div>
      <div class="listcontroller">
        <?php
      			$data1 = "";
            while ($result = mysqli_fetch_assoc($queryrunv1)) {
            if($_GET['tRANGE'] == "22Hrs" || $daysofstay > 1){
              $pricename = "Hours22";
            }else{
              $pricename = $_GET['tRANGE']."TimePrice";
            }
            
      
            $data1 .= "
            <div class='boxcontainers'>
              <img src='../Elijosh_Special/RoomsEtcImg/Rooms/".explode("-",$result["roomname"])[0].".jpeg' alt=''>
              <div class='textcontainers'>
              <h2 style='text-align: center;'>".$result["roomname"]."</h2>
              <small>Good for ".$result["MinPeople"]." - ".$result["MaxPeople"]." people</small>
              <small>Price : ₱ ".number_format($result[$pricename]*$daysofstay,2) ."</small>
              </div>
              <div class='spawnerbtn' style='display: flex;justify-content: center;padding:0.5em 1em;'>
              <button type='button' class='ADDMEBTN' id='".$result["roomname"]."' onclick='activateClick(this,`".$result["roomname"]."-".$result[$pricename]*$daysofstay."-".$result["MaxPeople"]."-".$result["RoomID"]."`)'>Add</button>
              </div>
            </div>
            ";
            }
            echo $data1;
        ?>
        

        
      </div>
      <div class="BUTTONHANDLER">
        <button type="submit" class="ContinueBTN">Continue</button>
      </div>
        

    </form>
</main>

<script>
        var datacontainer = {}
        function activateClick(e,data) {
            // Find the checkbox element by its ID
            let arrval = data.split("-")


            if (e.classList[0] === 'ADDMEBTN'){
                e.classList.remove('ADDMEBTN')
                e.classList.add('REMOVEMEBTN')
                e.innerText = "Remove"

                datacontainer[`${arrval[0]}-${arrval[1]}`] = {
                  price :  arrval[2],
                  name :  arrval[0],
                  num :  arrval[4],
                  max : arrval[3],
                }
            }else{
                e.classList.add('ADDMEBTN')
                e.classList.remove('REMOVEMEBTN')
                e.innerText = "Add"
                delete datacontainer[`${arrval[0]}-${arrval[1]}`];
            }

            console.log(datacontainer)
            updatePrice()

        }

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
          e.preventDefault();

          let pakagedetails = `<?php echo $_GET['package']; ?>`


         
          let totalnumperson = 0;
          for (let key in datacontainer) {
            if (datacontainer.hasOwnProperty(key)) {
              // Convert the price to a number and add it to the total
              totalnumperson += parseFloat(datacontainer[key].max);
            }
          }
          let clientstotalnumber = parseInt(`<?php echo $guesttotalnumber; ?>`)

          if(pakagedetails === "Package2"){
            if(Object.keys(datacontainer).length <= 0){
              await Swal.fire({
                text: "Pick a Room First",
                icon: "info"
              });
              return;
            }

            if(totalnumperson < clientstotalnumber){
              await Swal.fire({
                text: "The max people in the room is less than the guest numbers",
                icon: "info"
              });
              return;
          }
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

          let currentURL = location.href;
          let theparams = currentURL.split("?")[1]
          var modifiedString = theparams.replace('&', '?');
          theparams = (modifiedString.split("?")[1]).split("&tinit")[0]

          location.href = `./index.php?nzlz=booking_Package1&${theparams}&roomlist=${stringedJSON}&tinit=${TOTALINIT}`



        })
    </script>