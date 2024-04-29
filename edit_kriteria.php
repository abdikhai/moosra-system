<?php
include './src/koneksi.php';

if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if (empty($_SESSION['id'])) {
    header('location:./loginfirst.php');
}

$query = "SELECT idkriteria FROM tbkriteria ORDER BY idkriteria DESC LIMIT 1";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastidkriteria = $row["idkriteria"];
    // Generate the next idkriteria
    $nextidkriteria = "C" . ($row["idkriteria"] + 1);
    $Idkriteria = ($row["idkriteria"] + 1);
} else {
    // If no data exists, default to A1
    $nextidkriteria = "C1";
    $Idkriteria = "1";
}

$vnamakriteria = "";
$vjeniskriteria = "";
$vbobotkriteria = "";

if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbkriteria WHERE idkriteria = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);

        if ($data) {
            $Idkriteria = $data['idkriteria'];
            $nextidkriteria = 'C' . $data['idkriteria'];
            $vnamakriteria = $data['namakriteria'];
            $vjeniskriteria = $data['jeniskriteria'];
            $vbobotkriteria = $data['bobot'];
        }
    }

    if ($_GET['hal'] == "hapus") {
        $cek = mysqli_query($koneksi, "SELECT * FROM tbkriteria WHERE idkriteria = '$_GET[id]'");
        $data = mysqli_fetch_array($cek);

        if ($data) {
            $hapus = mysqli_query($koneksi, "DELETE FROM tbkriteria WHERE idkriteria = '$_GET[id]'");
            $hapus1 = mysqli_query($koneksi, "DELETE FROM tbsubkriteria WHERE idkriteria = '$_GET[id]'");
            $n = 'C' . $_GET['id'];
            $hapus2 = mysqli_query($koneksi, "UPDATE tbhitung set $n = 0 WHERE $n != 0");

            if ($hapus) {
                session_start();
                $_SESSION['pesan'] = 'hapus()';
                header('location:./kriteria.php');
            } else {
                session_start();
                $_SESSION['pesan'] = 'gagalhapus()';
                header('location:./kriteria.php');
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK | Metode MOOSRA</title>
    <?php include './src/header.php'; ?>
</head>

<body onload="<?= @$pesan ?>" class="select-none">
    <?php include './src/navbar.php'; ?>

    <section id="isi" class="mt-3">
        <form action="./src/aksicrud.php" method="post" class="container max-w-5xl mx-auto mt-12 w-50">
            <h1 class="text-center font-weight-bold fs-4 text-primary">Data Kriteria</h1>
            <hr class="w-12 h-1 outline-none border-none bg-gradient-to-r from-primary via-primary to-secondary rounded-full mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Kode Kriteria<span class="text-danger">*</span></label>
                        <input type="text" name="tkode" readonly class="form-control" value="<?= $nextidkriteria; ?>" />
                        <input type="text" name="tkode1" readonly class="form-control d-none" value="<?= $Idkriteria; ?>" />
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Kriteria<span class="text-danger">*</span></label>
                        <input type="text" name="tnamakriteria" required value="<?= $vnamakriteria ?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label>Jenis Kriteria<span class="text-danger">*</span></label>
                        <select name="tjeniskriteria" required class="form-control">
                            <option value="<?= $vjeniskriteria ?>"><?= $vjeniskriteria ?></option>
                            <option>Benefit</option>
                            <option>Cost</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Bobot<span class="text-danger">*</span></label>
                        <input type="number" name="tbobot" required value="<?= $vbobotkriteria ?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <button type="submit" name="bkriteria" class="btn btn-primary">Simpan</button>
                    <a href="./kriteria.php" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Bootstrap -->
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#myTable').DataTable();
        });
    </script>

</body>

</html>
