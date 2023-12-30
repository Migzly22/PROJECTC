<!DOCTYPE html>
<!-- Designined by CodingLab - youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Registration Form | EliJosh Resort & Events Place</title>
  
    <link rel="stylesheet" href="./CSS/stylev2.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">


	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

     <script src="./JS/script1.js"></script>

     <link rel="icon" type="image/x-icon" href="../EliJosh_Dashboard/img/title_logo.ico">
   </head>
   
<body>
  <div class="container">
    <!--<div class="title">Registration</div>
    <div class="logo">
      <img src="/EliJosh Login/css/image/title_logo.png" alt="">
    </div>-->
    <div class="title-and-image">
      <div class="title">Registration</div>
      <!-- Add your image source -->
      <img src="./CSS/image/title_logo.png" alt="Right Image">
    </div>
    <div class="content">
      <form action="../EliJosh_Login/index.php" id="REGFORM" method="post">
        <div class="user-details">
          <div class="input-box">
            <input type="text" placeholder="First name" id="fname" required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box">
            <input type="text" placeholder="Middle name" id="mname"  required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box">
            <input type="text" placeholder="Surname" id="lname" required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box-4">
            <input type="text" placeholder="Address" id="address" required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box">
            <select id="region" required onchange="showProvince()">
              <option value="" selected>--Select Region--</option>
            </select>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box">
            <select id="Province" required onchange="showCities()">
              <option value="" selected>--Select Province--</option>
            </select>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box">
            <select id="City" required>
              <option value="" selected>--Select City--</option>
            </select>
            <small style="color:red;text-align:center;"></small>
          </div>

          <div class="input-box-5">
            <input type="text" placeholder="Contact No."  id="pnum"  required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box-5">
            <input type="text" placeholder="Email Address" id="email" required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box-5">
            <input type="password" placeholder="Password" id="password" required>
            <small style="color:red;text-align:center;"></small>
          </div>
          <div class="input-box-5">
            <input type="password" placeholder="Confirm Password" id="cpassword" required>
            <small style="color:red;text-align:center;"></small>
          </div>
        <!--<div class="note">
            <h6>* At least 8 characters long<br>
                * Contains at least One Uppercase letter<br>
                * Contains at least One Lowercase letter<br>
                * Contains at least One Digit<br>
                * Contains atleast One Special Character (e.g.,!@#$%^&*)
            </h6>
        </div>-->
       
        <div class="button">
            <input type="submit" value="Register">
          </div>
      </form>
    </div>
    <div class="login">
      <span class="login">Already have an account?
        <?php
          $specialcase = isset(explode('?', $_SERVER['REQUEST_URI'])[1]) ?   "?".explode('?', $_SERVER['REQUEST_URI'])[1] : "";
          echo "<a class='link' href='../EliJosh_Login/index.php$specialcase'>Sign in</a>  ";
        ?>   
      </span>
    </div>
  </div>

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
    regionSelect.innerHTML = '<option value="" selected>--Select Region--</option>';

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
    ProvinceSelect.innerHTML = '<option value="" selected>--Select Province--</option>';

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
    citiesSelect.innerHTML = '<option value="" selected>--Select City--</option>';
    // Populate the select with the new options
    City.forEach(region => {
      const option = document.createElement('option');
      option.value = region.name;
      option.text = region.name.split("(")[0];
      citiesSelect.add(option);
    });
  }
  function convertToUppercase(inputElement) {
        const inputValue = inputElement.value;
        inputElement.value = inputValue.toUpperCase();
    }

  // Initialize the region options on page load
  updateRegionOptions();


//Nonumber
  function validateInput(inputElement) {
    const inputValue = inputElement.value;
    if (/[\d]/.test(inputValue)) {
      inputElement.parentNode.children[1].innerHTML = 'Should not contain numbers.';
      return false
    } else {
      inputElement.parentNode.children[1].innerHTML = '';
      return true
    }
  }
  function validateNumberInput(inputElement) {
    const inputValue = inputElement.value;
    if (/^(?:\+\d{12}|\d{11})$/.test(inputValue)) {
      inputElement.parentNode.children[1].innerText = '';
      return true
    } else {
      inputElement.parentNode.children[1].innerText = 'Philippine contact number.';
      return false
    }
  }


  function passwordValidation(inputElement) {
    const inputValue = inputElement.value;
    if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/.test(inputValue)) {
      inputElement.parentNode.children[1].innerText = 'Password is Strong';
      inputElement.parentNode.children[1].style.color = 'green';
      return true
    }else{
      inputElement.parentNode.children[1].innerText = 'Password is weak';
      inputElement.parentNode.children[1].style.color = 'red';
      return false
    }
  }
  function cpasswordValidation(inputElement) {
    const inputValue = inputElement.value;
    const password = document.getElementById('password').value
    if (inputValue !== password) {
      inputElement.parentNode.children[1].innerText = 'Password doesnt match';
      return false
    }else{
      inputElement.parentNode.children[1].innerText = '';
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
    }else if(input.id !== "address" && input.id !== "email" ){
      input.addEventListener('change', function () {
        validateInput(this)
        convertToUppercase(this)
      });
    }else if (input.id === "address" ){
      input.addEventListener('input', function() {
        convertToUppercase(this)
      });
    }

  });
  const REGFORM = document.getElementById('REGFORM')
  REGFORM.addEventListener('submit',async (e)=>{
    e.preventDefault();
    let errcount = 0;
    let jsondata = {}

      inputs.forEach(input => {
        if(input.type !== "submit"){
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
        }

      });

//EMAIL VALIDATION
      if(await AjaxSendv3(jsondata.email,"REGISTERLOGIC","&other=VALIDATION") !== "VALID"){
        Swal.fire({
          text: "Email was Already been Existed",
          icon: "error"
        });
        return 
      }

//PASSWORD ENCRYPTION
      let passwordnew = await AjaxSendv3(jsondata.password,"REGISTERLOGIC","&other=ENCRYPTION");

      const selects = document.querySelectorAll('select');
      jsondata["city"] = selects[2].value+", "+selects[1].value.split("[]")[1]

      if(errcount == 0){
        let sqlcode= `INSERT INTO userscredentials (Password, Email, FirstName, LastName, MiddleName, Address, City, Country, PhoneNumber) 
        VALUES ('${passwordnew}', '${jsondata.email}', '${jsondata.fname}', '${jsondata.lname}', '${jsondata.mname}','${jsondata.address}', '${jsondata.city}', 'PH', '${jsondata.pnum}');`;
        
        console.log(sqlcode)
        await AjaxSendv3(sqlcode,"REGISTERLOGIC","")

        await Swal.fire({
          text: "Registered Successfully",
          icon: "success"
        });

        let cururl = location.href;
        
        if(cururl.includes("?")){
          let cururl = location.href
          let data = cururl.split("?")[1]
          sessionStorage.setItem("MissedBooked", data);
          //REGFORM.action = `./breakdownv2.php?${data}`
        }

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
