            <!--Manage User-->
            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Inventory</h1>
                    <?php
                        if($_SESSION["ACCESS"] == "ADMIN"){
                    ?>
                        <button class="addbtn" onclick="ADDFUNC()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                        </button>
                    <?php
                        }
                    ?>
                </div>
                <div class="SEARCHANDFILTRATION">
                    <div class="box">

                            <div class="searchingDIV">
                                <input type="search" name="" id="SEARCHITEMINPUT" class="Searchinput">
                                <button class="addbtn" onclick="SEARCHING()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                </button>
                            </div>
                            <button class="Editbtn" onclick="FILTERING()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
                            </button>
                            <button class="Editbtn" onclick="RESETTABLE()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z"/></svg>
                            </button>

                    </div>
                </div>
                <div class="stafflistbox">
                    <div class="box">

                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2>List of Items</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col' style="text-align: start;">#</th>
                                    <th scope='col'>Item Name</th>
                                    <th scope='col'>Price</th>
                                    <th scope='col'>Quantity</th>
                                    <th scope='col' style="text-align: center;">Action</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">
<?php
    $sqlcode7 = "SELECT * FROM extracharges ORDER BY ExtraID";
    $querynum3 = mysqli_query($conn,$sqlcode7);
    $table7 = "";
    $i = 1;
    while($result7 = mysqli_fetch_assoc($querynum3)){
        $table7 .= "
            <tr>
                <td>$i</td>
                <td>".$result7["ItemName"]."</td>
                <td style='text-align: end;'>".$result7["Price"]."</td>
                <td style='text-align: center;'>".$result7["QuantityAvailable"]."</td>
                <td class='ActionTABLE' id='".$result7["ExtraID"]."'>
                    <button class='Editbtn' onclick='EDITFUNC(this)'>
                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/></svg>
                    </button>
                    <button class='Deletebtn' onclick='DELETION(this)'>
                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg>
                    </button>
                </td>
                <td style='display:none'>".$result7["PackageFor"]."</td>
            </tr>
                ";
            $i++;
        }

    if (mysqli_num_rows($querynum3) == 0) {
        $table7 = "     <tr>
            <td colspan='5' style='text-align:center; font-weight:bolder;'>No data </td>
        </tr> ";
    }
    echo $table7;
?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

<script>
    const SEARCHITEMINPUT = document.getElementById("SEARCHITEMINPUT");
    const mainquery = `SELECT * FROM extracharges WHERE [CONDITION] ORDER BY ExtraID;`
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')



    async function SEARCHING() {
        let item = SEARCHITEMINPUT.value;
        const Tabledata =await AjaxSendv3(mainquery,"INVETORYLOGIC",`&Process=Search&number=${item}`)
        TBODYELEMENT.innerHTML = Tabledata

    }


    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","INVETORYLOGIC","&Process=Reset")
        if(SEARCHITEMINPUT){
            SEARCHITEMINPUT.value = "";
        }
        TBODYELEMENT.innerHTML = Tabledata
    }

    async function FILTERING(){
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Search</label>
                <input type ="text" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Package For</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value="-">-</option>
                    <option value='ALL'>All</option>
                    <option value='ROOMS'>Rooms</option>
                    <option value='VENUE'>Venue</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Filters",design,2)

        if (formValues) {
            let conditions = [];

            if(formValues[0] !== ""){
                conditions.push(`[CONDITION]`);
            }
            if(formValues[1] !== "-"){
                conditions.push(`PackageFor = '${formValues[1]}'`);
            }


            const joinedString = conditions.join(' AND ');
            const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);


            const Tabledata =await AjaxSendv3(formattedText,"INVETORYLOGIC",`&Process=Search&number=${formValues[0]}`)
            TBODYELEMENT.innerHTML = Tabledata

        }
    }

    async function DELETION(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[1].innerHTML

        Swal.fire({
            title: `Do you want to delete item ${targetname}?`,
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

    async function ADDFUNC() {
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Item Name</label>
                <input type ="text" id="swal-input1" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Price</label>
                <input type ="number" id="swal-input2" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Quantity</label>
                <input type ="number" id="swal-input3" class="SWALinput" required>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input4'>Package For</label>
                <select class='SWALinput swalselect' id='swal-input4' aria-label='Floating label select example'>
                    <option value='ALL' selected>All</option>
                    <option value='ROOMS'>Rooms</option>
                    <option value='VENUE'>Venue</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Filters",design,4)

        if (formValues) {
            if(formValues[0] === "" && formValues[1] === "" && formValues[2] === ""){
                SweetError()
                return 0
            }
            if( formValues[1] < 0 ||  formValues[2] < 0){
                SweetError()
                return 0
            }
            let formattedText =`INSERT INTO extracharges VALUES (NULL, '${formValues[0]}', '${formValues[1]}', '${formValues[2]}', '${formValues[3]}');`
            const Tabledata =await AjaxSendv3(formattedText,"INVETORYLOGIC",`&Process=AccessUpdate`)
            TBODYELEMENT.innerHTML = Tabledata

        }
    }

    async function EDITFUNC(e) {
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[1].innerText
        let targetprice = e.parentNode.parentNode.cells[2].innerText
        let targetquan = e.parentNode.parentNode.cells[3].innerText
        let targetPack = e.parentNode.parentNode.cells[5].innerText



        let case1,case2,case3;

        switch (targetPack) {
            case "ALL":
                case1 = "selected";
                break;
            case "ROOMS":
                case2 = "selected";
                break;
            case "VENUE":
                case3 = "selected";
                break;
        }       
        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input1'>Item Name</label>
                <input type ="text" id="swal-input1" class="SWALinput" required value='${targetname}'>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>Price</label>
                <input type ="number" id="swal-input2" class="SWALinput" required value='${targetprice}'>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input3'>Quantity</label>
                <input type ="number" id="swal-input3" class="SWALinput" required value='${targetquan}'>
            </div>
            <div class='SWEETFORMS'>
                <label for='swal-input4'>Package For</label>
                <select class='SWALinput swalselect' id='swal-input4' aria-label='Floating label select example'>
                    <option value='ALL' ${case1}>All</option>
                    <option value='ROOMS' ${case2}>Rooms</option>
                    <option value='VENUE' ${case3}>Venue</option>
                </select>
            </div>
        </div>`

        let formValues =await POPUPCREATE("Filters",design,3)

        if (formValues) {

            if(formValues[0] === "" && formValues[1] === "" && formValues[2] === ""){
                SweetError()
                return 0
            }
            if( formValues[1] < 0 ||  formValues[2] < 0){
                SweetError()
                return 0
            }

            let  formattedText = `UPDATE extracharges SET ItemName = '${formValues[0]}', Price = '${formValues[1]}', QuantityAvailable = '${formValues[2]}', PackageFor = '${formValues[3]}' WHERE ExtraID = '${targetid}';`
            console.log(formattedText)
            
            const Tabledata =await AjaxSendv3(formattedText,"INVETORYLOGIC",`&Process=AccessUpdate`)
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
</script>