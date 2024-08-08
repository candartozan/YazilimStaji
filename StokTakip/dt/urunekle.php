<?php 
include("ek/vt_baglantisi.php");
ob_start();
session_start();

if(!isset($_SESSION["login"])){
    header("Location:giris.php");
    exit();
}

if(isset($_POST['ekle'])){
    $uadi = $_POST['adi'];
    $urunMalzemeKodu = $_POST['urunMalzemeKodu'];
    $urunRaf = $_POST['urunRaf'];
    $adeti = $_POST['adet'];
    $depo = $_POST['depo'];
    $urunResim = "";

    // Eğer bir dosya seçilmişse dosya yükleme işlemi yap
    if (!empty($_FILES["urunResim"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["urunResim"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["urunResim"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["urunResim"]["size"] > 10000000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["urunResim"]["tmp_name"], $target_file)) {
                // Dosya başarıyla yüklendi
                $urunResim = basename($_FILES["urunResim"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Prepared statement ile veritabanına güvenli şekilde veri ekleme
    $stmt = $baglan->prepare("INSERT INTO urunler (urunAdi, urunMalzemeKodu, urunRaf, urunAdet, Depo, urunResim) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $uadi, $urunMalzemeKodu, $urunRaf, $adeti, $depo, $urunResim);

    if ($stmt->execute()) {
        header("Location:urunler.php");
        exit();
    } else {
        echo "<h1 style='color:red; align:center;'>Hata! Tekrar Deneyin!</h1>";
    }

    $stmt->close();
    $baglan->close();
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ürün Ekle - TKY</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
   
    <!-- BOOTSTRAP CORE STYLE -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills">
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="index.php" data-toggle="">Ana Sayfa</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="urunler.php" data-toggle="">Ürün Takip</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="depolar.php" data-toggle="">Depo Takip</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="tifler.php" data-toggle="">TİF Takip</a></button></li>
            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="tutanaklar.php" data-toggle="">Tutanak Takip</a></button></li>
            <button class="right-div btn btn-primary"><a style="color:white;" href="cikis.php">Çıkış Yap</a></button>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade active in" id="urunler"><br><br>
                <h4>Ürün Ekle</h4>
                <div class="table-responsive">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <form role="form" method="post" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Ürün Adı</label>
                                    <input class="form-control" name="adi" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label>Malzeme Kodu</label>
                                    <input class="form-control" name="urunMalzemeKodu" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label>Ürün Adeti</label>
                                    <input class="form-control" name="adet" type="number" required>
                                </div>
                                <div class="form-group">
                                    <label>Depo</label>
                                    <select name="depo" required>
                                        <?php
                                        $depocek = mysqli_query($baglan, "SELECT * FROM depolar");
                                        while($depoSirala = mysqli_fetch_array($depocek)){
                                            echo "<option value=".$depoSirala[0].">".$depoSirala[1]."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Raf</label>
                                    <input class="form-control" name="urunRaf" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label>Ürün Resmi</label>
                                    <input class="form-control" type="file" name="urunResim">
                                </div>
                                <button type="submit" name="ekle" class="btn btn-danger">Kaydet</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

</body>
</html>
