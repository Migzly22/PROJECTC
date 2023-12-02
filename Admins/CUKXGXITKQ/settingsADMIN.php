

<!--Settings-->
<?php
    $sqlcodeSettings = "SELECT *, CONCAT(LastName,', ', FirstName, ' ', MiddleName ) AS staffname FROM userscredentials WHERE userID = '".$_SESSION["STAFFID"]."';";
    $querySettings = mysqli_query($conn,$sqlcodeSettings);
    $result = mysqli_fetch_assoc($querySettings);

?>
            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Settings</h1>
                </div>
                <div class="stafflistbox SETTINGS" id="tbody">
                    <div class="box">
                        <h1>Basic Information</h1>
                        <p>Manage and update your Personal Information</p>
                        <div class="box2">
                            <table class="table" style="border-collapse: collapse;">
                                <tbody>
                                    <tr>
                                        <th scope='row'>User Number</th>
                                        <td colspan="2">

                                            <span id='studnum'><?php echo $_SESSION["STAFFID"]; ?></span>

                                        </td>
            
                                    </tr>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td id="namecontainer">
                                        <span id='name'><?php echo $result["staffname"]; ?></span>
                                    </td>
                                    <td class="ActionTABLE">
                                        <button class="Editbtn" onclick="Editdata(<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </button>
                
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" >Phone Number</th>
                                    <td id="Phonenumber">
                                        <span><?php echo $result["PhoneNumber"]; ?></span>
                                    </td>
                                    <td class="ActionTABLE">
                                        <button class="Editbtn" onclick="Editdata(<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </button>
                
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" >Address</th>
                                    <td id="Address">
                                        <span ><?php echo $result["Address"]; ?></span>
                                    </td>
                                    
                                    <td class="ActionTABLE">
                                        <button class="Editbtn" onclick="Editdata(<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </button>
                
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box">
                        <h1>Login Information</h1>
                        <p>Manage and update your Login Information</p>
                        <div class="box2">
                            <table class="table" style="border-collapse: collapse;">
                                <tbody>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td id="Email">
                                        <span><?php echo $result["Email"]; ?></span>
                                    </td>
                                    <td class="ActionTABLE">
                                        <button class="Editbtn" onclick="Editdata2(this,<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </button>
                
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Password</th>
                                    <td id="Password">
                                        <span id="pass">*************</span>
                                    </td>
                                    <td class="ActionTABLE">
                                        <button class="Editbtn" onclick="Editdata2(this,<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </button>
                
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box">
                        <h1>User Data Deletion</h1>
                        <p>Deletion of account details</p>
                        <div class="box2">
                            <table class="table" style="border-collapse: collapse;">
                                <tbody>
                                <tr>
                                    <th scope="row">Delete This Account</th>
                                    <td class="ActionTABLE">
                                        <button class='Deletebtn' onclick="DELETIONBTN(this,<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

<script>
    const tbody = document.getElementById("tbody");
    async function Editdata(targetid){
        location.href = `./Mainpage.php?nzlz=viewuserinfo&plk=8&ISU=${targetid}`;
    }
    async function DELETIONBTN(e,userid){

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
            let throwns = await AjaxSendv3(sqlcodecheck,"Deletionlogic","")

            
            if(eval(throwns)){
                let sqlcode = `DELETE FROM userscredentials WHERE userID  ='${userid}';;`
                throwns = await AjaxSendv3(sqlcode,"Deletionlogic","")
                await Swal.fire(``, 'The Account Has Been Delete Successfully', 'success') 
                location.href = "./AjaxLogic/LOGOUT.php"
            }else{
                SweetError("Incorrect Password, Account Deletion has been Aborted")
            }


        }

    }
    async function Editdata2(e,userid){

        let Title = e.parentNode.parentNode.cells[0].innerHTML
        let Spansdata = e.parentNode.parentNode.cells[1]

        let newdatacollector = Spansdata.querySelectorAll('span')
        let spanlenght = newdatacollector.length;

        let htmldata = ``;
        let counter = 0
        let datatochange = Spansdata.id

        switch (Title) {
            case 'Password':
                htmldata += `<input id="swal-input1" class="swal2-input" placeholder="New Password"><input id="swal-input2" class="swal2-input" placeholder="Confirm Password">`;
                counter =2
                break;                 
            case 'Email':
                htmldata += `<input id="swal-input1" class="swal2-input" placeholder="${Title}" value="${newdatacollector[0].innerText.replace(/\s+/g, ' ').trim()}">`;
                counter =1
                break;
        }
        const { value: formValues } = await Swal.fire({
            title: 'Changing '+Title,
            html: htmldata,
            focusConfirm: false,
            confirmButtonText: 'Save',
            showCancelButton: true,
            preConfirm: () => {
                return Array.from({ length: counter }, (_, i) => document.getElementById('swal-input'+(i+1)).value);
            }
        })

        const hasBlankData = formValues.some(item => item === "");

        if (!hasBlankData) {
            if(Title === "Password"){
                if(formValues[0] !== formValues[1]){
                    await SweetError()
                    return true;
                }
            }


            let sqlcode = ""

            if(Title === "Email" || Title === "Password" ){
                sqlcode = `UPDATE userscredentials SET ${datatochange} = '${formValues[0]}' WHERE userID ='${userid}';`
            }
            let throwns = await AjaxSendv3(sqlcode,"SETTINGSLogic","")
            tbody.innerHTML = throwns
            SweetSuccess()
        }else{
            SweetError();
        }
    }
</script>