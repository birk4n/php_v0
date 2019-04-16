<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Yayın video</title>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="/socket.io/socket.io.js"></script>
</head>

<body>
<center>
 <br>
<br>

<video controls src="" id="video" style="width:400px;height:300px;" autoplay></video>

<canvas style="display: none;" id="preview"></canvas>

<div id="logger"></div>
</center>
<script type="text/javascript">
	
	var canvas = document.getElementById("preview");
	var context = canvas.getContext("2d");
	
	canvas.width=400;
	canvas.height=300;
	
	context.width= canvas.width;
	context.height=canvas.height;
	var video = document.getElementById("video");
	var socket = io();
	
	function logger(msg)
	{
		$("#logger").text(msg);
	}
	function loadCam(stream)
	{
		video.src = window.URL.createObjectURL(stream);
		logger('Camera [ok]');
	}
	function loadFail()
	{
		logger('Camera No connection');
	}

	function loadCam(stream) {
            video.src = window.URL.createObjectURL(stream);

            var media = new MediaRecorder(stream);
            media.ondataavailable = function (e) {
                socket.emit('radio', e.data);
            }


            media.start(1000)
            logger("Cam is ok")
}
navigator.getUserMedia({ video: true, audio: true }, loadCam, loadFail)
	</script>
</body>
</html>
