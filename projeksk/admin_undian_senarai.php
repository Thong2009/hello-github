<?php
include('inc_header.php');
semak_tahap('admin'); 

// ======================= BUANG REKOD =======================
if (isset($_GET['delete'])) {
    $idundian = mysqli_real_escape_string($db, $_GET['delete']);

    $sql = "DELETE FROM undian WHERE idundian = '$idundian'";
    query($db, $sql);

    exit("<script>alert('Undian berjaya dibuang.');
    window.location.replace('admin_undian_senarai.php');</script>");
}

// ======================= CARIAN =======================
$keyword = $status = "";
$q = " WHERE 1 ";   // lebih stabil

if (isset($_POST['search'])) {

    $keyword = trim($_POST['keyword']);
    $status = trim($_POST['status']);

    if (!empty($keyword)) {
        $keyword_sql = mysqli_real_escape_string($db, $keyword);
        $q .= " AND label_undian LIKE '%$keyword_sql%' ";
    }

    $masa_now = date("Y-m-d H:i:s");

    if ($status == "aktif") {
        $q .= " AND masa_tamat > '$masa_now' ";
    } elseif ($status == "tamat") {
        $q .= " AND masa_tamat < '$masa_now' ";
    }
}

// RESET
if (isset($_POST['searchreset'])) {
    $keyword = "";
    $status = "";
    $q = " WHERE 1 ";
}
?>

<h2>Urus Undian</h2>

<form method="POST" action="">
<div class="row">
    <div class="col">
        <div class="input-group">

            <input class="form-control" type="text" name="keyword"
            value="<?= $keyword ?>" placeholder="Kata kunci">

            <select class="form-control" name="status">
                <option value="">Status</option>
                <option value="aktif" <?= ($status=="aktif"?"selected":"") ?>>Aktif</option>
                <option value="tamat" <?= ($status=="tamat"?"selected":"") ?>>Tamat</option>
            </select>

            <button class="btn btn-success" type="submit" name="search">Cari</button>
            <button class="btn btn-warning" type="submit" name="searchreset">Reset</button>

        </div>
    </div>

    <div class="col text-end">
        <a class="btn btn-sm btn-primary" href="admin_undian_borang.php">Tambah Undian</a>
        <button class="btn btn-sm btn-primary" onclick="window.print()">Cetak</button>
    </div>
</div>
</form>

<hr>

<?php
// ======================= PAPAR SENARAI =======================
$sql = "SELECT * FROM undian $q ORDER BY masa_tamat DESC";
$result = query($db, $sql);
$total = mysqli_num_rows($result);

if ($total > 0) {

    echo "Jumlah: $total<br>";

    echo "<table class='table table-bordered table-striped' border='1' cellpadding='4' cellspacing='0'>
        <tr>
            <th width='200'>Imej</th>
            <th>Undian</th>
            <th class='text-end'>Tindakan</th>
        </tr>";

    while ($row = mysqli_fetch_array($result)) {

        $idundian = $row['idundian'];
        $label_undian = $row['label_undian'];  
        $masa_tamat = date("j M Y, g:i A", strtotime($row['masa_tamat']));

        // WARNA TARIKH TAMAT
        if (semak_tamat($row['masa_tamat'])) {
            $label_masa = "Undian telah tamat: <span style='color:red'>$masa_tamat</span>";
        } else {
            $label_masa = "Tarikh tamat undian: <span style='color:green'>$masa_tamat</span>";
        }

        // IMEJ
        $imej = $row['imej'];
        if (!empty($imej)) {
            $img = "<img src='$image_folder/$imej' class='border rounded' alt='Gambar Undian' width='100%'>";
        } else {
            $img = "<div class='text-center text-muted'>Tiada Gambar</div>";
        }

        echo "<tr>
            <td>$img</td>

            <td>
                <b>$idundian : $label_undian</b><br>
                $label_masa<br><br>

                <a href='admin_undian_borang.php?id=$idundian'>Edit Maklumat</a> |
                <a href='admin_undian_soalan.php?id=$idundian'>Urus Soalan</a> |
                <a href='javascript:void(0);' onclick='deletethis(\"$idundian\")'>Buang</a>
            </td>

            <td align='right'>
                <a class='btn btn-info btn-sm mb-2' href='undian.php?id=$idundian'>Previu</a>
                <a class='btn btn-info btn-sm mb-2' href='keputusan.php?id=$idundian'>Keputusan</a>
            </td>
        </tr>";
    }

    echo "</table>";

} else {
    echo "Belum ada undian.";
}

include('inc_footer.php');
?>

<script>
function deletethis(id){
    if(confirm("Buang undian ini?")){
        window.location = "admin_undian_senarai.php?delete=" + id;
    }
}
</script>
