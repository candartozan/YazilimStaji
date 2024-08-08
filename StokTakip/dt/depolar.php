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
                            <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="index.php" data-toggle="">Ana Sayfa</a>
                                </li>
                                <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="urunler.php" data-toggle="">Ürün Takip</a>
                                </li>
                                <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="depolar.php" data-toggle="">Depo Takip</a>
                                </li>
                                <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="tifler.php" data-toggle="">TİF Takip</a>
                                </li>
                                <li class=""><button class="right-div btn btn-primary"><a style="color:white;" href="tutanaklar.php" data-toggle="">Tutanak Takip</a>
                                </li>
                                <button class="right-div btn btn-primary"><a style="color:white;" href="cikis.php">Çıkış Yap</a>
                                </button>
																				
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="urunler">
                                    <h4>Depo Yönetimi</h4>
                                    <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            
                                            <th>Depo NO </th>
											<th>İşlemler</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
// Veritabanı bağlantısı
include "ek/vt_baglantisi.php";

// Veritabanı sorgusu
$deposql = mysqli_query($baglan, "SELECT * FROM depolar");

// Hata kontrolü
if (!$deposql) {
    die('Sorgu başarısız: ' . mysqli_error($baglan));
}

// Veritabanından alınan verileri ekrana yazdırma
while ($depo = mysqli_fetch_array($deposql)) {
    echo '<tr class="odd gradeX">
          
            <td><a href="depogoruntule.php?depoID=' . $depo['depoID'] . '">
            <button class="btn btn-simple" data-toggle="modal" data-target="#myModal">
                ' . $depo['depoAdi'] . '
            </button>
        </a> </td>
            <td class="center">
                <a href="depoduzenle.php?id=' . $depo['depoID'] . '">
                    <button class="btn btn-simple" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-pencil"></i> Düzenle
                    </button>
                </a> 
                
            </td>
        </tr>';
}
?>


                                        
                                    </tbody>
                                </table>
                            </div></div>
                                <div class="tab-pane fade" id="profile">
                                    <h4>Profile Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="tab-pane fade" id="messages">
                                    <h4>Messages Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                                <div class="tab-pane fade" id="settings">
                                    <h4>Settings Tab</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
					
<center><?=$alt;?></center>

                            
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
   <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

					</body>
</html>