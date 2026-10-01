<?php 
include('inc_header.php');
semak_tahap('pengguna-admin');

if( isset($_GET['id'])){
	$idundian = $_GET['id'];
}else{
	exit("<script>alert('ID undian diperlukan.');
	window.location.replace('senarai_undian.php');</script>");
}
$idpengguna = $_SESSION['idpengguna'];
$tahap = $_SESSION['tahap'];

if( !semak_undi($idundian,$idpengguna) && $tahap != 'admin'){
	exit("<script>alert('Anda perlu mengundi sebelum melihat keputusan.');
	window.location.replace('senarai_undian.php');</script>");
}

$sql = "SELECT undian.* , COUNT(respon.idjawapan) AS jumlah_respon FROM undian
	LEFT JOIN soalan ON soalan.idundian = undian.idundian
	LEFT JOIN jawapan ON jawapan.idsoalan = soalan.idsoalan
	LEFT JOIN respon ON respon.idjawapan = jawapan.idjawapan
	WHERE undian.idundian = '$idundian'
	GROUP BY jawapan.idsoalan";
$result = query($db,$sql);

if(mysqli_num_rows($result) > 0){
	$data = mysqli_fetch_array($result);
	$label_undian = $data['label_undian'];
	$jumlah_respon = $data['jumlah_respon'];
	$masa_tamat = date("j M Y,g:i A" , strtotime($data['masa_tamat']));
}else{
	exit("<script>alert('Undian $idundian tidak wujud.');
	window.location.replace('index.php');</script>");
}
?>

<div id='kandungan' class='d-flex justify-content-center w-100 mb-2'>
	<div class='card'> <div class="card-header py-3 text-center">
		<h4 class="my-0 fw-normal">Keputusan Undian</h4>
		<p><b>Jumlah respon : <?=$jumlah_respon?></b><br>
		Masa Tamat : <?=$masa_tamat?></p>
		<p>
		<button class="btn btn-sm btn-primary" onclick='wimdow.print()'>Cetak</button>
		</p>
	</div>
	<div class='card-body mx-1'>
	<h2><?=$label_undian?></h2>

<?php
$sql = "SELECT * FROM soalan WHERE idundian = '$idundian' ORDER BY idsoalan ASC";
$result2 = query($db,$sql);

if(mysqli_num_rows($result2) == 0 || $jumlah_respon == 0){
	echo "Belum ada soalan atau respon.";
}else{
	while($soalan = mysqli_fetch_array($result2)){
		$idsoalan = $soalan['idsoalan'];
		$label_soalan = $soalan['label_soalan'];
		
		echo "<h5 class='mt-4'>$label_soalan</h5>";
		
		$sql = "SELECT jawapan.*, COUNT(respon.idjawapan) AS jumlah_undi
			FROM jawapan LEFT JOIN respon ON respon.idjawapan = jawapan.idjawapan
			WHERE jawapan.idsoalan = '$idsoalan'
			GROUP BY jawapan.idjawapan
			ORDER BY jumlah_undi DESC";
			
		$result3 = query($db,$sql);
		while($jawapan = mysqli_fetch_array($result3)){
			$jumlah_undi = $jawapan['jumlah_undi'];
			$label_jawapan = $jawapan['label_jawapan'];
			$persen = round(($jumlah_undi / $jumlah_respon) * 100, 1);
			
			echo "($jumlah_undi undi) $label_jawapan <br>
				<div class='progress mb-2' style='height: 15px;'>
				<div class='progress-bar' style='width:$persen%;'
				aria-valuenow='$persen' aria-valuemin='0'
				aria-valuemax='100'>$persen%</div>
				</div>";
		}
	}
}
?>

		</div>
	</div>
</div>	
<?php include('inc_footer.php');?>