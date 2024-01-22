<?php
$sqlcode1 = "SELECT * FROM rooms ORDER BY RoomID";

$queryrun1 = mysqli_query($conn, $sqlcode1);


?>

<!-- DASHBOARD MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Gallery</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Content</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="#">Gallery</a>
				</li>
			</ul>
		</div>

	</div>
	<div class="box-add" onclick="ADDROOM()">
		<a href=""></a>
		<i class='bx bxs-add-to-queue'></i>
	</div>



	<Style>
		.Listopener {
			position: relative;
		}

		.boxxy02 {
			background-color: red;
			width: 100%;
			height: 200px;
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

		.buttonholder02 .DeleteBTN:hover {
			color: #FD7238;
			background: #FFE0D3;
		}

		.buttonholder02 .EditBTN:hover {
			color: #0000fe;
			background: #CFE8FF;

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
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			grid-gap: 24px;
			margin-top: 36px;
		}

		.SPECIALBTNN02 button {
			padding: .5em;
			border-radius: 10px;
			border: 1px solid #333;
		}

		.SPECIALBTNN02 .DeleteBTN:hover {
			color: #FD7238;
			background: #FFE0D3;
		}

		.SPECIALBTNN02 .EditBTN:hover {
			color: #0000fe;
			background: #CFE8FF;

		}
	</Style>

	<ul class="box-info" id='datatable'>

		<?php
		$folderPath = '../RoomsEtcImg/Gallery';

		// Get the list of all files in the folder
		$files = scandir($folderPath);

		// Filter out only image files (you can customize the list of allowed extensions)
		$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
		$imageFiles = array_filter($files, function ($file) use ($allowedExtensions) {
			$extension = pathinfo($file, PATHINFO_EXTENSION);
			return in_array(strtolower($extension), $allowedExtensions);
		});

		$data = "";
		// Generate HTML markup for each image
		foreach ($imageFiles as $imageFile) {
			$imagePath = "../RoomsEtcImg/Gallery/" . $imageFile;


			$data .= "<li class='Listopener'>
				<div class='boxxy02'>
					<img src='$imagePath' alt=''>
				</div>
				<div class='buttonholder02'>
					<button class='bex EditBTN' onclick='DELETEBTN(`$imageFile`)'><i class='fa-solid fa-trash'></i></button>
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
	async function DELETEBTN(imgname) {
		const newgal = await AjaxSendv3(imgname, "Content", "&Process=Deletion")
		document.getElementById('datatable').innerHTML = newgal
		Swal.fire({
			title: "",
			text: "Deleted Successfully",
			icon: "success"
		});
	}

	async function ADDROOM() {
		await Swal.fire({
			title: 'Select an image',
			input: 'file',
			inputAttributes: {
				accept: 'image/*',
			},
			showCancelButton: true,
			confirmButtonText: 'Upload',
			showLoaderOnConfirm: true,
			preConfirm: (file) => {
				// You can use FormData to send the file to your PHP script using AJAX
				let formData = new FormData();
				formData.append('image', file);
				formData.append('Process', 'Add');
				formData.append('sqlcode', 'Add');

				// Perform AJAX request to your PHP script
				$.ajax({
					url: './AjaxLogic/Content.php',
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
						document.getElementById('datatable').innerHTML = response
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
			},
		});

	}
</script>