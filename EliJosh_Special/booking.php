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
        break;
    case 'Night':
        $timevalue = "07:00 PM - 07: 00 AM";
        break;
    case '22Hrs':
        $timevalue = "02:00 PM - 12: 00 PM";
        break;
    }
    //print_r($_SESSION["Walkinuser"]);
    $fname = isset($_SESSION["Walkinuser"]) ? $_SESSION["Walkinuser"]["FirstName"] : "";
    $mname = isset($_SESSION["Walkinuser"]) ? $_SESSION["Walkinuser"]["MiddleName"] : "";
    $lname = isset($_SESSION["Walkinuser"]) ? $_SESSION["Walkinuser"]["LastName"] : "";
    $email = isset($_SESSION["Walkinuser"]) ? $_SESSION["Walkinuser"]["Email"] : "";
    $phone = isset($_SESSION["Walkinuser"]) ? $_SESSION["Walkinuser"]["PhoneNumber"] : "";
    $address = isset($_SESSION["Walkinuser"]) ?  $_SESSION["Walkinuser"]["Address"] : "";


    $nAdult = isset($_GET['na']) ? $_GET['na'] : "1";
    $nKid = isset($_GET['nk']) ? $_GET['nk'] : "0";
    $nSenior = isset($_GET['ns']) ? $_GET['ns'] : "0";
    $nStay =isset($_GET['nsy']) ? $_GET['nsy'] : "1";
    
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
    <div class="head-title">
        <div class="left">
            <h1>Booking</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Booking</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Home</a>
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
	<div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Guest Number</h3>
            </div>
            <form action="" method="get" class="formcontainers" id="REGFORM">
                <div class="layer-3">
                  <div class="form-group f30">
                    <label for="" > Time of Arrival <span class="requiredcolor">*</span></label>
                      <input data-role="timepicker" data-seconds="false" type="text" id="timeSSS">
                      <small style="color: #D2042D;text-align:center;"></small>
                      <p></p>
                  </div>
                  <?php 
                    if($_GET['package'] != "Package1"){
                  ?>
                  <div class="form-group f30">
                        <input type="number" class="form-control" name="" value="<?php echo $nStay?>" id="nStay"  required placeholder=" ">
                        <label for=""  class="form-label">Number of Days (Rooms)<span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                        <p></p>
                    </div>
                    <div class="form-group f30">
                     
                    </div>
                  <?php 
                    }
                  ?>
                </div>
                <div class="layer-3">
                    <div class="form-group f30">
                        <input type="number" class="form-control" name="" value="<?php echo $nAdult?>" id="nAdult"  required placeholder=" ">
                        <label for=""  class="form-label">Number of Adult <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                        <p>₱ <?php echo $entrance[0];?></p>
                    </div>
                    <div class="form-group f30">
                        <input type="number" class="form-control" name="" value="<?php echo $nKid?>" id="nKid"  required placeholder=" ">
                        <label for=""  class="form-label">Number of Kid <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                        <p>₱ 0.00</p>
                    </div>
                    <div class="form-group f30">
                        <input type="number" class="form-control" name="" value="<?php echo $nSenior?>" id="nSenior" required placeholder=" ">
                        <label for=""  class="form-label">Number of Senior <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                        <p>₱ 0.00</p>
                    </div>
                </div>
                <div class="box3">
                  <h3>Total : ₱ <span id="TOTALINIT"><?php echo ($_GET['package'] == "Package2") ? "0.00" : $entrance[0];?></span></h3>
                  <small>This Package has no entrance / pool charges.</small>
          </div>
                <div class="BUTTONHANDLER">
                    <button type="submit" class="ContinueBTN">Continue</button>
                </div>
            </form>
        </div>
    </div>
</main>


<script>
    let adultval = parseFloat(<?php echo $entrance[0];?>)
    let kidval = parseFloat(<?php  echo $entrance[1];?>)
    let senior = adultval - (adultval * .2)

    function validateNumberInput(inputElement, price) {
      const inputValue = inputElement.value;
      if (inputValue < 0) {
        inputElement.value = 0;
        return false
      } 
      inputElement.parentNode.children[2].value = `${(inputElement.value*price).toFixed(2)}`
      inputElement.parentNode.children[3].innerText =  `₱ ${(inputElement.value*price).toFixed(2)}`

      compute();
      return true
    }
    function validateNumberInput2(inputElement) {
      const inputValue = inputElement.value;
      if (inputValue < 1) {
        inputElement.value = 1;
      } 
    }

    //Validation
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
      if (input.type === "number" ) {
        input.addEventListener('input', function() {
          let numnew = 0;
          if(input.id === "nStay"){
            validateNumberInput2(this)
          }else{
            if(input.id.includes("Kid")){
              numnew = kidval
            }else if(input.id.includes("Adult")){
              numnew = adultval
            }else{
              numnew = senior
            }
            validateNumberInput(this,numnew)
          }

        });
      } 
    });

    let packsss = `<?php echo $_GET['package'];?>`;


    function compute2(){
      let sum = 0;
      
      if(packsss == "Package2"){
        return '0.00'
      }


      let a = document.getElementById('nAdult').value 
      let b = document.getElementById('nKid').value 
      let c = document.getElementById('nSenior').value

      sum = (parseFloat(a)*adultval) + (parseFloat(b)*kidval) + (parseFloat(c)*senior)

      console.log(sum)
      return sum.toFixed(2)
    }
    const REGFORM = document.getElementById('REGFORM')
    REGFORM.addEventListener('submit', async (e) => {

      e.preventDefault();
      let ids = document.getElementsByTagName('BUTTON')[0]

      let totalpax = parseInt( REGFORM.nSenior.value) + parseInt( REGFORM.nKid.value) + parseInt( REGFORM.nAdult.value) 

      if(totalpax == 0){
        await Swal.fire({
          text: "Enter proper number of people",
          icon: "error"
        });
        return;
      }

      let errcount = 0
        if(errcount == 0){
              //location.href = `./${REGFORM.noSenior.value}.php?cin=${Checkin}&package=${REGFORM.noSenior.value}`;
          let TOTALINIT = document.getElementById('TOTALINIT').innerText.replace("Total : ₱ ", "");


          let specialTEXTAREA = `<?php
                    $getUSER = "SELECT * FROM userscredentials WHERE userID = '".$_SESSION["USERID"]."';";
                    $sqlquery32 = mysqli_query($conn,$getUSER);
                    $result = mysqli_fetch_assoc($sqlquery32);
                    echo json_encode($result, JSON_PRETTY_PRINT);?>`
          let jsondataUSER = JSON.parse(specialTEXTAREA);


          console.log(jsondataUSER)
          let jsondata = {
            userID : jsondataUSER.userID,
            FirstName : jsondataUSER.FirstName,
            MiddleName : jsondataUSER.MiddleName,
            LastName : jsondataUSER.LastName,
            PhoneNumber : jsondataUSER.PhoneNumber,
            Address : jsondataUSER.Address,
            City : jsondataUSER.City,
            Email : jsondataUSER.Email
          }

          console.log(jsondata)

          let insertguest =JSON.stringify(jsondata); 
          await AjaxSendv3(insertguest,"JSONTOARRAY")


          let currentURL = location.href;
          let theparams = currentURL.split("?")[1]
          let nsy = 1;
          if(REGFORM.nStay){
            nsy = REGFORM.nStay.value
          }
          location.href = `./specialcon.php?nzlz=<?php echo $_GET["package"];?>&${theparams}&ETIME=${REGFORM.timeSSS.value}&na=${REGFORM.nAdult.value}&nk=${REGFORM.nKid.value}&ns=${REGFORM.nSenior.value}&nsy=${nsy}&tinit=${compute2()}`

        }
        
 
    })

   
  </script>
