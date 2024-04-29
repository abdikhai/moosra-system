<?php
include './src/koneksi.php';

if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

if (empty($_SESSION['id'])) {
    header('location:./loginfirst.php');
}

?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK | Metode MOOSRA</title>
    <?php include './src/header.php'; ?>
    <link rel="stylesheet" href=".src/output.css">
    <style>
    a {
        text-decoration: none;
    }

    </style>
</head>

<body onload="<?= @$pesan ?>" class="select-none">
    <?php include './src/navbar.php'; ?>


    <div class="container-fluid">
        <div class="row justify-content-center align-items-center mt-5">
            <div class="col-sm-12 col-md-8 col-lg-8 align-items-center">
                <div class="text-center font-weight-bold fs-4">Sistem Pendukung Keputusan <br> Menggunakan
                    <span class="text-dark ps-1 ">Metode MOOSRA</span>
                </div>
                <hr class="w-48 h-2 mx-auto border-0 bg-gradient bg-primary-secondary rounded-pill my-4">
                <div class="row justify-content-center w-100">
                    <div class="col-md-4 mb-3">
                        <a href="./alternatif.php" class="card bg-light border-0 hover-bg-primary shadow" >
                            <div class="card-custom"></div>
                            <div class="card-body">
                                <h2 class="card-title ">Alternatif</h2>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM tbalternatif";
                                $result = $koneksi->query($query);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                ?>
                                    <div class="text-center fs-1 text-primary"><?= $row['total'] ?></div>
                                <?php }
                                ?>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="./kriteria.php" class="card bg-light border-0 hover-bg-primary shadow">
                            <div class="card-body">
                                <h2 class="card-title">Kriteria</h2>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM tbkriteria";
                                $result = $koneksi->query($query);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                ?>
                                    <div class="text-center fs-1 text-primary"><?= $row['total'] ?></div>
                                <?php }
                                ?>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="./subkriteria.php" class="card bg-light border-0 hover-bg-primary shadow">
                            <div class="card-body">
                                <h2 class="card-title">Sub Kriteria</h2>
                                <?php
                                $query = "SELECT COUNT(*) as total FROM tbsubkriteria";
                                $result = $koneksi->query($query);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                ?>
                                    <div class="text-center fs-1 text-primary"><?= $row['total'] ?></div>
                                <?php }
                                ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
