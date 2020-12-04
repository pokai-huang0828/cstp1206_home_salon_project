document.addEventListener('DOMContentLoaded', function() {
    
    displayViewByRole();

    M.AutoInit();

    var elems = document.querySelectorAll('.slider');
    var instances = M.Slider.init(elems, {"height":725});

    $(".loginToggle").click(function(){
        $("#loginFormDiv").slideToggle();
    });


});

function returnToHomeIfAuthenticated(){
    if(sessionStorage.getItem("userID")) {window.location.href = "index.html";}
}

async function displayViewByRole(){

    // check if user is signIn
    userID = sessionStorage.getItem("userID");
    role = sessionStorage.getItem("role");

    if(!userID) {
        
        // Display userOnly elements : this means User is a Visitor
        userOnlyElements = document.getElementsByClassName("userOnly");

        for(userOnlyElement of userOnlyElements){
            userOnlyElement.style.display  = "none";
        }
        
    } else {
        
        // Display visitorOnly elements :  : this means User is a User
        visitorOnlyElements = document.getElementsByClassName("visitorOnly");
        
        for(visitorOnlyElement of visitorOnlyElements){
            visitorOnlyElement.style.display = "none";
        }
        
        // Set Customer or Stylist Edit Url
        editLinkElements = document.getElementsByClassName("editLink");

        for(editLinkElement of editLinkElements){
            editLinkElement.href = `${role}Edit.html`;
        }

        // Display welcome + user's firstName
        welcomeTags = document.getElementsByClassName("welcomeTag");

        for(welcomeTag of welcomeTags){
            welcomeTag.innerText  = `Welcome ${sessionStorage.getItem("firstName")}`;
        }

    }
    
}

async function signIn() {

    sessionStorage.clear();
    
    // clear previous errors
    document.getElementById("loginError").innerText = "";
    
    email = document.getElementById("loginEmail").value;
    password = document.getElementById("loginPassword").value;
    
    // check for empty string
    if (email == "" || password == ""){
        document.getElementById("loginError").innerText = "Please fill in both Email and Password.";
        return;
    }

    // Send a POST request to getUser Info, if none is returned, the credential is invalid
    payload = {
        method: "POST",
        body: JSON.stringify({email, password})
    }

    try{
        
        user = await fetch("http://localhost/inc/utilities/SignInController.php", payload)
        .then(res => res.json());

    } catch(e) {

        document.getElementById("loginError").innerText = e;
    }

    if(!user.userID){
        // console.log(user);
        document.getElementById("loginError").innerText = user.error;
    } else {
        
        // setUser info to session
        setUserToSession(user);
        
        // refresh the page, bring user wherever they were
        location.reload();

    }

}

function setUserToSession(user){
    
    sessionStorage.setItem("userID", user.userID);
    sessionStorage.setItem("email", user.email);
    sessionStorage.setItem("firstName", user.firstName);
    sessionStorage.setItem("lastName", user.lastName);
    sessionStorage.setItem("phoneNumber", user.phoneNumber);
    sessionStorage.setItem("role", user.role);

}

function signOut() {
    sessionStorage.clear();
    location.reload();
}

async function customerCancelBooking(){
    bookingID = this.bookingID;

    url = "http://localhost/inc/utilities/BookingController.php";
    payload = {
        method: "DELETE",
        body: JSON.stringify({
            role: "customer",
            bookingID
        })
    } 
    
    $res = await fetch(url, payload).then(res => res.json());

    if($res){
        document.getElementById("bookingError").innerText = $res.error;
    } else {
        document.getElementById("bookingError").innerText = "";
        // this.disabled = true;
        // this.innerText = "Booking Canceled";
        done = await displayBookings(sessionStorage.getItem("userID"), "customer");
    }
}