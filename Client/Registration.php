<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>


    <link rel="stylesheet" href="./CSS/Login1.css">
    <link rel="stylesheet" href="./CSS/registration.css">

    <script src="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!--Jquery-->
    <script src="../Jquery/node_modules/jquery/dist/jquery.js"></script>
    <script src="../Jquery/node_modules/jquery/dist/jquery.min.js"></script>

  

    <script src="./JS/script1.js"></script>
</head>
<body>

    <section>
        <form action="./login.php" class="form" method="post" id="REGFORM">
            <header>
              <h1 class="text-center">Registration</h1>
            </header>
            <div class="levels-3">
              <div class="form-group">
                <input type="text" id="fname" required>
                <label for="fname">First Name <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
              <div class="form-group">
                <input type="text" id="mname" required>
                <label for="mname">Middle Name <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
              <div class="form-group">
                <input type="text" id="lname" required>
                <label for="lname">Surname <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
            </div>
            <div class="levels">
              <div class="form-group">
                <input type="text" id="address" required>
                <label for="address">Address <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
            </div>

            <div class="levels-3">
              <div class="form-group">
                <select id="region" required onchange="showProvince()">
                  <option value="" selected></option>
                </select>
                <label for="region">Region <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
              <div class="form-group">
                <select id="Province" required onchange="showCities()">
                  <option value="" selected></option>
                </select>
                <label for="Province">Province <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
              <div class="form-group">
                <select id="City" required>
                  <option value="" selected></option>
                </select>
                <label for="City">City <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
              
            </div>

            <div class="levels-2">
              <div class="form-group">
                <input type="text" name="pnum" id="pnum" required>
                <label for="pnum">Contact no. <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
              <div class="form-group">
                <input type="email" name="email" id="email" required>
                <label for="email">Email address <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
            </div>
            <div class="levels-2">
              <div class="form-group">
                <input type="password" name="password" id="password" required>
                <label for="password">Password <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
                <small style="white-space: pre-line;">
                  At least 8 characters long.
                  Contains at least one uppercase letter.
                  Contains at least one lowercase letter.
                  Contains at least one digit.
                  Contains at least one special character (e.g., !@#$%^&*).
                </small>
              </div>
              <div class="form-group">
                <input type="password" name="cpassword" id="cpassword" required>
                <label for="cpassword">Confirm Password <span style="color: red;">*</span></label>
                <p style="color:red;text-align:center;"></p>
              </div>
            </div>
            <div class="specials123" style="display: flex;justify-content: center;">
              <button type="submit" name="SignupBtn">Register</button>
            </div>
            
            <p class="text-center">Already have an account? 
              <?php
                $specialcase = isset(explode('?', $_SERVER['REQUEST_URI'])[1]) ?   explode('?', $_SERVER['REQUEST_URI'])[1] : "";
                echo "<a class='link' href='./login.php?$specialcase'>Sign in</a>  ";
              ?>    
                
            </p>
        </form>
    </section>

      
</body>
</html>

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
    }else if(input.id !== "address" && input.id !== "email" ){
      input.addEventListener('change', function () {
        validateInput(this)
      });
    }

  });
  const REGFORM = document.getElementById('REGFORM')
  REGFORM.addEventListener('submit',async (e)=>{
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
        let sqlcode= `INSERT INTO userscredentials (Password, Email, FirstName, LastName, MiddleName, Address, City, Country, PhoneNumber) 
        VALUES ('${jsondata.password}', '${jsondata.email}', '${jsondata.fname}', '${jsondata.lname}', '${jsondata.mname}','${jsondata.address}', '${jsondata.city}', 'PH', '${jsondata.pnum}');`;
        
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
