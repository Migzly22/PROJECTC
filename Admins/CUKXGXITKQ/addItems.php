<?php
    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_GET["ISU"])) ? $_GET["ISU"]: $_SESSION["USERID"];
    $gid = (isset($_GET["GID"])) ? $_GET["GID"]: $_SESSION["USERID"];
?>
<style>



.SOitemlist{
    display: flex;
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

.SRFlexandSearch{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
}
.search_sortv2{
    gap: 1em;
}

.SRReportbox{
    display: none;
}
.search_sort{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    align-items:baseline;
}
.search_sort .selection select{
    width: 10em;
    border: 1px solid #6eff6e;
    border-top-right-radius: 1em;
    border-top-left-radius: 1em;

    outline: none;
}
.Editbtn, .Deletebtn{
    background: transparent;
    border-radius: 10px;
    padding: .5em;
}

</style>

<div class="mainbodycontainer">
    <div class="classHeader">
        <h1>Add Expenditures</h1>
        <button class="addbtn" onclick="SavingData(`<?php echo $userid;?>`,`<?php echo $gid;?>`)">
        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 96V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V170.5c0-4.2-1.7-8.3-4.7-11.3l33.9-33.9c12 12 18.7 28.3 18.7 45.3V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H309.5c17 0 33.3 6.7 45.3 18.7l74.5 74.5-33.9 33.9L320.8 84.7c-.3-.3-.5-.5-.8-.8V184c0 13.3-10.7 24-24 24H104c-13.3 0-24-10.7-24-24V80H64c-8.8 0-16 7.2-16 16zm80-16v80H272V80H128zm32 240a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"/></svg>
        </button>
    </div>

    
    <form action="" method="post" class="ViewAccount" id="FCONTAIN">
        <div class="box">
            <div class="SRFlexandSearch"> 
                <h3>-List of Item-</h3>
                <div class="search_sort search_sortv2">
      
                    <div class="selection">
                        <select name="" id="STselect">
                            <option value='All'>All</option>
                            <option value='ROOMS'>Room</option>
                            <option value='VENUE'>Venue</option>
                        </select>
                    </div>
                    
                    <button onclick="ResetFilter()" class='Editbtn'>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M142.9 142.9c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5c0 0 0 0 0 0H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5c7.7-21.8 20.2-42.3 37.8-59.8zM16 312v7.6 .7V440c0 9.7 5.8 18.5 14.8 22.2s19.3 1.7 26.2-5.2l41.6-41.6c87.6 86.5 228.7 86.2 315.8-1c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.2 62.2-162.7 62.5-225.3 1L185 329c6.9-6.9 8.9-17.2 5.2-26.2s-12.5-14.8-22.2-14.8H48.4h-.7H40c-13.3 0-24 10.7-24 24z"/></svg>
                    </button>
  
                </div>
            </div>
            <div class="box2">
                <div class="SOitemlist" id="SOITEMList">
                    <?php
                            $sqlcodeITEM = "SELECT * FROM extracharges ORDER BY ItemName";
                            $queryrunITEM = mysqli_query($conn, $sqlcodeITEM);
                            $rowdata2 = "";

                            while ($result1 = mysqli_fetch_assoc($queryrunITEM)) {
                                $rowdata2 .= "<div class='SO-item'>
                                                <input type='checkbox' id='".$result1["ExtraID"]."' value='".$result1['ItemName']."||".$result1['PackageFor']."||".$result1['Price']."' name='SOItemSelect'>
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
                        <th scope='col' style='text-align:center;'>Price</th>
                        <th scope='col' style='text-align:center;'>Quantity</th>

                        <th scope='col' style='text-align:center;'>Total</th>
                        <th scope='col' style='text-align:center;'>Action</th>
                    </tr>
                </thead>

                <tbody id="TBODY">




                </tbody>
            </table>

            
            </div>

        </div>
    </form>
</div>


<script>

    const STselect = document.getElementById('STselect')
    const checkboxes = document.querySelectorAll('input[name="SOItemSelect"]');
    let CheckItemsinbox = {}
    let lastCheckedCheckbox = null;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function(event) {

            const checkedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
            const checkedValues = checkedCheckboxes.map(cb => cb.value);
            CheckItemsinbox = checkedValues


            if (event.target.checked) {
                if (CheckItemsinbox.includes(event.target.value)) {
                    lastCheckedCheckbox = event.target;
                }
            } else {
                let idname = event.target.value.split("||")[0]                
                const targetedTDid = document.getElementById(idname)

                targetedTDid.parentElement.remove()

            }
 
            ONUPDATE()
        });
    });

    STselect.addEventListener('change',(e)=>{
        let selectedName = e.target.value
        console.log(selectedName)
        ListReset()
        if(selectedName !== 'All'){
            checkboxes.forEach(checkbox => {
                    let targetparent = ""
                    let [value, name, blank] = checkbox.value.split("||");
                    //just to remove extraspaces in the name
                    if (name !== selectedName) {
                        targetparent = checkbox.parentElement
                        targetparent.style.display = "none"
                    }
            });
      
        }
    })

    function ListReset(){
        //to reset the hidden box
        const hiddenLabels = document.querySelectorAll('.SO-item[style="display: none;"]');
        hiddenLabels.forEach(label => {
            label.style.display = "block";
        });
    }
    function ResetFilter(){
        ListReset()
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        STselect.value = "-"
        CheckItemsinbox = {}
        ONUPDATE()
    }

    ONUPDATE()
    function ONUPDATE(){
        data = ""
        if (Object.keys(CheckItemsinbox).length === 0) {
            data = `<tr><td style="text-align: center;" colspan="6">No Data</td></tr>`
            totalpayment = "0.00"
            $('#TBODY').html(data);
        } else {
            if(lastCheckedCheckbox !== null){
                let [name, STID, price] = lastCheckedCheckbox.value.split("||")

                let containerrows = `
                            <tr>
                                <td scope='row' id="${name}" >${name}</td>
                                <td scope='row' style='text-align:end'>${price}</td>
                                <td scope='row' style='text-align:center'>
                                    <input type="number" name="" id="" value ="1" class="Inputnumbercss" onchange="Inputnum(this)">
                                </td>
    
                                <td scope='row' style='text-align:end'>
                                    ${price}
                                </td>
                                <td scope='row' style='display:flex;justify-content:center;'>
                                    <button onclick='Deletebtn(this,"${name}||${STID}||${price}")' class='Deletebtn'>
                                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z'/></svg>
                                    </button>
                                </td>
                            </tr>
                            `

                data = containerrows

                if (Object.keys(CheckItemsinbox).length === 1) {
                    $('#TBODY').html(null);
                }
            }

        

      
            
            $('#TBODY').append(data);
            lastCheckedCheckbox = null
        }


    }

    function Deletebtn(data,value12){


        let Rowparent = data.parentElement.parentElement
        Rowparent.id = "TOBEDELETED"
        
        
        const checkbox = document.querySelector(`input[value="${value12}"]`);
        const TOBEDELETED = document.getElementById('TOBEDELETED')

        if (checkbox) {
            checkbox.checked = false; 

            //reset the value in correctform
            checkboxes.forEach(checkbox => {
                const checkedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);
                const checkedValues = checkedCheckboxes.map(cb => cb.value);
                CheckItemsinbox = checkedValues
            });
        }

        if (TOBEDELETED) {
            TOBEDELETED.remove();
        }

        ONUPDATE()
    }

    function Inputnum(data){
        let targetrow = data.parentElement.parentElement
        if(parseFloat(data.value) > 0){
            let product = parseFloat(targetrow.cells[1].innerText)* parseFloat(data.value) 
            targetrow.cells[3].innerText = parseFloat(product).toFixed(2)
        }else{
            data.value = 1
            targetrow.cells[3].innerText = targetrow.cells[1].innerText
        }
    }

    const TBODY = document.getElementById('TBODY')



    async function SavingData(id,gid){
        let rows = TBODY.rows;

        //setting up the objectdata
        for (let i = 0; i < rows.length; i++) {
            let targetKey = rows[i].cells[0].innerText
            let Price = rows[i].cells[1].innerText
            let Quantity = rows[i].cells[2].children[0].value
            let Totalnum = rows[i].cells[3].innerText

            console.log(targetKey,Price,Quantity,Totalnum)

            let sqlcode = `INSERT INTO guestextracharges (ReservationID,ChargeDescription, quantity, ChargeAmount, ChargeDate) VALUES ('${id}','${targetKey}', '${Quantity}', '${Totalnum}', CURRENT_DATE);`;
            await AjaxSendv3(sqlcode,"GUESTLOGIC",`&Process=Insertmore`)
        }

        await Swal.fire(
            '',
            'Inserted Successfully!',
            'success'
        )

        location.href = `./Mainpage.php?nzlz=reservationview&plk=2&ISU=${gid}`
    }

</script>