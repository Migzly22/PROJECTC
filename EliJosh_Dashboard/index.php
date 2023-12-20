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
    //error_reporting(E_ERROR | E_PARSE);


	$_SESSION["ACCESS"] = "ADMIN";
	$_SESSION["USERID"] = 1;
/*
require("./Database.php");

    

    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        header("Location: ../Client/login.php");
        ob_end_flush();
        exit;
    }

    
    $num =  isset($_GET["plk"]) ? $_GET["plk"] :"1" ;


    $sqlcodeUSERDATA = "SELECT CONCAT(LastName,', ', FirstName, ' ', MiddleName ) AS staffname, userID AS StaffID FROM userscredentials WHERE userID = '".$_SESSION['USERID']."';";
    $USERDATA = mysqli_query($conn,$sqlcodeUSERDATA);
    $resultUSERDATA = mysqli_fetch_assoc($USERDATA);
    $_SESSION["STAFFNAME"] = $resultUSERDATA["staffname"];
    $_SESSION["STAFFID"] = $resultUSERDATA["StaffID"];

*/

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
	<link rel="icon" type="image/x-icon" href="/img/title_logo.png">
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
	canva{
		pointer-events: none;
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
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#" class="logout">
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
				<input type="checkbox" id="switch-mode" hidden>
				<label for="switch-mode" class="switch-mode"></label>
				<div class="dropdown">
					<a href="#" class="profile">
					  <img src="img/people.png" alt="Profile Image">
					</a>
					<div class="dropdown-content">
					  <a href="./index.php?nzlz=settings"><i class='bx bx-cog' ></i> Setting</a>
					  <a href="../Client/index.php"><i class='bx bx-home' ></i>Go Home</a>
					  <a href="#"><i class='bx bx-door-open' ></i>Logout</a>
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
