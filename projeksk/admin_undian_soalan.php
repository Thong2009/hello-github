<?php
include('inc_header.php');
semak_tahap('admin');

// --- Semak ID undian ---
if(isset($_GET['id'])){
    $idundian = $_GET['id'];
}else{
    exit("<script>alert('ID diperlukan.');
    window.location.replace('admin_undian_senarai.php');</script>");
}

// --- Buang soalan ---
if(isset($_GET['delete'])){
    $idsoalan = $_GET['delete'];

    // Delete jawapan terlebih dahulu
    query($db, "DELETE FROM jawapan WHERE idsoalan = '$idsoalan'");
    query($db, "DELETE FROM soalan WHERE idsoalan = '$idsoalan'");

    exit("<script>alert('Soalan berjaya dibuang.');
    window.location.replace('admin_undian_soalan.php?id=$idundian');</script>");
}

// --- Maklumat undian ---
$sql = "SELECT * FROM undian WHERE idundian = '$idundian' LIMIT 1";
$result = query($db, $sql);

if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_array($result);
    $label_undian = $data['label_undian'];
}else{
    echo "<script>alert('ID ($idundian) tidak wujud.');
    window.location.replace('admin_undian_senarai.php');</script>";
    exit;
}

// ================================================
// ============ PROSES SIMPAN SOALAN ==============
// ================================================
if(
    isset($_POST['idsoalan']) &&
    isset($_POST['label_soalan']) &&
    isset($_POST['idjawapan']) &&
    isset($_POST['label_jawapan'])
){

    $idsoalan = $_POST['idsoalan'];
    $label_soalan = $_POST['label_soalan'];

    $idjawapan = $_POST['idjawapan'];       // array
    $label_jawapan = $_POST['label_jawapan']; // array

    // --- Simpan soalan ---
    $sql = "INSERT INTO soalan (idsoalan, label_soalan, idundian)
            VALUES ('$idsoalan', '$label_soalan', '$idundian')";
    query($db, $sql);

    // --- Simpan banyak jawapan ---
    foreach($idjawapan as $key => $idj){
        if(!empty($idj) && !empty($label_jawapan[$key])){
            $lj = $label_jawapan[$key];

            $sql2 = "INSERT INTO jawapan (idjawapan, label_jawapan, idsoalan)
                     VALUES ('$idj', '$lj', '$idsoalan')";
            query($db, $sql2);
        }
    }

    echo "<script>alert('Berjaya disimpan.');
    window.location.replace('admin_undian_soalan.php?id=$idundian');</script>";
    exit;
}
?>

<h2>Soalan Undian <?=$idundian?> : <?=$label_undian?></h2>

<!-- ======================= -->
<!-- FORM TAMBAH SOALAN BARU -->
<!-- ======================= -->

<form method="POST" action="">
<p>
<label>ID Soalan</label><br>
<input style="width:150px" type="text" name="idsoalan"
placeholder="ID Soalan" required>

<br><br>
<label>Label Soalan</label><br>
<input style="width:300px" type="text" name="label_soalan"
placeholder="Tajuk Soalan" required>
</p>

<hr>

<h4>Jawapan</h4>

<p>
<input style="width:100px" type="text" name="idjawapan[]"
placeholder="ID Jawapan" required>
<input type="text" name="label_jawapan[]" placeholder="Label Jawapan" required>
</p>

<p id="input-jawapan">
<!-- tambahan jawapan akan diletakkan di sini -->
</p>

<p>
<a href="javascript:void(0);" onclick="tambah_jawapan()">+ Tambah Pilihan</a>
</p>

<button class="btn btn-sm btn-success" type="submit">Simpan Soalan</button>
</form>

<hr>

<!-- ======================= -->
<!-- SENARAI SOALAN DALAM UNDIA -->
<!-- ======================= -->

<?php
$sql = "SELECT * FROM soalan WHERE idundian = '$idundian' ORDER BY idsoalan ASC";
$result = query($db, $sql);
$total = mysqli_num_rows($result);

if($total > 0){
    echo "Jumlah: $total<br>";
    echo "<table class='table table-bordered table-striped'>
    <tr>
        <th>Label Soalan</th>
        <th>Pilihan Jawapan</th>
        <th>Tindakan</th>
    </tr>";

    while($row = mysqli_fetch_array($result)){
        $idsoalan = $row['idsoalan'];
        $label_soalan = $row['label_soalan'];

        // Ambil jawapan
        $result2 = query($db,
            "SELECT * FROM jawapan WHERE idsoalan = '$idsoalan'
             ORDER BY idjawapan ASC"
        );

        $senarai = "";
        while($jaw = mysqli_fetch_array($result2)){
            $senarai .= $jaw['idjawapan']." : ".$jaw['label_jawapan']."<br>";
        }

        echo "
        <tr>
            <td>$idsoalan : $label_soalan</td>
            <td>$senarai</td>
            <td>
                <a class='btn btn-sm btn-danger'
                   href='javascript:void(0);'
                   onclick='deletethis(\"$idsoalan\")'>
                   Buang
                </a>
            </td>
        </tr>";
    }
    echo "</table>";
}else{
    echo "Belum ada soalan.";
}

include('inc_footer.php');
?>

<script>
//Tambah jawapan dinamik
function tambah_jawapan(){
    let html = `
    <p>
        <input style='width:100px' type='text' name='idjawapan[]' placeholder='ID Jawapan' required>
        <input type='text' name='label_jawapan[]' placeholder='Label Jawapan' required>
    </p>`;
    document.getElementById("input-jawapan").innerHTML += html;
}

//Hapus soalan
function deletethis(id){
    if(confirm("Padam soalan ini?")){
        window.location = "admin_undian_soalan.php?id=<?=$idundian?>&delete=" + id;
    }
}
</script>
