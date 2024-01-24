<?php
$sqlcode1 = "SELECT * FROM rooms ORDER BY RoomID";

$queryrun1 = mysqli_query($conn, $sqlcode1);


?>

<!-- DASHBOARD MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Content</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Content</a>
				</li>
				<li><i class='bx bx-chevron-right'></i></li>
				<li>
					<a class="active" href="#">Video</a>
				</li>
			</ul>
		</div>

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

        .imagebgv2 {
            position: relative;
            width: 100%;
            height: 100dvh;
            border-radius: 10px;
            z-index: 1;
            object-fit: cover;
        }

	</Style>

	<ul class="box-info" id='datatable'>

		<?php
		$videoDirectory = "../RoomsEtcImg/Videos/";

		// Get all video files in the directory
		$videoFiles = glob($videoDirectory . "*.mp4");
		$data = "";
		// Generate HTML markup for each image
		foreach ($videoFiles as $videoPath) {
			$data .= "<li class='Listopener'>
				<video id='myVideo' class='imagebgv2' controls>
					<source src='$videoPath' type='video/mp4'>
					
				</video>
			<div class='buttonholder02'>
				<button class='bex EditBTN' onclick='ADDROOM()'><i class='fa-solid fa-pen'></i></button>
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

	async function ADDROOM() {
		let num = parseInt(`<?php echo $arrayLength; ?>`)
		if (num >= 5) {
			Swal.fire({
				title: "",
				text: "Sorry, you have reached the maximum allowed number of images in the slider.",
				icon: "info"
			});
			return
		}
		await Swal.fire({
			title: 'Select an video',
			input: 'file',
			inputAttributes: {
				accept: 'video/*', // Accept any video file type
			},
			showCancelButton: true,
			confirmButtonText: 'Upload',
			showLoaderOnConfirm: true,
			preConfirm: (file) => {
				// You can use FormData to send the file to your PHP script using AJAX
				let formData = new FormData();
				formData.append('video', file);
				formData.append('Process', 'Add');
				formData.append('sqlcode', 'Add');

				// Perform AJAX request to your PHP script
				$.ajax({
					url: './AjaxLogic/Contentv3.php',
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