<?php
include './src/koneksi.php';

if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if (empty($_SESSION['id'])) {
    header('location:./loginfirst.php');
}

$query = "SELECT idhitung FROM tbhitung ORDER BY idhitung DESC LIMIT 1";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastidsubkriteria = $row["idhitung"];
    // Generate the next idsubkriteria
    $idhitung = ($row["idhitung"] + 1);
} else {
    // If no data exists, default to A1
    $idhitung = "1";
}


if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "hapus") {
        $cek = mysqli_query($koneksi, "SELECT * FROM tbhitung WHERE idalternatif = '$_GET[id]'");
        $data = mysqli_fetch_array($cek);

        if ($data) {
            $hapus = mysqli_query($koneksi, "DELETE FROM tbhitung WHERE idalternatif = '$_GET[id]'");

            if ($hapus) {
                session_start();
                $_SESSION['pesan'] = 'hapus()';
                header('location:./input.php');
            } else {
                session_start();
                $_SESSION['pesan'] = 'gagalhapus()';
                header('location:./input.php');
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

<body onload="<?= @$pesan ?>" class="select-none">
    <?php include './src/navbar.php'; ?>

    <section id="isi">
                <!-- Add Modal -->
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
                            <h1 class="text-center font-weight-bold fs-4 text-primary">Input Nilai</h1>
                            <hr class="w-12 h-1 outline-none border-none bg-gradient-to-r from-primary via-primary to-secondary rounded-full mb-4">
                            </div>
                            <input type="text" name="tidhitung" class="form-control hidden" value="<?= $idhitung ?>" />
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">
                                        Provider<span class="text-danger">*</span>
                                    </label>
                                    <select name="tidalternatif" required class="form-select">
                                        <option value=""></option>
                                        <?php
                                        $query = "SELECT * FROM tbalternatif";
                                        $result = mysqli_query($koneksi, $query);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $idalternatif = $row['idalternatif'];
                                            $namaalternatif = $row['namaalternatif'];
                                            // Membuat opsi untuk combo box
                                            echo "<option value='$idalternatif' >$namaalternatif</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                $query = "SELECT * FROM tbkriteria";
                                $result = mysqli_query($koneksi, $query);
                                while ($data = mysqli_fetch_array($result)) {
                                ?>
                                    <div class="col-md-4">
                                        <label class="form-label">
                                            <?= $data['namakriteria'] ?><span class="text-danger">*</span>
                                        </label>
                                        <select name="<?= 'C' . $data['idkriteria'] ?>" required class="form-select">
                                            <option value=""></option>
                                            <?php
                                            $query = "SELECT * FROM tbsubkriteria WHERE idkriteria = '$data[idkriteria]'";
                                            $results = mysqli_query($koneksi, $query);
                                            while ($rows = mysqli_fetch_array($results)) {
                                                $bobotsubkriteria = $rows['bobotsubkriteria'];
                                                $namasubkriteria = $rows['namasubkriteria'];
                                                // Membuat opsi untuk combo box
                                                echo "<option value='$bobotsubkriteria' >$namasubkriteria</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class="col-md-12 d-flex justify-content-center mt-3">
                                    <button type="submit" name="binput" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-secondary mx-2">Reset</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section id="tabel">
        <div class="mb-3 container">
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addModal">Input Nilai</button>
        </div>
        <div class="container mt-5">
            <table class="table table-striped">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Kode Alternatif</th>
                        <th>Nama Alternatif</th>
                        <?php
                        // Menampilkan header hanya untuk kolom dengan nilai lebih dari 0 di setidaknya satu baris
                        $columnsToShow = [];
                        for ($i = 1; $i <= 5; $i++) {
                            $columnHeader = 'C' . $i;
                            $q = "SELECT COUNT(*) FROM tbhitung WHERE $columnHeader > 0";
                            $query = mysqli_query($koneksi, $q) or die(mysqli_error($koneksi));
                            $hasData = mysqli_fetch_array($query)[0] > 0;

                            if ($hasData) {
                                echo '<th>' . $columnHeader . '</th>';
                                $columnsToShow[] = $columnHeader; // Menyimpan nama kolom yang akan ditampilkan di tbody
                            }
                        }
                        ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT * FROM tbhitung INNER JOIN tbalternatif ON tbhitung.idalternatif = tbalternatif.idalternatif";
                    $query = mysqli_query($koneksi, $q) or die(mysqli_error($koneksi));
                    if (mysqli_num_rows($query) > 0) {
                        // Menampilkan data jika ada
                        while ($data = mysqli_fetch_array($query)) :
                    ?>
                            <tr>
                                <th><?= 'A' . $data['idalternatif'] ?></th>
                                <th><?= $data['namaalternatif'] ?></th>
                                <?php
                                // Menampilkan hanya kolom dari C1 sampai C7 sesuai dengan header
                                foreach ($columnsToShow as $columnName) {
                                    $columnValue = $data[$columnName];
                                    echo '<th>' . $columnValue . '</th>';
                                }
                                ?>
                                <th>
                                    <a href="./input.php?hal=hapus&id=<?= $data['idalternatif'] ?>" class="btn btn-sm btn-secondary">Hapus</a>
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
