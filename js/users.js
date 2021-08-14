const searchBar = document.querySelector(".users .search input"),
    searchBtn = document.querySelector(".users .search button"),
    usersList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBtn.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
}


searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;
    if (searchTerm != "") {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }
    // let's start ajax
    let xhr = new XMLHttpRequest(); //Create XML object
    xhr.open("POST", "controller/search.php");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                usersList.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('searchTerm=' + searchTerm); // sending the form data to php
}

setInterval(() => {
    // let's start ajax
    let xhr = new XMLHttpRequest(); //Create XML object
    xhr.open("GET", "controller/users.php");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                if (!searchBar.classList.contains("active")) { //if active not contains in search bar than add this data
                    usersList.innerHTML = data;
                }
            }
        }
    }
    xhr.send(); // sending the form data to php
}, 500); // Function will be run after 500ms