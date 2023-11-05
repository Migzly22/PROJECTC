

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


async function POPUPCREATE(title,HTMLDESIGN ,numberOfInputs){
    const { value: formValues } = await Swal.fire({
        title: title,
        html: HTMLDESIGN,
        focusConfirm: false,
        showDenyButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Cancel`,
        preConfirm: () => {

            const values = Array.from({ length: numberOfInputs }, (_, index) => {
                const input = document.getElementById(`swal-input${index + 1}`);
                return input ? input.value : '';
            });

            return values;
        }
    })
    return formValues;
}