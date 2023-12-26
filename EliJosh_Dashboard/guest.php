<?php
$sqlcode1 = "SELECT a.*, b.*, CONCAT(a.LastName,', ', a.FirstName) as Name FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID ORDER BY a.Lastname, a.Firstname;";
$queryrun1 = mysqli_query($conn,$sqlcode1);

?>
<!-- GUEST MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Guest</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Guest</a>
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
				<h3>Guest List</h3>
				<i class='bx bx-search' onclick="showCustomAlert()"></i>
				<i class='bx bx-filter' onclick="FILTERING()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Guest</th>
						<th>Email</th>
						<th>Arrival</th>
						<th>Checkout</th>
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
									<p>".$result['Name']."</p>
								</td>
								<td>".$result['Email']."</td>
								<td>".$result['eCheckin']."</td>
								<td>".$result['finalCheckout']."</td>
								<td class='TableBtns'>
									<a class='OpenBTN' href='./index.php?nzlz=guest_info&ISU=".$result['GuestID']."'  rel='noopener noreferrer'>
										<i class='bx bx-book-open' ></i>
									</a>
								</td>
							</tr>";
						}

						if(mysqli_num_rows($queryrun1) <= 0){
							$data1 .= "
							<tr>
								<td>No Data</td>
								<td></td>
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
<!-- GUEST MAIN -->

<script>
	// Function to show SweetAlert with custom HTML
	var mainquery = "SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID WHERE [CONDITION] ORDER BY a.CheckInDate DESC;";
	const TBODYELEMENT = document.getElementById('TBODYELEMENT');
	
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
		let searchcondition = `(
            a.ReservationID LIKE '%${item}%' OR
            a.GuestID LIKE '%${item}%' OR
            a.ReservationStatus LIKE '%${item}%' OR
            b.FirstName LIKE '%${item}%' OR
            b.LastName LIKE '%${item}%' OR
            b.Email LIKE '%${item}%' OR
            b.Phone LIKE '%${item}%' OR
            CONCAT(b.LastName,', ', b.FirstName) LIKE '%${item}%' 
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)

        const Tabledata =await AjaxSendv3(formattedText,"GUESTLOGIC","&Process=Search")
        TBODYELEMENT.innerHTML = Tabledata

	}
	async function RESETTABLE() {
		const Tabledata =await AjaxSendv3("","GUESTLOGIC","&Process=Reset")
		await Swal.fire({
			text: "The table has been reset.",
			icon: "success"
		});
        TBODYELEMENT.innerHTML = Tabledata
		
    }

    async function FILTERING(){
        let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Search</label>
			<input type="text" id="swal-input1" class="SWALinput" placeholder="Enter text..." style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Checked-in</label>
			<input type ="date" id="swal-input2" class="SWALinput" required style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Status</label>
			<select class='SWALinput swalselect' id='swal-input3' aria-label='Floating label select example' style='padding:0.5em;'>
                    <option value="-">-</option>
                    <option value='BOOKED'>Booked</option>
                    <option value='CHECKIN'>Checked in</option>
                    <option value='CHECKOUT'>Checked out</option>
                    <option value='CANCELLED'>Cancelled</option>
                </select>
		</div>`

        let formValues =await POPUPCREATE("Filters",design,3)
		if(formValues){
			if (formValues[0] !== "" || formValues[1] !== "" || formValues[2] !== "-") {
				let conditions = [];

				if(formValues[0] !== ""){
					let item = formValues[0]
					conditions.push(`(
						a.ReservationID LIKE '%${item}%' OR
						a.GuestID LIKE '%${item}%' OR
						a.ReservationStatus LIKE '%${item}%' OR
						b.FirstName LIKE '%${item}%' OR
						b.LastName LIKE '%${item}%' OR
						b.Email LIKE '%${item}%' OR
						b.Phone LIKE '%${item}%' OR
						CONCAT(b.LastName,', ', b.FirstName) LIKE '%${item}%' 
					)`);
				}
				if(formValues[1] !== ""){
					conditions.push(`
						a.CheckInDate  = '${formValues[1]}'
					`);
				}
				if(formValues[2] !== "-"){
					conditions.push(`a.ReservationStatus = '${formValues[2]}'`)
				}

				const joinedString = conditions.join(' AND ');
				const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);

				console.log(formattedText)
				const Tabledata =await AjaxSendv3(formattedText,"GUESTLOGIC","&Process=Search")
				TBODYELEMENT.innerHTML = Tabledata

			}else{
				await Swal.fire({
					text: "No Data",
					icon: "error"
				});
			}
		}

    }
</script>