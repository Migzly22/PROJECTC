<?php

require("../../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

switch ($_POST['process']) {
    case 'About':

        $newsqlcode = "UPDATE aboutsection SET about = ? WHERE webid = 1;";
        $stmt = $conn->prepare($newsqlcode);

        // Bind the parameter
        $stmt->bind_param("s", $_POST["sqlcode"]);

        // Execute the statement
        $stmt->execute();

        break;
    case 'Contact No.':
        $newsqlcode = "UPDATE aboutsection SET contactnum = '" . $_POST["sqlcode"] . "' WHERE webid = 1;";
        break;
    case 'Facebook Link':
        $newsqlcode = "UPDATE aboutsection SET fblink = '" . $_POST["sqlcode"] . "' WHERE webid = 1;";
        break;
    case 'Instagram Link':
        $newsqlcode = "UPDATE aboutsection SET iglink = '" . $_POST["sqlcode"] . "' WHERE webid = 1;";
        break;
    case 'Video Link':
        $newsqlcode = "UPDATE aboutsection SET vidlink = ? WHERE webid = 1;";
        $stmt = $conn->prepare($newsqlcode);

        // Bind the parameter
        $stmt->bind_param("s", $_POST["sqlcode"]);

        // Execute the statement
        $stmt->execute();
        break;
}
if ($_POST['process'] != 'About' || $_POST['process'] != 'Video Link') {
    mysqli_query($conn, $newsqlcode);
}



$sqlcodeforwebitself = "SELECT * FROM `aboutsection`";
$sqlqueryrunwebitself = mysqli_query($conn, $sqlcodeforwebitself);
$webitself = mysqli_fetch_assoc($sqlqueryrunwebitself);



?>

<div class="head-title">
    <div class="left">
        <h1>Content</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Content</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Home</a>
            </li>
        </ul>
    </div>
    <div class="RESERVATIONBTNS">
        <div class="btn-download2" onclick="this.querySelector('a').click()">
            <a href="./index.php?nzlz=content_slider" class="">
                <i class='bx bxs-image-alt'></i>
                <span class="text">Slider Images</span>
            </a>
        </div>
        <div class="btn-download2" onclick="this.querySelector('a').click()">
            <a href="./index.php?nzlz=content_gallery" class="">
                <i class='bx bxs-image-alt'></i>
                <span class="text">Gallery Images</span>
            </a>
        </div>
    </div>
</div>


<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>About Information</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;"><i class='bx bx-cog'></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>

                    </td>
                    <td style="text-align: justify;padding:1em;">
                        <?php
                        echo $webitself["about"];
                        ?>
                    </td>
                    <td class="TableBtns">
                        <div class="EditBTN" onclick="About(`<?php echo $webitself['about']; ?>`)">
                            <i class='bx bx-edit-alt'></i>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Contact Information</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="text-align: center;"><i class='bx bx-cog'></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="display: flex;justify-content:center;padding:2em;">
                        <i class="fa-solid fa-phone"></i>
                    </td>
                    <td>
                        <?php
                        echo $webitself["contactnum"];
                        ?>
                    </td>
                    <td class="TableBtns">
                        <div class="EditBTN" onclick="Editdata(`Contact No.`,`<?php echo $webitself['contactnum']; ?>`)">
                            <i class='bx bx-edit-alt'></i>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td style="display: flex;justify-content:center;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </td>
                    <td>
                        <?php
                        echo $webitself["fblink"];
                        ?>
                    </td>
                    <td class="TableBtns">
                        <div class="EditBTN" onclick="Editdata(`Facebook Link`,`<?php echo $webitself['fblink']; ?>`)">
                            <i class='bx bx-edit-alt'></i>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td style="display: flex;justify-content:center;">
                        <i class="fa-brands fa-instagram"></i>
                    </td>
                    <td>
                        <?php
                        echo $webitself["iglink"];
                        ?>
                    </td>
                    <td class="TableBtns">
                        <div class="EditBTN" onclick="Editdata(`Instagram Link`,`<?php echo $webitself['iglink']; ?>`)">
                            <i class='bx bx-edit-alt'></i>
                        </div>

                    </td>
                </tr>
                <tr>
						<td style="display: flex;justify-content:center;">
							<i class="fa-solid fa-play"></i>
						</td>
						<td>
							<?php
							echo $webitself["vidlink"];
							?>
						</td>
						<td class="TableBtns">
							<div class="EditBTN" onclick="Editdata2()">
								<i class='bx bx-edit-alt'></i>
							</div>

						</td>
					</tr>
            </tbody>
        </table>
    </div>

</div>