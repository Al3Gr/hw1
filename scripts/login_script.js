const form = document.forms["login_form"];
const login_button = document.querySelector("#login_button")


function sendData(event){
    if(form.username.value.length == 0 || form.password.value.length == 0){
        
        event.preventDefault()
    }
}

login_button.addEventListener('click', sendData)