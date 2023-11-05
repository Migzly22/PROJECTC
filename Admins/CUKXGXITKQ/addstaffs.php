
            <div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Add New Staff</h1>
                   
                </div>
                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="box">
                        <h2>Employee Info</h2>
                        <div class="credentialinfo">
                            <div class="form-column">
                                <label for="userID">User ID:</label>
                                <input type="text" name="userID" id="userID" readonly >
                            </div>
                            <div class="form-column">
                                <label for="access">Access:</label>
                                <input type="text" name="access" id="access" readonly >
                            </div>
                            <div class="form-column">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email"   >
                            </div>
                            <div class="form-column">
                                <label for="phoneNumber">Phone Number:</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber" >
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <h2>Personal Info</h2>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="firstName">First Name:</label>
                                <input type="text" name="firstName" id="firstName" >
                            </div>
                            
                            
                            
                            <div class="form-column">
                                <label for="middleName">Middle Name:</label>
                                <input type="text" name="middleName" id="middleName" >
                            </div>
                            <div class="form-column">
                                <label for="lastName">Last Name:</label>
                                <input type="text" name="lastName" id="lastName" >
                            </div>
                            <div class="form-column">
                                <label for="gender">Sex:</label>
                                <select name="gender" id="gender" >
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            
                            <div class="form-column">
                                <label for="dateOfBirth">Date of Birth:</label>
                                <input type="date" name="dateOfBirth" id="dateOfBirth" >
                            </div>
                        </div>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="mfirstName">Mothers First Name:</label>
                                <input type="text" name="mfirstName" id="mfirstName" >
                            </div>
                            
                            
                            <div class="form-column">
                                <label for="mmiddleName">Mothers Middle Name:</label>
                                <input type="text" name="mmiddleName" id="mmiddleName" >
                            </div>
                            
                            <div class="form-column">
                                <label for="mlastName">Mothers Last Name:</label>
                                <input type="text" name="mlastName" id="mlastName">
                            </div>
                        </div>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="ffirstName">Fathers First Name:</label>
                                <input type="text" name="ffirstName" id="ffirstName" >
                            </div>
                            
                            
                            
                            <div class="form-column">
                                <label for="fmiddleName">Fathers Middle Name:</label>
                                <input type="text" name="fmiddleName" id="fmiddleName" >
                            </div>
                            <div class="form-column">
                                <label for="flastName">Fathers Last Name:</label>
                                <input type="text" name="flastName" id="flastName">
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <h2>Address Info</h2>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="address">Address:</label>
                                <input type="text" name="address" id="address">
                            </div>
                            
                            <div class="form-column">
                                <label for="city">City:</label>
                                <input type="text" name="city" id="city" >
                            </div>
                            
                            <div class="form-column">
                                <label for="state">State:</label>
                                <input type="text" name="state" id="state">
                            </div>
                            
                            <div class="form-column">
                                <label for="postalCode">Postal Code:</label>
                                <input type="text" name="postalCode" id="postalCode" >
                            </div>
                            
                            <div class="form-column">
                                <label for="country">Country:</label>
                                <input type="text" name="country" id="country"  > 
                            </div>
                        </div>
                            
                    </div>
                    
                </form>
                    <div style="text-align: center; ">
                        <input type="button" value="Save and Submit" class="submitbtn addbtn" onclick="EDIT()">
                    </div>
                
            </div>

<script>
    

    async function EDIT() {
        const FCONTAIN = document.getElementById("FCONTAIN")

        let password = FCONTAIN.firstName.value+FCONTAIN.lastName.value+FCONTAIN.phoneNumber.value
        
        let sqlcode1 = `INSERT INTO userscredentials( Password, Email, FirstName, LastName, MiddleName, Gender, DateOfBirth, mFirstName, mMiddleName, mLastName, fFirstName, fMiddleName, fLastName, Address, City, State, PostalCode, Country, PhoneNumber, HireDate) 
        VALUES ( '${password}',
          '${FCONTAIN.email.value}', 
          '${FCONTAIN.firstName.value}', 
          '${FCONTAIN.lastName.value}',
          '${FCONTAIN.middleName.value}',
           '${FCONTAIN.gender.value}', 
           '${FCONTAIN.dateOfBirth.value}', 
           '${FCONTAIN.mfirstName.value}',
            '${FCONTAIN.mmiddleName.value}', 
            '${FCONTAIN.mlastName.value}',
             '${FCONTAIN.ffirstName.value}',
              '${FCONTAIN.fmiddleName.value}',
               '${FCONTAIN.flastName.value}', 
               '${FCONTAIN.address.value}', 
               '${FCONTAIN.city.value}',
                '${FCONTAIN.state.value}', 
                '${FCONTAIN.postalCode.value}', 
                '${FCONTAIN.country.value}',
                 '${FCONTAIN.phoneNumber.value}',
                  CURRENT_DATE);`

        const Tabledata = await AjaxSendv3(sqlcode1,"INSERTLOGIC",``)
        await eval(Tabledata)
        location.href =  `./Mainpage.php?nzlz=manstaff&plk=5`;
    }
</script>

            