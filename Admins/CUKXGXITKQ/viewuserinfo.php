<?php
    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_GET["ISU"])) ? $_GET["ISU"]: $_SESSION["USERID"];


    $sqlcode10 = "SELECT * FROM userscredentials WHERE userID = '$userid';";
    $query10 = mysqli_query($conn,$sqlcode10);
    $result10 = mysqli_fetch_assoc($query10);

    $Male = "";
    $Female = "";
    if($result10["Gender"] == "Male"){
        $Male= "selected"; 
    }else{
        $Female = "selected";
    }
?>


            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>User Information</h1>
                   
                </div>
                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="box">
                        <div class="credentialinfo">
                            <div class="form-column">
                                <label for="userID">User ID:</label>
                                <input type="text" name="userID" id="userID" readonly value="<?php echo $userid;?>">
                            </div>
 
                            <div class="form-column">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" <?php echo $readonly;?>   value="<?php echo $result10["Email"];?>">
                            </div>
                            <div class="form-column">
                                <label for="phoneNumber">Phone Number:</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber" <?php echo $readonly;?> value="<?php echo $result10["PhoneNumber"];?>">
                            </div>
                        </div>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="firstName">First Name:</label>
                                <input type="text" name="firstName" id="firstName" <?php echo $readonly;?> value="<?php echo $result10["FirstName"];?>">
                            </div>
                            
                            
                            
                            <div class="form-column">
                                <label for="middleName">Middle Name:</label>
                                <input type="text" name="middleName" id="middleName" <?php echo $readonly;?> value="<?php echo $result10["MiddleName"];?>">
                            </div>
                            <div class="form-column">
                                <label for="lastName">Last Name:</label>
                                <input type="text" name="lastName" id="lastName" <?php echo $readonly;?> value="<?php echo $result10["LastName"];?>">
                            </div>
                            <div class="form-column">
                                <label for="gender">Sex:</label>
                                <select name="gender" id="gender" >
                                    <option value="Male" <?php echo $Male; ?>>Male</option>
                                    <option value="Female" <?php echo $Female; ?>>Female</option>
                                </select>
                            </div>
                            
                            <div class="form-column">
                                <label for="dateOfBirth">Date of Birth:</label>
                                <input type="date" name="dateOfBirth" id="dateOfBirth" <?php echo $readonly;?> value="<?php echo $result10["DateOfBirth"];?>">
                            </div>
                        </div>

                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address" <?php echo $readonly;?>  value="<?php echo $result10["Address"];?>">
                            </div>
                            
                            <div class="form-column">
                                <label for="city">City:</label>
                                <input type="text" name="city" id="city" <?php echo $readonly;?>  value="<?php echo $result10["City"];?>">
                            </div>
                            
                            <div class="form-column">
                                <label for="postalCode">Postal Code:</label>
                                <input type="text" name="postalCode" id="postalCode" <?php echo $readonly;?>  value="<?php echo $result10["PostalCode"];?>">
                            </div>
                        </div>
                    </div>
                </form>
                    <div style="text-align: center;  <?php if($readonly != ""){echo "display:none;";}?>">
                        <input type="button" value="Save and Submit" class="submitbtn addbtn" onclick="EDIT()">
                    </div>
                
            </div>

<script>
    

    async function EDIT() {
        const FCONTAIN = document.getElementById("FCONTAIN")

        let sqlcode = `UPDATE userscredentials SET
        Email = '${FCONTAIN.email.value}', 
        FirstName = '${FCONTAIN.firstName.value}', 
        LastName = '${FCONTAIN.lastName.value}', 
        MiddleName = '${FCONTAIN.middleName.value}', 
        Gender = '${FCONTAIN.gender.value}', 
        DateOfBirth = '${FCONTAIN.dateOfBirth.value}',
        PhoneNumber = '${FCONTAIN.phoneNumber.value}',
        Address = '${FCONTAIN.address.value}', 
        City = '${FCONTAIN.city.value}', 
        PostalCode = '${FCONTAIN.postalCode.value}',
        WHERE userID = '${FCONTAIN.userID.value}';`;

        
        const Tabledata = await AjaxSendv3(sqlcode,"VIEWUSERINFOLOGIC",`&ISU=${FCONTAIN.userID.value}`)
        FCONTAIN.innerHTML = Tabledata
        SweetSuccess()
    }
</script>

            