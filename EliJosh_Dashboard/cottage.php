<?php
	$sqlcode1 = "SELECT a.*, a.RoomType AS roomname, f.*, if(f.ReservationStatus is null, 'Available', f.ReservationStatus) AS Status, CONCAT(g.LastName, ', ', g.FirstName) AS Name
	FROM rooms a
	LEFT JOIN (
		SELECT d.*, e.*
		FROM roomsreservation d
		LEFT JOIN reservations e ON d.greservationID = e.ReservationID
		WHERE (e.ReservationStatus != 'CHECKOUT') AND (DATE(e.CheckInDate) <= CURRENT_DATE AND e.CheckOutDate >= CURRENT_TIMESTAMP)
	) f ON f.Room_num = a.RoomID
	LEFT JOIN guests g ON f.GuestID = g.GuestID
	ORDER BY a.RoomID;";
	$queryrun1 = mysqli_query($conn, $sqlcode1);

?>

<!-- ROOM MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Cottage</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Cottage</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
		<div class="RESERVATIONBTNS">
			<div class="btn-download2" onclick="ADDPERSON()">
				<a href="./index.php?nzlz=cottage_report" class="">
					<i class='bx bxs-report' ></i>
					<span class="text">Cottage Sales</span>
				</a>
			</div>
		</div>
	</div>
	<?php
		if($_SESSION["ACCESS"] == "ADMIN"){
	?>
		<div class="box-add" onclick="this.querySelector('a').click()">
			<a href="./index.php?nzlz=facilities" ></a>
			<i class='bx bxs-cog' ></i>
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
						<th></th>
						<th>Guest Name</th>
						<th>Arrival</th>
						<th>Status</th>
						
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data1 = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							# code...

							$statuscolor = ($result['Status'] == "BOOKED" ? "process" : ($result['Status'] == "Available" ? "pending" : "completed"));

							$data1 .= "
							<tr>
								<td>".$result["RoomType"]."</td>
								<td>".$result["Name"]."</td>
								<td>".$result["eCheckin"]."</td>
								<td><span class='status $statuscolor'>".$result['Status']."</span></td>
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
const mainquery = `SELECT a.*, a.RoomType AS roomname, f.*, if(f.ReservationStatus is null, 'Available', f.ReservationStatus) AS Status, CONCAT(g.LastName, ', ', g.FirstName) AS Name
	FROM rooms a
	LEFT JOIN (
		SELECT d.*, e.*
		FROM roomsreservation d
		LEFT JOIN reservations e ON d.greservationID = e.ReservationID
		WHERE (e.ReservationStatus != 'CHECKOUT') AND ([CONDITION2])
	) f ON f.Room_num = a.RoomID
	LEFT JOIN guests g ON f.GuestID = g.GuestID
	WHERE [CONDITION1]
	ORDER BY a.RoomID;`
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
		</select>
	</div>
	<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;" >
		<label for="inputLabel">Room Type</label>
		<select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example' style='padding:0.5em;'>
			<option value="-">-</option>
			<option value='Superior Room'>Superior Room</option>
			<option value='Standard Room'>Standard Room</option>
			<option value='Family Room'>Family Room</option>
			<option value='Barkada Room'>Barkada Room</option>
		</select>
	</div>
	<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Date Range</label>
			<input type ="date" id="swal-input3" class="SWALinput" placeholder="From" required value="" style='padding:0.5em;width:120px;'>
			-
			<input type="date" id="swal-input4" class="SWALinput" placeholder="To" style='padding:0.5em;width:120px;'>
	</div>`

	let formValues =await POPUPCREATE("Filter",design,4,"Search")
	if (formValues) {
		let conditions = [];
		if(formValues[0] !== "-" || formValues[1] !== "-" || formValues[2] !== "" || formValues[3] !== ""){

			if(formValues[0] !== "-"){
				conditions.push(`if(f.ReservationStatus is null, 'Available', f.ReservationStatus) = '${formValues[0]}'`);
			}
			if(formValues[1] !== "-"){
				conditions.push(`a.RoomType LIKE '%${formValues[1]}%'`);
			}
			//DATE(e.CheckInDate) <= CURRENT_DATE AND e.CheckOutDate >= CURRENT_TIMESTAMP
			let condition2 = []
			if(formValues[2] !== ""){
				condition2.push(`DATE(e.CheckInDate) <= '${formValues[2]}'`);
			}else{
				condition2.push(`DATE(e.CheckInDate) <= CURRENT_DATE`);
			}
			if(formValues[3] !== ""){
				condition2.push(`DATE(e.CheckOutDate) >= '${formValues[3]}'`);
			}else{
				condition2.push(`e.CheckOutDate >= CURRENT_TIMESTAMP`);
			}

			if(conditions.length === 0){
				conditions.push( '1')
			}

			let joinedString = conditions.join(' AND ');
			let joinedString2 = condition2.join(' OR ');
			const formattedText1 = mainquery.replace(/\[CONDITION1\]/, joinedString);
			const formattedText2 = formattedText1.replace(/\[CONDITION2\]/, joinedString2);

			const Tabledata =await AjaxSendv3(formattedText2,"ROOMSLOGIC","&Process=Search")
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
