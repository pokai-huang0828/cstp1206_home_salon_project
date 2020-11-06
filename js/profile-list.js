document.addEventListener('DOMContentLoaded', async function() {

    fileName = '../data/stylist_user.data.json';
    data = await getData(fileName);
    data = filterList(data);
    displayList(data);    
    
});

function displayList(data){

    list = document.getElementById("profile-list");

    for(var p in data){

        var root_div = document.createElement("div");
        root_div.className = "col s12 m3";
        
        var card_div = document.createElement("div");
        card_div.className = "card";

        var card_image_div = document.createElement("div");
        card_image_div.className = "card-image";

        var profile_img = document.createElement("img");
        profile_img.src = data[p]["profilePic"];

        var card_content_div = document.createElement("div");
        card_content_div.className = "card-content center";

        var name_p = document.createElement("p");
        name_p.innerText = `Name: ${data[p]["firstName"]} ${data[p]["lastName"]}`;
        
        var rating_p = document.createElement("p");
        rating_p.innerText = `Rating: ${data[p]["rating"]}`;

        var button = document.createElement("button");
        button.className = "btn-small";
        button.id = data[p]["userID"];
        button.innerText = "More Info";
        button.onclick = goToDetailPage;
        
        card_image_div.appendChild(profile_img);

        card_content_div.appendChild(name_p);
        card_content_div.appendChild(rating_p);
        card_content_div.appendChild(button);

        root_div.appendChild(card_image_div);
        root_div.appendChild(card_content_div);

        list.appendChild(root_div);
    }

}

function goToDetailPage(){
    window.location.href = "profile-details.html?id=" + this.id;
}

function filterList(data){
    const urlParams = new URLSearchParams(window.location.search);

    for(var pair of urlParams.entries()) {
        data = data.filter(profile => profile[pair[0]] == pair[1]);
    }

    return data    
}

function searchList(){
    selection = getUserSelection();

    url = "profile-list.html";
    query = "?";

    for ( item in selection){
        selection[item] != "" ? query += `${item}=${selection[item]}&` : query += "";
    }

    if(query == "?") setUrl(url);
    url += query.slice(0, query.length-1);
    setUrl(url);
}

function setUrl(url){
    window.location.href = url + "#profile-list-section";  
}

function getUserSelection(){
    var searchItems = {};
    var userSelection = document.getElementsByTagName("select");
    for (let item of userSelection){
        item_id = item.id.replace("select-", "");
        searchItems[item_id] = item.options[item.selectedIndex].value;
    }
    return searchItems;
}

function getData(fileName){
    return fetch(fileName).then((data)=> data.json());
}