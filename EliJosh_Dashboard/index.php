<?php
    require("../Database.php");
	header('Content-Type: text/html; charset=utf-8');

	session_start();
    ob_start();
	date_default_timezone_set('Asia/Shanghai');

	
	$targetlinks= isset($_GET["nzlz"]) ? $_GET["nzlz"] :"dashboard" ;

	$activecode = 0;
	switch (explode("_",$targetlinks)[0]) {
		case 'dashboard':
			$activecode = 1;
			break;
		case 'booking':
			$activecode = 2;
			break;
		case 'room':
			$activecode = 3;
			break;
		case 'guest':
			$activecode = 4;
			break;
		case 'product':
			$activecode = 5;
			break;
		case 'staff':
			$activecode = 6;
			break;
		case 'report':
			$activecode = 7;
			break;
	}


    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        header("Location: ../EliJosh_Login/index.php");
        ob_end_flush();
        exit;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/7489440202.js" crossorigin="anonymous"></script>
	<!-- My CSS -->
	<link rel="stylesheet" href="./CSS/stylev1.css">
	<link rel="stylesheet" href="./CSS/mystylev2.css">


	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script src="./JS/compilation.js" defer></script>



	<title>Admin | EliJosh Resort & Events Place</title>
	<link rel="icon" type="image/x-icon" href="./img/title_logo.ico">
</head>
<style>
	 /* Add your styles here */
	 .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background: var(--light);
      min-width: 160px;
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
	  right: 0;
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
	.dropdown-content a {
		display: flex;
		justify-content: start;
		align-items: center;
		gap: .5em;
    }
    .dropdown-content a:hover {
		background: var(--grey);
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }
	
	div:where(.swal2-container).swal2-backdrop-show, div:where(.swal2-container).swal2-noanimation {
		z-index: 9999;
	}
	.SWALinput{
		min-width: 100px;
		width: 170px;
		border: 0;
		border-bottom: 1px solid #000;
		outline: none;
	}
	.SWALinput2{
		min-width: 70px;
		width: 170px;
		border: 0;
		border-bottom: 1px solid #000;
		outline: none;
	}
	.RESERVATIONBTNS{
		margin-left: auto;
		flex-wrap: wrap;
	}
	.box-add{
		margin-top: .5em;
	}

	#myChart,#myChart2{
		pointer-events:none;
		display: block;
		width: 100% !important;
		height: 100% !important;
	}
	#myChart32{
		display: block;
		width: 100% !important;
		height: 100% !important;
	}




		
	#content main .table-data .tableleft {
		flex-grow: 1;
		flex-basis: 350px;
	}
	#content main .table-data .tableleft table {
		width: 100%;
		border-collapse: collapse;
	}
	#content main .table-data .tableleft table th {
		padding-bottom: 12px;
		font-size: 13px;
		text-align: left;
		border-bottom: 1px solid var(--grey);
	}
	#content main .table-data .tableleft table td {
		padding: 16px 0;
	}
	#content main .table-data .tableleft table tr td:first-child {
		display: flex;
		align-items: center;
		grid-gap: 12px;
		padding-left: 6px;
	}
	#content main .table-data .tableleft table td img {
		width: 36px;
		height: 36px;
		border-radius: 50%;
		object-fit: cover;
	}
	#content main .table-data .tableleft table tbody tr:hover {
		background: var(--grey);
	}
	#content main .table-data .tableleft table tr td .status {
		font-size: 10px;
		padding: 6px 16px;
		color: var(--light);
		border-radius: 20px;
		font-weight: 700;
	}
	#content main .table-data .tableleft table tr td .status.completed {
		background: var(--blue);
	}
	#content main .table-data .tableleft table tr td .status.process {
		background: var(--yellow);
	}
	#content main .table-data .tableleft table tr td .status.pending {
		background: var(--orange);
	}


	#content main .table-data .tableright {
		flex-grow: 1;
		flex-basis: 350px;
	}
	#content main .table-data .tableright table {
		width: 100%;
		border-collapse: collapse;
	}
	#content main .table-data .tableright table th {
		padding-bottom: 12px;
		font-size: 13px;
		text-align: left;
		border-bottom: 1px solid var(--grey);
	}
	#content main .table-data .tableright table td {
		padding: 16px 0;
	}
	#content main .table-data .tableright table tr td:first-child {
		display: flex;
		align-items: center;
		grid-gap: 12px;
		padding-left: 6px;
	}
	#content main .table-data .tableright table td img {
		width: 36px;
		height: 36px;
		border-radius: 50%;
		object-fit: cover;
	}
	#content main .table-data .tableright table tbody tr:hover {
		background: var(--grey);
	}
	#content main .table-data .tableright table tr td .status {
		font-size: 10px;
		padding: 6px 16px;
		color: var(--light);
		border-radius: 20px;
		font-weight: 700;
	}
	#content main .table-data .tableright table tr td .status.completed {
		background: var(--blue);
	}
	#content main .table-data .tableright table tr td .status.process {
		background: var(--yellow);
	}
	#content main .table-data .tableright table tr td .status.pending {
		background: var(--orange);
	}

	/**Add item */
	.SOitemlist{
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		align-items: center;
		gap: 1em;
		max-height: 300px;
		overflow: auto;
	}
	.SOitemlist > .SO-item{
		padding: .5em;
		background: #FD7238;
		border-radius: .5em;
		min-width: 250px;
	}
	.SO-item > input,.SO-item > label {
		pointer-events: none;
	}

	/** for booking adds*/
	.formcontainers{
		width: 100%;
	}
	.form-group {
		width: 100%;
		position: relative;
	}

	.form-control {
		width: 100%;
		height: 3em;
		padding: 8px;
		font-size: 16px;
		border: 1px solid #ccc;
		border-radius: 4px;
		background: transparent;
	}
	.f30{
		width: 30%;
		min-width: 300px;
	}
	.f45{
		width: 46%;
		min-width: 400px;
	}
	.f100{
		width: 100%;
	}
	.form-label {
		position: absolute;
		top: 8px;
		left: 10px;
		transition: all 0.2s ease-in-out;
		pointer-events: none;
		color: #888;
	}

	.form-control:focus + .form-label,
	.form-control:not(:placeholder-shown) + .form-label {
		top: -12px;
		left: 5px;
		font-size: 12px;
		color: #333;
		background-color: #F9F9F9;
		padding: 0 4px;
	}
	.requiredcolor{
		color: red;
	}
	.layer-3, .layer-2, .layer-1{
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 1em;
		padding: .5em;
		flex-wrap: wrap;
	}
	.BUTTONHANDLER{
		margin: auto;
		width: fit-content;
		margin-top: 1em;
	}
	.ContinueBTN{
		padding: 1em;
		letter-spacing: .3ch;
		border-radius: .5em;
		border: 0;
		background: #9fffcb;
		color: #25a18e;
	}
	.ContinueBTN:hover{
		color: #fff;
		background: #25a18e;
	}

	.head2{
		margin-top: 1em;
		font-size: 24px;
		font-weight: 600;
	}
	.listcontroller {
		display: flex;
		gap: 1em;
		padding: 1em ;
		overflow-x: auto; /* Enable horizontal scrolling */
		white-space: nowrap; /* Prevent wrapping of the items */
	}

	.boxcontainers {
		background: #F9F9F9;
		border-radius: 10px;
		width: 30%;
		min-width: 300px;
		position: relative;
		padding: 1em;
	}

	.boxcontainers img {
		width: 100%;
		height: 200px;
		margin-top: 0.3em;
		margin-bottom: 0.5em;
	}
	.textcontainers{
		display: flex;
		flex-direction: column;
	}
	.ADDMEBTN {
		padding: 1em;
		background-color: #28a745;
		border-color: #218838;
		color: #fff;
	}
	.ADDMEBTN{
		padding: 1em;
		border-radius: .5em;
		border: 0;
		background: #9fffcb;
		color: #25a18e;
	}
	.ADDMEBTN:hover{
		color: #fff;
		background: #25a18e;
	}
	.REMOVEMEBTN{
		padding: 1em;
		border-radius: .5em;
		border: 0;
		background: #FFE0D3;
		color: #FD7238;
	}
	.REMOVEMEBTN:hover{
		color: #FFE0D3;
		background: #FD7238;
	}

	.TableBtns .EditBTN .fa-regular2{
		font-size: 1.4em;
		padding: .5em;
		position: relative;
		top: -50%;
		translate: 0% 80%;
	}
	.TableBtns .EditBTN:hover .fa-regular2{
		border-radius: 10px;
	}

	.TableBtns .OpenBTN .fa-regular2{
		font-size: 1.4em;
		padding: .5em;
	}
	.TableBtns .OpenBTN:hover .fa-regular2{
		border-radius: 10px;
	}
</style>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<img src="./img/title_logo.png" alt="">
			<span class="text">EliJosh</span>
		</a>
		<ul class="side-menu top">
			<li class="<?php echo ($activecode == 1) ? "active" : ""; ?>">
				<a href="./index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="<?php echo ($activecode == 2) ? "active" : ""; ?>">
				<a href="./index.php?nzlz=booking">
					<i class='bx bxs-bookmark-alt-plus' ></i> <!--bookmark or book-add-->
					<span class="text">Booking</span>
				</a>
			</li>
			<li class="<?php echo ($activecode == 3) ? "active" : ""; ?>"> 
				<a href="./index.php?nzlz=room">
					<i class='bx bxs-home-smile' ></i> <!--home-heart or home-smile-->
					<span class="text">Rooms</span>
				</a>
			</li>
			<li class="<?php echo ($activecode == 4) ? "active" : ""; ?>">
				<a href="./index.php?nzlz=guest">
					<i class='bx bxs-group' ></i>
					<span class="text">Guest</span>
				</a>
			</li>
			<?php
				if($_SESSION["ACCESS"] == "ADMIN"){
			?>
				<li class="<?php echo ($activecode == 5) ? "active" : ""; ?>">
					<a href="./index.php?nzlz=product">
						<i class='bx bxs-collection' ></i> <!--cabinet or collection or package-->
						<span class="text">Product Items</span>
					</a>
				</li>
				<li class="<?php echo ($activecode == 6) ? "active" : ""; ?>">
					<a href="./index.php?nzlz=staff">
						<i class='bx bxs-user-detail' ></i> <!--user-account or user-badge or user-detail-->
						<span class="text">Manage Staff</span>
					</a>
				</li>
				<li class="<?php echo ($activecode == 7) ? "active" : ""; ?>">
					<a href="./index.php?nzlz=report">
						<i class='bx bxs-report' ></i> <!--report or -->
						<span class="text">Reports</span>
					</a>
				</li>

			<?php
				}
			?>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="./logOut.php" class="logout">
					<i class='bx bxs-log-out' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav style="display: flex;justify-content: space-between;">
			<i class='bx bx-menu' ></i>
			<div style="display: flex;align-items: center;gap: 2em;">
				<div class="dropdown">
					<a href="#" class="profile">
					  <img src="./img/peoplelogo.png" alt="Profile Image">
					</a>
					<div class="dropdown-content">
					  <a href="./index.php?nzlz=settings"><i class='bx bx-cog' ></i> Setting</a>
					  <a href="../EliJosh_Client/index.php"><i class='bx bx-home' ></i>Go Home</a>
					  <a href="./logOut.php"><i class='bx bx-door-open' ></i>Logout</a>
					</div>
				</div>
			</div>
		
		</nav>
		<!-- NAVBAR -->
		<?php
            include "./$targetlinks.php";
        ?>
		
	</section>
	<!-- CONTENT -->

	<script src="./JS/script1.js"></script>
</body>
</html>
