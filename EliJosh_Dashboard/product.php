
<?php
    $sqlcode1 = "SELECT * FROM extracharges ORDER BY ItemName";
    $queryrun1 = mysqli_query($conn,$sqlcode1);

?>

<!-- PRODUCTS MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Rental Items</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Items</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="box-add" onclick="ADDFUNC()">
		<i class='bx bxs-add-to-queue' ></i>
	</div>

	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Items List</h3>
				<i class='bx bx-search' onclick="showCustomAlert()"></i>
				<i class='bx bx-reset' onclick="RESET()"></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th>Price</th>
						<th>Overall Quantity</th>
						<th style="text-align: center;"><i class='bx bx-cog' ></i></th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							# code...
							$data .= "
								<tr>
									<td>".$result["ItemName"]."</td>
									<td>₱ ".number_format($result["Price"], 2)."</td>
									<td>".$result["QuantityAvailable"]."</td>
									<td class='TableBtns'>
										<div class='EditBTN' onclick='EDITFUNC( `".$result["ExtraID"]."`, `".$result["ItemName"]."`, `".$result["Price"]."`, `".$result["QuantityAvailable"]."`)'>
											<i class='bx bx-edit-alt' ></i>
										</div>
										<div class='DeleteBTN' onclick='DELETION(this, `".$result["ExtraID"]."`)'>
											<i class='bx bx-trash-alt' ></i>
										</div>
									</td>
								</tr>
							";
						}
						if(mysqli_num_rows($queryrun1) <= 0){
							$data  ="
								<tr>
									<td colspan='4'>No Data</td>
									<td></td>
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
<!-- PRODUCTS MAIN -->

<script>
	const TBODYELEMENT = document.getElementById('TBODYELEMENT');
	const mainquery = `SELECT * FROM extracharges WHERE [CONDITION] ORDER BY ItemName;`
	async function showCustomAlert() {
		let design = `
			<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
				<label for="inputLabel">Search</label>
				<input type="text" id="swal-input1" placeholder="Enter text..." style='padding:0.5em;'>
			</div>
		`
		let swalvalue = await POPUPCREATE('Search Information',design,1)

		if(swalvalue[0].length <= 0 ){
			await Swal.fire({
				text: "No Information Found",
				icon: "info"
			});
		}

		let item = swalvalue[0]

        const Tabledata =await AjaxSendv3(mainquery,"INVETORYLOGIC",`&Process=Search&number=${item}`)
        TBODYELEMENT.innerHTML = Tabledata

	}
	async function RESET() {
        const Tabledata =await AjaxSendv3("","INVETORYLOGIC","&Process=Reset")
        TBODYELEMENT.innerHTML = Tabledata
    }
	function changebacktozero(id){
        var element = document.getElementById(id);
        if(element.value < 0 ){
            element.value = 0;
        }
    }
	async function ADDFUNC() {
        let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Item Name</label>
			<input type ="text" id="swal-input1" class="SWALinput" required style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Price</label>
			<input type ="number" id="swal-input2" class="SWALinput" required style='padding:0.5em;' onchange="changebacktozero(this.id)">
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Quantity</label>
			<input type ="number" id="swal-input3" class="SWALinput" required style='padding:0.5em;' onchange="changebacktozero(this.id)">
		</div>`

        let formValues =await POPUPCREATE("Add Item",design,3)

        if (formValues) {
            if(formValues[0] === "" && formValues[1] === "" && formValues[2] === ""){
                SweetError()
                return 0
            }
            if( formValues[1] < 0 ||  formValues[2] < 0){
                SweetError()
                return 0
            }
            let formattedText =`INSERT INTO extracharges VALUES (NULL, '${formValues[0]}', '${formValues[1]}', '${formValues[2]}', 'ALL');`
            const Tabledata =await AjaxSendv3(formattedText,"INVETORYLOGIC",`&Process=AccessUpdate`)
            TBODYELEMENT.innerHTML = Tabledata

        }
    }

	async function DELETION(e,ID){
        let targetid = ID
        let targetname = e.parentNode.parentNode.cells[0].innerHTML

        Swal.fire({
            text: `Do you want to delete item ${targetname}?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then(async (result) => {
           
            if (result.isConfirmed) {
                let sqlcode = `DELETE FROM extracharges WHERE ExtraID ='${targetid}';;`
                //call for AjaxsSendv3
                const Tabledata = await AjaxSendv3(sqlcode,"INVETORYLOGIC","&Process=DeleteUpdate")
                TBODYELEMENT.innerHTML = Tabledata
                SweetSuccess()
            }

        })
    }

	async function EDITFUNC(ID, name, price, quantity) {
        let targetid = ID
        let targetname = name
        let targetprice = price
		let targetquantity = quantity
       


    
        let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Item</label>
			<input type ="text" id="swal-input1" class="SWALinput" required value='${targetname}' style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Price</label>
			<input type ="number" id="swal-input2" class="SWALinput" required value='${targetprice}' style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Quantity</label>
			<input type ="number" id="swal-input3" class="SWALinput" required value='${targetquantity}' style='padding:0.5em;'>
		</div>`

        let formValues =await POPUPCREATE("Edit",design,3)

        if (formValues) {

            if(formValues[0] === "" && formValues[1] === "" && formValues[2] === ""){
                SweetError()
                return 0
            }
            if( formValues[1] < 0 ||  formValues[2] < 0){
                SweetError()
                return 0
            }

            let  formattedText = `UPDATE extracharges SET ItemName = '${formValues[0]}', Price = '${formValues[1]}', QuantityAvailable = '${formValues[2]}' WHERE ExtraID = '${targetid}';`
            console.log(formattedText)
            
            const Tabledata =await AjaxSendv3(formattedText,"INVETORYLOGIC",`&Process=AccessUpdate`)
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
</script>