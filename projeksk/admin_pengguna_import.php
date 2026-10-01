<?php include('inc_header.php');
semak_tahap('admin');

if(isset($_FILES["import"])){
	if( !file_exists($_FILES['import']['tmp_name'])){
		echo "<script>alert('Sila pilih fail.');
		window.location.replace('urus_import.php');</script>";
	}
	$file = fopen($_FILES["import"]["tmp_name"], 'rb');

while(($line = fgetcsv($file, 100, ",")) !== False){
	if(count($line) >= 3){
		$idpengguna = trim($line[0]);
		$katalaluan = trim($line[1]);
		$nama = trim($line[2]);
		$tahap = trim($line[3]) ? trim($line[3]) : "pengguna";
		$sql = "INSERT IGMORE INTO pengguna (idpengguna, katalaluan, nama, tahap)
			VALUES ('$idpengguna', '$katalaluan', '$nama', '$tahap')";
		$result = query($db,$sql);
	}
}
fclose($file);
echo "<script>alert('Proses import selesai.');
window.location.replace('admin_pengguna_senarai.php');</script>";
}?>

<h2>Import Data Pengguna</h2>
<form method="POST" action="" enctype="multipart/form-data">
<p>
<label for='import'>Pilih fail untuk di import (Format TXT atau CSV sahaja)</label><br>
<input class="form-control mt-4 mb-4" type="file" name='import' accept='.csv, .txt' required>
</p>
</form>
<p>Data import mesti mengikut susunan :<br> idpengguna, katalaluan, nama, tahap</p>
<?php include('inc_footer.php'); ?>