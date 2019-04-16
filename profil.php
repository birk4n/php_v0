<?php
/**
 * Created by PhpStorm.
 * User: BenVeAlem
 * Date: 2/25/2018
 * Time: 1:00 AM
 * Site: https://www.benvealem.com/
 */

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

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Profil Bilgileri</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="http://localhost/">
        <?php
        if ($user) {
            echo $user["name"].' '.$user["surname"];
        } else {
            echo 'Uzaktan Eğitim';
        }
        ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <?php
                if ($user) {
                    echo '<li class="nav-item"><a class="nav-link" href="index.php">Sınıflar</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>';
                } else {
                    echo '
                        <li class="nav-item"><a class="nav-link" href="register.php">Kayıt Ol</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php">Giriş Yap</a></li>';
                }
            ?>
        </ul>
    </div>
</nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12"><hr></div>
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <?php
                    if ($user) {
                        echo 'Hoş Geldin: ' . $user["name"] . ' ' . $user["surname"];
                        echo '<br>Tebrikler! Oturum açtınız.';
                    } else {
                        echo 'Henüz oturum açmadınız. Oturum açmak için Giriş Yap sayfasına gidebilirsiniz.';
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <h1>Profil Bilgileriniz</h1>
                <?php
                if ($user) {
                    echo '<strong> Kullanıcı adınız</strong>: ' . $user["username"];
                    echo '<br>';
                    echo '<strong> Öğrenci Numaranız</strong>: ' . $user["ogr_no"];
                    echo '<br>';
                    if ($user["ogretmen"]=='0')
                    {
                        echo 'Sistemimizde <strong> öğrenci </strong> olarak kayıtlısınız.';
                    }
                    else
                    {
                        echo 'Sistemimizde <strong> öğretmen </strong> olarak kayıtlısınız.';
                    }


                } else {
                    echo 'Henüz oturum açmadınız. Oturum açmak için Giriş Yap sayfasına gidebilirsiniz.';
                }
                ?>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
