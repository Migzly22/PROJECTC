
<style>
    .boxcontainer3{
        display: flex;
        gap: 1em;
        justify-content: center;
        flex-wrap: wrap;
    }
    .box3{
        width: 25%;
        min-width: 300px;
        height: 200px;
        padding: 1em;
    }
    .box3 canvas{
        width: 100% !important;
        height: 100% !important;
    }
    .bg1{
        background: #007BFF;
    }
    .bg2{
        background: #DC3545;
    }
    .bg3{
        background: #6C757D;
    }
</style>

<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Report</h1>
                   
                </div>
                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="boxcontainer3">
                        <div class="box3 box bg1">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="box3 box bg3">
                            <canvas id="myChart2"></canvas>
                        </div>
                        <div class="box3 box bg2">
                            <canvas id="myChart3"></canvas>
                        </div>
                    </div>
                       
                </form>
            </div>

            <div class="mainbodycontainer">
                <div class="classHeader">
                    <div></div>
                    <div class="">
                        <button class="Editbtn" onclick="FILTERING()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
                        </button>
                        <button class="Editbtn" onclick="RESETTABLE()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z"/></svg>
                            </button>
                        <button class="addbtn" onclick="PRINT()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="stafflistbox">
                    <div class="box">
                        <div>
                            <h3>-Income Summary-</h3>
                        </div>
                        <div class="box2">
           
                        <table class="table" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th scope='col' style='text-align:start;'>Date</th>
                                    <th scope='col' style='text-align:start;'>Mode of Payment</th>
                                    <th scope='col' style='text-align:center;'>Amount</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
                                <?php
                                    $sqlcodeTable = "SELECT * FROM guestpayments a ORDER BY PaymentDate DESC;";
                                    $paymentquery = mysqli_query($conn,$sqlcodeTable);
                                    $paymentdata = "";
                                    while ($paymentresult = mysqli_fetch_assoc($paymentquery)) {
                                        # code...
                                        $paymentdata .= "<tr>
                                            <th style='text-align:start;'>".$paymentresult['PaymentDate']."</th>
                                            <td style='text-align:start;'>".$paymentresult['PaymentMethod']."</td>
                                            <td style='text-align:end;'>₱ ".$paymentresult['AmountPaid']."</td>
                                        </tr>";
                                    }
                                    echo $paymentdata;

                                ?>

                            </tbody>
                        </table>

                        
                        </div>


    
                    </div>
                </div>
            </div>

<script>
    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');
    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var ctx3 = document.getElementById('myChart3').getContext('2d');
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')

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

    async function CurrentMonthtarget (){
        let sqlcode = `SELECT MONTH(PaymentDate) AS month ,SUM(AmountPaid) AS monthamount FROM guestpayments WHERE YEAR(PaymentDate) = YEAR(CURDATE()) GROUP BY MONTH(PaymentDate) ORDER BY month DESC`
        let datajson = await AjaxSendv3(sqlcode,"REPORTLOGIC",`&Process=Chart`,"json")
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
                label: 'Monthy Report',
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
    async function OnlinevsCash (){
        let sqlcode = `SELECT SUM(AmountPaid) AS monthamount, PaymentMethod AS month
                        FROM guestpayments
                        WHERE MONTH(PaymentDate) = MONTH(CURRENT_DATE)
                        GROUP BY PaymentMethod;`
        let datajson = await AjaxSendv3(sqlcode,"REPORTLOGIC",`&Process=Chart`,"json")
        let arraydata = [
            (datajson.hasOwnProperty('CASH')) ? datajson["CASH"] : 0,
            (datajson.hasOwnProperty('ONLINE')) ? datajson["ONLINE"] : 0
        ];


        console.log(datajson)
        let labels2 = ["Cash", "Online"];
        const data = {
            labels: labels2,
            datasets: [{
                label: 'Payment Method',
                data: arraydata,
                fill: false,
                backgroundColor: [
                'rgba(255, 193, 7, 0.7)',
                'rgba(255, 159, 64, 0.7)'
                ],
                tension: 0.1
            }]
        };

        
        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.7)', // X-axis grid line color
                        },
                        ticks: {
                            color: 'rgb(255, 255, 255)', // Y-axis label color
                        },
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.7)', // X-axis grid line color
                        },
                        ticks: {
                            color: 'rgb(255, 255, 255)', // X-axis label color
                        },
                    },
                },
                plugins: {
                    legend: {
                    labels: {
                        color: 'rgb(255, 255, 255)', // Legend text color
                    },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 99, 132, 0.8)', // Tooltip background color
                        bodyColor: 'white', // Tooltip text color
                    },
                },
            },
        };
        // Create the chart
        var myChart = new Chart(ctx3, config);
    }

    CurrentMonthtarget()
    CurrentWeektarget()
    OnlinevsCash()

    async function CurrentWeektarget (){

        const labels = generateWeekLabels();
        let arraydata = [];
    
        for (const dateentity of labels) {
            let sqlstatement = `SELECT IF(SUM(AmountPaid) IS NULL, 0, SUM(AmountPaid)) AS Amount  FROM guestpayments WHERE DATE_FORMAT(PaymentDate, '%m-%d') = '${dateentity}' AND YEAR(PaymentDate) = YEAR(CURDATE());`
            let valuenew =  await AjaxSendv3(sqlstatement,"REPORTLOGIC",`&Process=ChartSpecific`)
            arraydata.push(valuenew);
        }
        
        const data2 = {
            labels: labels,
            datasets: [{
                label: 'Weekly Report',
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
      scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: 'rgba(255, 255, 255, 0.7)', // X-axis grid line color
            },
            ticks: {
                color: 'rgb(255, 255, 255)', // Y-axis label color
            },
        },
        x: {
            grid: {
                color: 'rgba(255, 255, 255, 0.7)', // X-axis grid line color
            },
            ticks: {
                color: 'rgb(255, 255, 255)', // X-axis label color
            },
        },
      },
      plugins: {
        legend: {
          labels: {
            color: 'rgb(255, 255, 255)', // Legend text color
          },
        },
      },
    };


    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","REPORTLOGIC","&Process=Reset")
        TBODYELEMENT.innerHTML = Tabledata
        ALLSQLCODE = "SELECT * FROM guestpayments a ORDER BY PaymentDate DESC;";
    }
    async function FILTERING(){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Year</label>
                <input type ="number" id="swal-input1" class="SWALinput" required value="">
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Month</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value="">-</option>
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
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Mode of Payment </label>
                <select class='SWALinput swalselect' id='swal-input3' aria-label='Floating label select example'>
                    <option value="">-</option>
                    <option value='CASH'>Cash</option>
                    <option value='ONLINE'>Online</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Filters",design,3)

        if (!formValues.every(value => value === "")) {
            console.log(formValues)
            let conditions = [];
            let sqlcode = `SELECT * FROM guestpayments a WHERE :CONDITION: ORDER BY PaymentDate DESC;`

            if(formValues[0] !== ""){
                conditions.push(`YEAR(PaymentDate) = '${formValues[0]}'`);
            }
            if(formValues[1] !== ""){
                conditions.push(`MONTH(PaymentDate) = '${formValues[1]}'`);
            }
            if(formValues[2] !== ""){
                conditions.push(`PaymentMethod = '${formValues[2]}'`);
            }
            
            const joinedString = conditions.join(' AND ');
            const formattedText = sqlcode.replace(/:CONDITION:/g, joinedString);

            const Tabledata =await AjaxSendv3(formattedText,"REPORTLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata
            ALLSQLCODE = formattedText // set the printing sqlcode


        }
    }

    var ALLSQLCODE = "SELECT :*: FROM guestpayments a ORDER BY PaymentDate DESC;";


    function PRINT() {
        location.href = `./Composer/paymentreport.php?sqlcode=${ALLSQLCODE}`
    }

</script>