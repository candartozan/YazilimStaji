<?php include "ek/vt_baglantisi.php"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ürünlerin Listesi - <?=$baslik;?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
	    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />

    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</head>

<body>
<?php 

include("ek/vt_baglantisi.php");
ob_start();
session_start();

if(!isset($_SESSION["login"])){
    header("Location:giris.php");
}
?>

<div class="panel panel-default">
                        
                        <div class="panel-body">
                            
                        <ul class="nav nav-pills">
                         <a style="color:white;" href="index.php" data-toggle=""><button class="left-div btn btn-primary">ANA SAYFA</button></a> 
                         <a style="color:white;" href="urunler.php" data-toggle=""> <button class="left-div btn btn-primary">ÜRÜN TAKİP</button></a>&nbsp;
                         <a style="color:white;" href="depolar.php" data-toggle=""><button class="left-div btn btn-primary">DEPO TAKİP</button></a>&nbsp;
                         <a style="color:white;" href="tifler.php" data-toggle=""><button class="left-div btn btn-primary">TİF TAKİP</button></a>&nbsp;
                         <a style="color:white;" href="tutanaklar.php" data-toggle=""><button class="left-div btn btn-primary">TUTANAK TAKİP</button></a>&nbsp;
                         <a style="color:white;" href="zimmetler.php" data-toggle=""><button class="left-div btn btn-primary">ZİMMET TAKİP</button></a>&nbsp;

           
                         <a style="color:white;" href="cikis.php"> <button class="right-div btn btn-primary">Çıkış Yap</a></button>
        </ul>

                            <div class="tab-content"><br>
                            <button class="btn btn-danger"><a style="color:white;" href="urunekle.php">Ürün Ekle</a></button>
                                <div class="tab-pane fade active in" id="urunler">
                                <br>
                                    <h4>Stoktaki Ürünler</h4>

                                    <!-- Depo Seçimi -->
                                    <form method="GET" action="">
                                        <label for="depoID">Depo Seçin:</label>
                                        <select name="depoID" id="depoID" class="form-control" onchange="this.form.submit()">
                                            <option value="">Tüm Depolar</option>
                                            <?php
                                            $depoCek = mysqli_query($baglan, "SELECT * FROM depolar");
                                            while ($depo = mysqli_fetch_array($depoCek)) {
                                                echo '<option value="' . $depo['depoID'] . '">' . $depo['depoAdi'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </form>
                                    <br>

                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Ürün Adı</th>
                                            <th>Ürün Resim</th>
                                            <th>Malzeme Kodu</th>
                                            <th>Depo</th>
                                            <th>Raf</th>
                                            <th>Adet</th>                                            
											<th>Hızlı Artır/Eksilt </th>
											<th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
include "ek/vt_baglantisi.php";

// Depo ID'sini al
$depoID = isset($_GET['depoID']) ? (int)$_GET['depoID'] : 0;
$depoFilter = $depoID > 0 ? "WHERE Depo=$depoID" : "";

// Ürünleri çekme
$urunsql = mysqli_query($baglan, "SELECT * FROM urunler $depoFilter");

if ($urunsql) {
    while ($urun = mysqli_fetch_array($urunsql)) {
        echo '<tr class="odd gradeX">
                <td>' . $urun['urunAdi'] . '</td>
             <td><a href="uploads/' . $urun['urunResim'] . '" target="_blank">
                    <img src="uploads/' . $urun['urunResim'] . '" alt="resmin büyük hali için tıklayınız" width="150" height="150">
                </a></td>
                <td>' . $urun['urunMalzemeKodu'] . '</td>

                <td class="center">';

        $depocek = mysqli_query($baglan, "SELECT * FROM depolar WHERE depoID=" . $urun['Depo']);

        if ($depocek) {
            while ($depoGoster = mysqli_fetch_array($depocek)) {
                echo $depoGoster['depoAdi'];
            }
        }

        echo '</td>
        <td>' . $urun['urunRaf'] . '</td>
        <td class="center">' . $urun['urunAdet'] . '</td>
              <td>
                <form method="get" action="?artir">
                    <input type="hidden" name="uuid" value="' . $urun['urunID'] . '">
                    <input type="hidden" name="adet" value="' . $urun['urunAdet'] . '">
                    <input type="text" name="artieksi">
                    <a name="artir" href="?artir=' . $urun['urunID'] . '">
                        <button name="arti">+</button>
                    </a>
                    <a href="?eksilt=' . $urun['urunID'] . '">
                        <button name="eksi">-</button>
                    </a>
                </form>
              </td>
              <td>
              <a href="urunduzenle.php?id=' . $urun['urunID'] . '">
                  <button class="btn btn-simple" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i> Düzenle</button>
              </a>
            </td>
            </tr>';
    }
} else {
    echo "Sorgu başarısız: " . mysqli_error($baglan);
}

// Veritabanı bağlantısını kapatma
mysqli_close($baglan);
?>
</tbody>
                                </table>
                            </div></div>
                               
                            </div>
                        </div>
                    </div>
					<center>  
                            <button class="btn btn-primary">  <a style="color:white;" href="index.php" data-toggle="">ANA SAYFA</a> </button> &nbsp;
                            <button class="btn btn-primary" > <a style="color:white;" href="urunler.php" data-toggle="">ÜRÜN TAKİP</a></button>&nbsp;
                            <button class="btn btn-primary" >    <a style="color:white;" href="depolar.php" data-toggle="">DEPO TAKİP</a></button>&nbsp;
                            <button class="btn btn-primary">   <a style="color:white;"  href="tifler.php" data-toggle="">TİF TAKİP</a></button>&nbsp;
                            <button class="btn btn-primary">   <a style="color:white;" href="tutanaklar.php" data-toggle="">TUTANAK TAKİP</a> &nbsp;    </center>
<center><?=$alt;?></center>


<?php
include "ek/vt_baglantisi.php";

if (isset($_GET['arti'])) {
    $adeti = (int)$_GET['adet'];
    $adeti1 = (int)$_GET['artieksi'];
    $urunid = (int)$_GET['uuid'];
    $toplam = $adeti + $adeti1;

    $islem = $baglan->query("UPDATE urunler SET urunAdet='$toplam' WHERE urunID=$urunid");

    if ($islem) {
        header("Location: urunler.php");
        exit();
    } else {
        echo "Error: " . $baglan->error;
    }
} else if (isset($_GET['eksi'])) {
    $adeti = (int)$_GET['adet'];
    $adeti1 = (int)$_GET['artieksi'];
    $urunid = (int)$_GET['uuid'];
    $toplam = $adeti - $adeti1;

    $islem = $baglan->query("UPDATE urunler SET urunAdet='$toplam' WHERE urunID=$urunid");

    if ($islem) {
        header("Location: urunler.php");
        exit();
    } else {
        echo "Error: " . $baglan->error;
    }
}
?>

                            
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
   <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

					</body>
</html>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>