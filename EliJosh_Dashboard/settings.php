<?php
	$sqlcode1 = "SELECT * FROM userscredentials WHERE userID = '".$_SESSION["USERID"]."';" ;
	$queryrun1 = mysqli_query($conn,$sqlcode1);
	$result = mysqli_fetch_assoc($queryrun1);
?>
<!-- SETTINGS MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Setting</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Setting</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>


	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>User Information</h3>
			</div>
			<table>
				<thead>
					<tr>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<p>Name</p>
						</td>
						<td id="namecontainer"><?php echo $result["FirstName"]." ".$result["MiddleName"]." ".$result["LastName"];?></td>
					</tr>
					<tr>
						<td>
							<p>Email</p>
						</td>
						<td><?php echo $result["Email"];?></td>
					</tr>
					<tr>
						<td>
							<p>Contact #</p>
						</td>
						<td><?php echo $result["PhoneNumber"];?></td>
					</tr>
					<tr>
						<td>
							<p>Address</p>
						</td>
						<td><?php echo $result["Address"]." ".$result["City"];?></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Login Information</h3>
			</div>
			<table>
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th style="text-align: center;"><i class='bx bx-cog' ></i></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<p>Password</p>
						</td>
						<td>*********</td>
						<td class="TableBtns">
							<div class="EditBTN" onclick="Editdata(`<?php echo $_SESSION['USERID'];?>`)">
								<i class='bx bx-edit-alt' ></i>
							</div>
							
						</td>
					</tr>
					<tr>
						<td>
							<p>Account Deletion</p>
						</td>
						<td></td>
						<td class="TableBtns">
							<div class="DeleteBTN" onclick="DELETIONBTN(`<?php echo $_SESSION['USERID'];?>`)">
								<i class='bx bx-trash-alt' ></i>
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
	    async function DELETIONBTN(userid){

			let targetname = document.getElementById("namecontainer").innerText.replace(/\s+/g, ' ').trim()
			console.log(targetname)
			console.log(userid)

			const { value: pass } = await Swal.fire({
				input: 'password',
				inputLabel: 'Enter your password to Continue the deletion',
				showCancelButton: true,
				confirmButtonText: 'Delete',
				inputPlaceholder: 'Enter your Password'
			})

			if (pass) {

				let sqlcodecheck = `SELECT * FROM userscredentials WHERE userID = '${userid}' AND Password = '${pass}';`
				let throwns = await AjaxSendv3(sqlcodecheck,"SETTINGSLOGIC","&Process=check")

				if(throwns.includes("success")){
					let sqlcode = `DELETE FROM userscredentials WHERE userID  ='${userid}';`
					throwns = await AjaxSendv3(sqlcode,"SETTINGSLOGIC","&Process=delete")
					await Swal.fire(``, 'The Account Has Been Delete Successfully', 'success') 
					location.href = "./AjaxLogic/LOGOUTLOGIC.php"
				}else{
					SweetError("Incorrect Password, Account Deletion has been Aborted")
				}


			}

		}

		async function Editdata(userid){

			let Title = "Password Change"

			let design = `
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">New Password</label>
				<input type='password' id="swal-input1" class="SWALinput" style='padding:0.5em;'>
			</div>
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Confirm Password</label>
				<input type='password' id="swal-input2" class="SWALinput" style='padding:0.5em;'>
			</div>`


			const { value: formValues } = await Swal.fire({
				title: Title,
				html: design,
				focusConfirm: false,
				confirmButtonText: 'Save',
				showCancelButton: true,
				preConfirm: () => {
					return Array.from({ length: 2 }, (_, i) => document.getElementById('swal-input'+(i+1)).value);
				}
			})

			const hasBlankData = formValues.some(item => item === "");

			if (!hasBlankData) {
				//Swal.fire(JSON.stringify(formValues))
				if(formValues[0] !== formValues[1]){
					await SweetError("Password Doesnt Match")
					return true;
				}

				let passwordnew = await AjaxSendv3(formValues[0],"SETTINGSLOGIC","&Process=ENCRYPTION");
	
				sqlcode = `UPDATE userscredentials SET Password = '${passwordnew}' WHERE userID ='${userid}';`
				
				let throwns = await AjaxSendv3(sqlcode,"SETTINGSLOGIC","&Process=update")
				await Swal.fire({
					text: "Password has been changed successfully",
					icon: "success"
				});

			}else{
				SweetError();
			}
		}
</script>