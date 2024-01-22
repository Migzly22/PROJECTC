<?php
$sqlcode1 = "SELECT * FROM rooms ORDER BY RoomID";

$queryrun1 = mysqli_query($conn, $sqlcode1);


?>

<!-- DASHBOARD MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Room</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Facilities</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="#">Room Facilities</a>
				</li>
			</ul>
		</div>

	</div>
	<div class="box-add" onclick="ADDROOM(`Add`)">
		<a href=""></a>
		<i class='bx bxs-add-to-queue'></i>
	</div>



	<Style>
		.Listopener {
			position: relative;
		}

		.boxxy02 {
			background-color: red;
			width: 100px;
			height: 100%;
			border-radius: 10px;
			overflow: hidden;
		}

		.boxxy02 img {
			width: 100%;
			height: 100%;
		}

		.smalltexting {
			max-width: 200px;
		}

		.buttonholder02 {
			position: absolute;
			padding: .7em;
			border-radius: 10px;
			left: 50%;
			bottom: 0;
			translate: -50% 50%;
			font-weight: bold;

		}

		.buttonholder02 button {
			padding: .5em;
			border-radius: 10px;
			border: 1px solid #333;
		}

		.NameofTarger {
			position: absolute;
			top: 0;
			left: 50%;
			translate: -50% -50%;
		}


		.swal2Put {
			width: 250px;
		}

		#content main .box-info {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
			grid-gap: 24px;
			margin-top: 36px;
		}
	</Style>

	<ul class="box-info">
		<?php
		$data = "";
		while ($result = mysqli_fetch_assoc($queryrun1)) {


			$data .= "
						<li class='Listopener'>
					<div class='boxxy02'>
						<img src='../RoomsEtcImg/ROOMS/" . $result['imgpath'] . "' alt=''>
					</div>
					<span class='text'>
						<h3>" . $result['RoomType'] . "</h3>
						<p>Price : ₱ " . $result['DayTimePrice'] . " - ₱ " . $result['Hours22'] . "</p>
						<p>Max : " . $result['MaxPeople'] . "</p>
					</span>
					<div class='buttonholder02'>
						
						<button class='bex' onclick='VIEW(`" . $result['RoomType'] . "`, `" . $result['DayTimePrice'] . "`,`" . $result['NightTimePrice'] . "`, `" . $result['Hours22'] . "`,`" . $result['MaxPeople'] . "`, `" . $result['Description'] . "`)'><i class='fa-solid fa-eye'></i></button>
						<button class='bex' onclick='ADDROOM(`Edit`,`" . $result['RoomID'] . "`,`" . $result['RoomType'] . "`, `" . $result['DayTimePrice'] . "`,`" . $result['NightTimePrice'] . "`, `" . $result['Hours22'] . "`,`" . $result['MaxPeople'] . "`, `" . $result['Description'] . "`)'><i class='fa-solid fa-pen-to-square'></i></button>
					</div>

				</li>";
		}
		echo $data;
		?>


	</ul>


</main>
<!-- DASHBOARD MAIN -->
<script>
		function openModal() {
			// Display the modal and overlay
			document.getElementById('modal').style.display = 'block';
			document.getElementById('overlay').style.display = 'block';
		}

		function closeModal() {
			// Hide the modal and overlay
			document.getElementById('modal').style.display = 'none';
			document.getElementById('overlay').style.display = 'none';
		}
	</script>

<script>

	async function VIEW(rname = "", dprice = "", nprice = "", hprice = "", max = "", jsondata = `{
		"AMENITIES": "",
		"DESCRIPTION": ""
	}`) {
		jsondata = JSON.parse(jsondata)
		//const rowCount = TBODYELEMENT.rows[TBODYELEMENT.rows.length - 1].cells[0].innerText //(TBODYELEMENT.rows.length )+1;
		let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Room Name</label>
				<input required type="text" id="swal-input1" name="swal-input1" class="SWALinput swal2Put" required value='${rname}' style='padding:0.5em;'>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Day Price</label>
				<input  required type="number" id="swal-input2" name="swal-input2" class="SWALinput swal2Put" required value='${dprice}' style='padding:0.5em;'>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Night Price</label>
				<input  required type="number" id="swal-input3" name="swal-input3" class="SWALinput swal2Put" required value='${nprice}' style='padding:0.5em;'>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">22 Hours Price</label>
				<input  required type="number" id="swal-input4" name="swal-input4" class="SWALinput swal2Put" required value='${hprice}' style='padding:0.5em;'>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Max Number</label>
				<input  required type="number" id="swal-input5"  name="swal-input5" class="SWALinput swal2Put" required value='${max}' style='padding:0.5em;'>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Description</label>
				<textarea  required  id="swal-input6"  name="swal-input6" cols="30" rows="10" style='padding:0.5em;'>${jsondata['DESCRIPTION']}</textarea>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Amenities</label>
				<textarea required id="swal-input7"  name="swal-input7" cols="30" rows="10" style='padding:0.5em;'>${jsondata['AMENITIES']}</textarea>
			</div>`
		const {
			value: formValues
		} = await Swal.fire({
			title: "View",
			html: design,
			confirmButtonText: "Close",
		});

	}
	
	async function ADDROOM(title = "EDIT", id= "",rname = "", dprice = "", nprice = "", hprice = "", max = "", jsondata = `{
		"AMENITIES": "",
		"DESCRIPTION": ""
	}`) {
		jsondata = JSON.parse(jsondata)
		document.getElementById('SWALTITLE').innerHTML = title;
		document.getElementById('swal-input11').value = rname;
		document.getElementById('swal-input12').value = dprice;
		document.getElementById('swal-input13').value = nprice;
		document.getElementById('swal-input14').value = hprice;
		document.getElementById('swal-input15').value = max;
		document.getElementById('swal-input16').value = jsondata['DESCRIPTION'];
		document.getElementById('swal-input17').value = jsondata['AMENITIES'];
		document.getElementById('hidid').value = id;


		openModal()


	}
</script>