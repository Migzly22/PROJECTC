<?php
	$sqlcode1 = "SELECT c.*, CONCAT(TIME(d.eCheckin), ' to ', TIME(d.CheckOutDate)) AS DT, IF(d.ReservationStatus IS NULL, 'Available', IF(d.ReservationStatus = 'CANCELLED', 'Available', d.ReservationStatus)) AS Status FROM rooms c LEFT JOIN (SELECT a.*, b.* FROM roomsreservation a LEFT JOIN (SELECT * FROM reservations WHERE CheckInDate = CURRENT_DATE() AND ReservationStatus != 'CHECKOUT') b ON a.greservationID = b.ReservationID WHERE b.ReservationID IS NOT NULL) d ON c.RoomNum = d.Room_num GROUP BY c.RoomID ORDER BY c.RoomNum ;";
	$queryrun1 = mysqli_query($conn, $sqlcode1);

?>

<!-- ROOM MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Rooms</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Rooms</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>
	
	<?php
		if($_SESSION["ACCESS"] == "ADMIN"){
	?>
		<div class="box-add" onclick="ADDROOM()">
			<i class='bx bxs-add-to-queue' ></i>
		</div>
	<?php
		}
	?>

	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Room List</h3>
				<i class='bx bx-filter' onclick="FILTERING()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>#</th>
						<th>Type</th>
						<th>Time</th>
						<th>Status</th>
						<?php
							if($_SESSION["ACCESS"] == "ADMIN"){
						?>
							<th style="text-align: center;"><i class='bx bx-cog' ></i></th>
						<?php
							}
						?>
						
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data1 = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							# code...

							$statuscolor = ($result['Status'] == "BOOKED" ? "process" : ($result['Status'] == "Available" ? "pending" : "completed"));
							
							if ($_SESSION["ACCESS"] == "ADMIN"){
								$tablebuttnon = "<td class='TableBtns'>
								<div class='DeleteBTN' onclick='DELETION(this,`".$result["RoomID"]."`)'>
									<i class='bx bx-trash-alt' ></i>
								</div>
							</td>";
							}else{
								$tablebuttnon = "";
							}


							$data1 .= "
							<tr>
								<td>".$result["RoomNum"]."</td>
								<td>".$result["RoomType"]."</td>
								<td>".$result["Status"]."</td>
								<td><span class='status $statuscolor'>".$result['Status']."</span></td>
								$tablebuttnon
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
<!-- ROOM MAIN -->

<script>
const mainquery = `SELECT c.*, CONCAT(TIME(d.eCheckin), ' to ', TIME(d.CheckOutDate)) AS DT, IF(d.ReservationStatus IS NULL, 'Available', IF(d.ReservationStatus = 'CANCELLED', 'Available', d.ReservationStatus)) AS Status FROM rooms c LEFT JOIN (SELECT a.*, b.* FROM roomsreservation a LEFT JOIN (SELECT * FROM reservations WHERE CheckInDate = CURRENT_DATE() AND ReservationStatus != 'CHECKOUT') b ON a.greservationID = b.ReservationID WHERE b.ReservationID IS NOT NULL) d ON c.RoomNum = d.Room_num  WHERE [CONDITION] GROUP BY c.RoomID ORDER BY c.RoomNum ;`
const TBODYELEMENT = document.getElementById('TBODYELEMENT')


async function RESETTABLE() {
	const Tabledata =await AjaxSendv3("","ROOMSLOGIC","&Process=Reset")
	await Swal.fire({
		text: "The table has been reset.",
		icon: "success"
	});
	TBODYELEMENT.innerHTML = Tabledata
}

async function FILTERING(){
	let design = `
	<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;" >
		<label for="inputLabel">Room Status</label>
		<select class='SWALinput swalselect' id='swal-input1' aria-label='Floating label select example' style='padding:0.5em;'>
			<option value="-">-</option>
			<option value='Available'>Available</option>
			<option value='BOOKED'>Booked</option>
			<option value='Checked in'>Checked in</option>
			<option value='Checked out'>Checked out</option>
		</select>
	</div>
	<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;" >
		<label for="inputLabel">Room Status</label>
		<select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example' style='padding:0.5em;'>
			<option value="-">-</option>
			<option value='Superior Room'>Superior Room</option>
			<option value='Standard Room'>Standard Room</option>
			<option value='Family Room'>Family Room</option>
			<option value='Barkada Room'>Barkada Room</option>
		</select>
	</div>`

	let formValues =await POPUPCREATE("Filter",design,2)
	if (formValues) {
		let conditions = [];
		if(formValues[0] !== "-" || formValues[1] !== "-"){

			if(formValues[0] !== "-"){
				conditions.push(`IF(
					d.ReservationStatus IS NULL, 'Available', IF(
						d.ReservationStatus = 'CANCELLED', 'Available', d.ReservationStatus)
						)=  '${formValues[0]}'`);
			}
			if(formValues[1] !== "-"){
				conditions.push(`c.RoomType = '${formValues[1]}'`);
			}
			const joinedString = conditions.join(' AND ');
			const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);

			console.log(formattedText)
			const Tabledata =await AjaxSendv3(formattedText,"ROOMSLOGIC","&Process=Search")
			TBODYELEMENT.innerHTML = Tabledata
		}else{
			await Swal.fire({
				text: "No Data",
				icon: "error"
			});
		}


	}
}

async function DELETION(e, ID){
	let targetid = ID
	let targetname = e.parentNode.parentNode.cells[0].innerHTML
	let targetname1 = e.parentNode.parentNode.cells[1].innerHTML

	Swal.fire({
		title:"Deletion",
		text: `Remove Room ${targetname}-${targetname1} ?`,
		showDenyButton: true,
		showCancelButton: false,
		confirmButtonText: 'Yes',
		denyButtonText: `No`,
	}).then(async (result) => {
	   
		if (result.isConfirmed) {
			let sqlcode = `DELETE FROM rooms WHERE RoomNum ='${targetname}';`
			console.log(sqlcode)
			//call for AjaxsSendv3
			const Tabledata = await AjaxSendv3(sqlcode,"ROOMSLOGIC","&Process=DeleteUpdate")
			TBODYELEMENT.innerHTML = Tabledata
			SweetSuccess()
		}

	})
}

async function ADDROOM(){

	const rowCount = TBODYELEMENT.rows[TBODYELEMENT.rows.length -1].cells[0].innerText //(TBODYELEMENT.rows.length )+1;

	let design = `
	<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;" >
		<label for="inputLabel">Room No.</label>
		<input type ="text" id="swal-input1" class="SWALinput" required readonly value='${parseInt(rowCount)+1}' style='padding:0.5em;'>
	</div>
	<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
		<label for="inputLabel">Room Type</label>
		<select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example' style='padding:0.5em;'>
				<option value='Superior Room' selected>Superior Room</option>
				<option value='Standard Room'>Standard Room</option>
				<option value='Family Room'>Family Room</option>
				<option value='Barkada Room'>Barkada Room</option>
			</select>
	</div>`

	let formValues =await POPUPCREATE("Add Room",design,2)



	if (formValues) {
		let formattedText =  `INSERT INTO rooms (RoomNum, RoomType) VALUES ( '${formValues[0]}', '${formValues[1]}');`
		const Tabledata =await AjaxSendv3(formattedText,"ROOMSLOGIC","&Process=AccessUpdate")
		TBODYELEMENT.innerHTML = Tabledata

	}
}
</script>