<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>İzleme</title>

  
  <script type="text/javascript" src="/socket.io/socket.io.js"></script>
</head>

<body>



 
  <audio controls id="audio"></audio>
	
<script>
 const socket = io();
	socket.on('voice', function(arrayBuffer) {
  var blob = new Blob([arrayBuffer], { 'type' : 'audio/mp3; codecs=opus' });
  var audio = document.getElementById("audio");
  audio.src = window.URL.createObjectURL(blob);
  audio.play();
});
        
		

	</script>
</body>
</html>
