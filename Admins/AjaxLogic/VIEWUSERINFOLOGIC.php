<?php
require("../Database.php");
session_start();
ob_start();

$sqlcode = $_POST["sqlcode"];
mysqli_query($conn,$sqlcode);

    $readonly = (isset($_GET["qwe"])) ? "readonly":"";
    $userid = (isset($_POST["ISU"])) ? $_POST["ISU"]: $_SESSION["USERID"];


  

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


                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="box">
                        <h2>Employee Info</h2>
                        <div class="credentialinfo">
                            <div class="form-column">
                                <label for="userID">User ID:</label>
                                <input type="text" name="userID" id="userID" readonly value="<?php echo $userid;?>">
                            </div>
                            <div class="form-column">
                                <label for="access">Access:</label>
                                <input type="text" name="access" id="access" readonly value="<?php echo $result10["Access"];?>">
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
                    </div>
                    <div class="box">
                        <h2>Personal Info</h2>
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
                                <label for="mfirstName">Mothers First Name:</label>
                                <input type="text" name="mfirstName" id="mfirstName" <?php echo $readonly;?> value="<?php echo $result10["mFirstName"];?>">
                            </div>
                            
                            
                            <div class="form-column">
                                <label for="mmiddleName">Mothers Middle Name:</label>
                                <input type="text" name="mmiddleName" id="mmiddleName" <?php echo $readonly;?> value="<?php echo $result10["mMiddleName"];?>">
                            </div>
                            
                            <div class="form-column">
                                <label for="mlastName">Mothers Last Name:</label>
                                <input type="text" name="mlastName" id="mlastName" <?php echo $readonly;?> value="<?php echo $result10["mLastName"];?>">
                            </div>
                        </div>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="ffirstName">Fathers First Name:</label>
                                <input type="text" name="ffirstName" id="ffirstName" <?php echo $readonly;?> value="<?php echo $result10["fFirstName"];?>">
                            </div>
                            
                            
                            
                            <div class="form-column">
                                <label for="fmiddleName">Fathers Middle Name:</label>
                                <input type="text" name="fmiddleName" id="fmiddleName" <?php echo $readonly;?> value="<?php echo $result10["fMiddleName"];?>">
                            </div>
                            <div class="form-column">
                                <label for="flastName">Fathers Last Name:</label>
                                <input type="text" name="flastName" id="flastName" <?php echo $readonly;?> value="<?php echo $result10["fLastName"];?>">
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <h2>Address Info</h2>
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
                                <label for="state">State:</label>
                                <input type="text" name="state" id="state" <?php echo $readonly;?>  value="<?php echo $result10["State"];?>">
                            </div>
                            
                            <div class="form-column">
                                <label for="postalCode">Postal Code:</label>
                                <input type="text" name="postalCode" id="postalCode" <?php echo $readonly;?>  value="<?php echo $result10["PostalCode"];?>">
                            </div>
                            
                            <div class="form-column">
                                <label for="country">Country:</label>
                                <input type="text" name="country" id="country" <?php echo $readonly;?>  value="<?php echo $result10["Country"];?>"> 
                            </div>
                        </div>
                            
                    </div>
                    
                </form>
    
