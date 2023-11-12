<div class="mainbodycontainer">
                <div class="classHeader">
                    <h1>Reservation Form</h1>
                   
                </div>
                <form action="" method="post" class="ViewAccount" id="FCONTAIN">
                    <div class="box">
                        <div class="credentialinfo">
                            <div class="form-column">
                                <label for="firstName">First Name :</label>
                                <input type="text" name="firstName" id="firstName">
                            </div>
                            <div class="form-column">
                                <label for="middleName">Middle Name :</label>
                                <input type="text" name="middleName" id="middleName">
                            </div>
                            <div class="form-column">
                                <label for="lastName">Last Name  :</label>
                                <input type="text" name="lastName" id="lastName">
                            </div>
                            <div class="form-column">
                                <label for="address">Address :</label>
                                <input type="text" name="address" id="address">
                            </div>
                            <div class="form-column">
                                <label for="email">Email :</label>
                                <input type="email" name="email" id="email">
                            </div>
                            <div class="form-column">
                                <label for="phoneNumber">Phone Number :</label>
                                <input type="tel" name="phoneNumber" id="phoneNumber">
                            </div>

                         
                            
                        </div>
                        <div class="personalinfo">
                            <div class="form-column">
                                <label for="numadult">Number of Adults :</label>
                                <input type="number" name="numadult" id="numadult" value="0">
                            </div>
                            <div class="form-column">
                                <label for="numkid">Number of Kids :</label>
                                <input type="number" name="numkid" id="numkid" value="0">
                            </div>
                            <div class="form-column">
                                <label for="numsenior">Number of Senior :</label>
                                <input type="number" name="numsenior" id="numsenior" value="0">
                            </div>
                            <div class="form-column">
                                <label for="Checkin" >Checkin :</label>
                                <input type="datetime-local" name="Checkin" id="Checkin" onchange="datachange()">
                            </div>
                            <div class="form-column">
                                <label for="Checkout">Checkout :</label>
                                <input type="datetime-local" name="Checkout" id="Checkout" onchange="datachange()">
                            </div>
                            <div class="form-column">
                                <label for="timapackage">Time Type :</label>
                                <select name="timapackage" id="timapackage" onchange="Packagetype(this)">
                                    <option value="DayPrice">Day Time (8:00 AM - 5:00 PM)</option>
                                    <option value="NightPrice">Night Time (7:00 PM - 7:00 AM)</option>
                                    <option value="22Hrs">22 Hrs (2:00 PM - 12:00 PM)</option>
                                </select>
                            </div>
                        </div>
                        <div class="personalinfo">
                                <div class="form-column">
                                    <label for="numromocu">Number of Room Occupied :</label>
                                    <input type="number" name="numromocu" id="numromocu" value="0">
                                </div>
                                <div class="form-column">
                                    <label for="Cottage">Cottage:</label>
                                    <select name="Cottage" id="Cottage">
                                        <option value="None" selected>None</option>
                                        <option value="Umbrella">Umbrella</option>
                                        <option value="Kubo">Kubo</option>
                                        <option value="Gazebo">Gazebo</option>
                                        <option value="Tent">Tent</option>
                                    </select>
                                </div>
                                <div class="form-column">
                                    <label for="evplace">Events Place:</label>
                                    <select name="evplace" id="evplace">
                                        <option value="None" selected>None</option>
                                        <option value="Pavilion">Pavilion</option>
                                        <option value="Grand Pavilion">Grand Pavilion</option>
                                    </select>
                                </div>
                        </div>
                        <div class="personalinfo" id="RoomNUMBERMULTI">
                                
                        </div>
                    </div>
                </form>
                <div style="text-align: center;  ">
                        <input type="button" value="Save and Submit" class="submitbtn addbtn" onclick="EDIT()">
                </div>
            </div>
<script>

    const RoomNUMBERMULTI = document.getElementById('RoomNUMBERMULTI')

    var duplicatedinnerhtml = `<div class="form-column">
                                    <label for="">Room Number:</label>
                                    <select name="RNUM" id="">
                                        <option value="None">-</option>
                                    </select>
                                </div>`
    
    //RoomNUMBERMULTI.innerHTML


    const FCONTAIN = document.getElementById("FCONTAIN")

    var sqlc = `SELECT a.*,d.*, b.*, c.* FROM rooms a LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num LEFT JOIN greservations c ON b.greservationID = c.ReservationID LEFT JOIN roomtypes d ON a.RoomType = d.RoomType
    WHERE c.CheckInDate > '[chosen_checkout_datetime]'
    OR c.CheckOutDate < '[chosen_checkin_datetime]'
    OR c.CheckInDate IS NULL
    OR c.CheckOutDate IS NULL
    ORDER BY a.RoomID`


    var dataholder = ""

    function handleInputChange1(event) {
      const inputElement = event.target;
      let value = parseFloat(inputElement.value);

      if(value >= 0){
        RoomNUMBERMULTI.innerHTML = "" //reset the innerhtml
        for (let i = 0; i < value; i++) {
            RoomNUMBERMULTI.innerHTML += `<div class="form-column">
                                    <label for="">Room Number:</label>
                                    <select name="RNUM" id="">
                                        ${dataholder}
                                    </select>
                                </div>`
        }
      }
    }


    async function datachange() {
        const FCONTAIN2 = document.getElementById("FCONTAIN")
        if(FCONTAIN2.Checkin.value !== "" && FCONTAIN2.Checkout.value !== ""){
             sqlc = `SELECT a.*,d.*, b.*, c.* FROM rooms a LEFT JOIN roomsreservation b ON a.RoomNum = b.Room_num LEFT JOIN greservations c ON b.greservationID = c.ReservationID LEFT JOIN roomtypes d ON a.RoomType = d.RoomType
                WHERE c.CheckInDate > '${FCONTAIN2.Checkout.value}'
                OR c.CheckOutDate < '${FCONTAIN2.Checkin.value}'
                OR c.CheckInDate IS NULL
                OR c.CheckOutDate IS NULL
                ORDER BY a.RoomID`
            const Tabledata =await AjaxSendv3(sqlc,"RESERVATIONLOGIC","&Process=Search")
            let changeable = document.querySelector("select[name='RNUM']")
            //changeable.innerHTML = Tabledata

            dataholder = Tabledata;
            if(changeable){
                changeable.innerHTML += Tabledata
            }
        }
    }

    function hasDuplicates(arr) {
        return new Set(arr).size !== arr.length;
    }
    async function EDIT(){
        const FCONTAIN2 = document.getElementById("FCONTAIN")
        var mergedHTML = [];


        var elements = document.querySelectorAll("select[name='RNUM']");

        if(elements){
            // Loop through the elements and merge their innerHTML with "*"
            for (var i = 0; i < elements.length; i++) {
                mergedHTML.push(elements[i].value);
            }
            if(hasDuplicates(mergedHTML)){
                Swal.fire(
                    '',
                    'Duplicated room number',
                    'error'
                    )
                return 0
            }
        }


        
        let datacontroller = `{
            "firstName": "${FCONTAIN2.firstName.value}",
            "middleName": "${FCONTAIN2.middleName.value}",
            "lastName":"${FCONTAIN2.lastName.value}",
            "address":"${FCONTAIN2.address.value}",
            "email":"${FCONTAIN2.email.value}",
            "phoneNumber":"${FCONTAIN2.phoneNumber.value}",
            "No. of Adult":"${FCONTAIN2.numadult.value}",
            "No. of Kid":"${FCONTAIN2.numkid.value}",
            "No. of Seniors":"${FCONTAIN2.numsenior.value}",
            "Checkin":"${FCONTAIN2.Checkin.value}",
            "Checkout":"${FCONTAIN2.Checkout.value}",
            "timapackage":"${FCONTAIN2.timapackage.value}",
            "numromocu":"${FCONTAIN2.numromocu.value}",
            "Cottage":"${FCONTAIN2.Cottage.value}",
            "evplace":"${FCONTAIN2.evplace.value}",
            "roomnumbers":"${mergedHTML.join("@")}"
        }`;

         Swal.fire({
            title: 'Are you sure you want to add the informations?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Save',
            denyButtonText: `Cancel`,
            }).then(async (result) => { 
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                await AjaxSendv3(datacontroller,"RESERVATIONLOGIC","&Process=PaymentTime")
                location.href = "../Admins/Mainpage.php?nzlz=breakdown&plk=2";
            } 
        })
    }


    // Get references to all input elements with the class "input-box"
    const inputElements = document.querySelectorAll("input[type='number']");
    
    // Add event listeners to all selected input elements
    inputElements.forEach(input => {
        input.addEventListener("input", function() {
            // Parse the input value as a number
            const value = parseFloat(input.value);
            if( input.id=="numromocu"){
                input.addEventListener('change', handleInputChange1);
            }
            // Check if the value is less than 0
            if (value < 0) {
                // Set the value to 0
                input.value = 0;
            }
      
        });
    });
</script>