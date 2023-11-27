<?php
    require("../Database.php");
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
    
    <link rel="stylesheet" href="./CSS/settings.css">

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
                <a href="./booking.php#COTTAGES" class="textkainit">COTTAGES</a>
            </li>
            <li>
                <a href="./booking.php#ROOMS" class="textkainit">ROOMS</a>
            </li>
            <li>
                <a href="./booking.php#EVENTPLACE" class="textkainit">EVENTPLACE</a>
            </li>
            <li>
                <a href="./booking.php#EXPENDITURES" class="textkainit">EXPENDITURES</a>
            </li>
        </ul>
        <div class="USERVALUE USERVALUE2 dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
            <ul class="dropdown-menu">
                <li><a href="./InsideMain.php">Account Settings</a></li>
                <li><a href="./bookinginformations.php">Booking Information</a></li>
                <li><a href="./logOut.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main>
<?php
    $ids = $_SESSION["USERID"];
    $sqlcode = "SELECT userID, FirstName, MiddleName,LastName, PhoneNumber, Address, City, Email FROM userscredentials WHERE userID = '$ids';";
    $USERDATA = mysqli_query($conn,$sqlcode);   
    $result = mysqli_fetch_assoc($USERDATA);

    $data2 = explode(', ',$result["City"]);

?>
        <section class="mainbody" style="padding: 1em 3em;">
            <form action="./InsideMain.php" class="form" method="post" id="REGFORM">
                <header>
                  <h1 class="text-center">Update Information</h1>
                </header>
                <div class="levels-3">
                  <div class="form-group">
                    <input type="text" id="fname" required value="<?php echo $result["FirstName"];?>">
                    <label for="fname">First Name <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                  <div class="form-group">
                    <input type="text" id="mname" required value="<?php echo $result["MiddleName"];?>">
                    <label for="mname">Middle Name <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                  <div class="form-group">
                    <input type="text" id="lname" required  value="<?php echo $result["LastName"];?>">
                    <label for="lname">Surname <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                </div>
                <div class="levels">
                  <div class="form-group">
                    <input type="text" id="address" required  value="<?php echo $result["Address"];?>">
                    <label for="address">Address <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                </div>
    
                <div class="levels-32">
                  <div class="form-group">
                    <select id="region" onchange="showProvince()">
                      <option value="" selected></option>
                    </select>
                    <label for="region">Region</label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                  <div class="form-group">
                    <select id="Province" required onchange="showCities()">
                      <option value="<?php echo $data2[1];?>" selected><?php echo $data2[1];?></option>
                    </select>
                    <label for="Province">Province <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                  <div class="form-group">
                    <select id="City" required>
                      <option value="<?php echo $data2[0];?>" selected><?php echo $data2[0];?></option>
                    </select>
                    <label for="City">City <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                  
                </div>
    
                <div class="levels-2">
                  <div class="form-group">
                    <input type="text" name="pnum" id="pnum" required value="<?php echo $result["PhoneNumber"];?>">
                    <label for="pnum">Contact no. <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" id="email" required value="<?php echo $result["Email"];?>">
                    <label for="email">Email address <span style="color: red;">*</span></label>
                    <p style="color:red;text-align:center;"></p>
                  </div>
                </div>
                <div class="specials123" style="display: flex;justify-content: center;">
                  <button type="submit" name="SignupBtn" id="<?php echo $ids;?>">Update</button>
                </div>
                
            </form>
        </section>
    </main>


    <script>
        async function fetchRegions() {
          return fetch('https://ph-locations-api.buonzz.com/v1/regions')
          .then(response => response.json())
          .then(data => {
            return data
          })
          .catch(error => console.error('Error:', error));
        }
      
        async function fetchProvince(regioncode = null) {
          return fetch('https://ph-locations-api.buonzz.com/v1/provinces')
          .then(response => response.json())
          .then(data => {
            return (regioncode !== null) ? data.data.filter(province => province.region_code === `${regioncode}`) : data.data;
          })
          .catch(error => console.error('Error:', error));
        }
      
        async function fetchCities(regioncode = null) {
          return fetch('https://ph-locations-api.buonzz.com/v1/cities')
          .then(response => response.json())
          .then(data => {
            return (regioncode !== null )? data.data.filter(province => province.province_code === `${regioncode}`) : data.data;
          })
          .catch(error => console.error('Error:', error));
        }
      
        async function updateRegionOptions() {
          const regionSelect = document.getElementById('region');
          const regions = await fetchRegions();
          // Clear existing options
          regionSelect.innerHTML = '<option value="" selected></option>';
      
          // Populate the select with the new options
          regions.data.forEach(region => {
            const option = document.createElement('option');
            option.value = region.id;
            option.text = region.name.split("(")[0];
            regionSelect.add(option);
          });
      
      
        }
      
        async function showProvince() {
          const regionSelect = document.getElementById('region').value;
          const ProvinceSelect = document.getElementById('Province');
          const provinces = await fetchProvince(regionSelect)
      
          // Clear existing options
          ProvinceSelect.innerHTML = '<option value="" selected></option>';
      
          // Populate the select with the new options
          provinces.forEach(region => {
            const option = document.createElement('option');
            option.value = `${region.id}[]${region.name.split("(")[0]}`;
            option.text = region.name.split("(")[0];
            ProvinceSelect.add(option);
          });
        }
      
        async function showCities() {
          const ProvinceSelect = document.getElementById('Province').value.split("[]")[0];
          const citiesSelect = document.getElementById('City');
          const City = await fetchCities(ProvinceSelect)
      
          // Clear existing options
          citiesSelect.innerHTML = '<option value="" selected></option>';
          console.log(City)
          // Populate the select with the new options
          City.forEach(region => {
            const option = document.createElement('option');
            option.value = region.name;
            option.text = region.name.split("(")[0];
            citiesSelect.add(option);
          });
        }
      
        // Initialize the region options on page load
        updateRegionOptions();
      
      
      //Nonumber
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
        function validateNumberInput(inputElement) {
          const inputValue = inputElement.value;
          if (/^(?:\+\d{12}|\d{11})$/.test(inputValue)) {
            inputElement.parentNode.children[2].innerText = '';
            return true
          } else {
            inputElement.parentNode.children[2].innerText = 'Philippine contact number only.';
            return false
          }
        }
      
      
        function passwordValidation(inputElement) {
          const inputValue = inputElement.value;
          if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/.test(inputValue)) {
            inputElement.parentNode.children[2].innerText = 'Password is Strong';
            inputElement.parentNode.children[2].style.color = 'green';
            return true
          }else{
            inputElement.parentNode.children[2].innerText = 'Password is weak';
            inputElement.parentNode.children[2].style.color = 'red';
            return false
          }
        }
        function cpasswordValidation(inputElement) {
          const inputValue = inputElement.value;
          const password = document.getElementById('password').value
          if (inputValue !== password) {
            inputElement.parentNode.children[2].innerText = 'Password doesnt match';
            return false
          }else{
            inputElement.parentNode.children[2].innerText = '';
            return true
          }
        }
      
      
        //Validation
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
          if(input.id === "password" ){
            input.addEventListener('input', function () {
              passwordValidation(this)
            });
          }else if(input.id === "cpassword" ){
            input.addEventListener('input', function () {
              cpasswordValidation(this)
            });
          }else if(input.id === "pnum" ){
            input.addEventListener('change', function () {
              validateNumberInput(this)
            });
          }else if(input.id !== "address" && input.id !== "email" && input.id !== "region"){
            input.addEventListener('change', function () {
              validateInput(this)
            });
          }
      
        });
        const REGFORM = document.getElementById('REGFORM')
        REGFORM.addEventListener('submit',async (e)=>{
          let ids = document.getElementsByTagName('BUTTON')[0]

          e.preventDefault();

    
          let errcount = 0;
          let jsondata = {}
      
            inputs.forEach(input => {
              if(input.id === "password" ){
                !(passwordValidation(input)) ? errcount++ : ""
              }else if(input.id === "pnum" ){
                !(validateNumberInput(input)) ? errcount++ : ""
              }else if(input.id === "cpassword" ){
                  !(cpasswordValidation(input))? errcount++ : ""
              }else if(input.id !== "address" && input.id !== "email" ){
                  !(validateInput(input))? errcount++ : ""
              }
      
              jsondata[input.id] = input.value
            });


            const selects = document.querySelectorAll('select');
            jsondata["city"] = selects[2].value+", "+selects[1].value.split("[]")[1]
      
            if(errcount == 0){
              let sqlcode= `UPDATE userscredentials SET 
                            Email = '${jsondata.email}', 
                            FirstName = '${jsondata.fname}', 
                            LastName = '${jsondata.lname}',
                            MiddleName = '${jsondata.lname}',
                            Address = '${jsondata.address}', 
                            City = '${jsondata.city}', 
                            PhoneNumber = '${jsondata.pnum}' 
                            WHERE userID = ${ids.id};`;
              
              await AjaxSendv3(sqlcode,"REGISTERLOGIC","")
              console.log(sqlcode)
      
              await Swal.fire({
                text: "Updated Successfully",
                icon: "success"
              });
              REGFORM.submit();
            }else{
              Swal.fire({
                text: "Fill the form correctly",
                icon: "info"
              });
      
            }


        })
      
      </script>
</body>
</html>