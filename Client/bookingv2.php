<?php
require("./Database.php");
session_start();
ob_start();

$usertoken = !isset($_SESSION["USERID"]) ?  null : $_SESSION["USERID"];
$linksref = !isset($_SESSION["USERID"]) ?  "./login.php" : "./booking.php";

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
  <link rel="stylesheet" href="./CSS/settingsv2v2.css">

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
      </div>
      <div class="box2">
        <form action="" class="form " method="post" id="REGFORM">
          <header>
            <h1 class="text-center">Guest Booking Details</h1>
          </header>
          <div class="levels">
            <div class="form-group">
              <input type="time" id="timeSSS" required value="12:00" style="text-align: center;"> 
              <label for="timeSSS">Arrival Time<span style="color: red;">*</span></label>
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
   
    </section>
  </main>


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
        
      //location.href = `./${REGFORM.noSenior.value}.php?cin=${Checkin}&package=${REGFORM.noSenior.value}`;
      let TOTALINIT = document.getElementById('TOTALINIT').innerText.replace("Total : ₱ ", "");
      let timeSSS = document.getElementById('timeSSS').value
      
      location.href = `./<?php echo $_GET["package"];?>.php?cin=<?php echo $_GET["cin"];?>&ETIME=${timeSSS}&adultval=${adultval}&kidval=${kidval}&package=<?php echo $_GET["package"];?>&tRANGE=<?php echo $_GET["tRANGE"];?>&na=${REGFORM.noAdult.value}&nk=${REGFORM.noKids.value}&ns=${REGFORM.noSenior.value}&tinit=${compute2()}`;


    })
  </script>
</body>

</html>
