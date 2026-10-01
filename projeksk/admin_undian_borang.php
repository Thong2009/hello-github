<?php
include('inc_header.php');
semak_tahap('admin');

// folder imej
$image_folder = "uploads";

// inisialisasi
$idundian = $label_undian = $detail = $imej = "";
$masa_tamat = "";
$edit_mode = false;

// ============= LOAD DATA FOR EDIT =============
if (isset($_GET['id'])) {

    $idundian = mysqli_real_escape_string($db, $_GET['id']);
    $sql = "SELECT * FROM undian WHERE idundian='$idundian' LIMIT 1";
    $result = query($db, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);
        $edit_mode = true;

        $idundian = $row['idundian'];
        $label_undian = $row['label_undian'];
        $detail = $row['detail'];   // diperbetulkan
        $imej = $row['imej'];

        $masa_tamat = date("Y-m-d\TH:i:s", strtotime($row['masa_tamat']));

    } else {
        exit("<script>alert('ID undian tidak ditemui.');
        window.location.replace('admin_undian_senarai.php');</script>");
    }
}

// ============= SAVE / UPDATE =============
if (isset($_POST['label_undian']) && !empty($_POST['masa_tamat'])) {

    $idedit = $_POST['idedit'];

    $idundian = mysqli_real_escape_string($db, $_POST['idundian']);
    $label_undian = mysqli_real_escape_string($db, $_POST['label_undian']);
    $detail = mysqli_real_escape_string($db, $_POST['detail']);

    $masa_tamat = date("Y-m-d H:i:s", strtotime($_POST['masa_tamat']));

    // ========== FILE UPLOAD ==========
    if (!empty($_FILES['imej']['tmp_name'])) {

        $i = $_FILES['imej'];
        $file_name = explode(".", $i['name']);
        $file_ext = strtolower(end($file_name));

        if (in_array($file_ext, ['jpeg', 'jpg', 'png', 'gif', 'bmp'])) {

            $location = __DIR__ . '/' . $image_folder . '/';
            $newname = "undian_" . $idundian . "." . $file_ext;

            if (move_uploaded_file($i['tmp_name'], $location . $newname)) {
                $imej = $newname;
            }
        }
    }

    // ========== SQL (INSERT / UPDATE) ==========
    if ($edit_mode) {

        $sql = "UPDATE undian SET 
                label_undian='$label_undian',
                detail='$detail',
                masa_tamat='$masa_tamat',
                imej='$imej'
                WHERE idundian='$idedit'";

    } else {

        $sql = "INSERT IGNORE INTO undian 
                (idundian, label_undian, detail, masa_tamat, imej) VALUES
                ('$idundian','$label_undian','$detail','$masa_tamat','$imej')";
    }

    query($db, $sql);

    echo "<script>alert('Berjaya disimpan.');
    window.location.replace('admin_undian_senarai.php');</script>";
    exit();
}
?>

<h2>Borang Maklumat Undian</h2>

<form class="form-group row" method="POST" action="" enctype="multipart/form-data">

<input type="hidden" name="idedit" value="<?=$idundian?>">

<div class="col">

<p>
<label>ID Undian</label><br>
<input type='text' name='idundian' value='<?= $idundian ?>' required>
</p>

<p>
<label>Label Undian</label><br>
<input type='text' name='label_undian' value='<?= $label_undian ?>' required>
</p>

<div class="mb-2">
<label class="form-label">Maklumat Detail</label><br>
<code>Boleh guna HTML atau Kod embed.</code>

<textarea class="form-control" name="detail" rows="8">
<?= htmlspecialchars($detail) ?>
</textarea>
</div>

</div>

<div class="col">

<p>
<label>Tutup Undian Pada</label><br>
<input type="datetime-local" step="any" name="masa_tamat" value="<?= $masa_tamat ?>" required>
</p>

<p>
<?php
$img = (!empty($imej)) ? $image_folder . "/" . $imej : "";
echo "<img src='$img' id='imej_preview' class='border rounded' width='200'>";
?>
</p>

<p>
<label>Muat Naik Gambar</label><br>
<input class="form-control" type="file" name="imej" accept="image/*">
</p>

<p>
<button class="btn btn-success" type="submit">Simpan</button>
</p>

</div>
</form>

<?php include('inc_footer.php'); ?>
