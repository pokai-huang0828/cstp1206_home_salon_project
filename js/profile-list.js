document.addEventListener('DOMContentLoaded', async function() {

    fileName = 'http://localhost/inc/utilities/StylistController.php';
    
    data = await getData(fileName);
    data = filterList(data);

    displayList(data);    
    
});

function getData(fileName){
    return fetch(fileName).then((data)=> data.json());
}

function filterList(data){
    const urlParams = new URLSearchParams(window.location.search);

    // pair => key and value of the query terms, ie: ["category", "hair"]
    for(var pair of urlParams.entries()) {
        data = data.filter(profile => profile[pair[0]] == pair[1]);
    }

    return data;   
}

function searchList(){
    selection = getUserSelection();

    url = "profile-list.html";
    query = "?";

    for ( item in selection){
        if(item == "category" || item == "serviceLocation" || item == "gender"){
            selection[item] != "" ? query += `${item}=${selection[item]}&` : query += "";
        }
    }

    if(query == "?") setUrl(url);
    url += query.slice(0, query.length-1);
    setUrl(url);
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

function displayList(data){

    list = document.getElementById("profile-list");

    for(var p in data){
        
        var root_div = document.createElement("div");
        root_div.className = "col s12 m4 l3 profile_root_div";
        
        var card_div = document.createElement("div");
        card_div.className = "card";

        var card_image_div = document.createElement("div");
        card_image_div.className = "card-image";

        var img_object_div = document.createElement("div");
        img_object_div.className = "profile_pic_div"

        var profile_img = document.createElement("img");
        profile_img.src = data[p]["profilePic"];
        profile_img.className = "responsive-img";

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
        
        img_object_div.appendChild(profile_img);
        card_image_div.appendChild(img_object_div);

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

function setUrl(url){
    window.location.href = url + "#profile-list-section";  
}