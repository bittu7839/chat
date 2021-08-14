const micArea = document.querySelector(".mic-area"),
    micBtn = micArea.querySelector(".mic"),
    audioFile = document.querySelector("audio");

var outgoing_id = document.getElementById("outgoing_id").value;
var incoming_id = document.getElementById("incoming_id").value;

micBtn.onclick = () => {
    let device = navigator.mediaDevices.getUserMedia({ audio: true });
    let chunks = [];
    let recorder;
    device.then(stream => {
        recorder = new MediaRecorder(stream);

        recorder.ondataavailable = e => {
            chunks.push(e.data);

            if (recorder.state == "inactive") {
                let blob = new Blob(chunks, { type: 'audio/webm' })
                    // audioFile.innerHTML = '<source src="' + URL.createObjectURL(blob) + '" type="audio/webm">';
                let xhr = new XMLHttpRequest(); //Create XML object
                xhr.open("POST", "controller/insert-chat.php");
                xhr.onload = () => {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status == 200) {
                                let data = xhr.response;
                                chatBox.innerHTML = data;
                            }
                        }
                    }
                    // we have to send the form data through ajax to php
                let formData = new FormData(form); // Creating new formData object
                const fullDate = new Date();
                let time = fullDate.getTime();
                formData.append("audio_data", blob, time);
                formData.append('type', 'audio');
                formData.append('outgoing_id', outgoing_id);
                formData.append('incoming_id', incoming_id);
                xhr.send(formData); // sending the form data to php
            }
        }

        recorder.start(1000);
    });


    setTimeout(() => {
        recorder.stop();
    }, 4000);
}