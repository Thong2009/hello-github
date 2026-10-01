<?php 
# Nama sistem dipaparkan di header dan title bar browser
$nama_sistem = "eUndi ketua dan penolong ketua kelab komputer SMK Bandar Utama Damansara (4)";

# Maklumat pangkalan data
$dbname = "undi";
$dbuser = "root";
$dbpass = "";
$dbhost = "localhost";
$dbport = 3306;
# Buka sambungan ke pengkalan data 
$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport) OR exit(mysqli_connect_error());

// Pastikan sama dengan nama folder images dalam folder projek
$image_folder = "images";

# set timezone Malaysia untuk sistem
date_default_timezone_set('Asia/Kuala_Lumpur');

// nama unik session
session_name($dbname);
// Session dimulakan
session_start();
// session simpan tahap pengguna
if(isset($_SESSION['tahap'])){
  $tahap = $_SESSION['tahap'];
}else{
  $tahap = $_SESSION['tahap'] = 'pelawat';
}

# FUNCTION 1 semak jika Pengguna telah Mengundi
function semak_undi($idundian, $idpengguna){
    global $db;
    // Semak jika respon pengguna SUDAH wujud
    $sql = "SELECT respon.*, soalan.label_soalan, jawapan.label_jawapan FROM respon 
            JOIN jawapan ON respon.idjawapan = jawapan.idjawapan
            JOIN soalan ON soalan.idsoalan = jawapan.idsoalan
            WHERE respon.idpengguna = '$idpengguna' 
            AND soalan.idundian = '$idundian' ";
    $result = query($db, $sql);

    // jika dah ada rekod, bermakna pengguna sudah mengundi
    if( mysqli_num_rows($result) > 0 ){
      // jika rekod wujud, kembalikan result query
      return $result;
    }else{
      // jika rekod TIDAK wujud, kembalikan false
      return false;
    }
}

# FUNCTION 2 semak masa sudah tamat atau tidak
function semak_tamat($masa_tamat){
  
  if( strtotime($masa_tamat) < strtotime('now') ){
    // jika sudah tamat
    return true; //ya sudah tamat
  }else{
    // jika belum tamat
    return false; //tidak, belum tamat
  }
}

# FUNCTION 3 semak level pengguna dan tahap kebenaran akses
function semak_tahap($akses){
  $tahap = $_SESSION['tahap'];
  $error = "";
 
  if($tahap == 'pelawat'){ 
    $error = 'Anda perlu log masuk untuk akses halaman ini.';
  }elseif($tahap == 'pengguna'  &&  $akses == 'admin'){
   $error = 'Hanya akaun Admin boleh mengakses halaman ini.';
  }elseif($tahap == 'admin'  &&  $akses == 'pengguna'){
   $error = 'Hanya akaun Pengguna biasa boleh mengakses halaman ini.';
  }
 
  if(!empty($error)){
   exit( "<script> alert('$error'); window.location.replace('index.php'); </script>" );
  }
 }

// JANGAN EDIT Kod di bawah. Function ini untuk paparkan ralat MySQLi
function query($db, $sql = ''){
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  try{ 
    $result = mysqli_query($db, $sql) ; 
  } catch (Exception $e) {
    $er = $e->getTrace()[1]; 
    $text = $e->getMessage();
    $file = $er['file']; 
    $line = $er['line']; 
    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $debugger = "https://sk.jomgeek.com/debugger?msg=".base64_encode($text);
    $msg = "<div class='alert alert-danger w-100 shadow'>
     <p class='alert-heading h5'><i class='bi bi-bug'></i> Ralat Dikesan <a class='btn btn-danger' href='$debugger' target='_blank'><span class='spinner-grow spinner-grow-sm'></span> Semak</a></p> 
     <hr><b>Ralat:</b> <mark>$text</mark><br><br>
      <b>SQL:</b> $sql<br><br>Query dijalankan di baris $line <br>Kod: $file<br>URL: $url</div>";
    exit($msg);
  }
  return $result;
}

// session simpan saiz font
if(!isset($_SESSION['saizfont'])){
  $_SESSION['saizfont'] = 100;
}
$saizfont = $_SESSION['saizfont'];

// session simpan jenis font
if(!isset($_SESSION['jenisfont'])){
  $_SESSION['jenisfont'] = 'Arial';
}
$jenisfont = $_SESSION['jenisfont'];

// session simpan jenis efek cursor
if(!isset($_SESSION['cursor'])){
  $_SESSION['cursor'] = "";
}
$cursor = $_SESSION['cursor'];

?> 