<?php
 $sqlcode1 = "SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE userID <> '".$_SESSION["USERID"]."' ORDER BY Lastname, Firstname, Middlename;";
 $queryrun1 = mysqli_query($conn,$sqlcode1);


?>
<!-- ADD STAFF MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Manage Staff</h1>
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
				<h3>List of Staff</h3>
				<i class='bx bx-search' onclick="showCustomAlert()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Access</th>
						<th style="text-align: center;"><i class='bx bx-cog' ></i></th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data1 = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							# code...
							$statuscolor = $result['Access'] == "STAFF" ? "completed" :"pending";
							$data1 .= "
							<tr>
								<td>
									<p>".$result["fullname"]."</p>
								</td>
								<td>".$result["Email"]."</td>
								<td><span class='status $statuscolor'>".$result['Access']."</span></td>
								<td class='TableBtns'>
									<div class='EditBTN' onclick='EDIT(this, `".$result['userID']."`)'>
										<i class='bx bx-edit-alt' ></i>
									</div>
								</td>
							</tr>
							";
						}
						if(mysqli_num_rows($queryrun1) <= 0){
							$data1 .= "
							<tr>
								<td>No Data</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>";
						}
						echo $data1;
					?>
					
				</tbody>
			</table>
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