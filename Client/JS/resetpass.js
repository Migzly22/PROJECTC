const EmailSendbtn = document.getElementById('EmailSendbtn')

EmailSendbtn.addEventListener('click',async (e)=>{
    e.preventDefault()
    const email = document.getElementById('email').value

    if (!(isEmailFormat(email))) {
        Swal.fire({
            icon: 'error',
            text: 'Please check the email format'
        })
        return 0
    } 
    


    // Insert the loading screen
    const loadingContainer = document.createElement('div');
    loadingContainer.id = 'loading-container';
    document.body.appendChild(loadingContainer);  

    // Fetch the content of loading.html
    const response = await fetch('./Template/LoadingTemplate.html');
    const loadingHtml = await response.text();

    $.ajax({    
        type: "post",
        url: "/PROJECTC/Send.php",             
        data: "Email="+ email,    
        dataType: 'json',   
        beforeSend:function(){
            // Set the content of the loading container
            console.log(123)
            loadingContainer.innerHTML = loadingHtml;
        },  
        error:function(response){
            // Remove the loading screen
            console.log(response)
            loadingContainer.parentNode.removeChild(loadingContainer);
        },
        success: function(response) {
            // Remove the loading screen
            console.log(123)
            loadingContainer.parentNode.removeChild(loadingContainer);


            Swal.fire({
                icon: response.icon,
                text: response.text,
            })

            if(response.icon == 'success'){
                const form_1 = document.getElementsByClassName("form-1")[0]
                const form_2 = document.getElementsByClassName("form-2")[0]
                form_2.style.display = "flex"
                form_1.style.display = "none"
            }
        }


    });

})

function isEmailFormat(text) {
    var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return emailRegex.test(text);
}


const Resetpassbtn = document.getElementById('Resetpassbtn')
Resetpassbtn.addEventListener('click',(e)=>{
    e.preventDefault()


    const email = document.getElementById('email').value
    const OTP = document.getElementById('OTP').value
    const password = document.getElementById('password').value
    const cpassword = document.getElementById('cpassword').value

    if(password.length < 8){
        Swal.fire({
            icon: 'info',
            text: 'Password length should be at least 8 characters',
        })
        return 0
    }else if (password != cpassword){
        Swal.fire({
          icon: 'error',
          text: 'Password Doesnt Match',
        })
        return 0
    }

    $.ajax({    
        type: "post",
        url: "./AjaxLogic/resetpassword.php",             
        data: "Email="+ email +"&OTP=" + OTP +"&pass=" + password,    
        dataType: 'json',   
        beforeSend:function(){
            //loading screen
        },  
        success: async function(response) {
            await Swal.fire({
                icon: response.icon,
                text: response.text,
               
            })
            document.location='./login.php'
        }


    });
})