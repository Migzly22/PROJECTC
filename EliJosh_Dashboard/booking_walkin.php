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
            <h1>Walk-ins Reservation</h1>
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
                    <a class="active" href="#">Walk-ins</a>
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
                <h3>Guest Information</h3>
            </div>
            <form action="" method="get" class="formcontainers" id="REGFORM">
                <div class="layer-3">
                    <div class="form-group f30">
                        <input type="text" class="form-control" value="<?php echo $fname?>" name="" id="fname" required placeholder="">
                        <label for="" class="form-label">First name <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f30">
                        <input type="text" class="form-control" name="" value="<?php echo $mname?>" id="mname" required placeholder=" ">
                        <label for=""  class="form-label">Middle name <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f30">
                        <input type="text" class="form-control" name="" value="<?php echo $lname?>" id="lname" required placeholder=" ">
                        <label for=""  class="form-label">Last name <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
                <div class="layer-2">
                    <div class="form-group f45">
                        <input type="email" class="form-control" name="" value="<?php echo $email?>" id="email" required placeholder=" ">
                        <label for=""  class="form-label">Email <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f45">
                        <input type="text" class="form-control" name="" value="<?php echo $phone?>" id="phone" required placeholder=" ">
                        <label for=""  class="form-label">Contact # <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
                <div class="layer-1">
                    <div class="form-group">
                        <input type="text" class="form-control" name="" value="<?php echo $address?>" id="address" required placeholder=" ">
                        <label for=""  class="form-label">Address <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
                <div class="layer-1">
                  <?php 
                      if($_GET['package'] != "Package1"){
                    ?>
                    <div class="form-group">
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
                        <label for=""  class="form-label">Number of Kids (3ft and above) <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                        <p>₱ 0.00</p>
                    </div>
                    <div class="form-group f30">
                        <input type="number" class="form-control" name="" value="<?php echo $nSenior?>" id="nSenior" required placeholder=" ">
                        <label for=""  class="form-label">Number of Senior/PWD (20% Discount) <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                        <p>₱ 0.00</p>
                    </div>
                </div>
                <div class="box3">
                  <h3>Total : ₱ <span id="TOTALINIT"><?php echo ($_GET['package'] == "Package2") ? "0.00" : $entrance[0];?></span></h3>
                <?php 
                  if ($_GET['package'] == "Package2"){
                ?>
                  <small>This Package has no entrance / pool charges.</small>
                <?php
                  }
                ?>
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
          if (/^(?:\+\d{12}|\d{11})$/.test(inputValue)) {
            inputElement.parentNode.children[2].innerText = '';
            return true
          } else {
            inputElement.parentNode.children[2].innerText = 'Philippine contact number only.';
            return false
          }
        }
    function validateNumberInput22(inputElement) {
      const inputValue = inputElement.value;
      if (inputValue < 1) {
        inputElement.value = 1;
      } 
    }
    function validateInput(inputElement) {
          const inputValue = inputElement.value;
          console.log(inputElement)
          if (/[\d]/.test(inputValue)) {
            inputElement.parentNode.children[2].innerText = 'Inputs should not contain numbers.';
            return false
          } else {
            inputElement.parentNode.children[2].innerText = '';
            return true
          }
        }

    function compute(){
      let sum = 0;
      if(packsss == "Package2"){
        document.getElementById('TOTALINIT').innerText = sum.toFixed(2)
        return
      }
 
      let a = document.getElementById('nAdult').value 
      let b = document.getElementById('nKid').value 
      let c = document.getElementById('nSenior').value

      sum = (parseFloat(a)*adultval) + (parseFloat(b)*kidval) + (parseFloat(c)*senior)

      document.getElementById('TOTALINIT').innerText = sum.toFixed(2)
    }

    function convertToUppercase(inputElement) {
        const inputValue = inputElement.value;
        inputElement.value = inputValue.toUpperCase();
    }

    //Validation
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
      if (input.type === "number") {
        input.addEventListener('input', function() {
          let numnew = 0;
          if(input.id === "nStay"){
            validateNumberInput22(this)
          }else {
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
      }else  if(input.id === "phone"){
        input.addEventListener('input', function() {
          validateNumberInput2(this)
        });

      }else if (input.id !== "address" && input.id !== "email"){
        input.addEventListener('input', function() {
          validateInput(this)
          convertToUppercase(this)
        });
      }else if (input.id === "address" ){
        input.addEventListener('input', function() {
          convertToUppercase(this)
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



      
      let errcount = 0;

      inputs.forEach(input => {
        if (input.type === "number") {
          
        }else  if(input.type !== "hidden"){
          if(!input.id.includes("swal-input")){
            if(input.id === "phone" ){
            console.log(input.id, validateInput(input))
            !(validateNumberInput2(input)) ? errcount++ : ""
          }else if (input.id !== "address" && input.id !== "email"){
              console.log(input.id, validateInput(input))
              !(validateInput(input))? errcount++ : ""
          }
          }
          
        }
      })

      console.log(errcount)
        if(errcount == 0){
              //location.href = `./${REGFORM.noSenior.value}.php?cin=${Checkin}&package=${REGFORM.noSenior.value}`;
          let TOTALINIT = document.getElementById('TOTALINIT').innerText.replace("Total : ₱ ", "");

          let jsondata = {
            userID : null,
            FirstName : REGFORM.fname.value,
            MiddleName : REGFORM.mname.value,
            LastName : REGFORM.lname.value,
            PhoneNumber : REGFORM.phone.value,
            Address : REGFORM.address.value,
            City : null,
            Email : REGFORM.email.value,

          }
          let insertguest =JSON.stringify(jsondata); 
          await AjaxSendv3(insertguest,"JSONTOARRAY")


          let currentURL = location.href;
          let theparams = currentURL.split("?")[1]
          var modifiedString = theparams.replace('&', '?');
          theparams = modifiedString.split("?")[1]

          let nsy = 1;
          if(REGFORM.nStay){
            nsy = REGFORM.nStay.value
          }

          location.href = `./index.php?nzlz=booking_<?php echo $_GET["package"];?>&${theparams}&na=${REGFORM.nAdult.value}&nk=${REGFORM.nKid.value}&ns=${REGFORM.nSenior.value}&nsy=${nsy}&tinit=${compute2()}`

        }
        
 
    })

   
  </script>