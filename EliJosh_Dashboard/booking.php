<?php
	$sqlcode1 = "SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID ORDER BY a.CheckInDate DESC;";
	$queryrun1 = mysqli_query($conn,$sqlcode1);
?>

<!-- BOOKING MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Booking</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Booking</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>

	<div style="margin-left:auto;width:fit-content;">
		<a class="box-add" href="#" onclick="OPENBOOKING()">
			<i class='bx bxs-add-to-queue' ></i>
		</a>
	</div>


	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Reservations</h3>
				<i class='bx bx-search' onclick="showCustomAlert()"></i>
				<i class='bx bx-filter' onclick="FILTERING()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Guest</th>
						<th>Check-in</th>
						<th>Check-out</th>
						<th>Status</th>
						<th style="text-align: center;"><i class='bx bx-cog' ></i></th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data1 = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							$time = $result['eCheckin'];
							$statuscolor = ($result['ReservationStatus'] == "BOOKED" ? "process" : ($result['ReservationStatus'] == "CANCELLED" ? "pending" : "completed"));
							
							$data1 .= "
							<tr>
								<td style='display:flex;flex-direction:column;align-items:start;'>
									<p>".$result['Name']."</p>
									<small><i>".$result['Email']."</i></small>
								</td>
								<td>$time</td>
								<td>".$result['finalCheckout']."</td>
								<td><a href='#' onclick='showChangeStatus(`".$result['ReservationID']."`,`".$result['ReservationStatus']."`)'><span class='status $statuscolor'>".$result['ReservationStatus']."</span></a></td>
								<td class='TableBtns'>
									<a class='EditBTN' href='./index.php?nzlz=booking_info&ISU=".$result['ReservationID']."'  rel='noopener noreferrer'>
										<i class='bx bx-edit-alt' ></i>
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
<!-- BOOKING MAIN -->



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
            b.ReservationID LIKE '%${item}%' OR
            b.GuestID LIKE '%${item}%' OR
            b.RoomNumber LIKE '%${item}%' OR
            b.CottageTypeID LIKE '%${item}%' OR
            b.ReservationStatus LIKE '%${item}%' OR
            a.FirstName LIKE '%${item}%' OR
            a.LastName LIKE '%${item}%' OR
            a.Email LIKE '%${item}%' OR
            a.Phone LIKE '%${item}%' OR
            CONCAT(a.LastName,', ', a.FirstName) LIKE '%${item}%' 
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)

        const Tabledata =await AjaxSendv3(formattedText,"BOOKINGLOGIC","&Process=Search")
        TBODYELEMENT.innerHTML = Tabledata

	}
	async function showChangeStatus(IDS, VALUES) {
		let access = 0;
		switch (VALUES) {
			case "BOOKED":
				access = 1;
				break;
			case "CHECKIN":
				access = 2;
				break;
			case "CHECKOUT":
				access = 3;
				break;
			case "CANCELLED":
				access = 4;
				break;
		}
		let design = `
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Status</label>
				<select class='SWALinput swalselect' id='swal-input1' aria-label='Floating label select example' style='padding:0.5em;'>
                    <option value='BOOKED' ${access == 1 ? "selected" : ""}>Booked</option>
                    <option value='CHECKIN' ${access == 2 ? "selected" : ""}>Checked in</option>
                    <option value='CHECKOUT' ${access == 3 ? "selected" : ""}>Checked out</option>
                    <option value='CANCELLED' ${access == 4 ? "selected" : ""}>Cancelled</option>
                </select>
			</div>
		`
		let swalvalue = await POPUPCREATE('Status Change',design,1)

		if(swalvalue[0].length <= 0 ){
			await Swal.fire({
				text: "No Information Found",
				icon: "info"
			});
		}

		let item = swalvalue[0]
		let searchcondition = `UPDATE reservations SET ReservationStatus = '${item}' WHERE ReservationID = ${IDS};`;
        const Tabledata =await AjaxSendv3(searchcondition,"BOOKINGLOGIC","&Process=AccessUpdate")
        TBODYELEMENT.innerHTML = Tabledata

	}
	async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","BOOKINGLOGIC","&Process=Reset")
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
				const Tabledata =await AjaxSendv3(formattedText,"BOOKINGLOGIC","&Process=Search")
				TBODYELEMENT.innerHTML = Tabledata

			}else{
				await Swal.fire({
					text: "No Data",
					icon: "error"
				});
			}
		}

    }

	async function OPENBOOKING(){
        let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Check-in</label>
			<input type ="datetime-local" class='SWALinput swalselect' id="swal-input1" placeholder="" style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Package</label>
			<select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example' style='padding:0.5em;'>
				<option value="Package1">Swimming Only</option>
				<option value='Package2'>Room + Swimming</option>
				<option value='Package3'>Pavilions</option>
			</select>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Time Range</label>
			<select class='SWALinput swalselect' id='swal-input3' aria-label='Floating label select example' style='padding:0.5em;'>
				<option value="Day">08:00 AM - 05:00 PM</option>
				<option value='Night'>07:00 PM - 07:00 AM</option>
				<option value='22Hrs'>02:00 PM - 12:00 PM</option>
			</select>
		</div>`

        let formValues =await POPUPCREATE("Walk-in Registration",design,3)
        if (formValues) {
            if(!formValues[0]){
                await Swal.fire({
                    text: "Please enter check-in time",
                    icon: "info"
                });
                return 
            }
            let values1 = formValues[0].split("T")


            let  senddata = await AjaxSendv3(formValues[1],"Availability",`&cin=${values1[0]}&tday=${formValues[2]}`)  
                if(senddata == "true"){
                    await Swal.fire({
                        text: "There's an available slot",
                        icon: "success"
                    });
                    location.href = `./index.php?nzlz=booking_walkin&cin=${values1[0]}&package=${formValues[1]}&tRANGE=${formValues[2]}&ETIME=${values1[1]}`;
                }else{
                    await Swal.fire({
                        text: "The date has been fully booked",
                        icon: "info"
                    });
                }

        }


        //location.href = `./Mainpage.php?nzlz=reservationform&plk=2&cin=2023-12-10&ETIME=12:00&adultval=200&kidval=150&package=Package1&tRANGE=Day&na=4&nk=3&ns=3&tinit=1730.00`;
    }
</script>