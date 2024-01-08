<?php
	$sqlcode1 = "SELECT a.*, CONCAT(c.LastName, ', ', c.FirstName) AS Name FROM guestpayments a LEFT JOIN reservations b ON a.ReservationID = b.ReservationID LEFT JOIN guests c ON b.GuestID = c.GuestID ORDER BY a.PaymentDate DESC;";
	$queryrun1 = mysqli_query($conn,$sqlcode1);
?>
<!-- REPORTS MAIN -->
<main>
	<div class="head-title">
		<div class="left">
			<h1>Sales Report</h1>
			<ul class="breadcrumb">
				<li>
					<a href="#">Sales</a>
				</li>
				<li><i class='bx bx-chevron-right' ></i></li>
				<li>
					<a class="active" href="#">Home</a>
				</li>
			</ul>
		</div>
        <div class="RESERVATIONBTNS">
			<div class="btn-download2" onclick="ADDPERSON()">
				<a href="./index.php?nzlz=report_items" class="">
					<i class='bx bxs-report' ></i>
					<span class="text">Items Sales</span>
				</a>
			</div>
		</div>
	</div>


	

	<ul class="box-info">
		<li style="min-height:200px;height:100%;width:100%;position:relative;">
			<canvas id="myChart"></canvas>
		</li>
		<li style="min-height:200px;height:100%;width:100%;position:relative;">
			<canvas id="myChart2"></canvas>
		</li>
	</ul>

	<div class="table-data">
		<div class="tableright">
			<div class="head">
				<h3>Overall Sales Report</h3>
				<i class='bx bx-filter' onclick="FILTERING()"></i>
				<i class='bx bx-reset' onclick="RESETTABLE()"></i>
				<i class='bx bx-printer' onclick="PRINT()" ></i>
			</div>
			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th>Date</th>
						<th>Payment</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody id="TBODYELEMENT">
					<?php
						$data = "";
						while ($result = mysqli_fetch_assoc($queryrun1)) {
							$data .= "
								<tr>
									<td>
										<p>".$result['Name']."</p>
									</td>
									<td>".$result['PaymentDate']."</td>
									<td>".$result['PaymentMethod']."</td>
									<td>₱ ".number_format($result['AmountPaid'],2)."</td>
								</tr>
							";
						}
						if(mysqli_num_rows($queryrun1) <= 0 ){
							$data = "
								<tr>
									<td>No Data</td>
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
<!-- REPORTS MAIN -->
<script>
	const TBODYELEMENT= document.getElementById('TBODYELEMENT')
	async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","REPORTLOGIC","&Process=Reset")
        TBODYELEMENT.innerHTML = Tabledata
        ALLSQLCODE = "1";
    }
	async function FILTERING(){
        let design = `
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for='swal-input1'>Year</label>
            <input type ="number" id="swal-input1" class="SWALinput" required value="2024" style='padding:0.5em;'>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Month</label>
			<select class='SWALinput swalselect' id='swal-input2' class="SWALinput" aria-label='Floating label select example' style='padding:0.5em;'>
                    <option value=""></option>
                    <option value='1'>January</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>
		</div>
		<div style="display: flex; justify-content: space-between;align-items:center;margin-bottom:0.5em;">
			<label for="inputLabel">Date Range</label>
			<input type ="date" id="swal-input3" class="SWALinput" placeholder="From" required value="" style='padding:0.5em;width:120px;'>
			-
			<input type="date" id="swal-input4" class="SWALinput" placeholder="To" style='padding:0.5em;width:120px;'>
		</div>`

        let formValues =await POPUPCREATE("Filter",design,4)

        if (!formValues.every(value => value === "")) {
            console.log(formValues)
            let conditions = [];
            let sqlcode = `SELECT a.*, CONCAT(c.LastName, ', ', c.FirstName) AS Name FROM guestpayments a LEFT JOIN reservations b ON a.ReservationID = b.ReservationID LEFT JOIN guests c ON b.GuestID = c.GuestID WHERE :CONDITION: ORDER BY a.PaymentDate DESC;`

            let showcounter = true;
            if(formValues[2] !== ""){
                conditions.push(`a.PaymentDate >= '${formValues[2]}'`);
				showcounter = false
            }
			if(formValues[3] !== ""){
                conditions.push(`a.PaymentDate <= '${formValues[3]}'`);
				showcounter = false
            }

			if(showcounter){
				if(formValues[0] !== ""){
					conditions.push(`YEAR(a.PaymentDate) = '${formValues[0]}'`);
				}
				if(formValues[1] !== ""){
					conditions.push(`MONTH(a.PaymentDate) = '${formValues[1]}'`);
				}
			}
	
            
            const joinedString = conditions.join(' AND ');
            const formattedText = sqlcode.replace(/:CONDITION:/g, joinedString);

            const Tabledata =await AjaxSendv3(formattedText,"REPORTLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata
            ALLSQLCODE = joinedString // set the printing sqlcode


        }
    }

	var ALLSQLCODE = "1";


    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');
    var ctx2 = document.getElementById('myChart2').getContext('2d');

   // Function to generate month labels
    function generateMonthLabels(count = 12) {
      const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      return months.slice(0, count);
    }
    function generateWeekLabels() {
        const today = new Date();
        const last5Days = [];

        for (let i = 0; i < 5; i++) {
            const pastDay = new Date(today);
            pastDay.setDate(today.getDate() - i);
            const month = (pastDay.getMonth() + 1).toString().padStart(2, '0'); // Adding 1 because months are zero-indexed
            const day = pastDay.getDate().toString().padStart(2, '0');
            const formattedDate = `${month}-${day}`;
            last5Days.push(formattedDate);
        }

        return last5Days.reverse();
    }
	

	function AjaxSendv4(sqlcode,link,table = "", htmlParam="html", inside="",targetbody ="TBODY") {
		return new Promise(function(resolve, reject) {
				$.ajax({
				url:`./AjaxLogic/${link}.php`,
				type:"POST",
				data:'sqlcode='+sqlcode+table,
				dataType:htmlParam,
				beforeSend:function(){
			
				},
				error: function() 
				{
					SweetError();
					reject("An error occurred.");
				},
				success:function(data){
				
					if ((table.includes("Update"))){
						SweetSuccess();
					}
				
					console.log(data)
					resolve(data);
				}
			}); 
		});
	}

    async function CurrentMonthtarget (){
        let sqlcode = `SELECT MONTH(PaymentDate) AS month ,SUM(AmountPaid) AS monthamount FROM guestpayments WHERE YEAR(PaymentDate) = YEAR(CURDATE()) GROUP BY MONTH(PaymentDate) ORDER BY month DESC`
        let datajson = await AjaxSendv4(sqlcode,"REPORTLOGIC",`&Process=Chart`,"json")
        let arraydata = [];

        // Find the highest key
        let keys = Object.keys(datajson);
        let highestKey = Math.max(...keys);

        for (let index = 0; index < highestKey; index++) {
            if(datajson.hasOwnProperty(index+1)){
                arraydata.push(parseFloat(datajson[index+1]));
            }else{
                arraydata.push(0);
            }
        }
        


        let labels2 = generateMonthLabels(highestKey);
        const data = {
            labels: labels2,
            datasets: [{
                label: 'Monthy Sales Report',
                data: arraydata,
                fill: false,
                borderColor: 'rgb(14,255,0)',
                tension: 0.1
            }]
        };

        
        const config = {
            type: 'line',
            data: data,
            options: options,
            plugins: []
        }
        // Create the chart
        var myChart = new Chart(ctx, config);
    }

    CurrentMonthtarget()
    CurrentWeektarget()

    async function CurrentWeektarget (){

        const labels = generateWeekLabels();
        let arraydata = [];
    
        for (const dateentity of labels) {
            let sqlstatement = `SELECT IF(SUM(AmountPaid) IS NULL, 0, SUM(AmountPaid)) AS Amount  FROM guestpayments WHERE DATE_FORMAT(PaymentDate, '%m-%d') = '${dateentity}' AND YEAR(PaymentDate) = YEAR(CURDATE());`
            let valuenew =  await AjaxSendv4(sqlstatement,"REPORTLOGIC",`&Process=ChartSpecific`)
            arraydata.push(valuenew);
        }
        
        const data2 = {
            labels: labels,
            datasets: [{
                label: 'Weekly Sale Report',
                data: arraydata,
                fill: false,
                borderColor: 'rgb(14,255,0)',
                tension: 0.1
            }]
        };

        const config2 = {
            type: 'line',
            data: data2,
            options: options,
            plugins: []
        }

        
        // Create the chart
        var myChart2 = new Chart(ctx2, config2);
    }


    // Configure the chart
    var options = {
        legend: {
            onClick: function (event) { alert(123) }, // Set the onClick callback to null to make legend labels unclickable
        },
      scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: 'rgba (192, 192, 192)', // X-axis grid line color
            },
            ticks: {
                color: 'rgb (192, 192, 192)', // Y-axis label color
            },
        },
        x: {
            grid: {
                color: 'rgba(192, 192, 192)', // X-axis grid line color
            },
            ticks: {
                color: 'rgb(255, 255, 255)', // X-axis label color
            },
        },
      },
      plugins: {
        legend: {
          labels: {
            color: 'rgb(64, 64, 64)', // Legend text color
          },
        },
      },
    };

    function PRINT() {
        location.href = `../Admins/Composer/overallreport.php?sqlcode=${ALLSQLCODE}`///Composer/paymentreport.php?sqlcode=${ALLSQLCODE}
    }
</script>
