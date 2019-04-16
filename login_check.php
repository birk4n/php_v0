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
 * login_user oturum değişkeninden bilgileri alıyoruz ve
 * $user değişkenine kaydediyoruz.
 *
 * Eğer kullanıcımız oturum açmış ise, $user dolu olacak.
 * Eğer kullanıcımız daha önce oturum açmamış ise, $user boş olacak.
 *
 */
$user = $_SESSION["login_user"];

/**
 * Kullanıcı zaten oturum açmış ise index.php ye yönlendiriyoruz.
 * $user dolu ise, yada içinde her hangi bir değer var ise, bunun anlamı kullanıcımız oturum açmış.
 * Eğer $user boş ise, bunun anlamı kullanıcımız henüz oturum açmamış
 */
if ($user) {
    header("location: index.php");
    exit;
}


// login.php den gönderilen Kullanıcı adı ve Şifreyi alıyoruz.
$username = $_POST["username"];
$password = $_POST["password"];

// Varsa Sağında yada Solunda gereksiz boşluklar, bunları temizliyoruz.
$username = trim($username);
$password = trim($password);

// Kullanıcı adını güvenli hale getiriyoruz.
$username = $db->quote($username);

// Şifremizi md5 e çeviriyoruz
$password = md5($password);

// Sorgumuzu hazırlıyoruz.
$query= "SELECT * FROM user WHERE username=$username and password='$password'";

/**
 * Sorgumuzu Çalıştırıyoruz.
 */
$result = $db->select($query);

/**
 * Sorgumuzu çalıştırdıktan sonra dönen sonucu inceliyoruz.
 * Login Formundan gelen bilgiler ile, veritabanımız da bulunan bilgileri karşılaştırdık.
 * Burada ki IF ile EŞLEŞEN bir kayıt var mı diye kontrol ediyoruz.
 */
if ($result && count($result) == 1) {
    /**
     * Girilen Kullanıcı adı ve Şifre ile eşleşen bir kayıt bulduk.
     * Tanımsız olarak başlattığımız Session ı, artık tanımlaya biliriz.
     * Böylece oturum açma işlemini gerçekleştirebiliriz.
     */

    // Ihtiyaç duyduğumuz alanları login_user adlı oturum değişkenine kayıt ettik.
    // login_user oturum değişkeni ilk defa burada dulduruluyor.
    // Daha önce hep boştu. Boş olması demek, kişi oturum açmamış demektir.
    // Dolu olması demek ise, kişi oturum açmış demektir.
    // Bizde doldurmak için gerekli alanları login_user oturum değişkenine kayıt ettik.
    // Örneğin başka bir sayfa da kullanıcın adını yada soyadını almak için, burada kayıt ettiğimiz name ve surname i alacağız.
    $_SESSION["login_user"] = array(
        "id" => $result[0]["id"],
        "name" => $result[0]["name"],
        "surname" => $result[0]["surname"],
        "username" => $result[0]["username"],
        "ogr_no" => $result[0]["ogr_no"],
        "ogretmen" => $result[0]["ogretmen"]
    );

    /**
     * Oturum açma işlemi gerçekleşti.
     * Kullanıcıyı index.php e göndereceğiz.
     * Hatırlarsanız, index.php de oturum açma/açmama durumuna göre navbar daki linkler görünüyordu.
     * Oturum açmamış ise: Kayıt Ol, Giriş Yap görünüyordu.
     * Oturum Açmış ise: Çıkış Yap görünecekti.
     */
    header("location: profil.php");
    exit;

} else {
    /**
     * Girilen Kullanıcı adı ve Şifre ile eşleşen bir kayıt bulamadık.
     * Girilen kullanıcı adı ve/veya şifre yanlış.
     * Kullanıcının tekrar denemesi için login.php ye yönlendiriyoruz.
     */
    header("location: login.php?type=error");
    exit;

}