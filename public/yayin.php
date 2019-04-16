<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Yayin</title>
    <script src="/socket.io/socket.io.js"></script>
      <script src="jquery.min.js"></script>
</head>

<body>


<script>


function mikAc() {

    const socket = io();
    var constraints = {audio: true};

    navigator.mediaDevices.getUserMedia(constraints).then(function (mediaStream) {
        var mediaRecorder = new MediaRecorder(mediaStream);
        mediaRecorder.onstart = function (e) {
            this.chunks = [];
        };
        mediaRecorder.ondataavailable = function (e) {
            this.chunks.push(e.data);
        };
        mediaRecorder.onstop = function (e) {
            var blob = new Blob(this.chunks, {'type': 'audio/ogg; codecs=opus'});
            socket.emit('radio', blob);
        };

// Start recording
        mediaRecorder.start();


        setInterval(function () {
            mediaRecorder.stop()
            mediaRecorder.start()
        }, 11000);
    });
}
function mikKapat() {
    const socket = io();
    socket.disconnect();

}

	</script>
	<button id="ac" onClick="mikAc()" >Mikrofonu aç</button>
<button id="kapat" onclick="mikKapat()"> Kapat</button>
</body>
</html>
