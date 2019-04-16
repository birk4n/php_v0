<!DOCTYPE html>
<?php





/**
 * Veritabanı bağlantı bilgilerimizin olduğu sayfayı dahil ediyoruz.
 */
include_once ("inc/config.php");

$db = new Db();
/**
 * Veritabanımıza bağlanmaya çalışıyoruz.
 * Bağlanamazsak, hata mesajını ekrana yazdırıyoruz
 */
if (!$db->connect()) {
    die("Hata: Veritabanına bağlanırken bir hata oluştu." . $db->error());
}
/**
 * $user değişkeni varsayılan olarak tanımsızdır.
 * Eğer kullanıcımız oturum açmış ise, login_user oturum değişkeni doludur.
 * login_user oturum değişkeninin değerini alıyoruz $user a kayıt ediyoruz.
 *
 * Eğer $user null yada false ise bunun anlamı kişi oturum açmamış.
 */
$user = $_SESSION["login_user"];

/**
 * Bir kişinin oturum açıp açmadığını aşağıda ki şekilde kontrol edebiliriz.
 * Aşağıda ki kodları inceleyin.
 * Yorum satırı olarak bırakın.
 */
//    if ($user) {
//        // Kişi oturum açmış
//        die("Oturum Açmışsınız");
//    } else {
//        // Kişi oturum açmamış.
//        die("HATA: Oturum Açın");
//    }
if ($user==""){
    header("refresh:10;url=../index.php");
die("10 Saniye içerisinde başka sayfaya yönlendirilecektir.");
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Tahta</title>
        <meta charset="utf-8">

		  <style type="text/css">
      #container { position: relative; }
      #container{
        width: 900px;
        height: 500px;
        background-color: #fff;
        border-radius: 5px;
      }
      body{
        background: rgb(55,55,55) !important;
      }
      #imageView { border: 1px solid #000; }
      #imageTemp { position: absolute; top: 1px; left: 1px; }
      canvas {
        border-radius: 5px;
        cursor: url(../img/pen.png), crosshair;

    }
    #text_tool {
    position: absolute;
    border: 1px dashed black;
    outline: 0;
    z-index:1000 !important;
    display: none;
    overflow: hidden;
    white-space: nowrap;
}
.container .btn.btn-sm{
    background: #0c5460;
    box-shadow: 0 3px 0 0 rgba(0, 0, 0, 0.5);
    color: #fff;
    outline: none;
    cursor: pointer;
    text-shadow: 0 1px gray;
    display: inline-block;
    font-size: 10px;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    margin-right: 5px;
}
			  .container .btn.btn-sm:hover{
				  background-color: cadetblue;
			  }
.container .btn.btn-sm:active{
   background-color: cornflowerblue;
    color: aqua;
}
label{
    color: #fff;
}
              .iframe{
                 border-radius: 5px;
                -webkit-border-radius: 5px;
                -o-border-radius: 5px;
                  float: right;


              }

    </style>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <script src="http://localhost:3000/socket.io/socket.io.js"></script>




	</head>

	<body style="margin-top:10px;">
        <div class="container">
 <?php
   if ($user["ogretmen"]=='1')
   {
	echo '
<p style="">

    <button type="button" class="btn btn-warning btn-sm" value="pencil" id="pencil-button"><center><img src="img/kalem1.png" width="15" height="20" alt=""/></center>  Kalem </button>
        <button type="button" class="btn btn-warning btn-sm" value="rect" id="rect-button"><center><img src="img/kare.png" width="15" height="20" alt=""/></center> Dikdörtgen</button>
        <button type="button" class="btn btn-warning btn-sm" value="circle" id="circle-button"><center>
          <img src="img/beyaz-daire-png-3.png" width="20" weight="20" alt=""/>
        </center>Çember</button>
        <button type="button" class="btn btn-warning btn-sm" value="ellipse" id="ellipse-button"><center>
          <img src="img/içi-boş-daire-png.png" width="20" height="20" alt=""/>
        </center>Elips</button>
        <button type="button" class="btn btn-warning btn-sm" value="line" id="line-button"><center>
          <img src="img/siyah-çizgi-png-4.png" width="20" height="20" alt=""/>
        </center>Çizgi</button>
        <button type="button" class="btn btn-warning btn-sm" value="text" id="text-button"><center>
          <img src="img/Aa-icon.png" width="20" height="20" alt=""/>
        </center>Yazı</button>
        <button type="button" class="btn btn-warning btn-sm" id="clear-all"><center>
          <img src="img/X-Shape-PNG-High-Quality-Image.png" width="20" height="20" alt=""/>
        </center>Temizle</button>
        <label for="colour" style="position:absolute;">Renk </label>
        <input id="colour-picker" value="#000000" style="width:80px;" class="jscolor {width:243, height:150, position:"right",
    borderColor:"#FFF", insetColor:"#FFF", backgroundColor:"#666"}">
        <!-- <span class="form-group" style="width: 100px;display: inline-block;">
              <label for="draw-grid">Grid: </label>
              <select class="form-control" id="draw-grid">
                <option value="normal">Normal</option>
                <option value="medium" selected>Medium</option>
                <option value="large">Large</option>
                <option value="nogrid">No Grid</option>
              </select>
        </span> -->
        <span class="form-group" style="width: 60px;display: inline-block;">
          <label for="line-Width">Kalınlık </label>
          <select class="form-control" id="line-Width">
            <option>2</option>
            <option>4</option>
            <option>6</option>
            <option>8</option>
            <option>10</option>
            <option>12</option>
            <option>14</option>
          </select>
        </span>
         <span class="form-group" style="width: 100px;display: inline-block;">
          <label for="draw-text-font-family">Yazı Tipi</label>
          <select class="form-control" id="draw-text-font-family">
            <option value="Arial">Arial</option>
            <option value="Verdana" selected>Verdana</option>
            <option value="Times New Roman">Times New Roman</option>
            <option value="Courier New">Courier New</option>
            <option value="serif">serif</option>
            <option value="sans-serif">sans-serif</option>
          </select>
        </span>
        <span class="form-group" style="width: 90px;display: inline-block;">
          <label for="draw-text-font-size">Yazı Boyutu </label>
          <select class="form-control" id="draw-text-font-size">
            <option value="16">16 Px</option>
            <option value="18">18 Px</option>
            <option value="20">20 Px</option>
            <option value="22">22 Px</option>
            <option value="24">24 Px</option>
            <option value="26">26 Px</option>
            <option value="28">28 Px</option>
            <option value="30">30 Px</option>
            <option value="32" selected>32 Px</option>
            <option value="34">34 Px</option>
            <option value="36">36 Px</option>
            <option value="38">38 Px</option>
            <option value="40">40 Px</option>
          </select>
        </span>
    <button type="button" class="btn btn-warning btn-sm" onclick="mikAc()" id="mikAc">Mikrofon Aç</button>
    <button type="button" class="btn btn-warning btn-sm" onclick="mikKapat()" id="mikKapat">Mikrofon Kapat</button>
       ';

              }
        else {
            echo 'Henüz oturum açmadınız. Oturum açmak için Giriş Yap sayfasına gidebilirsiniz.';
        }
        ?>
            <audio controls id="audio"></audio>
    <?php

    if ($user) {
      if ($user["ogretmen"]=='1'){
echo '<div class="iframe">' ;
      }
      else {
        echo '<br>';
            echo '<div class="iframe">' ;
      }
           echo '<iframe src="oda1.php" width="350px" height="800px" scrolling="no" frameborder="0px" ></iframe>' ;
         echo '</div>';
                    }
    else {

            echo 'Henüz oturum açmadınız. Oturum açmak için Giriş Yap sayfasına gidebilirsiniz.';
    }
    ?>


        <div id="container">

        <canvas id="imageView" width="900" height="500">
            <p>Tarayıcınız Desteklenmiyor.</p>

        </canvas>



</div>
      </div>

<!-- Script files -->
        <script src="jquery.min.js"></script>

        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="jscolor/jscolor.min.js"></script>

		 <script src="canvas.js"></script>
		<!-- <script src="canvas-backup-latest-v1.js"></script> -->

     <script type="text/javascript">
      $(document).ready(function(){
          var board_url = window.location.href;
          $('.linkToBoard').attr("href",board_url);
      });
 const socket = io.connect('//127.0.0.1:3000/voice');
	socket.on('voice', function(arrayBuffer) {
  var blob = new Blob([arrayBuffer], { 'type' : 'audio/mp3; codecs=opus' });
  var audio = document.getElementById("audio");
  audio.src = window.URL.createObjectURL(blob);
  audio.play();
});

      function mikAc() {

          const socket = io.connect('//127.0.0.1:3000/voice');
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



	</body>
</html>
