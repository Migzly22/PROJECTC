function testing(a) {
    alert(a)
}


//sweetalert
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
})

function SweetError(errmsg = "Please Fill the form correctly") {
    Swal.fire({
        icon: 'error',
        text: errmsg,
    })
}
async function SweetSuccess(msg = "Updated Successfully") {
    await Toast.fire({
        icon: "success",
        title: msg
    })
}

function AjaxSendv3(sqlcode,link,table = "", htmlParam="html", inside="",targetbody ="TBODY") {
    return new Promise(function(resolve, reject) {
            $.ajax({
            url:`./AjaxLogic/${link}.php`,
            type:"POST",
            data:'sqlcode='+sqlcode+table,
            dataType:htmlParam,
            beforeSend:function(){
           
            },
            error: function() 
            {
                SweetError();
                reject("An error occurred.");
            },
            success:function(data){
              
                if ((table.includes("Update"))){
                    SweetSuccess();
                }
               
                console.log(data)
                resolve(data);
            }
        }); 
    });
}


async function POPUPCREATE(title, HTMLDESIGN, numberOfInputs, confirmmsg = "Save") {
    const { value: formValues } = await Swal.fire({
        title: title,
        html: HTMLDESIGN,
        focusConfirm: false,
        showDenyButton: true,
        confirmButtonText: confirmmsg,
        denyButtonText: `Cancel`,
        preConfirm: () => {
            // Validate each input
            for (let index = 1; index <= numberOfInputs; index++) {
                const input = document.getElementById(`swal-input${index}`);
                if (input) {
                    const value = input.value.trim();

                    // Perform your validation here
                    if (value === '') {
                        Swal.showValidationMessage(`Please fill in all fields.`);
                        return false; // Prevent the modal from closing
                    }

                    // Additional validation rules can be added here

                    // Assign the validated value back to the input
                    input.value = value;
                }
            }

            // All inputs are valid, return an array of values
            return Array.from({ length: numberOfInputs }, (_, index) => {
                const input = document.getElementById(`swal-input${index + 1}`);
                return input ? input.value : '';
            });
        }
    });

    return formValues;
}