<?php include('inc_header.php');
semak_tahap('pengguna');

if(isset($_POST['undian']) && isset($_POST['respon'])){
	
	$idpengguna = $_SESSION['idpengguna'];
	$idundian = $_POST['undian'];
	
	foreach($_POST['respon'] as $key => $idjawapan){
		$sql = "INSERT IGNORE INTO respon (idpengguna,idjawapan)
		VALUES('$idpengguna','$idjawapan')";
		
		$result = query($db,$sql);
	}
	echo "<script> alert('Terima Kasih kerana mengundi.');
	window.location.replace('keputusan.php?id=$idundian');</script>";
}else{
	echo "<script> alert('Tiada POST data yang diperlukan.');
	window.location.replace('index.php');</script>";
}
?>