<?php include "ek/vt_baglantisi.php"; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$baslik;?></title>
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
                                                            <button class="right-div btn btn-primary"><a style="color:white;" href="cikis.php">Çıkış Yap</a>
                                </button>
								
								
								
                            </ul>
                            </div>
                            <div class="tab-content">
                            <center> <img src="logo.png"  width="150" height="150" ><br>
                           <b> ASKİ GENEL MÜDÜRLÜĞÜ<br>
                            BİLGİ İŞLEM DAİRESİ BAŞKANLIĞI <br>
                            DEPO TAKİP PROGRAMI<br></b>
                            </center>
                            <br><br>       

                            <center>  
                            <a style="color:white;" href="index.php" data-toggle=""><button class="btn btn-primary">  ANA SAYFA </button> </a>&nbsp;
                            <a style="color:white;" href="urunler.php" data-toggle=""><button class="btn btn-primary" > ÜRÜN TAKİP</button></a>&nbsp;
                            <a style="color:white;" href="depolar.php" data-toggle=""><button class="btn btn-primary" >    DEPO TAKİP</button></a>&nbsp;
                            <a style="color:white;"  href="tifler.php" data-toggle=""><button class="btn btn-primary">   TİF TAKİP</button></a>&nbsp;
                            <a style="color:white;"  href="zimmetler.php" data-toggle=""><button class="btn btn-primary">   ZİMMET TAKİP</button></a>&nbsp;
                            <a style="color:white;" href="tutanaklar.php" data-toggle=""><button class="btn btn-primary">   TUTANAK TAKİP</button> </a>&nbsp;  
                            <a style="color:white;" href="malzeme_analiz.php" data-toggle=""><button class="btn btn-primary">   MALZEME ANALİZ &nbsp;</button></a>
                            
                        
                        
                        </center>   <br><br><br><br><br><br><br><br>                    
                                
                            </div>
                               
                            
                        </div>
    </div>                    
					
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
        header("Location: index.php");
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
        header("Location: index.php");
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