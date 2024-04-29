<?php
session_start();
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK | Metode MOOSRA</title>
    <?php include './src/header.php'; ?>
</head>
<body onload="<?= @$pesan ?>">
<section id="isi">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="./src/ceklogin.php" method="post">
                            <h1>LOGIN</h1>
                            <div class="mb-3">
                                <label for="tnim" class="form-label">Username</label>
                                <input type="text" name="tnim" id="tnim" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="tpassword" class="form-label">Password</label>
                                <input type="password" name="tpassword" id="tpassword" class="form-control">
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <button type="submit" name="blogin" class="btn btn-primary w-100 mb-2">Login</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" name="bguest" class="btn btn-secondary w-100 mb-2">Guest</button>
                                </div>
                                <input type="hidden" name="login_type" value="user">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
