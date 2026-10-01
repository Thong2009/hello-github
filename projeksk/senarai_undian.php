<?php include('inc_header.php');
//jika pengguna sudah log masuk, simpan nilai idpengguna
$idpengguna = isset($_SESSION['idpengguna']) ? $_SESSION['idpengguna']:false;
?>
<h2>Senarai Undian</h2>
<?php
$sql = "SELECT*FROM undian";
$result = query($db,$sql);
$total = mysqli_num_rows($result);

if($total > 0){
	echo "<table class='table table-boardered table-striped' border='1'
	cellpadding='4' cellspacing='0'>
	<tr><th width='200'>Imej</td><th>Undian</td>
	<th class='text-end'>Tindakan</td></tr>";
	
	while($row = mysqli_fetch_array($result)){
		$idundian = $row['idundian'];
		$label_undian = $row['label_undian'];
		$masa_tamat = date("j M Y, g:i:A", strtotime($row['masa_tamat']));
		//set warna tulisan tarikh tamat
		if(semak_tamat($row['masa_tamat'])){
			$label_masa = "Undian telah tamat:<span style='color:red'>$masa_tamat</span>";
		}else{
			$label_masa = "Tarikh tamat undian:<span style='color:green'>$masa_tamat</span>";
		}
		//umpuk pemboleh ubah dengan nilai daripada database
		$imej = $row['imej'];
		//jika nilai $imej tidak kosong (not empty), sediakan kod tag img untuk paparkan Imej
		if(!empty($imej)){
			$img = "<img src='$image_folder/$imej' class='border rounded' alt='Gambar Undian' width='100%'>";
		}else{
			$img = "";
		}
		//variable untuk simpan respon undi pengguna jika ada
		$respon_undi ="";
		//jika ada idpengguna, semak rekod undian pengguna 
		if($idpengguna){
			$undi_db = semak_undi($idundian,$idpengguna);
			
			if($undi_db){
				$respon_undi = "<br><b>Undian anda:</b><br>";
				foreach ($undi_db as $key => $value){
					$respon_undi .=$value['label_soalan'].":".$value['label_jawapan']."<br>";
				}
			}
		}
		echo "<tr><td>$img</td>
		<td><b>$label_undian</b><br>
		$label_masa <br>$respon_undi
		</td>
		<td align='right'>
		<a class='btn btn-info btn-sm mb-2' href='undian.php?id=$idundian'>Undi</a>
		<a class='btn btn-info btn-sm mb-2' href='keputusan.php?id=$idundian'>Keputusan</a>
		</td>
		</tr>
		";
	}
	echo "</table>";
}else{
	echo "Belum ada undian.";
}
include('inc_footer.php'); ?>