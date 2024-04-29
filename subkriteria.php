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
    // If no data exists, default to A1
    $nextidsubkriteria = "C1";
    $idsubkriteria = "1";
}

$data['namarombel'] = "";
$vnamakriteria = "";
$vnamasubkriteria = "";
$vketerangan = "";
$vbobotsubkriteria = "";

if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbsubkriteria WHERE idsubkriteria = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);

        if ($data) {
            $Idkriteria = $data['idkriteria'];
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
        <!-- modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Alternatif</h5>

                    </div>
                    <div class="modal-body">
                        <!-- Your form for adding data goes here -->
                            <form action="./src/aksicrud.php" method="post" class="container mt-5">
                                <div class="text-3xl text-transparent bg-clip-text bg-gradient-to-r from-primary via-secondary to-secondary font-bold">
                                    <h1 class="text-center font-weight-bold fs-4 text-primary">Data Sub Kriteria</h1></div>
                                <hr class="w-12 h-1 outline-none border-none bg-gradient-to-r from-primary via-primary to-secondary rounded-full mb-4">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <span>
                                            <label class="form-label">
                                            Kode Kriteria<span class="text-danger">*</span>
                                            <input type="text" disabled name="tidsubkriteria" class="form-control hidden w-50" value="<?= $idsubkriteria ?>" />
                                        </label>

                                        </span>
                                        <span>

                                        </span>

                                        <select name="tidkriteria" id="tidkriteria" required class="form-select w-50" onchange="populateNamaKriteria()">
                                            <option value=""></option>
                                            <?php
                                            $query = "SELECT * FROM tbkriteria";
                                            $result = mysqli_query($koneksi, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $idKriteria = $row['idkriteria'];
                                                $namaKriteria = $row['namakriteria'];
                                                // Membuat opsi untuk combo box
                                                echo "<option value='$idKriteria' data-nama='$namaKriteria' >C$idKriteria</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">
                                            Nama Kriteria<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="tnamakriteria" id="tnamakriteria" readonly class="form-control input-disabled bg-gray-800 border-2 border-gray-700" />
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">
                                            Nama Sub Kriteria<span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="tnamasubkriteria" required value="<?= $vnamasubkriteria ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            Keterangan
                                        </label>
                                        <input type="text" name="tketerangan" value="<?= $vketerangan ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            Bobot<span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="tbobot" required value="<?= $vbobotsubkriteria ?>" class="form-control" />
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <button type="submit" name="bsubkriteria" class="btn btn-primary mx-2">Simpan</button>
                                        <a href="./subkriteria.php" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-3" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="tabel">
        <div class="mb-3 container">
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addModal">Tambah Sub Kriteria</button>
        </div>
        <div class="container mt-5">
            <table class="table table-striped">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Kode Kriteria</th>
                        <th class="hidden">Kode Sub Kriteria</th>
                        <th>Nama Sub Kriteria</th>
                        <th>Keterangan</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT * FROM tbsubkriteria";
                    $query = mysqli_query($koneksi, $q) or die(mysqli_error($koneksi));
                    if (mysqli_num_rows($query) > 0) {
                        // Menampilkan data jika ada
                        while ($data = mysqli_fetch_array($query)) :
                    ?>
                            <!-- row 1 -->
                            <tr>
                                <th><?= "C" . $data['idkriteria'] ?></th>
                                <th class="hidden"><?= $data['idsubkriteria'] ?></th>
                                <th><?= $data['namasubkriteria'] ?></th>
                                <th><?= $data['keterangansubkriteria'] ?></th>
                                <th><?= $data['bobotsubkriteria'] ?></th>
                                <th>
                                    <a href="./edit_subkriteria.php?hal=edit&id=<?= $data['idsubkriteria'] ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="./subkriteria.php?hal=hapus&id=<?= $data['idsubkriteria'] ?>" class="btn btn-sm btn-secondary">Hapus</a>
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

    <script>
        $(document).ready(function() {
            if (typeof jQuery !== 'undefined') {
                // jQuery is loaded, you can proceed with DataTables initialization
                $('#myTable').DataTable();
            } else {
                console.error('jQuery is not loaded!');
            }
        });

        function populateNamaKriteria() {
            // Mendapatkan nilai terpilih dari dropdown
            var selectedKriteria = document.getElementById("tidkriteria");
            var selectedOption = selectedKriteria.options[selectedKriteria.selectedIndex];
            var selectedNamaKriteria = selectedOption.getAttribute("data-nama");

            // Mengisi nilai ke dalam input dengan id "tnamakriteria"
            document.getElementById("tnamakriteria").value = selectedNamaKriteria;
        }
    </script>
</body>

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

</html>
