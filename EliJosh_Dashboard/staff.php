<?php
    $sqlcode1 = "SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE Access = 'STAFF' ORDER BY Lastname, Firstname, Middlename;";
    $queryrun1 = mysqli_query($conn,$sqlcode1);

?>
<!-- STAFF MAIN -->
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
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>

	<div style="margin-left:auto;width:fit-content;">
		<a class="box-add" href="./index.php?nzlz=staff_add">
			<i class='bx bxs-add-to-queue' ></i>
		</a>
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
						<th style="text-align: center;"><i class='bx bx-cog' ></i></th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data1 = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							$data1 .= "
							<tr>
								<td>
									<p>".$result["fullname"]."</p>
								</td>
								<td>".$result["Email"]."</td>
								<td class='TableBtns'>
									<div class='DeleteBTN' onclick='DELETION(this, `".$result["userID"]."`)'>
										<i class='bx bx-trash-alt' ></i>
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
							</tr>";
						}
						echo $data1;
					?>	
					
				</tbody>
			</table>
		</div>

	</div>
</main>
<!-- STAFF MAIN -->

<script>
    const SEARCHITEMINPUT = document.getElementById("SEARCHITEMINPUT");
    const mainquery = `SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE Access = 'STAFF' [CONDITION] ORDER BY Lastname, Firstname, Middlename;`
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
            Email LIKE '%${item}%'
            OR CONCAT(LastName, ' ' , FirstName, ' ', MiddleName ) LIKE '%${item}%'
            OR FirstName LIKE '%${item}%'
            OR LastName LIKE '%${item}%'
            OR MiddleName LIKE '%${item}%'
            OR Gender LIKE '%${item}%'
            OR DateOfBirth LIKE '%${item}%'
            OR Address LIKE '%${item}%'
            OR City LIKE '%${item}%'
            OR Country LIKE '%${item}%'
            OR PhoneNumber LIKE '%${item}%'
            OR Access LIKE '%${item}%'
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)

        const Tabledata =await AjaxSendv3(formattedText,"BOOKINGLOGIC","&Process=Search")
        TBODYELEMENT.innerHTML = Tabledata

	}

    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","MANSTAFFLOGIC","&Process=Reset")
        TBODYELEMENT.innerHTML = Tabledata
    }
    
    async function DELETION(e, ID){
        let targetid =ID
        let targetname = e.parentNode.parentNode.cells[0].innerText

        Swal.fire({
            text: `Do you want to remove ${targetname} as Staff?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then(async (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let sqlcode = `UPDATE userscredentials SET Access = 'CLIENT' WHERE userID = '${targetid}';`
                //call for AjaxsSendv3
                const Tabledata = await AjaxSendv3(sqlcode,"MANSTAFFLOGIC","&Process=DeleteUpdate")
                TBODYELEMENT.innerHTML = Tabledata
                SweetSuccess()
            }

        })
    }
</script>