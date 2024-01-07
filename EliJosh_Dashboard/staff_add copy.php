<?php
 $sqlcode1 = "SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE userID <> '".$_SESSION["USERID"]."' ORDER BY Lastname, Firstname, Middlename;";
 $queryrun1 = mysqli_query($conn,$sqlcode1);


?>
<!-- ADD STAFF MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Adding Staff</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Staff</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="./index.php?nzlz=staff">Home</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Adding Staff</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Staff Registration Form</h3>
			</div>
			<form action="./index.php?nzlz=staff" method="post" class="formcontainers" id="REGFORM">
                <div class="layer-3">
                    <div class="form-group f30">
                        <input type="text" class="form-control" value="" name="" id="fname" required placeholder="">
                        <label for="" class="form-label">First name <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f30">
                        <input type="text" class="form-control" name="" value="" id="mname" required placeholder=" ">
                        <label for=""  class="form-label">Middle name <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f30">
                        <input type="text" class="form-control" name="" value="" id="lname" required placeholder=" ">
                        <label for=""  class="form-label">Last name <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
				<div class="layer-1">
                    <div class="form-group">
                        <input type="text" class="form-control" name="" value="" id="address" required placeholder=" ">
                        <label for=""  class="form-label">Address <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
                <div class="layer-2">
                    <div class="form-group f45">
                        <input type="email" class="form-control" name="" value="" id="email" required placeholder=" ">
                        <label for=""  class="form-label">Email <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f45">
                        <input type="text" class="form-control" name="" value="" id="pnum" required placeholder=" ">
                        <label for=""  class="form-label">Contact # <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
				<div class="layer-3">
                    <div class="form-group f30">
						<select id="region" required onchange="showProvince()" class="form-control">
							<option value="" selected>--Select Region--</option>
						</select>                        
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f30">
						<select id="Province" required onchange="showCities()" class="form-control">
							<option value="" selected>--Select Province--</option>
						</select>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f30">
						<select id="City" required class="form-control">
							<option value="" selected>--Select City--</option>
						</select>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
				<div class="layer-2">
                    <div class="form-group f45">
                        <input type="password" class="form-control" name="" value="" id="password" required placeholder=" ">
                        <label for=""  class="form-label">Password <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                    <div class="form-group f45">
                        <input type="password" class="form-control" name="" value="" id="cpassword" required placeholder=" ">
                        <label for=""  class="form-label">Confirm Password # <span class="requiredcolor">*</span></label>
                        <small style="color: #D2042D;text-align:center;"></small>
                    </div>
                </div>
				<h6>* At least 8 characters long<br>
					* Contains at least One Uppercase letter<br>
					* Contains at least One Lowercase letter<br>
					* Contains at least One Digit<br>
					* Contains atleast One Special Character (e.g.,!@#$%^&*)
				</h6>
                <div class="BUTTONHANDLER">
                    <button type="submit" class="ContinueBTN">Continue</button>
                </div>
                
            </form>

		</div>

	</div>
</main>
<!-- ADD STAFF MAIN -->
<script>
    const SEARCHITEMINPUT = document.getElementById("SEARCHITEMINPUT");
    const mainquery = `SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE userID <> '<?php echo $_SESSION["USERID"];?>' [CONDITION] ORDER BY Lastname, Firstname, Middlename;`
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')


	async function showCustomAlert() {
		let design = `
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Search</label>
				<input type="text" id="swal-input1" placeholder="Enter text..." style='padding:0.5em;'>
			</div>
		`
		let swalvalue = await POPUPCREATE('Search Information',design,1)

		if(swalvalue[0].length <= 0 ){
			await Swal.fire({
				text: "No Information Found",
				icon: "info"
			});
		}

		let item = swalvalue[0]
		let searchcondition = `AND (
            Email LIKE '%{item}%'
            OR CONCAT(LastName, ' ' , FirstName, ' ', MiddleName ) LIKE '%{item}%'
            OR FirstName LIKE '%{item}%'
            OR LastName LIKE '%{item}%'
            OR MiddleName LIKE '%{item}%'
            OR Gender LIKE '%{item}%'
            OR DateOfBirth LIKE '%{item}%'
            OR Address LIKE '%{item}%'
            OR City LIKE '%{item}%'
            OR Country LIKE '%{item}%'
            OR PhoneNumber LIKE '%{item}%'
            OR Access LIKE '%{item}%'
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)

        const Tabledata =await AjaxSendv3(formattedText,"ADDINGSTAFF2",`&Process=Search&data=${item}`)
        TBODYELEMENT.innerHTML = Tabledata

	}
    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","ADDINGSTAFF2","&Process=Reset")
        TBODYELEMENT.innerHTML = Tabledata
    }
    async function EDIT(e, ID){
        let targetid = ID
        let targetname = e.parentNode.parentNode.cells[2].innerText.trim()
        let accessval = ["","",""]
        switch(targetname){
            case "ADMIN":
                accessval[0] = "selected";
                break;
            case "STAFF":
                accessval[1] = "selected";
                break;
            case "CLIENT":
                accessval[2] = "selected";
                break;
        }

        let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Search</label>
			<select class='SWALinput swalselect' id='swal-input1' aria-label='Floating label select example' style='padding:0.5em;'>
                    <option value='ADMIN' ${accessval[0]}>Admin</option>
                    <option value='CLIENT' ${accessval[2]}>Client</option>
                    <option value='STAFF' ${accessval[1]}>Staff</option>
                </select>
		</div>`

        let formValues =await POPUPCREATE("Edit Access",design,1)

        if (formValues) {

            const formattedText = `UPDATE userscredentials SET Access = '${formValues[0]}' WHERE userID = '${targetid}';`
        
            console.log(formattedText)
            const Tabledata =await AjaxSendv3(formattedText,"ADDINGSTAFF2","&Process=AccessUpdate")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
    

</script>

<script>

  async function fetchProvince(regioncode = null) {
	return fetch('PH.json')
	.then(response => {
		if (!response.ok) {
		throw new Error('Network response was not ok');
		}
		return response.json();
	})
	.then(data => {
		return Object.keys(data[regioncode].province_list).sort()
	})
	.catch(error => {
		console.error('Error fetching JSON:', error);
	});
  }

  async function fetchCities(regioncode = null, province = null) {
	return fetch('PH.json')
	.then(response => {
		if (!response.ok) {
		throw new Error('Network response was not ok');
		}
		return response.json();
	})
	.then(data => {
		return Object.keys(data[regioncode].province_list[province].municipality_list).sort()
	})
	.catch(error => {
		console.error('Error fetching JSON:', error);
	});
  }

  async function updateRegionOptions() {
    const regionSelect = document.getElementById('region');

	fetch('PH.json')
	.then(response => {
		if (!response.ok) {
		throw new Error('Network response was not ok');
		}
		return response.json();
	})
	.then(data => {
		// Now, 'data' contains the content of the JSON file
		    // Clear existing options
			regionSelect.innerHTML = '<option value="" selected>--Select Region--</option>';
		// Populate the select with the new options
		Object.keys(data).sort().forEach(region => {
			const option = document.createElement('option');
			option.value = region
			option.text = region;
			regionSelect.add(option);
		});

	})
	.catch(error => {
		console.error('Error fetching JSON:', error.message);
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
		option.value = region
		option.text = region;
		ProvinceSelect.add(option);
    });
  }

  async function showCities() {
    const ProvinceSelect = document.getElementById('Province').value.split("[]")[0];
	const regionSelect = document.getElementById('region').value;
    const citiesSelect = document.getElementById('City');
	
    const City = await fetchCities(regionSelect,ProvinceSelect)

    // Clear existing options
    citiesSelect.innerHTML = '<option value="" selected>--Select City--</option>';
    // Populate the select with the new options
    City.forEach(region => {
		const option = document.createElement('option');
		option.value = region
		option.text = region;
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
      inputElement.parentNode.children[2].innerHTML = 'Should not contain numbers.';
      return false
    } else {
      inputElement.parentNode.children[2].innerHTML = '';
      return true
    }
  }
  function validateNumberInput(inputElement) {
    const inputValue = inputElement.value;
    if (/^(?:\+\d{12}|\d{11})$/.test(inputValue)) {
      inputElement.parentNode.children[2].innerText = '';
      return true
    } else {
      inputElement.parentNode.children[2].innerText = 'Philippine contact number.';
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
      jsondata["city"] = selects[2].value+", "+selects[1].value

      if(errcount == 0){
        let sqlcode= `INSERT INTO userscredentials (Password, Email, FirstName, LastName, MiddleName, Address, City, Country, PhoneNumber, Access) 
        VALUES ('${passwordnew}', '${jsondata.email}', '${jsondata.fname}', '${jsondata.lname}', '${jsondata.mname}','${jsondata.address}', '${jsondata.city}', 'PH', '${jsondata.pnum}', 'STAFF');`;
        
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
          //REGFORM.action = `./index.php?nzlz=staff`
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