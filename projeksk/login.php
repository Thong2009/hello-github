<?php
include('inc_header.php');

$idpengguna = "";

if (isset($_POST['idpengguna']) && isset($_POST['katalaluan'])) {

    $idpengguna = trim($_POST['idpengguna']);
    $katalaluan = trim($_POST['katalaluan']);

    $sql = "SELECT * FROM pengguna 
            WHERE idpengguna = '$idpengguna' 
            AND katalaluan = '$katalaluan' 
            LIMIT 1";

    $result = query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $_SESSION['idpengguna'] = $row['idpengguna'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['tahap'] = $row['tahap'];

        exit("<script>alert('Log Masuk Berjaya.'); window.location.replace('index.php');</script>");
    } else {
        echo "<script>alert('Log Masuk Gagal: ($idpengguna)');</script>";
    }
}
?>

<h2>Log Masuk</h2>
<form method="POST" action="login.php" class="w-50 m-auto">

    <div class="mb-3">
        <label class="form-label">ID Pengguna</label>
        <input type="text" class="form-control" name="idpengguna" placeholder="Masukkan ID Pengguna" value="<?= $idpengguna ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Katalaluan</label>
        <input type="password" class="form-control" name="katalaluan" required>
    </div>

    <div class="d-grid gap-2">
        <button class="btn btn-primary d-block" type="submit">Log Masuk</button>
    </div>

</form>

<?php include('inc_footer.php'); ?>
