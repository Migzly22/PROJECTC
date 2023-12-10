<?php
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



  <link rel="stylesheet" href="./CSS/settingsv2v2.css">

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

      <div class="box">
        <header>
          <h1 class="text-center">Booking Information</h1>
        </header>
        <p>Checkin Date</p>
        <div class="textshowinputs">
          <b>
            <?php echo $_GET['cin']." ".$_GET['ETIME']; ?>
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
      </div>
      <div class="box2">
        <form action="" class="form " method="post" id="REGFORM">
          <header>
            <h1 class="text-center">Guest Booking Details</h1>
          </header>
          <div class="levels-3">
            <div class="form-group">
              <input type="text" id="FirstName" required value="" style="text-align: center;">   
              <label for="FirstName">First Name<span style="color: red;">*</span></label>
              <small style="color: #D2042D;text-align:center;"></small>
            </div>
            <div class="form-group">
              <input type="text" id="MiddleName" required value="" style="text-align: center;">   
              <label for="MiddleName">Middle Name<span style="color: red;">*</span></label>
              <small style="color: #D2042D;text-align:center;"></small>
            </div>
            <div class="form-group">
              <input type="text" id="LastName" required value="" style="text-align: center;">   
              <label for="LastName">Last Name<span style="color: red;">*</span></label>
              <small style="color: #D2042D;text-align:center;"></small>
            </div>

          </div>
          <div class="levels-2">
            <div class="form-group">
              <input type="email" id="Email" required value="" style="text-align: center;">   
              <label for="Email">Email<span style="color: red;">*</span></label>
              <small style="color: #D2042D;text-align:center;"></small>
            </div>
            <div class="form-group">
              <input type="text" id="PhoneNumber" required value="" style="text-align: center;">   
              <label for="PhoneNumber">Phone no.<span style="color: red;">*</span></label>
              <small style="color: #D2042D;text-align:center;"></small>
            </div>
          </div>
          <div class="levels">
            <div class="form-group">
              <input type="text" id="Address" required value="" style="text-align: center;">   
              <label for="Address">Address<span style="color: red;">*</span></label>
              <small style="color: #D2042D;text-align:center;"></small>
            </div>

          </div>
          <div class="levels-3">
            <div class="form-group">
              <input type="number" id="noAdult" required value="1" style="text-align: center;">   
              <label for="noAdult">No. of Adult<span style="color: red;">*</span></label>
              <input type="hidden" name="" value="<?php echo $entrance[0];?>">
              <p>₱ 200.00</p>
            </div>
            <div class="form-group">
              <input type="number" id="noKids" required value="0" style="text-align: center;"> 
              <label for="noKids">No. of Kids<span style="color: red;">*</span></label>
              <input type="hidden" name="" value="0">
              <p>₱ 0.00</p>
            </div>
            <div class="form-group"> 
              <input type="number" id="noSenior" required value="0" style="text-align: center;"> 
              <label for="noSenior">No. of Senior<span style="color: red;">*</span></label>
              <input type="hidden" name="" value="0">
              <p>₱ 0.00</p>
            </div>
          </div>
          <div class="box3">
            <h1>Total : ₱ <span id="TOTALINIT"><?php echo ($_GET['package'] == "Package2") ? "0.00" : $entrance[0];?></span></h1>
            <?php 
              if ($_GET['package'] == "Package2"){
            ?>
              <small>This Package has no entrance / pool charges.</small>
            <?php
              }
            ?>
          </div>
  
          <div class="specials123" style="display: flex;justify-content: center;">
            <button type="submit" name="SignupBtn" id="">Continue</button>
          </div>
  
        </form>
      </div>
   
  <script>
    let adultval = parseFloat(<?php echo $entrance[0];?>)
    let kidval = parseFloat(<?php  echo $entrance[1];?>)

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
    function validateInput(inputElement) {
          const inputValue = inputElement.value;
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


      inputs.forEach(input => {
        if (input.type === "hidden") {
          sum += parseFloat(input.value)
        } 
      });

      document.getElementById('TOTALINIT').innerText = sum.toFixed(2)
    }



    //Validation
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
      if (input.type === "number") {
        input.addEventListener('input', function() {
          let numnew = 0;
          if(input.id.includes("Kids")){
            numnew = kidval
          }else if(input.id.includes("Adult")){
            numnew = adultval
          }else{
            numnew = adultval - (adultval*.2)
          }
          validateNumberInput(this,numnew)
        });
      }else  if(input.id === "PhoneNumber"){
        input.addEventListener('input', function() {
          validateNumberInput2(this)
        });

      }else if (input.id !== "Address" && input.id !== "Email"){
        input.addEventListener('input', function() {
          validateInput(this)
        });

      }
    });

    let packsss = `<?php echo $_GET['package'];?>`;


    function compute2(){
      let sum = 0;
      
      if(packsss == "Package2"){
        return '0.00'
      }


      inputs.forEach(input => {
        if(input.type != "hidden"){
          if(input.id.includes("Kids")){
            sum += parseFloat(input.value) * parseFloat(kidval)
          }else if(input.id.includes("Adult")){
            sum += parseFloat(input.value) * adultval
          }else if(input.id.includes("Senior")){
            sum += parseFloat(input.value) *(adultval - (adultval*.2))
          }
        }
        
      });
      console.log(sum)
      return sum.toFixed(2)
    }
    const REGFORM = document.getElementById('REGFORM')
    REGFORM.addEventListener('submit', async (e) => {

      e.preventDefault();
      let ids = document.getElementsByTagName('BUTTON')[0]

      let totalpax = parseInt( REGFORM.noSenior.value) + parseInt( REGFORM.noKids.value) + parseInt( REGFORM.noAdult.value) 

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
          if(input.id === "PhoneNumber"){
            console.log(input.id, validateInput(input))
            !(validateNumberInput2(input)) ? errcount++ : ""
          }else if (input.id !== "Address" && input.id !== "Email"){
              console.log(input.id, validateInput(input))
              !(validateInput(input))? errcount++ : ""
          }
        }
      })
      console.log(errcount)
      console.log(REGFORM.PhoneNumber.value)
        if(errcount == 0){
              //location.href = `./${REGFORM.noSenior.value}.php?cin=${Checkin}&package=${REGFORM.noSenior.value}`;
          let TOTALINIT = document.getElementById('TOTALINIT').innerText.replace("Total : ₱ ", "");

          let jsondata = {
            userID : null,
            FirstName : REGFORM.FirstName.value,
            MiddleName : REGFORM.MiddleName.value,
            LastName : REGFORM.LastName.value,
            PhoneNumber : REGFORM.PhoneNumber.value,
            Address : REGFORM.Address.value,
            City : null,
            Email : REGFORM.Email.value,

          }
          let insertguest =JSON.stringify(jsondata); 
          await AjaxSendv3(insertguest,"JSONTOARRAY")


          location.href = `./Mainpage.php?nzlz=<?php echo $_GET["package"];?>&plk=2&cin=<?php echo $_GET["cin"];?>&ETIME=<?php echo $_GET["ETIME"];?>&adultval=${adultval}&kidval=${kidval}&package=<?php echo $_GET["package"];?>&tRANGE=<?php echo $_GET["tRANGE"];?>&na=${REGFORM.noAdult.value}&nk=${REGFORM.noKids.value}&ns=${REGFORM.noSenior.value}&tinit=${compute2()}`;
        }
        
 
    })
  </script>
