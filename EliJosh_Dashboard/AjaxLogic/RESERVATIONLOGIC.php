<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];
mysqli_query($conn,$sqlcode);


$userid = $_POST["id2"];

$sqlcode1 = "SELECT a.*, b.* FROM guests a LEFT JOIN reservations b ON a.GuestID = b.GuestID WHERE b.ReservationID = '$userid';";
$queryrun1 = mysqli_query($conn,$sqlcode1);
$data = mysqli_fetch_assoc($queryrun1);

$sqlcode2 = "SELECT if(SUM(ChargeAmount) IS NULL, '0.00', SUM(ChargeAmount)) AS EXTRACHARGES FROM guestextracharges WHERE ReservationID = '".$data['ReservationID']."';";
$queryrun2 = mysqli_query($conn,$sqlcode2);
$data2 = mysqli_fetch_assoc($queryrun2);

$sqlcode3 = "SELECT SUM(AmountPaid) AS PaidAmountTotal FROM guestpayments WHERE ReservationID = '".$data['ReservationID']."';";
$queryrun3 = mysqli_query($conn,$sqlcode3);
$data3 = mysqli_fetch_assoc($queryrun3);

$total = (floatval($data2["EXTRACHARGES"]) + floatval($data["TotalPrice"])) - floatval($data3["PaidAmountTotal"]);

?>
<!-- BOOKING INFO MAIN -->

	<div class="head-title">
		<div class="left">
			<h1>Booking</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Booking</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="./index.php?nzlz=booking">Home</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Reservation Information</a>
				</li>
			</ul>
			
		</div>
		<div class="RESERVATIONBTNS">
			<div class="btn-download2">
				<a href="#" class="">
					<i class='bx bxs-user-plus' ></i>
					<span class="text">Add Person</span>
				</a>
			</div>
			<div class="btn-download2">
				<a href="#" class="">
					<i class='bx bxs-plus-square' ></i>
					<span class="text">Add Item</span>
				</a>
			</div>
			<?php 
				if($data["ReservationStatus"] == "CHECKIN"){
			?>
				<div class="btn-download2"  onclick="PAYMENT(`<?php echo $data['ReservationID']; ?>`)">
					<a href="#" class="">
						<i class='bx bxs-calendar-check' ></i>
						<span class="text">Check-out</span>
					</a>
				</div>
			<?php 
				}
			?>
	
		</div>
		
		
	</div>

	<ul class="box-info">
		<li>
			<span class="text">
				<h3><?php echo $data['LastName'].", ".$data['FirstName']; ?></h3>
				<small><b>Email : </b><?php echo $data['Email']; ?></small>
				<br>
				<small><b>Contact # : </b> <?php echo $data['Phone']; ?></small>
				<br>
				<small><b>Address : </b> <?php echo $data['Address']; ?></small>
			</span>
		</li>
		<li>
			<i class="bx">
				₱
			</i>
			<span class="text">
				<h3>Total</h3>
				<p><?php echo  number_format($total, 2);?> Pesos</p>
			</span>
		</li>
	</ul>

	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Booking Report</h3>
			</div>
			<table>

				<thead>
					<tr>
						<th></th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>

					<?php    

					$dateTime = new DateTime($data['CheckInDate']);
					// Get the day of the week as a number (1 = Monday, 2 = Tuesday, etc.)
					$dayOfWeekNumber = $dateTime->format('N');

					// Convert the number to the day name
					$dayOfWeekName = date('l', strtotime($data['CheckInDate']));



					if($dayOfWeekNumber <= 4){
						$columnstring = "Weekdays".$data['timapackage']."Price";
					}else{
						$columnstring = "WeekendsHolidays".$data['timapackage']."Price";
					}


					$sql1 = "SELECT * FROM poolrate ORDER BY RateID ASC;";
					$sql1query = mysqli_query($conn, $sql1);
					$entrance = array();

					while ($result = mysqli_fetch_assoc($sql1query)) {
					$entrance[] = $result[$columnstring];
					}



						$sum = 0;
						$sum += $data["NumAdults"] * $entrance[0];
						$sum += $data["NumChildren"] * $entrance[1];
						$sum += $data["NumSeniors"] * ($entrance[0]-(($entrance[0]*.2)));


						$pricepool = array();
						$pricepool[] = $data["NumAdults"] * $entrance[0];
						$pricepool[] = $data["NumChildren"] * $entrance[1];
						$pricepool[] = $data["NumSeniors"] * ($entrance[0]-(($entrance[0]*.2)));

						if($data["package"] == "Package2"){
							$pricepool[0] = 0.00;
							$pricepool[1] = 0.00;
							$pricepool[2] = 0.00;
						}

						$sum += $pricepool[0];
						$sum += $pricepool[1];
						$sum += $pricepool[2] ;
					?>
					<tr>
						<th style='text-align:start;'>No. of Adults</th>
						<td style='text-align:center;'><?php echo $data["NumAdults"];?></td>
						<td style='text-align:end;'>₱ <?php echo  number_format($pricepool[0], 2) ;?></td>
					</tr>
					<tr>
						<th style='text-align:start;'>No. of Kids</th>
						<td style='text-align:center;'><?php echo $data["NumChildren"];?></td>
						<td style='text-align:end;'>₱ <?php echo number_format($pricepool[1], 2);?></td>
					</tr>
					<tr>
						<th style='text-align:start;'>No. of Senior</th>
						<td style='text-align:center;'><?php echo $data["NumSeniors"];?></td>
						<td style='text-align:end;'>₱ <?php echo number_format($pricepool[2], 2);?></td>
					</tr>
					<?php
						$COTTAGELIST = "SELECT a.*, b.*, c.* FROM cottagereservation a LEFT JOIN cottage b ON a.cottagenum = b.Cottagenum LEFT JOIN cottagetypes c ON b.CottageType = c.ServiceTypeName  WHERE a.reservationID = '".$data["ReservationID"]."';";

						$COTTAGELISTQuery =  mysqli_query($conn, $COTTAGELIST);
						$data1 = "";
						if(mysqli_num_rows($COTTAGELISTQuery) > 0){
							while($CottageResult = mysqli_fetch_assoc($COTTAGELISTQuery)){
								if($data["timapackage"] == "22Hrs"){
									$datatype = "NightPrice";
								}else{
									$datatype = $data["timapackage"]."Price";
								}

								$data1 .= "<tr>
								<th style='text-align:start;'>".$CottageResult["ServiceTypeName"]."-".$CottageResult["cottagenum"]."</th>
								<td style='text-align:center;'>1</td>
								<td style='text-align:end;'>₱ ".number_format($CottageResult[$datatype], 2)."</td>
								</tr>";

								$sum += intval($CottageResult[$datatype]);
							}
							echo $data1;
						}

						$ROOMLIST = "SELECT a.*, b.*, c.* FROM roomsreservation a LEFT JOIN rooms b ON a.Room_num = b.RoomNum LEFT JOIN roomtypes c ON b.RoomType = c.RoomType  WHERE a.greservationID = '".$data["ReservationID"]."';";
						$ROOMLISTQuery =  mysqli_query($conn, $ROOMLIST);
						$data2 = "";

						if(mysqli_num_rows($ROOMLISTQuery) > 0){
							while($CottageResult = mysqli_fetch_assoc($ROOMLISTQuery)){
								if($data["timapackage"] == "22Hrs"){
									$datatype = "Hours22";
								}else{
									$datatype = $data["timapackage"]."TimePrice";
								}

								$data2 .= "<tr>
								<th style='text-align:start;'>".$CottageResult["RoomType"]."-".$CottageResult["RoomNum"]."</th>
								<td style='text-align:center;'>1</td>
								<td style='text-align:end;'>₱ ".number_format($CottageResult[$datatype], 2)."</td>
								</tr>";
								$sum += intval($CottageResult[$datatype]);
							}
							echo $data2;
							
						}


						$EVENTLIST = "SELECT a.*, b.* FROM eventreservation a LEFT JOIN eventpav b ON a.eventname = b.Pavtype WHERE a.reservationID = '".$data["ReservationID"]."';";
						$EVENTLISTQuery =  mysqli_query($conn, $EVENTLIST);
						$data2 = "";

						if(mysqli_num_rows($EVENTLISTQuery) > 0){
							while($CottageResult = mysqli_fetch_assoc($EVENTLISTQuery)){
								
								$guesttotalnumber = $data["NumAdults"] + $data["NumChildren"] + $data["NumSeniors"] ;
								$newsql22 = "SELECT `".$CottageResult["Pavtype"]."` FROM eventplace WHERE PAX >= '$guesttotalnumber' ORDER BY PAX ASC LIMIT 1;";
								$EVENTLISTQuery1 =  mysqli_query($conn, $newsql22);
								$EVENTresult = mysqli_fetch_assoc($EVENTLISTQuery1);

								$data2 .= "<tr>
								<th style='text-align:start;'>".$CottageResult["eventname"]."</th>
								<td style='text-align:center;'>1</td>
								<td style='text-align:end;'>₱ ".number_format($EVENTresult[$CottageResult["Pavtype"]], 2)."</td>
								</tr>";
								$sum += intval($EVENTresult[$CottageResult["Pavtype"]]);
							}
							echo $data2;
							
						}

					?>
					<tr>
						<th style='text-align:start;' colspan="2">Downpayment</th>
						<td style='text-align:end;' id="Dpayment">₱ <?php echo number_format($data["Downpayment"], 2);?></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Additional Expenses Report</h3>
			</div>
			<table>
			
				<thead>
					<tr>
						<th></th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$extrachargessql = "SELECT *, SUM(quantity) AS newQuantity, SUM(ChargeAmount) as newPrice FROM guestextracharges WHERE ReservationID = '".$data['ReservationID']."' GROUP BY ChargeDescription;";
						$extrachargequery = mysqli_query($conn,$extrachargessql);
						$extrachargestable = "";
						while ($extrachargeresult = mysqli_fetch_assoc($extrachargequery)) {
							$arraycharge =  explode(" - ", $extrachargeresult["ChargeDescription"]);
							$extrachargestable .= "
								<tr>
									<th style='text-align:start;'>".$extrachargeresult["ChargeDescription"]."</th>
									<td style='text-align:center;'>".$extrachargeresult["newQuantity"]."</td>
									<td style='text-align:end;'>₱ ".number_format( $extrachargeresult["newPrice"], 2)."</td>
								</tr>
							";
						}
						if(mysqli_num_rows($extrachargequery) <= 0 ){
							$extrachargestable .= "
							<tr>
								<td>No Data</td>
								<td></td>
								<td></td>
							</tr>
						";
						}
						echo $extrachargestable;

					?>
				</tbody>
			</table>
		</div>

	</div>

