const form = document.querySelector(".signup form"),
    continueBtn = form.querySelector(".button input"),
    errorText = form.querySelector(".error-text");

form.onsubmit = (e) => {
    e.preventDefault(); //preventing form from submitting
}

continueBtn.onclick = () => {
    // let's start ajax
    let xhr = new XMLHttpRequest(); //Create XML object
    xhr.open("POST", "controller/signup.php");
    xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    let data = xhr.response;
                    if (data == "success") {
                        location.href = "user.php";
                    } else {
                        errorText.textContent = data;
                        errorText.style.display = "block";
                    }
                }
            }
        }
        // we have to send the form data through ajax to php
    let formData = new FormData(form); // Creating new formData object
    xhr.send(formData); // sending the form data to php
}