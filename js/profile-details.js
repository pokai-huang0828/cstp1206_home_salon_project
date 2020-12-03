document.addEventListener('DOMContentLoaded', async function() {

    // Config Datepicker
    var datepicker = document.querySelectorAll('.datepicker');
    M.Datepicker.init(datepicker, {
        format: "yyyy-mm-dd"  ,
        minDate: new Date() 
    });
    
    // Config Timepicker
    var timepicker = document.querySelectorAll('.timepicker');
    M.Timepicker.init(timepicker, {
        twelveHour: false 
    });
    
    // Toggle Booking Form Model
    $(".bookingFormToggle").click(function(){
        $("#BookingFormDiv").slideToggle();
    });
    
    // get userID from param
    let id = getParamID();

    // get data from database
    fileName = 'http://localhost/inc/utilities/StylistController.php';
    let data = await getData(fileName);

    if(!data){
        displayError();
    } else {
        // find the correct data
        profile = findProfileByID(data, id);

        // display data
        if(!profile){
            displayError();
        } else {
            displayProfile(profile);
        }
    }

});

function getData(fileName){
    return fetch(fileName).then((data)=> data.json()); 
}

function getParamID(){
    let params = new URLSearchParams(document.location.search.substring(1));
    return params.get("id");
}

function findProfileByID(data, id){
    return data.find(obj => obj.userID == id);
}

function displayError(){

    document.getElementsByClassName("card")[0].style.display = "none";
    document.getElementsByClassName("backButton")[0].style.display = "none";
    document.getElementsByClassName("error")[0].style.display = "block";
};

function displayProfile(profile){

    document.getElementById("profile_pic").src = profile.profilePic;
    document.getElementById("name").innerText = `${profile.firstName} ${profile.lastName}`;
    document.getElementById("signUpDate").innerText = profile.signUpDate;
    document.getElementById("rating").innerText = profile.rating;
    document.getElementById("name_").innerText = `${profile.firstName} ${profile.lastName}`;
    document.getElementById("gender").innerText = profile.gender;
    document.getElementById("professionalExperience").innerText = profile.professionalExperience;
    document.getElementById("category").innerText = profile.category;
    document.getElementById("serviceLocation").innerText = profile.serviceLocation;
    document.getElementById("pricing").innerText = profile.priceList;
    document.getElementById("email").innerText = profile.email;
    document.getElementById("phoneNumber").innerText = profile.phoneNumber;

    // set stylistID to ratingInput button 
    document.getElementById("ratingSubmitButton").stylistID = profile.userID;

    // set stylistID to BOOK ME button
    document.getElementById("bookMeButton").stylistID = profile.userID;

    // turn off bookme and rating if this is a stylist
    if(sessionStorage.getItem("role") == "stylist"){
        document.getElementById("bookingFormToggle").style.display = "none";
        document.getElementById("displayRatingInputIcon").style.display = "none";
    };

};

function goBack(){
    window.history.back();
}

function displayRatingInput(){
    var x = document.getElementById("ratingInputDiv");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
}

async function submitRating(){

    var rating = document.getElementById("ratingInput").value;
    var stylistID = document.getElementById("ratingSubmitButton").stylistID;
    var customerID = sessionStorage.getItem("userID");

    var fileName = "http://localhost/inc/utilities/RatingController.php";

    let res = await fetch(fileName, {
        method: "POST",
        body: JSON.stringify({
            customerID,
            stylistID,
            rating
        })
    }).then((data)=> data.json()); 

    document.getElementById("ratingSubmitText").innerText = "Submitted";

}

// Bookings

async function customerCreateBooking() {

    var role = sessionStorage.getItem("role");
    var customerID = sessionStorage.getItem("userID");
    var stylistID = document.getElementById("bookMeButton").stylistID;
    var date = document.getElementById("bookingDate").value;
    var time = document.getElementById("bookingTime").value;
    var comment = document.getElementById("bookingComment").value;
    
    // Validate booking date and time
    if (date == "" || time == "") {
        document.getElementById("bookingFormError").innerText = "Must fill out booking date and time.";
        return;
    }
    
    var fileName = "http://localhost/inc/utilities/BookingController.php";
    
    let res = await fetch(fileName, {
        method: "POST",
        body: JSON.stringify({
            role,
            customerID, 
            stylistID,
            date,
            time,
            comment
        })
    }).then((data)=> data.json()); 
    
    // Display Success or Error Message
    if (res.error){
        document.getElementById("bookingFormSuccess").innerText = "";
        document.getElementById("bookingFormError").innerText = res.error;
    } else {
        document.getElementById("bookingFormError").innerText = "";
        document.getElementById("bookingFormSuccess").innerText = `Booking Success! Here Your bookingID: ${res.bookingID}`;
    }

    // refresh my booking
    displayBookings(customerID, role);

}