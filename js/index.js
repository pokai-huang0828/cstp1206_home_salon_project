document.addEventListener('DOMContentLoaded', function() {
    
    displayViewByRole();

    M.AutoInit();

    var slider = document.querySelectorAll('.slider');
    var instances = M.Slider.init(slider, {"height":725});

    $(".loginToggle").click(function(){
        $("#loginFormDiv").slideToggle();
    });

    $(".bookingToggle").click(function(){
        $("#BookingDiv").slideToggle();
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
        
        // Display visitorOnly elements : this means User is a User
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

        // Display My Booking
        if(document.getElementById("bookingContainer")){
            displayBookings(userID, role);
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

// Bookings

async function displayBookings(userID, role){
    
    bookingContainer = document.getElementById("bookingContainer");
    bookingContainer.innerHTML = null;

    // Bookings should be an array of booking
    bookings = await getBookings(userID, role);

    // console.log(bookings);

    bookings.forEach( booking => {

        bookingLi = document.createElement("li");
        bookingLi.className = "collection-item";

        stylistName = document.createElement("span");
        stylistName.className = "title bold";
        stylistName.innerText = `Booking with ${booking.firstName} ${booking.lastName}`;
        
        // Create cancel btn if customer, else accept && decline btns for stylist

        if(role == "customer"){

            cancelButton = document.createElement("button");
            cancelButton.className = "btn-small red secondary-content";
            cancelButton.innerText = "cancel";
            cancelButton.bookingID = booking.bookingID;
            cancelButton.onclick = customerCancelBooking;
            
        } else {
            
            acceptButton = document.createElement("button");
            acceptButton.className = "btn-small green secondary-content acceptBookingBtn";
            acceptButton.innerText = "accept";
            acceptButton.bookingID = booking.bookingID;
            acceptButton.onclick = stylistAcceptBooking;

            declineButton = document.createElement("button");
            declineButton.className = "btn-small red secondary-content declineBookingBtn";
            declineButton.innerText = "decline";
            declineButton.bookingID = booking.bookingID;
            declineButton.onclick = stylistDeclineBooking;

        }
        
        info_paragraph = document.createElement("p");
        
        bookingID = document.createElement("span");
        bookingID.innerText = `Booking ID: ${booking.bookingID}`;

        break1 = document.createElement("br");

        date = document.createElement("span");
        date.innerText = `Date: ${booking.date}`;

        break2 = document.createElement("br");
        
        time = document.createElement("span");
        time.innerText = `Time: ${booking.time}`;
        
        break3 = document.createElement("br");

        bookingStatus = document.createElement("span");
        bookingStatus.innerText = `status: ${booking.status}`;
        
        info_paragraph.appendChild(bookingID);
        info_paragraph.appendChild(break1);
        info_paragraph.appendChild(date);
        info_paragraph.appendChild(break2);
        info_paragraph.appendChild(time);
        info_paragraph.appendChild(break3);
        info_paragraph.appendChild(bookingStatus);
        
        if(role=="stylist"){
            bookingLi.appendChild(acceptButton);
            bookingLi.appendChild(declineButton);
        }

        bookingLi.appendChild(stylistName);

        if(role=="customer"){
            bookingLi.appendChild(cancelButton);
        }

        bookingLi.appendChild(info_paragraph);

        bookingContainer.appendChild(bookingLi);

    });


}

async function getBookings(userID, role) {

    let path = `http://localhost/inc/utilities/BookingController.php?role=${role}&userID=${userID}`;
    results = await fetch(path).then(res => res.json());

    return results;

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

async function stylistAcceptBooking(){
    let bookingID = this.bookingID;

    let url = "http://localhost/inc/utilities/BookingController.php";

    let payload = {
        method: "POST",
        body: JSON.stringify({
            role: "stylist",
            status: "accepted",
            bookingID
        })
    } 
    
    $res = await fetch(url, payload).then(res => res.json());

    if($res){
        document.getElementById("bookingSuccess").innerText = "";
        document.getElementById("bookingError").innerText = $res.error;
    } else {
        done = await displayBookings(sessionStorage.getItem("userID"), "stylist");
        document.getElementById("bookingError").innerText = "";
        document.getElementById("bookingSuccess").innerText = "Accepted BookingID: " + bookingID;
    }
}

async function stylistDeclineBooking(){
    let bookingID = this.bookingID;

    let url = "http://localhost/inc/utilities/BookingController.php";
    let payload = {
        method: "POST",
        body: JSON.stringify({
            role: "stylist",
            status: "declined",
            bookingID
        })
    } 
    
    $res = await fetch(url, payload).then(res => res.json());

    if($res){
        document.getElementById("bookingSuccess").innerText = "";
        document.getElementById("bookingError").innerText = $res.error;
    } else {
        await displayBookings(sessionStorage.getItem("userID"), "stylist");
        document.getElementById("bookingError").innerText = "";
        document.getElementById("bookingSuccess").innerText = "Declined BookingID: " + bookingID;
    }
 
}