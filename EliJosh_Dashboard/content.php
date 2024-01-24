<?php
$sqlcodeforwebitself = "SELECT * FROM `aboutsection`";
$sqlqueryrunwebitself = mysqli_query($conn, $sqlcodeforwebitself);
$webitself = mysqli_fetch_assoc($sqlqueryrunwebitself);
?>
<!-- SETTINGS MAIN -->
<main id="MAINDATA">
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
					<i class='bx bxs-image-alt' ></i>
					<span class="text">Slider Images</span>
				</a>
			</div>
			<div class="btn-download2" onclick="this.querySelector('a').click()">
				<a href="./index.php?nzlz=content_gallery" class="">
					<i class='bx bxs-image-alt' ></i>
					<span class="text">Gallery Images</span>
				</a>
			</div>
			<!--
			<div class="btn-download2" onclick="this.querySelector('a').click()">
				<a href="./index.php?nzlz=content_video" class="">
					<i class='bx bxs-video' ></i>
					<span class="text">Video</span>
				</a>
			</div>
			-->
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
				</tbody>
			</table>
		</div>

	</div>
</main>
<!-- SETTINGS MAIN -->
<script>
	async function About(data) {
		const {
			value: text
		} = await Swal.fire({
			input: "textarea",
			inputLabel: "About",
			inputPlaceholder: "Type your message here...",
			inputAttributes: {
				"aria-label": "Type your message here"
			},
			inputValue: data,
			showCancelButton: true
		});
		if (text) {
			if (text && text.trim().length > 0) {
				let formData = new FormData();
				formData.append('sqlcode', text);
				formData.append('process', 'About');

				// Perform AJAX request to your PHP script
				$.ajax({
					url: './AjaxLogic/contentmain.php',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						// Handle the response from the server
						Swal.fire({
							title: 'Success!',
							text: '',
							icon: 'success',
						});
						document.getElementById('MAINDATA').innerHTML = response
					},
					error: function(xhr, status, error) {
						// Handle errors
						Swal.fire({
							title: 'Error!',
							text: 'An error occurred while uploading the image.',
							icon: 'error',
						});
					}
				});
			} else {
				Swal.fire({
					title: "",
					text: "Invalid input. Please enter a non-empty message.",
					icon: "error"
				});
			}
		}
	}
	async function Editdata(title, data) {
		const {
			value: text
		} = await Swal.fire({
			title: "Edit "+title,
			input: "text",
			inputLabel: "Enter your "+ title,
			inputPlaceholder: "",
			inputValue : data,
			showCancelButton: true
		});
		if (text) {
			if (text && text.trim().length > 0) {
				let formData = new FormData();
				formData.append('sqlcode', text);
				formData.append('process', title);

				// Perform AJAX request to your PHP script
				$.ajax({
					url: './AjaxLogic/contentmain.php',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						// Handle the response from the server
						Swal.fire({
							title: 'Success!',
							text: '',
							icon: 'success',
						});
						document.getElementById('MAINDATA').innerHTML = response
					},
					error: function(xhr, status, error) {
						// Handle errors
						Swal.fire({
							title: 'Error!',
							text: 'An error occurred while uploading the image.',
							icon: 'error',
						});
					}
				});
			} else {
				Swal.fire({
					title: "",
					text: "Invalid input. Please enter a non-empty message.",
					icon: "error"
				});
			}
		}
	}
</script>