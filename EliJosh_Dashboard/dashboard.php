<?php
	$sqlcode1 = "SELECT COUNT(ReservationID) AS Reservation, IF((SUM(NumAdults)+SUM(NumChildren)+SUM(NumSeniors)) IS NULL, 0, (SUM(NumAdults)+SUM(NumChildren)+SUM(NumSeniors))) AS GuestTotal FROM reservations WHERE DATE(CheckInDate) = CURRENT_DATE;";
	$sqlcode2 = "SELECT COUNT(*) as Cancelled FROM reservations WHERE DATE(CheckInDate) = CURRENT_DATE AND ReservationStatus = 'CANCELLED';";
	$sqlcode3 = "SELECT a.ReservationID, a.GuestID, CONCAT(b.LastName,', ', b.FirstName) AS NAME, a.ReservationStatus, a.eCheckin FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID WHERE DATE(CheckInDate) = CURRENT_DATE ORDER BY b.LastName, b.FirstName;";

	$queryrun1 = mysqli_query($conn,$sqlcode1);
	$data1 = mysqli_fetch_assoc($queryrun1);

	$queryrun2 = mysqli_query($conn,$sqlcode2);
	$data2 = mysqli_fetch_assoc($queryrun2);

	$queryrun3 = mysqli_query($conn,$sqlcode3);


?>

<!-- DASHBOARD MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Dashboard</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Dashboard</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>

	<ul class="box-info">
		<li>
			<i class='bx bxs-calendar-check' ></i>
			<span class="text">
				<h3><?php echo $data1['Reservation'];?></h3>
				<p>Reservation</p>
			</span>
		</li>
		<li>
			<i class='bx bxs-group' ></i>
			<span class="text">
				<h3><?php echo $data1['GuestTotal'];?></h3>
				<p>Guest</p>
			</span>
		</li>
		<li>
			<i class='bx bxs-message-square-x' ></i> <!--message-square-x or message-rounded-x-->
			<span class="text">
				<h3><?php echo $data2['Cancelled'];?></h3>
				<p>Cancelled</p>
			</span>
		</li>
	</ul>


	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Today's Reservation</h3>
			</div>
			<table>
				<thead>
					<tr>
						<th>User</th>
						<th>Arrival</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>

					<?php
						$reservation = "";
						while ($result = mysqli_fetch_assoc($queryrun3)) {
							# code...
							$time = $result['eCheckin'];
							$statuscolor = ($result['ReservationStatus'] == "BOOKED" ? "process" : ($result['ReservationStatus'] == "CANCELLED" ? "pending" : "completed"));

							$reservation .= "
							<tr>
								<td>
									<p>".$result['NAME']."</p>
								</td>
								<td>$time</td>
								<td><span class='status $statuscolor'>".$result['ReservationStatus']."</span></td>
							</tr>";
						}
						echo $reservation;

					?>
				</tbody>
			</table>
		</div>

	</div>
</main>
<!-- DASHBOARD MAIN -->