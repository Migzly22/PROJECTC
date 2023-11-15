
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
    .box4{
        width: 25%;
        min-width: 300px;
        min-height: 50px;
        padding: 1em;

        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1em;
    }
    .box4 .svgcontainer{
        width: 50px;
        padding: .3em;
        display: flex;
        justify-content: center;
        border-radius: 10px;
    }
    .box4 .svgcontainer svg{
        font-size: 3em;
        fill: #fff;
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
    .box4 .textcontainer p{
        padding: .3em 0;
        font-weight: bold;
    }
    .box3 canvas{
        width: 100% !important;
        height: 100% !important;
    }
</style>

<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Dashboard</h1>
                   
                </div>
                <div  class="ViewAccount" >
                    <?php
                        $sqlcodecards = "SELECT COUNT(ReservationID) AS Reservation, IF((SUM(NumAdults)+SUM(NumChildren)+SUM(NumSeniors)) IS NULL, 0, (SUM(NumAdults)+SUM(NumChildren)+SUM(NumSeniors))) AS GuestTotal FROM reservations WHERE DATE(CheckInDate) = CURRENT_DATE;";
                        $cardsquery = mysqli_query($conn,$sqlcodecards);
                        $cardsresult = mysqli_fetch_assoc($cardsquery);

                        $sqlcodecards2 = "SELECT COUNT(*) as Cancelled FROM reservations WHERE DATE(CheckInDate) = CURRENT_DATE AND ReservationStatus = 'CANCELLED';";
                        $cardsquery2 = mysqli_query($conn,$sqlcodecards2);
                        $cardsresult2 = mysqli_fetch_assoc($cardsquery2);
                    ?>
                    <div class="boxcontainer3">
                        <div class="box4 box bg1">
                            <div class="svgcontainer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z"/></svg>
                            </div>
                            <div class="textcontainer">
                                <h1>Reservations</h1>
                                <p>Total : <?php echo $cardsresult['Reservation'];?></p>
                            </div>
                        </div>
                        <div class="box4 box bg3">
                            <div class="svgcontainer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                            </div>
                            <div class="textcontainer">
                                <h1>Guest</h1>
                                <p>Total : <?php echo $cardsresult['GuestTotal'];?> </p>
                            </div>
                        </div>
                        <div class="box4 box bg2">
                            <div class="svgcontainer">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
                            </div>
                            <div class="textcontainer">
                                <h1>Cancelled</h1>
                                <p>Total : <?php echo $cardsresult2['Cancelled'];?></p>
                            </div>
                        </div>
                    </div>  
                    <?php
                        if($_SESSION["ACCESS"] == "ADMIN"){
                    ?>
                        <div class="boxcontainer3">
                            <div class="box3 box">
                                <canvas id="myChart"></canvas>
                            </div>
                            <div class="box3 box">
                                <canvas id="myChart2"></canvas>
                            </div>
                            <div class="box3 box">
                                <canvas id="myChart3"></canvas>
                            </div>
                        </div>    

                    <?php
                        }
                    ?>
                </div>

            </div>

            <div class="mainbodycontainer">
                <div class="stafflistbox">
                    <div class="box">
                        <div>
                            <h3>-<?php echo date("m/d");?> Reservations-</h3>
                        </div>
                        <div class="box2">
           
                        <table class="table" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th scope='col' style='text-align:center;'>Name</th>
                                    <th scope='col' style='text-align:center;'>Action</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
                                <?php
                                    $sqlcodeTable = "SELECT a.ReservationID, a.GuestID, CONCAT(b.LastName,', ', b.FirstName) AS NAME 
                                                    FROM reservations a LEFT JOIN guests b ON a.GuestID = b.GuestID 
                                                    WHERE DATE(CheckInDate) = CURRENT_DATE ORDER BY b.LastName, b.FirstName;";
                                    $paymentquery = mysqli_query($conn,$sqlcodeTable);
                                    $paymentdata = "";
                                    while ($paymentresult = mysqli_fetch_assoc($paymentquery)) {
                                        # code...
                                        $paymentdata .= "<tr>
                                            <td style='text-align:start;'>".$paymentresult['NAME']."</td>
                                            <td class='ActionTABLE' id ='".$paymentresult['GuestID']."'>
                                                <button class='addbtn' onclick='VIEW(this)'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 576 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z'/></svg>
                                                </button>
                                            </td>
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
                borderColor: 'rgb(75, 192, 192)',
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
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 159, 64, 0.5)'
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
                    beginAtZero: true
                }
                }
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
                borderColor: 'rgb(75, 192, 192)',
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
          beginAtZero: true
        }
      }
    };


    async function VIEW(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[0].innerHTML
        location.href = `./Mainpage.php?nzlz=guestview&plk=4&ISU=${targetid}&qwe=true`;
    }

</script>