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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .header, .content {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
        }
        .header {
            background-color: #f2f2f2;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .buttons {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    
    <div class="container">
    <ul class="nav nav-pills">
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="index.php" data-toggle="">Ana Sayfa</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="urunler.php" data-toggle="">Ürün Takip</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="depolar.php" data-toggle="">Depo Takip</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="tifler.php" data-toggle="">TİF Takip</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="tutanaklar.php" data-toggle="">Tutanak Takip</a></button></li>
            <button class="right-div btn btn-primary"><a style="color:white;" href="cikis.php">Çıkış Yap</a></button>
        </ul><br> <h2>Arama Kriterleri</h2><button class="btn btn-danger"> Malzeme Analiz Kodu Analiz</button><br><br>
        <div class="header">
           
            <form action="" method="GET">
              <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <tr>
                        <td>Sicilno</td>
                        <td><input type="text" name="sicilno"></td>
                        <td>Taşınır İşlem Fişno</td>
                        <td><input type="text" name="fisno"></td>
                    </tr>
                    <tr>
                        <td>Malzeme Kod</td>
                        <td><input type="text" name="malzeme_kod"></td>
                        <td>Zimmet Kişi</td>
                        <td><input type="text" name="zimmet_kisi"></td>
                    </tr>
                    <tr>
                        <td>Kurumsal Kod</td>
                        <td><input type="text" name="kurumsal_kod"></td>
                        <td>Zimmet Birim</td>
                        <td><input type="text" name="zimmet_birim"></td>
                    </tr>
                    <tr>
                        <td>Ambar No</td>
                        <td><input type="text" name="ambar_no"></td>
                        <td>Zimmet Firma</td>
                        <td><input type="text" name="zimmet_firma"></td>
                    </tr>
                    <tr>
                        <td>Giriş Tarihi</td>
                        <td><input type="date" name="giris_tarihi"></td>
                        <td>DT Açıklama</td>
                        <td><input type="text" name="dt_aciklama"></td>
                    </tr>
                    <tr>
                        <td>Marka</td>
                        <td><input type="text" name="marka"></td>
                        <td>Seri No</td>
                        <td><input type="text" name="seri_no"></td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td><input type="text" name="model"></td>
                        <td>Şase No</td>
                        <td><input type="text" name="sase_no"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Plaka No</td>
                        <td><input type="text" name="plaka_no"></td>
                    </tr>
                </table>
                <div class="buttons">
                    
                    <button class="btn btn-danger" type="submit">Ara</button>
                    
                </div>
            </form>
        </div>
        
        <div class="content">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>Sicilno</th>
                        <th>Malzeme Ad</th>
                        <th>Kurumsal Ad</th>
                        <th>Giriş Tarihi</th>
                        <th>Giriş Değeri</th>
                        <th>Tif No</th>
                        <th>Malzeme Kod</th>
                        <th>Ambar No</th>
                        <th>Çıkış Tarihi</th>
                        <th>Çıkış Değeri</th>
                        <th>Zimmetli Olduğu Yer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>255.02.01.01.02.011800252</td>
                        <td>BİLGİSAYAR DİZÜSTÜ (LEPTOP)</td>
                        <td>BİLGİ İŞLEM DAİRESİ BAŞKANLIĞI</td>
                        <td>17.07.2018</td>
                        <td>4,572.83</td>
                        <td>2018000024</td>
                        <td>255.02.01.01.02.01</td>
                        <td>46.06.03.10.019.01</td>
                        <td></td>
                        <td></td>
                        <td>44494556292 - İBRAHİM KÖŞKER</td>
                    </tr>
                    <!-- Daha fazla satır buraya eklenebilir -->
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
