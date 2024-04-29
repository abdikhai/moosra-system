<?php
include './src/koneksi.php';

if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if (empty($_SESSION['id'])) {
    header('location:./loginfirst.php');
}

$query = "SELECT idalternatif FROM tbalternatif ORDER BY idalternatif DESC LIMIT 1";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastIdAlternatif = $row["idalternatif"];
    $nextIdAlternatif = "A" . ($row["idalternatif"] + 1);
    $IdAlternatif = ($row["idalternatif"] + 1);
} else {
    $nextIdAlternatif = "A1";
    $IdAlternatif = "1";
}

$vnama = "";
$vketerangan = "";

if (isset($_GET['hal'])) {

    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbalternatif WHERE idalternatif = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);

        if ($data) {
            $IdAlternatif = $data['idalternatif'];
            $nextIdAlternatif = 'A' . $data['idalternatif'];
            $vnama = $data['namaalternatif'];
            $vketerangan = $data['keteranganalternatif'];
        }
    }

    if ($_GET['hal'] == "hapus") {
        $cek = mysqli_query($koneksi, "SELECT * FROM tbalternatif WHERE idalternatif = '$_GET[id]'");
        $data = mysqli_fetch_array($cek);

        if ($data) {
            $hapus = mysqli_query($koneksi, "DELETE FROM tbalternatif WHERE idalternatif = '$_GET[id]'");
            $hapus1 = mysqli_query($koneksi, "DELETE FROM tbhitung WHERE idalternatif = '$_GET[id]'");

            if ($hapus && $hapus1) {
                session_start();
                $_SESSION['pesan'] = 'hapus()';
                header('location:./alternatif.php');
            } else {
                session_start();
                $_SESSION['pesan'] = 'gagalhapus()';
                header('location:./alternatif.php');
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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body onload="<?= @$pesan ?>" class="select-none">
    <?php include './src/navbar.php'; ?>

    <section id="isi" class="container-fluid mt-3">



        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Alternatif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Your form for adding data goes here -->
                            <form action="./src/aksicrud.php" method="post" class=" container max-w-5xl mx-auto mt-12">
                            <div class="text-center font-weight-bold fs-4 text-primary">Data Alternatif</div>
                            <hr class="w-12 h-1 outline-none border-none bg-gradient-to-r from-primary via-primary to-secondary rounded-full mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Alternatif<span class="text-danger">*</span></label>
                                        <input type="text" name="tkode" readonly class="form-control" value="<?= $nextIdAlternatif; ?>" />
                                        <input type="text" name="tkode1" readonly class="form-control d-none" value="<?= $IdAlternatif; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input type="text" name="tketeranganalternatif" value="<?= $vketerangan ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Alternatif<span class="text-danger">*</span></label>
                                        <input type="text" name="tnamaalternatif" required value="<?= $vnama ?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="balternatif" class="btn btn-primary">Simpan</button>
                                    <a href="./alternatif.php" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                            <!-- Form fields for adding data -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="tabel">
        <div class="mb-3 container">
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addModal">Tambah Alternatif</button>
        </div>
        <div class="container my-8 mx-auto shadow-md p-3 rounded-lg">
            <table class="table text-center" id="myTable">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Kode Alternatif</th>
                        <th>Nama Alternatif</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT * FROM tbalternatif";
                    $query = mysqli_query($koneksi, $q) or die(mysqli_error($koneksi));
                    if (mysqli_num_rows($query) > 0) {
                        // Menampilkan data jika ada
                        while ($data = mysqli_fetch_array($query)) :
                    ?>
                            <!-- row 1 -->
                            <tr>
                                <th><?= "A" . $data['idalternatif'] ?></th>
                                <th><?= $data['namaalternatif'] ?></th>
                                <th><?= $data['keteranganalternatif'] ?></th>
                                <th>
                                    <a href="./edit_alternatif.php?id=<?= $data['idalternatif'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="./alternatif.php?hal=hapus&id=<?= $data['idalternatif'] ?>" class="btn btn-sm btn-secondary">Hapus</a>
                                </th>
                            </tr>
                    <?php
                        endwhile;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
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
