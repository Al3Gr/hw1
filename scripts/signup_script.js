const form = document.forms["signup_form"]
const nome = form.name
const cognome = form.lastname
const email = form.email
const username = form.username
const password = form.password

const submit_button = document.querySelector("#login_button")

function checkName(event) {
    const input = event.currentTarget
    if(input.value.length == 0){
        input.classList.add("errore")
        input.placeholder = "Nome non valido"
    }
}

function checkLastName(event) {
    const input = event.currentTarget
    if(input.value.length == 0){
        input.classList.add("errore")
        input.placeholder = "Cognome non valido"
    }
}

function checkUsername(event){
    const input = event.currentTarget
    if(!/^[a-zA-Z0-9_]{1,10}$/.test(input.value)){
        input.classList.add("errore")
        input.value=""
        input.placeholder = "Inserisci da 1 a 10 caratteri"
    } else {
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(response => response.json()).then(jsonCheckUsername)
    }
}


function jsonCheckUsername(json){
    if(json.exists) {
        username.classList.add("errore")
        username.value =""
        username.placeholder = "Username già utilizzato"
    } 
}

function checkEmail(event){
    const input = event.currentTarget
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(input.value).toLowerCase())){
        input.classList.add("errore")
        input.value=""
        input.placeholder = "Email non valida"
    } else {
        fetch("check_email.php?q="+encodeURIComponent(input.value)).then(response => response.json()).then(jsonCheckEmail)
    }
}

function jsonCheckEmail(json){
    if(json.exists) {
        email.classList.add("errore")
        email.value =""
        email.placeholder = "Email già utilizzata"
    }
}

function checkPassword(event){
    const input = event.currentTarget
    if(input.value.length < 8) {
        input.classList.add("errore")
        input.value=""
        input.placeholder = "Minimo 8 caratteri"
    }
}


function resetInputField(event){
    const input = event.currentTarget
    if(input.classList.contains("errore")){
        input.classList.remove("errore")
        switch (input) {
            case nome:
                input.placeholder = "Nome";
                break;
            case cognome:
                input.placeholder = "Cognome";
                break
            case username: 
                input.placeholder = "Username";
                break
            case email:
                input.placeholder = "Email";
                break
            case password:
                input.placeholder = "Password";
                break
            default:
                break;
        }
    }
}

function sendData(event){
    if(document.querySelector(".errore") !== null || nome.value.length == 0 || cognome.value.length == 0 || email.value.length == 0 || username.value.length == 0 || password.value.length == 0){
        alert("Metti qualcosa bastardo")
        event.preventDefault()
    } 
}

nome.addEventListener('blur', checkName)
nome.addEventListener('focus', resetInputField)
cognome.addEventListener('blur', checkLastName)
cognome.addEventListener('focus', resetInputField)
username.addEventListener('blur', checkUsername)
username.addEventListener('focus', resetInputField)
email.addEventListener('blur', checkEmail)
email.addEventListener('focus', resetInputField)
password.addEventListener('blur', checkPassword)
password.addEventListener('focus', resetInputField)
submit_button.addEventListener('click', sendData)
