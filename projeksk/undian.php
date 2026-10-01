<?php
include('inc_header.php');
semak_tahap('pengguna-admin');

// Pastikan idundian dihantar
if(isset($_GET['id'])){
    $idundian = $_GET['id'];
}else{
    exit("<script>alert('ID undian diperlukan.'); window.location.replace('senarai_undian.php');</script>");
}

$idpengguna = $_SESSION['idpengguna'];
$tahap      = $_SESSION['tahap'];

// Dapatkan maklumat undian
$sql = "SELECT * FROM undian WHERE idundian = '$idundian' LIMIT 1";
$result = query($db, $sql);

// Gunakan mysqli_num_rows() — elakkan double mysqli_fetch_array()
if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_array($result);
    $label_undian = $data['label_undian'];
    $detail       = $data['detail'];
    $imej         = $data['imej'];

    // Semak jika pengguna sudah mengundi (admin tidak disemak)
    if(semak_undi($idundian, $idpengguna) && $tahap != 'admin'){
        echo "<script>
                alert('Respon anda ada dalam rekod. Anda telah mengundi.');
                window.location.replace('keputusan.php?id=$idundian');
              </script>";
        exit;
    }

    // Semak masa tamat (admin tidak disekat)
    if(semak_tamat($data['masa_tamat']) && $tahap != 'admin'){
        exit("<script>alert('Undian ini telah ditutup.');
             window.location.replace('senarai_undian.php');</script>");
    }

}else{
    exit("<script>alert('Undian $idundian tidak wujud.');
         window.location.replace('index.php');</script>");
}
?>
<div class='d-flex justify-content-center w-100 mb-2'>
<div class='card'>
<div class="card-header py-3 text-center">
<h2><?=$label_undian?></h2>
<?php
if(!empty($imej)){
    echo "<img src='$image_folder/$imej' class='border rounded mb-3' alt='Gambar Undian' width='100%'>";
}
echo $detail;
?>
</div>

<div class='card-body mx-1'>
<form method="POST" action="undian_proses.php">
<input type="hidden" name="undian" value="<?=$idundian?>">

<?php
$sql = "SELECT * FROM soalan WHERE idundian = '$idundian' ORDER BY idsoalan ASC";
$result1 = query($db, $sql);

if(mysqli_num_rows($result1) > 0){

    while($soalan = mysqli_fetch_array($result1)){
        $idsoalan     = $soalan['idsoalan'];
        $label_soalan = $soalan['label_soalan'];

        echo "<h5 class='mt-4'>$label_soalan</h5>";

        $sql2 = "SELECT * FROM jawapan WHERE idsoalan = '$idsoalan' ORDER BY idjawapan ASC";
        $result2 = query($db, $sql2);

        while($jawapan = mysqli_fetch_array($result2)){
            $idjawapan     = $jawapan['idjawapan'];
            $label_jawapan = $jawapan['label_jawapan'];

            echo "
            <div class='form-check'>
                <input class='form-check-input' type='radio'
                    name='respon[$idsoalan]' value='$idjawapan'
                    id='j-$idsoalan-$idjawapan' required>
                <label class='form-check-label' for='j-$idsoalan-$idjawapan'>
                    $label_jawapan
                </label>
            </div>";
        }
    }

    echo "<button class='btn btn-sm btn-success mt-4' type='submit'>Hantar Undian</button>";

}else{
    echo "Belum ada soalan.";
}
?>
</form>
</div>
</div>
</div>

<?php include('inc_footer.php'); ?>
