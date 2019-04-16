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
    <meta charset="UTF-8">
    <title>Chat</title>
    <link href="chat.css" rel="stylesheet" />
    <script src="jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="http://localhost:3000/socket.io/socket.io.js"></script>
</head>
<body>

        <div id="mario-chat">

            <div id="chat-window">
                <div id="output"></div>
                   <div id="feedback"></div>
            </div>

            <input id="handle" type="hidden" value="<?php echo $user["name"] ?>"/>
            <input id="message" type="text" placeholder="Mesaj" autocomplete="off"/>
            <button id="send" >Gönder</button>

        </div>


</body>
<script>
var btn = document.getElementById("message");

// Execute a function when the user releases a key on the keyboard
btn.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("send").click();
  }
});






</script>
<script src="chat/chat.js"></script>
</html>
