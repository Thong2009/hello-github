<?php
include('inc_header.php');

#pembolehubah untuk menyimpan input pengguna
$idpengguna = $nama = $error = '';

if(isset($_POST['idpengguna'])&&isset($_POST['katalaluan'])){
	
	$idpengguna = trim($_POST['idpengguna']);
	$katalaluan = trim($_POST['katalaluan']);
	$nama = trim($_POST['nama']);
	
	
	#Semak supaya semua maklumat sudah diisi (tidak empty)
if(empty($idpengguna) || empty($nama) || empty($katalaluan)){
	$error.="Sila isi semua ruang di borang pendaftaran.";
}

#semak supaya idpengguna tiada simbol khas
if(preg_match('/[^a-zA-Z0-9]+/',$idpengguna)){
	$error.="ID Pengguna tidak boleh menggunakan simbol.";
}

#Dapatkan bilangan askara idpengguna
$panjang_idpengguna = strlen($idpengguna);

#Had atas untuk panjang idpengguna
if($panjang_idpengguna > 12){
	$error.="ID Pengguna terlalu panjang.Maksima 15 askara.";
}

#Had bawah untuk panjang idpengguna
if($panjang_idpengguna < 4){
	￥error."ID Pengguna terlalu penjek.Minima 4 aksara.";
}

#Had bawah untuk katalaluan
$panjang_katalaluan = strlen($katalaluan);
if($panjang_katalaluan < 6){
	$error.="Katalaluan terlalu pendek.Minima 6 askara.";
}

#Semak jika idpengguna sudah wujud dalam database
$sql = "SELECT * FROM Pengguna WHERE idpengguna='$idpengguna' LIMIT 1";
$result = query($db,$sql);
if(mysqli_num_rows($result) > 0){
	$error.="ID Penggunna ($idpengguna) sudah digunakan, sila gunakan yang lain.";
}	

#jika tiada error, teruskan pendaftaran
if(empty($error)){
	
	$sql = "INSERT INTO pengguna (idpengguna,katalaluan,nama,tahap)
	VALUES ('$idpengguna','$katalaluan','$nama','pengguna')";
	$result =query($db,$sql);
	
	exit("<script>alert('Pendaftaran berjaya,Sila Log Masuk');
	window.location.replace('lagin.php');</script>");
}else{
	echo"<script alert('$error');</script>";
}
}
?>

<h2>Daftar Akaun</h2>
<form method="POST" action="signup.php" class="w-50 m-auto">

<div class="mb-3">
<label class="form-label mt-2">ID Pengguna(Username/NoTel/No.KP)</label>
<input class="form-control"type="text" name="idpengguna"
data-bs-toggle="tooltip"data-bs-placement="top"title="ID Penggune untuk log masuk."
value='<?php echo $idpengguna;?>'required>
</div>

<div class="mb-3">
<label class="form-label mt-2">Katalaluan</label>"
<input class="form-control"type="password"name="katalaluan"value=""required>
</div>

<div class="mb-3">
<label class="form-label">nama</label>
<input class="form-control"type="text"name="nama"
value='<?php echo $nama;?>'required>
</div>

<div class="d=grid gap-2">
<button class="btn btn-success d-block"type="submit">Daftar</button>
</div>
</form>

<?php include('inc_footer.php'); ?>