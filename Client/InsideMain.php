<?php
    require("../Database.php");
    session_start();
    ob_start();

    error_reporting(E_ERROR | E_PARSE);

    $usertoken = !isset($_SESSION["USERID"]) ?  null : $_SESSION["USERID"];
    $linksref = !isset($_SESSION["USERID"]) ?  "./login.php" : "./booking.php";


    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        header("Location: ./index.php");
        ob_end_flush();
        exit;
    }


    $cin = isset($_GET["cin"]) ? $_GET["cin"] : "" ;
    $cout = isset($_GET["cout"]) ? $_GET["cout"] : "" ;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliJosh Resort & Event</title>


    <link rel="stylesheet" href="./CSS/Table.css">
    <link rel="stylesheet" href="./CSS/Admin12.css">
    
    <link rel="stylesheet" href="./CSS/styleformsettingclient.css">

    <link href="./CSS/style.scss" rel="stylesheet/scss" type="text/css">

    <script src="./JS/script1.js" defer></script>
    <script src="./Calendar/app.js" defer></script>

        <!--SweetAlert-->
        <script src="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <!--Jquery-->
        <script src="../Jquery/node_modules/jquery/dist/jquery.js"></script>
        <script src="../Jquery/node_modules/jquery/dist/jquery.min.js"></script>
    
             
</head>
<body>
    <nav class="Mainnavigation glassylink">
        <ul class="smoothmenu">
            <li class="creator">
                <a href="./index.php#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="./booking.php#COTTAGES" class="textkainit">COTTAGES</a>
            </li>
            <li>
                <a href="./booking.php#ROOMS" class="textkainit">ROOMS</a>
            </li>
            <li>
                <a href="./booking.php#EVENTPLACE" class="textkainit">EVENTPLACE</a>
            </li>
            <li>
                <a href="./booking.php#EXPENDITURES" class="textkainit">EXPENDITURES</a>
            </li>
        </ul>
        <div class="USERVALUE USERVALUE2 dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
            <ul class="dropdown-menu">
                <li><a href="./InsideMain.php">Account Settings</a></li>
                <li><a href="./bookinginformations.php">Booking Information</a></li>
                <li><a href="./logOut.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main>
<?php
    $ids = $_SESSION["USERID"];
    $sqlcode = "SELECT userID, FirstName, MiddleName,LastName, PhoneNumber, Address, City, Email FROM userscredentials WHERE userID = '$ids';";
    $USERDATA = mysqli_query($conn,$sqlcode);   
    $result = mysqli_fetch_assoc($USERDATA);

?>
        <section class="mainbody" style="padding: 1em 3em;">

            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Settings</h1>
                </div>
                <div class="stafflistbox SETTINGS" id="tbody">
                    <div class="box">
                        <div style="display: flex;justify-content:space-between;align-items:center;">
                            <div>
                                <h1>Basic Information</h1>
                                <p>Manage and update your Personal Information</p>
                            </div>
                            <div>
                                <button class="Editbtn" onclick="Editdata2(`<?php echo $_SESSION['USERID'];?>`)">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                </button>
                            </div>
                        </div>
                        



                        <div class="box2">
                            <table class="table" style="border-collapse: collapse;">
                                <tbody>
                                   
                                <tr>
                                    <th scope="row">Name</th>
                                    <td id="namecontainer">
                                        <span id='name'><?php echo $result["FirstName"]; ?></span>
                                        <span id='mname'><?php echo $result["MiddleName"]; ?></span>
                                        <span id='lname'><?php echo $result["LastName"]; ?></span>



                                    </td>
                            
                                </tr>
                                <tr>
                                    <th scope="row" >Phone Number</th>
                                    <td id="Phonenumber">
                                        <span><?php echo $result["PhoneNumber"]; ?></span>
                                    </td>
                                
                                </tr>
                                <tr>
                                    <th scope="row" >Address</th>
                                    <td id="Address">
                                        <span ><?php echo $result["Address"]; ?></span>
                                    </td>
                                    
                            
                                </tr>
                                <tr>
                                    <th scope="row" >City</th>
                                    <td id="Address">
                                        <span ><?php echo $result["City"]; ?></span>
                                    </td>
                                    
                                    
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td id="Email">
                                        <span><?php echo $result["Email"]; ?></span>
                                    </td>
                               
                                </tr>
                                

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box">
                        <h1>Login Information</h1>
                        <p>Manage and Delete your Login Information</p>
                        <div class="box2">
                            <table class="table" style="border-collapse: collapse;">
                                <tbody>
                                
                                <tr>
                                    <th scope="row">Password</th>
                                    <td id="Password">
                                        <span id="pass">*************</span>
                                    </td>
                                    <td class="ActionTABLE">
                                        <button class="Editbtn" onclick="Editdata(this,<?php echo $_SESSION['USERID'];?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                        </button>
                
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="2">Delete This Account</th>
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


        </section>

    </main>


<script>
    const tbody = document.getElementById("tbody");
    async function Editdata2(userid){

        location.href = "./settingsupdate.php"

    }

    function passwordValidation(inputElement) {
        if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/.test(inputElement)) {
            return true
        }else{
            return false
        }
    }


    async function Editdata(e,userid){

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
         
            Swal.fire(JSON.stringify(formValues))

            if(!passwordValidation(formValues[0]) || formValues[0] !== formValues[1] ){
                    await Swal.fire({
                        html: `
                            <b>Password Should Contain : </b>
                            <li style='text-align:start;'>At least 8 characters long.</li>
                            <li style='text-align:start;'>Contains at least one uppercase letter.</li>
                            <li style='text-align:start;'>Contains at least one lowercase letter.</li>
                            <li style='text-align:start;'>Contains at least one digit.</li>
                            <li style='text-align:start;'> Contains at least one special character (e.g., !@#$%^&*).</li>
                        `
                    });
                    return true;
            }

            let sqlcode = `UPDATE userscredentials SET Password = '${formValues[0]}' WHERE userID ='${userid}';`
            let throwns = await AjaxSendv3(sqlcode,"SETTING")

            await Swal.fire({
                text: "Updated Successfully",
                icon: "success"
            });
            tbody.innerHTML = throwns

            

        }else{
            SweetError();
        }
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
            let throwns = await AjaxSendv3(sqlcodecheck,"SETTING","&table=deletion")
            await eval(throwns.split("{00}")[0])

            console.log(throwns.split("{00}")[0].includes("success"))

            if(throwns.split("{00}")[0].includes("success")){
                location.href = "./logOut.php"
            }

        }
    }

</script>
</body>
</html>