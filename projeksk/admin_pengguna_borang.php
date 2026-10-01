<?php include('inc_header.php');
semak_tahap('admin');
$idpengguna = $katalaluan = $nama = $tahap = "";
$edit_data = 0;

if(isset($_GET['idpengguna'])){
	$idpengguna = $_GET['idpengguna'];
	$sql = "SELECT * FROM pengguna WHERE idpengguna = '$idpengguna' LIMIT 1";
	$result = query($db,$sql);
	if(mysqli_num_rows($result) > 0){
		$edit_data = mysqli_fetch_array($result);
		$idpengguna = $edit_data['idpengguna'];
		$katalaluan = $edit_data['katalaluan'];
		$nama = $edit_data['nama'];
		$tahap = $edit_data['tahap'];
	}else{
		echo"<script>alert('ID tidak ditemui')</script>";
	}
}
if(isset($_POST['idpengguna'])){
	$idpengguna = trim($_POST['idpengguna']);
	$katalaluan = trim($_POST['katalaluan']);
	$nama = $_POST['nama'];
	$tahap = $_POST['tahap'];
	$idedit = $_POST['idedit'];
	if($edit_data){
		$sql = "UPDATE IGNORE pengguna SET idpengguna='$idpengguna',
		katalaluan='$katalaluan', nama='$nama', tahap='$tahap' WHERE idpengguna='$idedit'";
	}else{
		$sql = "UPDATE IGNORE INTO pengguna (idpengguna, katalaluan, nama, tahap)
		VALUES ('$idpengguna', '$katalaluan', '$nama', '$tahap')";
	}
	$result = query($db,$sql);
	echo "<script>alert('Berjayaa disimpan.');
	window.location.replace('admin_pengguna_senarai.php');</script>";
} ?>

<form method="POST" action="">
<input type="hidden" name="idedit" value ="<?$idpengguna?>">
<p><label>ID Pengguna</label><br>
<input type='text' name='idpengguna' value='<?php echo $idpengguna;?>' required></p>
<p><label>Katalaluan</label><br>
<input type='password' name='katalaluan' value='<?php echo $katalaluan;?>' required></p>
<p><label>Nama</label><br>
<input type='text' name='nama' value='<?php echo $nama;?>' required></p>
<p><label>Tahap</label><br>
<select nama='tahap'>
<option <?=$tahap=='pengguna'?'selected':''?> value='pengguna'>Pengguna</option>
<option <?=$tahap=='admin'?'selected':''?> value='admin'>Admin</option>
</select>
</p>
<p><button class="btn btn-success btn-sm" type="submit">Simpan</button></p>
</form>
<?php include('inc_footer.php'); ?>