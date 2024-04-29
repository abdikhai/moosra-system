<?php
include './src/koneksi.php';

if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if (empty($_SESSION['id'])) {
    header('location:./loginfirst.php');
}

$query = "SELECT idsubkriteria FROM tbsubkriteria ORDER BY idsubkriteria DESC LIMIT 1";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastidsubkriteria = $row["idsubkriteria"];
    // Generate the next idsubkriteria
    $nextidsubkriteria = "C" . ($row["idsubkriteria"] + 1);
    $idsubkriteria = ($row["idsubkriteria"] + 1);
} else {
    // If no data exists, default to C1
    $nextidsubkriteria = "C1";
    $idsubkriteria = "1";
}

$vnamasubkriteria = "";
$vketerangan = "";
$vbobotsubkriteria = "";

if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbsubkriteria WHERE idsubkriteria = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);

        if ($data) {
            $idsubkriteria = $data['idsubkriteria'];
            $vnamasubkriteria = $data['namasubkriteria'];
            $vketerangan = $data['keterangansubkriteria'];
            $vbobotsubkriteria = $data['bobotsubkriteria'];
        }
    }

    if ($_GET['hal'] == "hapus") {
        $cek = mysqli_query($koneksi, "SELECT * FROM tbsubkriteria WHERE idsubkriteria = '$_GET[id]'");
        $data = mysqli_fetch_array($cek);

        if ($data) {
            $hapus = mysqli_query($koneksi, "DELETE FROM tbsubkriteria WHERE idsubkriteria = '$_GET[id]'");

            if ($hapus) {
                session_start();
                $_SESSION['pesan'] = 'hapus()';
                header('location:./subkriteria.php');
            } else {
                session_start();
                $_SESSION['pesan'] = 'gagalhapus()';
                header('location:./subkriteria.php');
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK | Metode MOOSRA</title>
    <?php include './src/header.php'; ?>
</head>

<body onload="<?= @$pesan ?>">
    <?php include './src/navbar.php'; ?>

    <section id="isi" class="mt-3">
        <form action="./src/aksicrud.php" method="post" class="container max-w-5xl mx-auto mt-12">
            <h1 class="text-center font-weight-bold fs-4 text-primary">Edit Sub Kriteria</h1>
            <hr class="w-12 h-1 outline-none border-none bg-gradient-to-r from-primary via-primary to-secondary rounded-full mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kode Sub Kriteria<span class="text-danger">*</span></label>
                        <input type="text" name="tidsubkriteria" readonly class="form-control" value="<?= $idsubkriteria; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Nama Sub Kriteria<span class="text-danger">*</span></label>
                        <input type="text" name="tnamasubkriteria" required value="<?= $vnamasubkriteria ?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="tketerangan" value="<?= $vketerangan ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Bobot<span class="text-danger">*</span></label>
                        <input type="number" name="tbobot" required value="<?= $vbobotsubkriteria ?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <button type="submit" name="esubkriteria" class="btn btn-primary">Simpan</button>
                    <a href="./subkriteria.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </section>

</body>



</html>
