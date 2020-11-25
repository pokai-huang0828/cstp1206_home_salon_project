document.addEventListener('DOMContentLoaded', async function() {

    userID = sessionStorage.getItem("userID");

    profile = userID ? await getProfileByID(userID) : null;

    if(profile){
        // populate the form

        // console.log(profile);
        fillUpForm(profile);

    } else {
        // display error: cannot find profile
        document.getElementById("stylistEditNotFoundError").style.display = "block";
        document.getElementById("stylistEditForm").style.display = "none";

        window.location.href = "index.html";
    }

});

function fillUpForm(profile){

    document.getElementById("firstName").value = profile.firstName;
    document.getElementById("lastName").value = profile.lastName;
    document.getElementById("password").value = profile.password;
    document.getElementById("phoneNumber").value = profile.phoneNumber;
    document.getElementById("email").value = profile.email;
    document.getElementById("profilePic").value = profile.profilePic;
    document.getElementById("address").value = profile.address;
    
    // pre-check gender
    profile.gender == "male" ? 
    document.getElementById("male").checked = true : 
    document.getElementById("female").checked = true;

}

async function getProfileByID(userID){

    let queryparam = new URLSearchParams({userID});

    try{
        let response = await fetch("http://localhost/inc/utilities/CustomerController.php?" + queryparam);
        return response.json();

    }catch(err){
        console.log("Profile not");
    }

}

async function submitEdit(){

    // Get UserID from sessionStorage
    userID = sessionStorage.getItem("userID");

    // userID = document.getElementById(userID).value;
    firstName = document.getElementById("firstName").value;
    lastName = document.getElementById("lastName").value;
    password = document.getElementById("password").value;
    phoneNumber = document.getElementById("phoneNumber").value;
    email = document.getElementById("email").value;
    profilePic = document.getElementById("profilePic").value;
    
    gender = document.getElementById("male").checked ? 
    document.getElementById("male").value : 
    document.getElementById("female").value ;
    
    // Non-required fields
    address = document.getElementById("address").value;

    // check for empty inputs that are required
    if (
        firstName == "" ||
        lastName == "" ||
        password == "" ||
        phoneNumber == "" ||
        email == "" ||
        gender == "" 
    ) {
        // display the errors, if any
        document.getElementById("inputErrorDiv").innerText = "Some required fields are left empty";
        return;
    }

    // package profile info into obj then serialize
    profile_info = {
        // user info fields
        userID,
        firstName,
        lastName,
        password,
        phoneNumber,
        email,
        gender,
        address,
        profilePic,
        role: "customer"
    }

    // console.log(profile_info);

    // serialize obj
    profile_info_str = JSON.stringify(profile_info);
    // console.log(profile_info_str);
    
    // Send PUT request to server to save the data
    result = await fetch('http://localhost/inc/utilities/CustomerController.php', {
        method: 'PUT',
        body: profile_info_str
    }).then(res => res.json());
    
    setUserToSession(result);

    // return user to main page
    window.location.href = "index.html";
}

function setUserToSession(user){
    
    sessionStorage.setItem("userID", user.userID);
    sessionStorage.setItem("email", user.email);
    sessionStorage.setItem("firstName", user.firstName);
    sessionStorage.setItem("lastName", user.lastName);
    sessionStorage.setItem("phoneNumber", user.phoneNumber);
    sessionStorage.setItem("role", user.role);
    sessionStorage.setItem("address", user.address);

}

