<?php
include('inc_header.php');
semak_tahap('admin');

// DELETE USER
if(isset($_GET['delete'])){
    $idpengguna = mysqli_real_escape_string($db, $_GET['delete']);
    $sql = "DELETE FROM pengguna WHERE idpengguna = '$idpengguna'";
    $result = query($db,$sql);

    echo "<script>
        alert('Akaun pengguna berjaya dibuang.');
        window.location.replace('admin_pengguna_senarai.php');
    </script>";
    exit();
}

// Carian
$keyword = $q = "";

if(isset($_POST['search'])){
    $keyword = trim($_POST['keyword']);

    if(!empty($keyword)){
        $keyword_sql = mysqli_real_escape_string($db, $keyword);
        $q .= " WHERE nama LIKE '%$keyword_sql%' 
                OR idpengguna LIKE '%$keyword_sql%'";
    }
}

// reset
if(isset($_POST['reset'])){
    $keyword = "";
    $q = "";
}

?>

<h2>Urus Pengguna</h2>

<form method="POST" action="">
    <div class="row">
        <div class="col">
            <div class="input-group">
                <input class="form-control" type='text' name='keyword'
                value='<?php echo $keyword;?>' placeholder='ID atau Nama Pengguna'>
                <button class="btn btn-success" type='submit' name='search'>Cari</button>
                <button class="btn btn-warning" type='submit' name='reset'>Reset</button>
            </div>
        </div>
        
        <div class="col text-end">
            <a class='btn btn-sm btn-primary' href="admin_pengguna_borang.php">Tambah Pengguna</a>
            <button class="btn btn-sm btn-primary" onclick='window.print()'>Cetak</button>
        </div>
    </div>
</form>

<hr>

<?php
$sql = "SELECT * FROM pengguna $q ORDER BY idpengguna ASC";
$result = query($db,$sql);
$total = mysqli_num_rows($result);

if($total > 0){
    echo "Jumlah: $total<br>";
?>

<table class='table table-striped table-sm' border='1' cellpadding='4' cellspacing='0'>
<tr>
    <th>Bil</th>
    <th>ID Pengguna</th>
    <th>Nama</th>
    <th>Tahap</th>
    <th class='text-end'>Tindakan</th>
</tr>

<?php
$counter = 0;
while($row = mysqli_fetch_array($result)){
    $counter++;
    $idpengguna = $row['idpengguna'];
    $nama = $row['nama'];
    $tahap = $row['tahap'];

    echo "<tr>
        <td>$counter</td>
        <td>$idpengguna</td>
        <td>$nama</td>
        <td>$tahap</td>
        <td align='right'>
            <a class='btn btn-sm btn-info' 
               href='admin_pengguna_borang.php?idpengguna=$idpengguna'>Edit</a>
            <a class='btn btn-sm btn-danger' 
               onclick='deletethis(\"$idpengguna\")'>Buang</a>
        </td>
    </tr>";
}
?>
</table>

<?php
} else {
    echo "Belum ada rekod pengguna.";
}

include('inc_footer.php');
?>

<script>
function deletethis(id){
    if(confirm("Adakah anda pasti mahu membuang pengguna ini?")){
        window.location = "admin_pengguna_senarai.php?delete=" + id;
    }
}
</script>
