 <!--Manage User-->
 <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Staff</h1>
                    <button class="addbtn" onclick="ADDSTAFF()">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                    </button>
                </div>
                <div class="SEARCHANDFILTRATION">
                    <div class="box">
                            <div class="searchingDIV">
                                <input type="search" name="" id="SEARCHITEMINPUT" class="Searchinput">
                                <button class="addbtn" onclick="SEARCHING()">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                                </button>
                            </div>
<!--
                            <button class="Editbtn" onclick="FILTERING()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
                            </button>

-->
                            <button class="Editbtn" onclick="RESETTABLE()">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z"/></svg>
                            </button>

                    </div>
                </div>


                <div class="stafflistbox">
                    <div class="box">
                        <div class="box2">
                        <table class="table" style="border-collapse: collapse;">
                            <caption>
                                <h2>List of Staff</h2>
                                
                            </caption>
                            <thead>
                                <tr>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>Email</th>
                                    <th scope='col' style="text-align:center;">Action</th>
                                </tr>
                            </thead>

                            <tbody id="TBODYELEMENT">

<?php
    $sqlcode = "SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE Access = 'STAFF' ORDER BY Lastname, Firstname, Middlename;";
    $query5 = mysqli_query($conn,$sqlcode);
    $table5 = "";
    while ($result5 = mysqli_fetch_assoc($query5)) {
        # code...
        $pick1 = "";
        $pick2 = "";
        if($result5["Access"] == "STAFF"){
            $pick2 = "selected";
        }else{
            $pick1 = "selected";
        }
        $table5 .= "
                <tr>
                    <td>".$result5["fullname"]."</td>
                    <td>".$result5["Email"]."</td>
                    <td class='ActionTABLE' id='".$result5["userID"]."'>
                        <button class='addbtn' onclick='VIEW(this)'>
                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 576 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z'/></svg>
                        </button>
                        <button class='Editbtn' onclick='EDIT(this)'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z'/></svg>
                        </button>
                        <button class='Deletebtn' onclick='DELETION(this)'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg>
                        </button>
                    </td>
                </tr>
        ";

    }

    if (mysqli_num_rows($query5) == 0) {
        $table5 = "     <tr>
            <td colspan='4' style='text-align:center; font-weight:bolder;'>No data </td>
        </tr> ";
    }
    echo $table5;
?>
                        
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>

            </div>

<script>
    const SEARCHITEMINPUT = document.getElementById("SEARCHITEMINPUT");
    const mainquery = `
    SELECT *, CONCAT(LastName, ', ', FirstName, ' ', UPPER(LEFT(MiddleName,1)), '.' ) AS fullname FROM userscredentials WHERE Access = 'STAFF' [CONDITION] ORDER BY Lastname, Firstname, Middlename;`
    const TBODYELEMENT = document.getElementById('TBODYELEMENT')



    async function SEARCHING() {
        let item = SEARCHITEMINPUT.value;
        
        let searchcondition = `AND (
            Email LIKE '%${item}%'
            OR CONCAT(LastName, ' ' , FirstName, ' ', MiddleName ) LIKE '%${item}%'
            OR FirstName LIKE '%${item}%'
            OR LastName LIKE '%${item}%'
            OR MiddleName LIKE '%${item}%'
            OR Gender LIKE '%${item}%'
            OR DateOfBirth LIKE '%${item}%'
            OR Address LIKE '%${item}%'
            OR City LIKE '%${item}%'
            OR State LIKE '%${item}%'
            OR PostalCode LIKE '%${item}%'
            OR Country LIKE '%${item}%'
            OR PhoneNumber LIKE '%${item}%'
            OR Position LIKE '%${item}%'
            OR HireDate LIKE '%${item}%'
            OR Salary LIKE '%${item}%'
            OR Access LIKE '%${item}%'
        )`;
        const formattedText = mainquery.replace(/\[CONDITION\]/, searchcondition);
        console.log(formattedText)
        const Tabledata =await AjaxSendv3(formattedText,"MANSTAFFLOGIC","&Process=Search")
        TBODYELEMENT.innerHTML = Tabledata

    }
    async function RESETTABLE() {
        const Tabledata =await AjaxSendv3("","MANSTAFFLOGIC","&Process=Reset")
        SEARCHITEMINPUT.value = "";
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
                <label for='swal-input2'>Sex</label>
                <select class='SWALinput swalselect' id='swal-input2' aria-label='Floating label select example'>
                    <option value="-">-</option>
                    <option value='Male'>Male</option>
                    <option value='Female'>Female</option>
                </select>
            </div>

        </div>`

        let formValues =await POPUPCREATE("Filters",design,2)

        if (formValues) {
            let conditions = [];

            if(formValues[0] !== ""){
                conditions.push(`(
                    Email LIKE '%${formValues[0]}%'
                    OR CONCAT(LastName, ' ' , FirstName, ' ', MiddleName ) LIKE '%${formValues[0]}%'
                    OR FirstName LIKE '%${formValues[0]}%'
                    OR LastName LIKE '%${formValues[0]}%'
                    OR MiddleName LIKE '%${formValues[0]}%'
                    OR DateOfBirth LIKE '%${formValues[0]}%'
                    OR Address LIKE '%${formValues[0]}%'
                    OR City LIKE '%${formValues[0]}%'
                    OR State LIKE '%${formValues[0]}%'
                    OR PostalCode LIKE '%${formValues[0]}%'
                    OR Country LIKE '%${formValues[0]}%'
                    OR PhoneNumber LIKE '%${formValues[0]}%'
                    OR Position LIKE '%${formValues[0]}%'
                    OR HireDate LIKE '%${formValues[0]}%'
                )`);
            }
            if(formValues[1] !== "-"){
                conditions.push(`Gender = '${formValues[1]}'`)
            }

            conditions.unshift("")
            const joinedString = conditions.join(' AND ');
            const formattedText = mainquery.replace(/\[CONDITION\]/, joinedString);
            

            console.log(formattedText)
            const Tabledata =await AjaxSendv3(formattedText,"MANSTAFFLOGIC","&Process=Search")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }
    
    async function DELETION(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[0].innerHTML

        Swal.fire({
            title: `Do you want to delete user ${targetname}?`,
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: `No`,
        }).then(async (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let sqlcode = `DELETE FROM userscredentials WHERE userID ='${targetid}';;`
                //call for AjaxsSendv3
                const Tabledata = await AjaxSendv3(sqlcode,"MANSTAFFLOGIC","&Process=DeleteUpdate")
                TBODYELEMENT.innerHTML = Tabledata
                SweetSuccess()
            }

        })
    }

    async function VIEW(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[0].innerHTML
        location.href = `./Mainpage.php?nzlz=viewuserinfo&plk=5&ISU=${targetid}&qwe=true`;
    }
    async function EDIT(e){
        let targetid = e.parentNode.id
        let targetname = e.parentNode.parentNode.cells[2].innerText.trim()

        let design = `
        <div class='sweetDIVBOX'>
            <div class='SWEETFORMS'>
                <label for='swal-input2'>User Access</label>
                <select class='SWALinput swalselect' id='swal-input1' aria-label='Floating label select example'>
                    <option value='ADMIN' >Admin</option>
                    <option value='CLIENT'>Client</option>
                    <option value='STAFF' selected>Staff</option>
                </select>
            </div>

        </div>`

        let formValues =await POPUPCREATE("Filters",design,1)

        if (formValues) {

            const formattedText = `UPDATE userscredentials SET Access = '${formValues[0]}' WHERE userID = '${targetid}';`
        
            console.log(formattedText)
            const Tabledata =await AjaxSendv3(formattedText,"ADDINGSTAFF2","&Process=AccessUpdate")
            TBODYELEMENT.innerHTML = Tabledata

        }
    }

    async function ADDSTAFF(){
        location.href = `./Mainpage.php?nzlz=addfromliststaff&plk=5`;
    }
</script>