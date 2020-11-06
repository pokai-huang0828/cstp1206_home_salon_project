document.addEventListener('DOMContentLoaded', async function() {
    
    // get userID from param
    let id = getParamID();

    // get data from database
    fileName = '../data/stylist_user.data.json';
    let data = await getData(fileName);

    if(!data){
        displayError();
    } else {
        // find the correct data
        profile = findProfileByID(data, id);
        
        console.log(profile);
        // display data
        if(!profile){
            displayError();
        } else {
            displayProfile(profile);
        }
    }

});

function goBack(){
    window.history.back();
}

function getParamID(){
    let params = new URLSearchParams(document.location.search.substring(1));
    return params.get("id");
}

function getData(fileName){
    return fetch(fileName).then((data)=> data.json());
}

function findProfileByID(data, id){
    return data.find(obj => obj.userID == id);
}

function displayError(){
    document.getElementsByClassName("card")[0].style.display = "none";
    document.getElementsByClassName("backButton")[0].style.display = "none";
    document.getElementsByClassName("error")[0].style.display = "block";
};

function displayProfile(){
    document.getElementById("profile_pic").src = profile.profilePic;
        
    document.getElementById("name").innerText = `${profile.firstName} ${profile.lastName}`;
    document.getElementById("signUpDate").innerText = profile.signUpDate;
    document.getElementById("rating").innerText = profile.rating;
    document.getElementById("name_").innerText = `${profile.firstName} ${profile.lastName}`;
    document.getElementById("gender").innerText = profile.gender;
    document.getElementById("professionalExperience").innerText = profile.professionalExperience;
    
    const reducer = (accumulator, currentValue) => accumulator + ' '+ currentValue;
    categories_str = profile.category.reduce(reducer);
    document.getElementById("category").innerText = categories_str;
    
    document.getElementById("serviceLocation").innerText = profile.serviceLocation;
    
    pricing_str = "";
    p_obj = profile.priceList;
    for(let item in p_obj){
        pricing_str += `${item} - ${p_obj[item]}\n`;
    }
    document.getElementById("pricing").innerText = pricing_str;

    document.getElementById("email").innerText = profile.email;
    document.getElementById("phoneNumber").innerText = profile.phoneNumber;
};