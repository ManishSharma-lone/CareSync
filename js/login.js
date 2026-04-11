function validateLogin(){

let email = document.getElementById("email").value.trim();
let password = document.getElementById("password").value.trim();

let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

document.getElementById("emailError").textContent="";
document.getElementById("passwordError").textContent="";

let isValid = true;

// email validation
if(email===""){
document.getElementById("emailError").textContent="Email or username is required";
isValid=false;
}
else if(!emailRegex.test(email)){
document.getElementById("emailError").textContent="Enter a valid email address";
isValid=false;
}

// password validation
if(password===""){
document.getElementById("passwordError").textContent="Password is required";
isValid=false;
}
else if(password.length<6){
document.getElementById("passwordError").textContent="Password must be at least 6 characters";
isValid=false;
}

return isValid;

}