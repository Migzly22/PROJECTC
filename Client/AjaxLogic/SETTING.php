<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];

if(isset($_POST["table"])){
    $valid = mysqli_query($conn, $sqlcode);
    if(mysqli_num_rows($valid) > 0){
        echo "
             Swal.fire(``, 'The Account Has Been Delete Successfully', 'success'){00}
        ";
    }else{
        echo "
            Swal.fire(``, 'The Account deletion transaction is failed', 'error'){00}
        ";
    }
}else{
    mysqli_query($conn, $sqlcode);
}



$ids = $_SESSION["USERID"];
$sqlcode2 = "SELECT userID, FirstName, MiddleName,LastName, PhoneNumber, Address, City, Email FROM userscredentials WHERE userID = '$ids';";
$USERDATA = mysqli_query($conn,$sqlcode2);   
$result = mysqli_fetch_assoc($USERDATA);





?>

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