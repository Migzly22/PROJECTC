<?php 

$userid = $_GET["ISU"];

$sqlcode1 = "SELECT a.*, b.* FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID WHERE b.ReservationID = '$userid';";
$queryrun1 = mysqli_query($conn,$sqlcode1);
$data = mysqli_fetch_assoc($queryrun1);

$sqlcode2 = "SELECT if(SUM(ChargeAmount) IS NULL, '0.00', SUM(ChargeAmount)) AS EXTRACHARGES FROM guestextracharges WHERE ReservationID = '".$data['ReservationID']."';";
$queryrun2 = mysqli_query($conn,$sqlcode2);
$data2 = mysqli_fetch_assoc($queryrun2);

$sqlcode3 = "SELECT SUM(AmountPaid) AS PaidAmountTotal FROM guestpayments WHERE ReservationID = '".$data['ReservationID']."';";
$queryrun3 = mysqli_query($conn,$sqlcode3);
$data3 = mysqli_fetch_assoc($queryrun3);

$total = (floatval($data2["EXTRACHARGES"]) + floatval($data["TotalPrice"])) - floatval($data3["PaidAmountTotal"]);

$sqlcode4 = "SELECT * FROM additionalhead WHERE Type = '".$data["timapackage"]."';";
$queryrun4 = mysqli_query($conn,$sqlcode4);
$data4 = mysqli_fetch_assoc($queryrun4);

$date1 = new DateTime($data["eCheckin"]);
$date2 = new DateTime($data["CheckOutDate"]);

$interval = $date1->diff($date2);

$total_hours = $interval->h + ($interval->days * 24);

// Round up to the nearest multiple of 24 hours
$rounded_hours = ceil($total_hours / 24) ;




    $newcin = $data['eCheckin'];
    $datetime = new DateTime($newcin);
    $cin = $datetime->format("Y-m-d");

    $ETIME = $data['eCheckin'] ;
    $tRANGE = $data['timapackage'] ;
    $package = $data['package'];

    //error_reporting(E_ERROR | E_PARSE);
    $pacvalue = "";
    $timevalue = "";

    switch ($package) {
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

    switch ($tRANGE) {
    case 'Day':
        $timevalue = "08:00 AM - 05: 00 PM";
        break;
    case 'Night':
        $timevalue = "07:00 PM - 07: 00 AM";
        break;
    case '22Hrs':
        $timevalue = "02:00 PM - 12: 00 PM";
        break;
    }

    
    $dateTime = new DateTime($cin);
    // Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
    $dayOfWeekNumber = $dateTime->format('N');
    // Convert the number to the day name
    $dayOfWeekName = date('l', strtotime($cin));

    if($dayOfWeekNumber <= 4){
        $columnstring = "Weekdays".$tRANGE."Price";
    }else{
        $columnstring = "WeekendsHolidays".$tRANGE."Price";
    }

    $sql1 = "SELECT * FROM poolrate ORDER BY RateID ASC;";
    $sql1query = mysqli_query($conn, $sql1);
    $entrance = array();

    while ($result = mysqli_fetch_assoc($sql1query)) {
      $entrance[] = $result[$columnstring];
    }

    $guesttotalnumber = $data['NumAdults']+$data['NumChildren']+$data['NumSeniors']+ $data["NumExcessPax"];

    $sqlcodev1 = "SELECT a.*, f.*, CONCAT(a.RoomType, '-', a.RoomNum) AS roomname, g.TOTAL FROM 
    (SELECT b.RoomID, b.RoomNum , c.* FROM rooms b LEFT JOIN roomtypes c ON b.RoomType = c.RoomType) a
    LEFT JOIN
    (SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate FROM roomsreservation d LEFT JOIN reservations e ON d.greservationID = e.ReservationID 
    WHERE e.CheckInDate = '".$cin."' AND (e.timapackage = '".$tRANGE."' OR e.timapackage = '22Hrs')) f ON a.RoomNum = f.Room_num 
    LEFT JOIN 
    (SELECT  a.RoomType, SUM(a.MaxPeople) AS TOTAL FROM (SELECT b.RoomID, b.RoomNum , c.* FROM rooms b LEFT JOIN roomtypes c ON b.RoomType = c.RoomType) a
    LEFT JOIN
    (SELECT d.*, e.GuestID, e.timapackage, e.CheckInDate FROM roomsreservation d LEFT JOIN reservations e ON d.greservationID = e.ReservationID 
    WHERE e.CheckInDate = '".$cin."' AND (e.timapackage = '".$tRANGE."' OR e.timapackage = '22Hrs')) f ON a.RoomNum = f.Room_num WHERE f.RR_ID IS NULL  GROUP BY a.MaxPeople) g ON a.RoomType = g.RoomType
    WHERE f.RR_ID IS NULL;";;
    $queryrunv1 = mysqli_query($conn, $sqlcodev1);


?>


<main>
    <div class="head-title">
        <div class="left">
            <h1>Add Rooms</h1>
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
					<a class="active" href='./index.php?nzlz=booking_info&ISU=<?php echo $userid;?>'>Reservation Information</a>
				</li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Addons: Rooms</a>
                </li>
            </ul>
            
        </div>
    </div>
    <form id="REGFORM" class="order">
      <div class="head head2" style="display: flex;justify-content:space-between;align-items:center;">
        <h3>Rooms</h3>
        <div class="textshowinputs">
          <h5>
              Total : ₱ <span id="TOTALINIT"><?php echo $total;?>
          </h5>
        </div>
      </div>
      <div class="listcontroller">
        <?php
          $data1 = "";
          while ($result = mysqli_fetch_assoc($queryrunv1)) {
            if($tRANGE == "22Hrs" || $rounded_hours > 1){
              $pricename = "Hours22";
            }else{
              $pricename = $tRANGE."TimePrice";
            }
            

            $data1 .= "
            <div class='boxcontainers'>
              <img src='../Client/RoomsEtcImg/Rooms/".$result['RoomType'].".jpeg' alt=''>
              <div class='textcontainers'>
                <h2 style='text-align: center;'>".$result["roomname"]."</h2>
                <small>Good for ".$result["MinPeople"]." - ".$result["MaxPeople"]." people</small>
                <small>Price :  ₱ ".number_format($result[$pricename]*$rounded_hours,2) ."</small>
              </div>
              <div class='spawnerbtn' style='display: flex;justify-content: center;padding:0.5em 1em;'>
                <button type='button' class='ADDMEBTN' id='".$result["roomname"]."' onclick='activateClick(this,`".$result["roomname"]."-".$result[$pricename]*$rounded_hours."-".$result["MaxPeople"]."`)'>Add</button>
              </div>
            </div>
            ";
          }

          if(mysqli_num_rows($queryrunv1) <= 0){
            $data1 .= "
            <div class='boxcontainers'>
              <img src='./img/title_logo.png' alt=''>
              <h1>No Available Room yet</h1>
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
                  num :  arrval[1],
                  max : arrval[3]
                }
            }else{
                e.classList.add('ADDMEBTN')
                e.classList.remove('REMOVEMEBTN')
                e.innerText = "Add"
                delete datacontainer[`${arrval[0]}-${arrval[1]}`];
            }
            updatePrice()

        }

        function updatePrice() {
          let basesum = <?php echo $total;?>;

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



            if(Object.keys(datacontainer).length <= 0){
              await Swal.fire({
                text: "Pick a Room First",
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

          let currentURL = location.href;
          let theparams = currentURL.split("?")[1]
          var modifiedString = theparams.replace('&', '?');
          theparams = (modifiedString.split("?")[1]).split("&tinit")[0]

          let iduserval = `<?php echo $userid;?>`

          let total = 0 
          for (let key in datacontainer) {
            if (datacontainer.hasOwnProperty(key)) {
              // Convert the price to a number and add it to the total
              total += parseFloat(datacontainer[key].price);
            }
          }

          if(datacontainer !== null){
            for (const key in datacontainer) {
          
              let insertrooms = `INSERT INTO roomsreservation (greservationID, Room_num) VALUES ('${iduserval}', '${datacontainer[key]['num']}');`
              await AjaxSendv3(insertrooms,"BREAKDOWNLOGIC",`&Process=Insertmore`)
                
              
            }
            await AjaxSendv3(total,"BREAKDOWNLOGIC",`&Process=Insertmore2&IDS=${iduserval}`)
          }
          await Swal.fire({
            text: "Added Successfully",
            icon: "success"
          });

          location.href = './index.php?nzlz=booking_info&ISU=<?php echo $userid;?>'
        })
    </script>