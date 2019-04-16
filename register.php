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
include_once("inc/config.php");

$db = new Db();
/**
 * Veritabanımıza bağlanmaya çalışıyoruz.
 * Bağlanamazsak, hata mesajını ekrana yazdırıyoruz
 */
if (!$db->connect()) {
    die("Hata: Veritabanına bağlanırken bir hata oluştu." . $db->error());
}

/**
 * login_user oturum değişkeninden bilgileri alıyoruz ve
 * $user değişkenine kaydediyoruz.
 *
 * Eğer kullanıcımız oturum açmış ise, $user dolu olacak.
 * Eğer kullanıcımız daha önce oturum açmamış ise, $user boş olacak.
 *
 */
$user = $_SESSION["login_user"];

/**
 * Kullanıcı zaten üye olmuş ve
 * Oturum açmış ise, index.php ye yönlendiriyoruz.
 */
if ($user) {
    header("location: index.php");
    exit;
}


/**
 * Yapılan işlemi kontrol et.
 * Eğer işlem POST ise, kullanıcının forma girdiği bilgileri al.
 */
if ($_POST) {
    /**
     * Varsayılan olarak hata durumunu ve
     * Hata mesajını false/null olarak ayarla.
     * Hata bulursak bu değişkenleri dolduracağız.
     */
    $error = false;
    $errors = array();

    /**
     * Form dan gelen bilgileri al
     */
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    $ogr_no = $_POST["ogr_no"];
    /**
     * Varsa değişkenlerde gereksiz boşluklar.
     * Bu boşlukları siliyoruz.
     */
    $name = trim($name);
    $surname = trim($surname);
    $username = trim($username);
    $password1 = trim($password1);
    $password2 = trim($password2);
    $ogr_no = trim($ogr_no);

    // ======== Basit Kontrolleri Gerçekleştir. ========
    /**
     * İsim girmiş mi ?
     */
    if (empty($name)) {
        /**
         * Hata yakaladık.
         * Vatandaş adını girmemiş.
         */
        $error = true;
        $errors[] = 'Lütfen adınızı girin. Bu alan boş bırakılamaz.';
    }

    /**
     * Soyisim girmiş mi ?
     */
    if (empty($surname)) {
        /**
         * Hata yakaladık.
         * Vatandaş Soyisim girmemiş.
         */
        $error = true;
        $errors[] = 'Lütfen Soyisim girin. Bu alan boş bırakılamaz.';
    }

    /**
     * Kullanıcı Adı/E-Posta Girmiş mi ?
     */
    if (empty($username)) {
        /**
         * Hata yakaladık.
         * Vatandaş kullanıcı adı girmemiş.
         */
        $error = true;
        $errors[] = 'Lütfen bir kullanıcı adı girin. Bu alan boş bırakılamaz.';
    }
    if (empty($ogr_no)) {
        /**
         * Hata yakaladık.
         * Vatandaş kullanıcı adı girmemiş.
         */
        $error = true;
        $errors[] = 'Lütfen bir kullanıcı adı girin. Bu alan boş bırakılamaz.';
    }
    /**
     * Şifreler eşleşiyor mu kontrol et.
     */
    if ($password1 != $password2) {
        /**
         * Hata bulduk.
         * Şifreler eşleşmiyor.
         */
        $error = true;
        $errors[] = 'Şifreler Eşleşmiyor.';
    }

    /**
     * Şifre 4 karakterden uzun mu ?
     */
    if (strlen($password1) < 4) {
        /**
         * Hata bulduk.
         * Şifre 4 karakter yada daha küçük.
         */
        $error = true;
        $errors[] = 'Şifre en az 5 karakter olmalıdır.';
    }

    /**
     * Şu ana kadar eğer hiçbir hata ile karşılaşmadıysak
     * Ekleme işlemini yapacağız.
     * Eğer hata varsa ekleme işlemini yapmayacağız.
     *
     * Burada kafanız karışmasın.
     * $error ın ilk değeri false idi. Yani hata yok demekti.
     * Eğer hiç hata bulamadıysak değeri hala false kalacak.
     *  if de başında ! işarati değeri ters çevirecek.
     * Eğer hiç hata bulamazsak $error değeri false 'tur. Ama !$error un değeri TRUE dur.
     * true olunca if in içerisine girecek. ve Register işlemini yapacak.
     *
     * Eğer hata bulursak $error true olacak, !$error ise false olacak. Dolayısıyla if in içine girmeyecek.
     *
     */
    if (!$error) {
        /**
         * Bu bilgileri güvenli hala getir.
         */
        $name = $db->quote($name);
        $surname = $db->quote($surname);
        $username = $db->quote($username);
        $password = md5($password1);
        $ogr_no = $db->quote($ogr_no);
        $sorgu = "INSERT INTO user (name,surname,username,password,ogr_no) VALUES ($name,$surname,$username,'$password',$ogr_no);";

        $db->query($sorgu);

        header("location: login.php?type=success");
        exit;


    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Kayıt Ol</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <a class="navbar-brand" href="http://localhost/">BenVeAlem</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav ml-auto">
            <?php
            if ($user) {
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
            <h3>Kayıt Ol</h3>
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="exampleInputEmail1">Ad</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Adınız" value="<?php echo $name;?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ad</label>
                    <input type="text" name="ogr_no" id="name" class="form-control" placeholder="Öğrenci Numaranız" value="<?php echo $ogr_no;?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Soyad</label>
                    <input type="text" name="surname" id="surname" class="form-control" placeholder="Soyadınız" value="<?php echo $surname;?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Kullanıcı Adı</label>
                    <input type="email" class="form-control" id="username" name="username" placeholder="E-Posta adresiniz" value="<?php echo $username;?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Şifre</label>
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Şifre" value="<?php echo $password1;?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Şifre - Tekrar</label>
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Şifre(Tekrar)" value="<?php echo $password2;?>">
                </div>
                <button type="submit" class="btn btn-primary">Kayıt İşlemini Tamamla</button>
            </form><hr>
            <?php
            /**
             * Eğer Method Post ise
             */
            if ($_POST) {
                /**
                 * Hata durumunu kontrol et.
                 */
                if ($error) {
                    /**
                     * Eğer hata var ise,
                     * Toplam hata adedini bul.
                     * Ve ekrana yazdır.
                     */
                    $totalError = count($errors);
                    echo '<div class="alert alert-danger" role="alert">' . $totalError . ' Hata bulundu. Lütfen bu hataları giderin ve tekrar deneyin.</div>';

                    /**
                     * Tek tek hataları ekrana yaz.
                     */
                    foreach ($errors as $err) {
                        echo '<div class="alert alert-warning" role="alert">' . $err . '</div>';
                    }
                }
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
