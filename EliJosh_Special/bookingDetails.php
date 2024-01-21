<?php
$sqlcode1 = "SELECT  a.*, (a.NumAdults + a.NumChildren + a.NumSeniors + a.NumExcessPax) AS noguest,
	CASE
	  WHEN a.package = 'Package1' THEN 'Swimming'
	  WHEN a.package = 'Package2'THEN 'Rooms + Swimming'
	  ELSE 'Pavilion'
	END AS packagesname,
  b.* FROM reservations a LEFT JOIN guestpayments b ON a.ReservationID = b.ReservationID WHERE a.UserID = '" . $_SESSION["USERID"] . "' AND b.Description is NOT NULL ORDER BY a.ReservationID DESC;";
$queryrun1 = mysqli_query($conn, $sqlcode1);
?>

<!-- BOOKING MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Reservation Details</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Reservation Details</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>

	<div style="margin-left:auto;width:fit-content;">
		<a class="box-add" href="../EliJosh_Client/index.php">
			<i class='bx bxs-add-to-queue'></i>
		</a>
	</div>


	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Reservations</h3>
				<i class='bx bx-filter' onclick="FILTERING()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Check-in</th>
						<th>Time & Package</th>
						<th>Downpayment</th>
						<th>Payment ID</th>
						<th>Status</th>
						<th style="text-align: center;"><i class='bx bx-cog'></i></th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
					$data1 = "";
					while ($result = mysqli_fetch_assoc($queryrun1)) {
						$time = $result['eCheckin'];
						$statuscolor = ($result['ReservationStatus'] == "BOOKED" ? "process" : ($result['ReservationStatus'] == "CANCELLED" ? "pending" : "completed"));


						if ($result['ReservationStatus'] != "CANCELLED" && $result['ReservationStatus'] != "CHECKOUT") {
							$onclicvalue = "showChangeStatus(`" . $result['ReservationID'] . "`,`" . $result['ReservationStatus'] . "`)";
						} else {
							$onclicvalue = "";
						}

						$data1 .= "
							<tr>
								<td style='display:flex;flex-direction:column;align-items:start;'>
									<p>" . $result['eCheckin'] . "</p>
								</td>
								<td>
								" . $result['timapackage'] . " " . $result['packagesname'] . "
								</td>
								<td>
								 ₱ " . number_format($result['Downpayment'], 2) . "
								</td>
								<td>" . $result['Description'] . "</td>


								<td><a href='#' onclick='$onclicvalue'><span class='status $statuscolor'>" . $result['ReservationStatus'] . "</span></a></td>
								
								
								<td class='TableBtns'>
									<a class='EditBTN' href='../Admins/Composer/paypal2.php?id=" . $result['ReservationID'] . "'  rel='noopener noreferrer'>
										<i class='bx bx-printer' ></i>
									</a>
								</td>
							</tr>";
					}

					if (mysqli_num_rows($queryrun1) <= 0) {
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
	//var mainquery = "SELECT a.*, b.*, CONCAT(b.LastName,', ', b.FirstName) as Name FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID WHERE [CONDITION] ORDER BY a.CheckInDate DESC;";
	const TBODYELEMENT = document.getElementById('TBODYELEMENT');

	async function showChangeStatus(IDS, VALUES) {
		let access = 0;
		switch (VALUES) {
			case "BOOKED":
				access = 1;
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
                    <option value='CANCELLED' ${access == 4 ? "selected" : ""}>Cancelled</option>
                </select>
			</div>
		`
		let swalvalue = await POPUPCREATE('Status Change', design, 1)

		if (swalvalue) {
			if (swalvalue[0] === "CANCELLED") {
				Swal.fire({
					title: 'Cancellation Reason',
					html: '<textarea id="cancellationReason" class="swal2-input custom-textarea" style="width:300px;" rows="10" placeholder="Enter reason for cancellation"></textarea>',
					showCancelButton: true,
					confirmButtonText: 'Submit',
					cancelButtonText: 'Cancel',
					showLoaderOnConfirm: true,
					preConfirm: () => {
						const reason = document.getElementById('cancellationReason').value;
						if (!reason) {
							Swal.showValidationMessage('Please enter the reason for cancellation');
						}
						return reason;
					},
				}).then(async (result) => {
					if (result.isConfirmed) {
						// Handle the cancellation reason (result.value)
						let sqlcode = `INSERT INTO notification ( reservationID, Message, Type, Status) VALUES ( '${IDS}', '${result.value}', 'Request', 'PENDING');`
						await AjaxSendv3(sqlcode,"BOOKINGLOGIC","&Process=insertion")
						await Swal.fire({
							title: 'Cancellation Request',
							text: 'Your cancellation request is now pending. We will review it shortly.',
							icon: 'info',
						});
					}
				});
			}
		}


		//let item = swalvalue[0]
		//let searchcondition = `UPDATE reservations SET ReservationStatus = '${item}' WHERE ReservationID = ${IDS};`;
		//const Tabledata =await AjaxSendv3(searchcondition,"BOOKINGLOGIC","&Process=AccessUpdate")
		//TBODYELEMENT.innerHTML = Tabledata

	}
	async function RESETTABLE() {
		const Tabledata = await AjaxSendv3("", "BOOKINGLOGIC", "&Process=Reset")
		await Swal.fire({
			text: "The table has been reset.",
			icon: "success"
		});
		TBODYELEMENT.innerHTML = Tabledata

	}

	async function FILTERING() {
		let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Arrival</label>
			<input type ="date" id="swal-input1" class="SWALinput" required style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Status</label>
			<select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example' style='padding:0.5em;'>
                    <option value="-">-</option>
                    <option value='BOOKED'>Booked</option>
                    <option value='CANCELLED'>Cancelled</option>
                </select>
		</div>`

		let formValues = await POPUPCREATE("Filters", design, 2, "Search")


		if (formValues) {
			if (formValues[0] !== "" || formValues[1] !== "-") {
				let conditions = [];

				if (formValues[0] !== "") {
					conditions.push(`
						DATE(a.eCheckin)  = '${formValues[0]}'
					`);
				}
				if (formValues[1] !== "-") {
					conditions.push(`a.ReservationStatus = '${formValues[1]}'`)
				}

				const joinedString = conditions.join(' AND ');
				const Tabledata = await AjaxSendv3(joinedString, "BOOKINGLOGIC", "&Process=Search")
				TBODYELEMENT.innerHTML = Tabledata

			} else {
				await Swal.fire({
					text: "No Data",
					icon: "error"
				});
			}
		}
	}

	async function OPENBOOKING() {
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

		let formValues = await POPUPCREATE("Walk-in Registration", design, 3)
		if (formValues) {
			if (!formValues[0]) {
				await Swal.fire({
					text: "Please enter check-in time",
					icon: "info"
				});
				return
			}
			let values1 = formValues[0].split("T")


			let senddata = await AjaxSendv3(formValues[1], "Availability", `&cin=${values1[0]}&tday=${formValues[2]}`)
			if (senddata == "true") {
				await Swal.fire({
					text: "There's an available slot",
					icon: "success"
				});
				location.href = `./specialcon.php?nzlz=booking&cin=${values1[0]}&package=${formValues[1]}&tRANGE=${formValues[2]}&ETIME=${values1[1]}`;
			} else {
				await Swal.fire({
					text: "The date has been fully booked",
					icon: "info"
				});
			}

		}


		//location.href = `./Mainpage.php?nzlz=reservationform&plk=2&cin=2023-12-10&ETIME=12:00&adultval=200&kidval=150&package=Package1&tRANGE=Day&na=4&nk=3&ns=3&tinit=1730.00`;
	}
</script>