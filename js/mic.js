const micArea = document.querySelector(".mic-area"),
    micBtn = micArea.querySelector(".mic"),
    audioFile = document.querySelector("audio");


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
                audioFile.innerHTML = '<source src="' + URL.createObjectURL(blob) + '" type="audio/webm">';
            }
        }

        recorder.start(1000);
    });


    setTimeout(() => {
        recorder.stop();
    }, 4000);
}