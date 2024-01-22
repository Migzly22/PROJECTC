<?php
$sqlcode1 = "SELECT COUNT(a.RR_ID)  AS total,
	c.timapackage,
	ROUND(SUM(
	CASE 
		WHEN c.timapackage = 'Night' THEN if(c.ReservationStatus = 'CHECKOUT', b.NightTimePrice, b.NightTimePrice /2 )
	WHEN c.timapackage = 'Day' THEN if(c.ReservationStatus = 'CHECKOUT', b.DayTimePrice, b.DayTimePrice /2 )
	WHEN c.timapackage = '22Hrs' THEN if(c.ReservationStatus = 'CHECKOUT', b.Hours22, b.Hours22 /2 )
	END
	),2)as Profit,
	
	
	b.*  FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomID
	LEFT JOIN reservations c ON a.greservationID = c.ReservationID
	GROUP BY b.RoomType DESC  
	ORDER BY COUNT(a.RR_ID) DESC";
$queryrun1 = mysqli_query($conn, $sqlcode1);
?>
<!-- REPORTS MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Room Sales Report</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Sales</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="./index.php?nzlz=room">Home</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="#">Room Report</a>
				</li>
			</ul>
		</div>
	</div>


	<div class="table-data">
		<div class="tableright">
			<div class="head">
				<h3>Overall Item Report</h3>
				<i class='bx bx-filter' onclick="FILTERING()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
				<i class='bx bx-printer' onclick="PRINT()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Room</th>
						<th>Reservation Count</th>
						<th>Profit</th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
					$data = "";
					while ($result = mysqli_fetch_assoc($queryrun1)) {
						$data .= "
								<tr>
									<td>
										<p>" . $result['RoomType'] . "</p>
									</td>
									<td>" . $result['total'] . "</td>
									<td>" . number_format($result['Profit'], 2, '.', ',') . "</td>
								</tr>
							";
					}
					if (mysqli_num_rows($queryrun1) <= 0) {
						$data = "
								<tr>
									<td>No Data</td>
									<td></td>
									<td></td>
								</tr>
							";
					}
					echo $data;
					?>

				</tbody>
			</table>
		</div>

	</div>

</main>
<!-- REPORTS MAIN -->
<script>
	const TBODYELEMENT = document.getElementById('TBODYELEMENT')
	async function RESETTABLE() {
		const Tabledata = await AjaxSendv3("", "REPORTLOGICv3", "&Process=Reset2")
		TBODYELEMENT.innerHTML = Tabledata
		ALLSQLCODE = `1`;
	}
	async function FILTERING() {
		let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for='swal-input1'>Year</label>
            <input type ="number" id="swal-input1" class="SWALinput" required value="2024" style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Month</label>
			<select class='SWALinput swalselect' id='swal-input2' class="SWALinput" aria-label='Floating label select example' style='padding:0.5em;'>
                    <option value=""></option>
                    <option value='1'>January</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Date Range</label>
			<input type ="date" id="swal-input3" class="SWALinput" placeholder="From" required value="" style='padding:0.5em;width:120px;'>
			-
			<input type="date" id="swal-input4" class="SWALinput" placeholder="To" style='padding:0.5em;width:120px;'>
		</div>`

		let formValues = await POPUPCREATE("Filter", design, 4, "Search")

		if (!formValues.every(value => value === "")) {
			console.log(formValues)
			let conditions = [];
			let sqlcode = `SELECT COUNT(a.RR_ID)  AS total,
c.timapackage,
ROUND(SUM(
CASE 
    WHEN c.timapackage = 'Night' THEN if(c.ReservationStatus = 'CHECKOUT', b.NightTimePrice, b.NightTimePrice /2 )
WHEN c.timapackage = 'Day' THEN if(c.ReservationStatus = 'CHECKOUT', b.DayTimePrice, b.DayTimePrice /2 )
WHEN c.timapackage = '22Hrs' THEN if(c.ReservationStatus = 'CHECKOUT', b.Hours22, b.Hours22 /2 )
END
),2)as Profit,


b.*  FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomID
LEFT JOIN reservations c ON a.greservationID = c.ReservationID
WHERE :CONDITION:


GROUP BY b.RoomType DESC  
ORDER BY COUNT(a.RR_ID) DESC;`
			let showcounter = true;
			if (formValues[2] !== "") {
				conditions.push(`c.CheckInDate >= '${formValues[2]}'`);
				showcounter = false
			}
			if (formValues[3] !== "") {
				conditions.push(`c.CheckInDate <= '${formValues[3]}'`);
				showcounter = false
			}

			if (showcounter) {
				if (formValues[0] !== "") {
					conditions.push(`YEAR(c.CheckInDate) = '${formValues[0]}'`);
				}
				if (formValues[1] !== "") {
					conditions.push(`MONTH(c.CheckInDate) = '${formValues[1]}'`);
				}
			}


			const joinedString = conditions.join(' AND ');
			const formattedText = sqlcode.replace(/:CONDITION:/g, joinedString);

			console.log(formattedText)
			const Tabledata = await AjaxSendv3(formattedText, "REPORTLOGICv3", "&Process=Search2")
			TBODYELEMENT.innerHTML = Tabledata
			ALLSQLCODE = "AND " + joinedString // set the printing sqlcode


		}
	}

	//var ALLSQLCODE = `SELECT a.*, COALESCE(c.USEDQUANTITY, 0) AS USEDQUANTITY , COALESCE(c.TOTALAMOUNT, 0) AS TOTALAMOUNT FROM extracharges a LEFT JOIN (SELECT b.*, SUM(b.quantity) AS USEDQUANTITY, SUM(b.ChargeAmount) AS TOTALAMOUNT FROM guestextracharges b GROUP BY b.ChargeDescription) c ON a.ItemName = c.ChargeDescription ORDER BY c.TOTALAMOUNT DESC, c.USEDQUANTITY DESC;`;
	var ALLSQLCODE = `1`

	function PRINT() {
		location.href = `../Admins/Composer/paymentreport_room.php?sqlcode=${ALLSQLCODE}` ///Composer/paymentreport.php?sqlcode=${ALLSQLCODE}
	}
</script>