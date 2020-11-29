document.addEventListener('DOMContentLoaded', async function() {

    // if the user is login, return the user to index.html
    returnToHomeIfAuthenticated();
    
});

async function signUp(){ 

    document.getElementById("error_msg").innerText = "";

    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;
    password = document.getElementById("password").value;
    phoneNumber = document.getElementById("phoneNumber").value;
    email = document.getElementById("email").value;
    gender = document.getElementById("male").checked ? "male" : "female";
    role = document.getElementById("customer").checked ? "customer" : "stylist";
    policy = document.getElementById("policy").checked ? "selected" : "";
    
    inputs = {
        firstName,
        lastName,
        password,
        phoneNumber,
        email,
        gender,
        role
    };

    // Ensure no empty fields 
    error_msg = "The following are missing: ";
    error_flag = false;

    for (const property in inputs) {

        if (inputs[property] == ""){
            error_msg += `${property}? `;
            error_flag = true;
        }

    }

    if(policy != "selected"){
        error_msg += "You must check to agree our site policy.";
        error_flag = true;
    }

    if(error_flag){
        document.getElementById("error_msg").innerText = error_msg;
        return;
    }

    // if inputs OK, send POST request to SignSignService

    payload = {
        method: "POST",
        body: JSON.stringify(inputs)  // must serialize your obj in the body
    }

    // If the sign up OK, an object of user is return, otherwise user.error 
    try{

        user = await fetch("http://localhost/inc/utilities/SignUpController.php", payload).then(res => res.json());
        
    }catch(e){
        document.getElementById("error_msg").innerText = `Internal Server Error. Please try again later.`;
    }

    // If sign up OK, return user to homepage, or else, display try again
    if(!user.error){
        // console.log(user);
        
        // set userInfo in session
        setUserToSession(user);

        // return to index.html
        window.location.href = "index.html";

    } else {
        document.getElementById("error_msg").innerText = user.error;
    }

}

function setUserToSession(user){
    
    sessionStorage.setItem("userID", user.userID);
    sessionStorage.setItem("email", user.email);
    sessionStorage.setItem("firstName", user.firstName);
    sessionStorage.setItem("lastName", user.lastName);
    sessionStorage.setItem("password", user.password);
    sessionStorage.setItem("phoneNumber", user.phoneNumber);
    sessionStorage.setItem("role", user.role);

}
