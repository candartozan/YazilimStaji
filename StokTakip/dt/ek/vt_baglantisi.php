<?php
// Veritabanı bağlantısı
$baglan = mysqli_connect("localhost", "root", "", "stok");

// Bağlantı kontrolü
if (mysqli_connect_errno()) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Karakter seti ayarlama
mysqli_set_charset($baglan, "utf8");

// Site Sabitleri
$ayarcek = mysqli_query($baglan, "SELECT * FROM ayarlar");
$ayar = mysqli_fetch_array($ayarcek);
extract($ayar);

$baslik = $sayfaBaslik;
$alt = $copright;
?>