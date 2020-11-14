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
    
    // pre-check gender
    profile.gender == "male" ? 
    document.getElementById("male").checked = true : 
    document.getElementById("female").checked = true;
    
    document.getElementById("professionalExperience").value = profile.professionalExperience;
    document.getElementById("priceList").value = profile.priceList;
    document.getElementById("portfolio").value = profile.portfolio;

    switch (profile.serviceLocation) {
        case 'serviceLocationDefault':
            document.getElementById("serviceLocationDefaulter").selected = true;
            break;
        case 'vancouver':
            document.getElementById("vancouver").selected = true;
            break;
        case 'burnaby':
            document.getElementById("burnaby").selected = true;
            break;
        case 'richmond':
            document.getElementById("richmond").selected = true;
            break;
        case 'surrey':
            document.getElementById("surrey").selected = true;
    }

    switch (profile.category) {
        case 'hair':
            document.getElementById("hair").selected = true;
            break;
        case 'makeup':
            document.getElementById("makeup").selected = true;
    }

}

async function getProfileByID(userID){

    let queryparam = new URLSearchParams({userID});

    try{
        let response = await fetch("http://localhost/inc/utilities/StylistController.php?" + queryparam);
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

    gender = document.getElementById("male").checked ? 
    document.getElementById("male").value : 
    document.getElementById("female").value ;

    // Non-required fields
    profilePic = document.getElementById("profilePic").value;
    priceList = document.getElementById("priceList").value;
    portfolio = document.getElementById("portfolio").value;
    professionalExperience = document.getElementById("professionalExperience").value;
    category = document.getElementById("category").value;
    serviceLocation = document.getElementById("serviceLocation").value;

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
        profilePic,
        professionalExperience,
        category,
        serviceLocation,
        priceList,
        portfolio
    }

    // console.log(profile_info);

    // serialize obj
    profile_info_str = JSON.stringify(profile_info);
    // console.log(profile_info_str);
    
    // Send PUT request to server to save the data
    result = await fetch('http://localhost/inc/utilities/StylistController.php', {
        method: 'PUT',
        body: profile_info_str
    }).then(res => res.json());
    
    // return user to main page
    window.location.href = "index.html";
}

