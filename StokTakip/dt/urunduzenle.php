<?php 
include("ek/vt_baglantisi.php");
ob_start();
session_start();

if(!isset($_SESSION["login"])){
    header("Location: giris.php");
    exit();
}

if (isset($_POST['guncelle'])) {
    // Dosya yükleme işlemi
    $urunResim = null;
    if (isset($_FILES["urunResim"]) && $_FILES["urunResim"]["error"] == 0) {
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

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["urunResim"]["tmp_name"], $target_file)) {
                $urunResim = basename($_FILES["urunResim"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    if ($urunResim) {
        $stmt = $baglan->prepare("UPDATE urunler SET 
            urunAdi = ?, 
            urunMalzemeKodu = ?, 
            urunRaf = ?, 
            urunAdet = ?, 
            urunResim = ?,
            Depo = ? 
            WHERE urunID = ?");
        $stmt->bind_param("sssissi", 
            $_POST['urunAdi'], 
            $_POST['urunMalzemeKodu'], 
            $_POST['urunRaf'], 
            $_POST['urunAdet'],
            $urunResim, 
            $_POST['Depo'], 
            $_GET['id']);
    } else {
        $stmt = $baglan->prepare("UPDATE urunler SET 
            urunAdi = ?, 
            urunMalzemeKodu = ?, 
            urunRaf = ?, 
            urunAdet = ?,
            Depo = ? 
            WHERE urunID = ?");
        $stmt->bind_param("ssssii", 
            $_POST['urunAdi'], 
            $_POST['urunMalzemeKodu'], 
            $_POST['urunRaf'], 
            $_POST['urunAdet'], 
            $_POST['Depo'], 
            $_GET['id']);
    }
    
    $sonuc = $stmt->execute();

    if ($sonuc) {
        header("Location: urunler.php?durum=ok");
    } else {
        header("Location: urunler.php?durum=no");
    }
    exit();
}

$urunID = $_GET['id'];
$stmt = $baglan->prepare("SELECT * FROM urunler WHERE urunID = ?");
$stmt->bind_param("i", $urunID);
$stmt->execute();
$sonuc = $stmt->get_result();
$veri = $sonuc->fetch_assoc();

if ($veri) {
    extract($veri);
} else {
    echo "Ürün bulunamadı.";
    exit();
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Ürün Düzenle</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills">
            <li><button class="right-div btn btn-primary"><a style="color:white;" href="index.php" data-toggle="">Ana Sayfa</a></li>
            <li><button class="right-div btn btn-primary"><a style="color:white;" href="urunler.php" data-toggle="">Ürün Takip</a></li>
            <li><button class="right-div btn btn-primary"><a style="color:white;" href="depolar.php" data-toggle="">Depo Takip</a></li>
            <li><button class="right-div btn btn-primary"><a style="color:white;" href="tifler.php" data-toggle="">TİF Takip</a></li>
            <li><button class="right-div btn btn-primary"><a style="color:white;" href="tutanaklar.php" data-toggle="">Tutanak Takip</a></li>
            <button class="right-div btn btn-primary"><a style="color:white;" href="cikis.php">Çıkış Yap</a></button>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="urunler">
                <h4>Ürün Düzenle</h4>
                <div class="table-responsive">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <form role="form" method="post" action="?id=<?=$urunID?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Ürün Adı</label>
                                    <input class="form-control" name="urunAdi" type="text" value="<?=$urunAdi;?>">
                                </div>
                                <div class="form-group">
                                    <label>Malzeme Kodu</label>
                                    <input class="form-control" name="urunMalzemeKodu" type="text" value="<?=$urunMalzemeKodu;?>">
                                </div>
                                <div class="form-group">
                                    <label>Ürün Adeti</label>
                                    <input class="form-control" name="urunAdet" type="text" value="<?=$urunAdet;?>">
                                </div>
                                <div class="form-group">
                                    <label>Depo</label><br>
                                    <select name="Depo">
                                        <?php
                                        $depocek = $baglan->query("SELECT * FROM depolar");
                                        while ($depoSirala = $depocek->fetch_assoc()) {
                                            $selected = ($Depo == $depoSirala['depoID']) ? "selected" : "";
                                            echo "<option value='" . $depoSirala['depoID'] . "' $selected>" . $depoSirala['depoAdi'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Raf</label>
                                    <input class="form-control" name="urunRaf" type="text" value="<?=$urunRaf;?>">
                                </div>
                                <div class="form-group">
                                    <label>Ürün Resmi</label><br>
                                    <a href="uploads/<?=$urunResim;?>" target="_blank">
                                        <img src="uploads/<?=$urunResim;?>" alt="resmin büyük hali için tıklayınız" width="150" height="150">
                                    </a>
                                    <br><br>
                                    <input class="form-control" type="file" name="urunResim">
                                </div>

                                <button type="submit" name="guncelle" class="btn btn-danger">Kaydet</button>
                            </form>
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
    </div>
</div>
</body>
</html>
