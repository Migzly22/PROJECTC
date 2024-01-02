<?php
    $userid = $_GET["ISU"];
    $sqlcode1 = "SELECT a.*, (COALESCE(a.QuantityAvailable, 0)- COALESCE(e.USED, 0)) AS remaining FROM extracharges a LEFT JOIN (
        SELECT SUM(d.quantity) as USED, d.ChargeDescription, d.finalCheckout FROM (SELECT b.*, c.finalCheckout FROM guestextracharges b LEFT JOIN reservations c ON b.ReservationID = c.ReservationID WHERE c.finalCheckout IS NULL) d GROUP BY d.ChargeDescription
        ) e ON a.ItemName = e.ChargeDescription
        WHERE (COALESCE(a.QuantityAvailable, 0)- COALESCE(e.USED, 0)) > 0
        ORDER BY a.ItemName;";
    $queryrun1 = mysqli_query($conn, $sqlcode1);
?>
<!-- BOOKING ADDITEM MAIN -->
<main>
    <div class="head-title">
        <div class="left">
            <h1>Add Item</h1>
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
					<a class="active" href='./index.php?nzlz=booking_info&ISU=<?php echo $userid;?>'>Reservation Information</a>
				</li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="#">Add Item</a>
                </li>
            </ul>
            
        </div>
        <div class="RESERVATIONBTNS">
			<div class="btn-download2" onclick="SAVE(`<?php echo $userid;?>`)">
				<a href="#" class="">
					<i class='bx bxs-save' ></i>
					<span class="text">Save</span>
				</a>
			</div>

	
		</div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Item List</h3>
                <i class='bx bx-search' onclick="showCustomAlert()"></i>
                <i class='bx bx-reset' onclick="RESETTABLE()"></i>
            </div>
            <div class="SOitemlist" id="TBODYELEMENT ">
                <?php
                    $data = "";
                    while ($result = mysqli_fetch_assoc($queryrun1)) {
                        # code...
                        $data .= "<div class='SO-item' onclick='this.querySelector(`label`).click()'>
                            <input type='checkbox' id='id".$result["ExtraID"]."' value='".$result['ItemName']."||".$result['remaining']."||".$result['Price']."' name='SOItemSelect' onchange='changesCHECK(this, `".$result["ExtraID"]."`)'>
                            <label for='id".$result["ExtraID"]."'>".$result['ItemName']."</label>
                        </div>";
                    }
                    if(mysqli_num_rows($queryrun1) <= 0){
                        $data = "No Data";
                    }
                    echo $data;
                ?>
            </div>
        </div>
        <div class="order">
            <div class="head">
                <h3>Additional Expenses</h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th style="text-align: center;"><i class='bx bx-cog' ></i></th>
                    </tr>
                </thead>
                <tbody id="TABLELISTING">
                    <tr>
                        <td>No Data</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</main>
<!-- BOOKING ADDITEM MAIN -->

<script>
    const mainquery = `SELECT a.*, (COALESCE(a.QuantityAvailable, 0)- COALESCE(e.USED, 0)) AS remaining FROM extracharges a LEFT JOIN (
        SELECT SUM(d.quantity) as USED, d.ChargeDescription, d.finalCheckout FROM (SELECT b.*, c.finalCheckout FROM guestextracharges b LEFT JOIN reservations c ON b.ReservationID = c.ReservationID WHERE c.finalCheckout IS NULL) d GROUP BY d.ChargeDescription
        ) e ON a.ItemName = e.ChargeDescription
        WHERE (COALESCE(a.QuantityAvailable, 0)- COALESCE(e.USED, 0)) > 0 [CONDITION]
        ORDER BY a.ItemName;`
    const TBODYELEMENT  = document.getElementById('TBODYELEMENT ')

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
		let searchcondition = `AND (a.ItemName LIKE '%{item}%')`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)

        const Tabledata =await AjaxSendv3(formattedText,"LISTOFITEM",`&Process=Search&data=${item}`)
        TBODYELEMENT.innerHTML = Tabledata

	}
	async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","LISTOFITEM","&Process=Reset")
		await Swal.fire({
			text: "The search list has been reset.",
			icon: "success"
		});
        TBODYELEMENT.innerHTML = Tabledata
		
    }

    const checkboxes = document.querySelectorAll('input[name="SOItemSelect"]');
    var CheckItemsinbox = {}

    function changesCHECK(event,id){
        let valueof = event.value
            const [name, quantity, price ] = valueof.split('||')
            // Get an array of keys
            var keysArray = Object.keys(CheckItemsinbox);
            // Count the number of keys
            var numberOfKeys = keysArray.length;

            if (event.checked) {
                CheckItemsinbox[name] = {
                    id : id,
                    quantity : quantity,
                    price : price,
                    totalprice : price,
                    newquan : 1
                }
            } else {
                delete CheckItemsinbox[name];
            }
            console.log(CheckItemsinbox)
            ONUPDATE()
    }

    function deleteCheck(name, id){
        
        delete CheckItemsinbox[name];

        const checkboxtarget = document.querySelector(`#id${id}`)
        checkboxtarget.checked = false;
        console.log(CheckItemsinbox)
        ONUPDATE()
    }

    const TABLELISTING = document.getElementById('TABLELISTING');
    function ONUPDATE (){
        let datacontainer = "";
        // Iterate over the outer object
        Object.keys(CheckItemsinbox).forEach(function(outerKey) {
            // Access the inner object
            var innerObject = CheckItemsinbox[outerKey];
            datacontainer += `<tr>
                        <td>${outerKey}</td>
                        <td><input type="number" name="" id="" style="padding: .5em; border-radius: 10px;" value="${innerObject["newquan"]}" onchange="INPUTVALIDATE(this,'${innerObject["quantity"]}','${outerKey}')"></td>
                        <td id='price${innerObject["id"]}'>${innerObject["totalprice"]} </td>
                        <td class="TableBtns">
                            <div class="DeleteBTN" onclick="deleteCheck('${outerKey}', '${innerObject["id"]}')">
                                <i class='bx bx-checkbox-minus' ></i>
                            </div>
                        </td>
                    </tr>`
            // Iterate over the inner object
            
        });
        if(datacontainer === ""){
            datacontainer += `<tr>
                        <td>No Data</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>`
        }
        TABLELISTING.innerHTML = datacontainer
    }

    function INPUTVALIDATE(params, left, name) {
        let value1 = params.value

        if(value1 <= 0 ){
            params.value = 1
            value1 = 1
        }else if (value1 > left){
            params.value = left
            value1 = left
        }

        console.log(value1)
        CheckItemsinbox[name]["newquan"] = value1;
        let number = value1 * parseFloat(CheckItemsinbox[name]["price"]);
        CheckItemsinbox[name]["totalprice"] = number.toFixed(2);
        ONUPDATE()
    }

    async function SAVE(id){
        // Iterate over the outer object
        Object.keys(CheckItemsinbox).forEach(async function(outerKey) {
            // Access the inner object
            var innerObject = CheckItemsinbox[outerKey];
  
            let targetKey = outerKey;
            let Quantity = innerObject["newquan"];
            let Totalnum = innerObject["totalprice"];

            let sqlcode = `INSERT INTO guestextracharges (ReservationID,ChargeDescription, quantity, ChargeAmount, ChargeDate) VALUES ('${id}','${targetKey}', '${Quantity}', '${Totalnum}', CURRENT_DATE);`;
            await AjaxSendv3(sqlcode,"GUESTLOGIC",`&Process=Insertmore`)
        });
        
        await Swal.fire(
            '',
            'Saved Successfully!',
            'success'
        )

        location.href = `./index.php?nzlz=booking_info&ISU=${id}`
    }
</script>