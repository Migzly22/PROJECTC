<?php
    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_GET["ISU"])) ? $_GET["ISU"]: $_SESSION["USERID"];

    $sqlcodeGuestinfo = "SELECT a.* FROM guests a WHERE a.GuestID = '$userid';";
    $GuestQuesry = mysqli_query($conn,$sqlcodeGuestinfo);
    $GuestInfo = mysqli_fetch_assoc($GuestQuesry);


    $sqlReservation = "SELECT * FROM reservations WHERE GuestID = '$userid';";
    $ReservationQuery = mysqli_query($conn,$sqlReservation);
    $ReservationData = mysqli_fetch_assoc($ReservationQuery);
?>
<style>



.SOitemlist{
    display: grid;
    grid-template-columns: auto auto auto auto;
    flex-wrap: wrap;
    justify-content: center;
    row-gap: 1em;
    column-gap: 1em;
    padding: 1em;
}


.SO-item input[type="checkbox"] {
    display: none;
}
.SO-item{
    display: block;
    width: 200px;
}
.SO-item label{
    display: block;
    width: 80%;
    height: 40px;
    padding: .5em;
    border: 2px solid #ccc;
    cursor: pointer;
    border-radius: 10px;
}

.SO-item input[type="checkbox"]:checked + label {
    background-color: #6eff6e; /* Change this to the desired color */
}
.Inputnumbercss{
    text-align: end;
    padding: 0.3em .5em;
    border: 2px solid var(--accent);
    border-radius: .5em;
}
.SidebySideBtn{
    display: flex;
    gap: .5em;
}

.disabledthing button{
    background: var(--bg);
    fill: var(--accent);
    pointer-events: none;
}

</style>

<div class="mainbodycontainer">
    <div class="classHeader">
        <h1>Add Expenditures</h1>
    </div>

    
    <form action="" method="post" class="ViewAccount" id="FCONTAIN">
        <div class="box">
            <div>
                <h3>-List of Item-</h3>
            </div>
            <div class="box2">
                <div class="SOitemlist" id="SOITEMList">
                    <?php
                            $sqlcodeITEM = "SELECT * FROM extracharges ORDER BY ItemName";
                            $queryrunITEM = mysqli_query($conn, $sqlcodeITEM);
                            $rowdata2 = "";

                            while ($result1 = mysqli_fetch_assoc($queryrunITEM)) {
                                $rowdata2 .= "<div class='SO-item'>
                                                <input type='checkbox' id='".$result1["ExtraID"]."' value='".$result1['ItemName']."||".$result1['ExtraID']."||".$result1['Price']."' name='SOItemSelect'>
                                                <label for='".$result1["ExtraID"]."'>".$result1['ItemName']."</label>
                                            </div>";
                            }

                            echo $rowdata2;
                    ?>
                </div>
            
            </div>

        </div>
    </form>
</div>
<div class="mainbodycontainer">
    <form action="" method="post" class="ViewAccount" id="FCONTAIN">
        <div class="box">
            <div>
                <h3>-List of Item-</h3>
            </div>
            <div class="box2">

            <table class="table" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th scope='col'></th>
                        <th scope='col' style='text-align:center;'>Quantity</th>
                        <th scope='col' style='text-align:center;'>Price</th>
                        <th scope='col' style='text-align:center;'>Total</th>
                    </tr>
                </thead>

                <tbody id="TBODYELEMENT">




                </tbody>
            </table>

            
            </div>

        </div>
    </form>
</div>


<script>

    function changebacktozero(id){
        var element = document.getElementById(id);
        if(element.value < 0 ){
            element.value = 0;
        }
    }
    async function ADDPERSON(id){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>No. of Adult</label>
                <input type ="number" id="swal-input1" class="SWALinput" required value="0" onchange="changebacktozero(this.id)">
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>No. of Kids</label>
                <input type ="number" id="swal-input2" class="SWALinput" required value="0" onchange="changebacktozero(this.id)">
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>No. of Senior</label>
                <input type ="number" id="swal-input3" class="SWALinput" required value="0" onchange="changebacktozero(this.id)">
            </div>
        </div>`

        let formValues =await POPUPCREATE("Additional Head Count",design,3)

        if (formValues) {
            let conditions = [];
            
            let paymentadult = document.getElementById("valueid1").value
            let paymentkid = document.getElementById("valueid1").value

            let Tabledata = '';
            let sqlcode = `INSERT INTO guestextracharges (ReservationID,ChargeDescription, quantity, ChargeAmount, ChargeDate) VALUES ('${id}', :VALUECHANGE:, CURRENT_DATE);`;
            
            if(formValues[0] !== "0"){
                let change = sqlcode.replace(':VALUECHANGE:',`'Additional No. of Adult','${formValues[0]}', '${parseFloat(formValues[0])*parseFloat(paymentadult)}'`)
                Tabledata = await AjaxSendv3(change,"RESERVATIONLOGIC",`&Process=AdditionalPay&id2=${id}`)
            }
            if(formValues[1] !== "0"){
                let change = sqlcode.replace(':VALUECHANGE:',`'Additional No. of Kid','${formValues[1]}', '${parseFloat(formValues[1])*parseFloat(paymentkid)}'`)
                Tabledata = await AjaxSendv3(change,"RESERVATIONLOGIC",`&Process=AdditionalPay&id2=${id}`)
            }
            if(formValues[2] !== "0"){
                let change = sqlcode.replace(':VALUECHANGE:',`'Additional No. of Senior','${formValues[2]}', '${parseFloat(formValues[2])* (parseFloat(paymentadult) - (parseFloat(paymentadult)*.2))}'`)
                Tabledata =await AjaxSendv3(change,"RESERVATIONLOGIC",`&Process=AdditionalPay&id2=${id}`)
            }
            const TBODYELEMENT = document.getElementById('TBODYELEMENT2')
            TBODYELEMENT.innerHTML = Tabledata
        }
    }

</script>