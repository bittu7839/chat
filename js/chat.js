const form = document.querySelector(".typing-area"),
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); //preventing form from submitting
}

var showChat = () => {
    // let's start ajax
    let xhr = new XMLHttpRequest(); //Create XML object
    xhr.open("POST", "controller/get-chat.php");
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains('active')) {
                    scrollToButtom();
                }
            }
        }
    }
    let formData = new FormData(form); // Creating new formData object
    xhr.send(formData); // sending the form data to php
}
showChat();
sendBtn.onclick = () => {
    // let's start ajax
    let xhr = new XMLHttpRequest(); //Create XML object
    xhr.open("POST", "controller/insert-chat.php");
    xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    let data = xhr.response;
                    chatBox.innerHTML = data;
                    inputField.value = "";
                    scrollToButtom();
                }
            }
        }
        // we have to send the form data through ajax to php
    let formData = new FormData(form); // Creating new formData object
    formData.append('type', 'text');
    xhr.send(formData); // sending the form data to php
}

chatBox.onmouseenter = () => {
    chatBox.classList.add('active');
}


chatBox.onmouseleave = () => {
    chatBox.classList.remove('active');
}

chatBox.ontouchstart = () => {
    chatBox.classList.add('active');
}

chatBox.touchend = () => {
    chatBox.classList.remove('active');
}

setInterval(() => {
    showChat();
}, 50000); // Function will be run after 500ms

function scrollToButtom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}