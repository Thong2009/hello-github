<?php include('inc_setup.php'); ?>
<!DOCTYPE html>
<html>
<head>  
<title><?=$nama_sistem?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- imej icon di Title bar pelayar web -->
<link rel="icon" href="images/favicon.png" type="image/png" >

<!-- memanggil bootstrap framework dan library untuk icon -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-icons.min.css" rel="stylesheet">
<style> 
* { 
    font-family: <?=$jenisfont?>, Arial, Helvetica;
    font-size: <?=$saizfont?>% ;
    color: #000;
}

.wrapper {
    border-radius: 16px;
    /* Warna latar box sistem */
    background-color: #ffffff !important;
    max-width: 900px;
    overflow: hidden;
    box-shadow: 0 1px 6px #222;
    margin: auto;
}

body{
    /* Imej latar sistem */
    background-image: url('images/bg.jpg');
    /* Warna latar sistem jika tidak gunakan imej */
    background-color: #6aa8ff;

    margin: 0;
    padding: 0;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}

/* Tambah jenis warna baru jika perlu */
.mybg-red { background-color: #ff3c2e !important; }
.mybg-purple { background-color: purple !important; }

/* Warna semua kotak input */
input,textarea,select {
    background-color: #f6fcca !important;
    border: 2px solid #d4cd83;
    border-radius: 8px;
}
input:focus,textarea:focus {
    background-color: #dedad9 !important;
}

/* Warna button bila halaman aktif */
.activepage {
  background-color: #d9faff !important;
  color: black !important;
}

.progress {
    /* Warna untuk LATAR bar keputusan undian */
    background-color: #dedede !important;
    background-image: none;
    -webkit-print-color-adjust: exact;
    box-shadow: inset 0 0;
    -webkit-box-shadow: inset 0 0;
}
.progress-bar {
    /* Warna untuk PROGRESS bar keputusan undian */
    background-color: #137dde !important;
    background-image: none;
    -webkit-print-color-adjust: exact;
    box-shadow: inset 0 0;
    -webkit-box-shadow: inset 0 0;
}
</style>
</head>
<body>
<div class="container wrapper min-vh-100 d-flex flex-column">

<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">

    <img src="images/logo.png" height="100" class="d-flex mb-2 me-lg-4 me-md-0 align-items-center text-decoration-none">

    <div class="d-flex flex-column align-items-center">

        <div class="mt-2 text-center">
            <h3> <?=$nama_sistem?> </h3>
        </div>

    <ul class="nav nav-pills ms-2 me-2 m-auto">
        <li class="nav-item"><a href="index.php" class="btn btn-outline-primary me-2">Utama</a></li>
        <li class="nav-item"><a href="senarai_undian.php" class="btn btn-outline-primary me-2">Jom Undi</a></li>
        <?php 
         if($tahap == 'admin'){ 
          echo "
          <li class='nav-item'><a class='btn btn-outline-primary me-2' href='admin_undian_senarai.php'>Urus Undian</a></li>
          <li class='nav-item'><a class='btn btn-outline-primary me-2' href='admin_pengguna_senarai.php'>Urus Pengguna</a></li>
          ";
         } 
         if($tahap == 'pelawat'){ 
          echo "
          <li class='nav-item'><a class='btn btn-outline-primary me-2' href='login.php'>Log Masuk</a></li>
          <li class='nav-item'><a class='btn btn-outline-primary me-2' href='signup.php'>Daftar</a></li>";
         }else{
          echo "
          <li class='nav-item'><a class='btn btn-outline-primary me-2' href='logout.php'>Log Keluar</a></li>";
         } 
        ?>
        </ul>

    </div>
</header>