<html>
<head>
<title>Depo Takip</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content=" " />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'><!--web font-->
<!-- //web font -->
</head>
<?php 
include("ek/vt_baglantisi.php");
ob_start();
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['kadi']) && isset($_POST['sifre'])) {
        $kadi = mysqli_real_escape_string($baglan, trim($_POST['kadi']));
        $sifre = mysqli_real_escape_string($baglan, trim($_POST['sifre']));
        
        $sql_check = mysqli_query($baglan, "SELECT * FROM kullanicilar WHERE kullaniciadi='$kadi' AND sifre='$sifre'") or die(mysqli_error($baglan));
        
        if(mysqli_num_rows($sql_check) > 0) {
            $_SESSION["login"] = "true";
            $_SESSION["user"] = $kadi;
            $_SESSION["pass"] = $sifre;
            
            header("Location: index.php");
        } else {
            if(empty($kadi) || empty($sifre)) {
                echo "<center>Lütfen kullanıcı adı ya da şifreyi boş bırakmayınız..! <a href='javascript:history.back(-1)'>Geri Dön</a></center>";
            } else {
                echo "<center>Kullanıcı Adı/Şifre Yanlış.<br><a href='javascript:history.back(-1)'>Geri Dön</a></center>";
            }
        }
    } else {
        header("Location: giris.php");
    }
} else {
    header("Location: giris.php");
}

ob_end_flush();
?>

