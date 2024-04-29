<?php
// Include the connection file
include './src/koneksi.php';

// Check if the user is logged in
if (empty($_SESSION['id'])) {
    header('location:./loginfirst.php');
    exit(); // Ensure script stops execution after redirection
}

// Initialize variables
$vnama = "";
$vketerangan = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $id = $_POST['tkode1']; // Assuming this is the ID of the alternative
    $nama = mysqli_real_escape_string($koneksi, $_POST['tnamaalternatif']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['tketeranganalternatif']);

    // Update data in the database
    $query = "UPDATE tbalternatif SET namaalternatif = '$nama', keteranganalternatif = '$keterangan' WHERE idalternatif = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect to the alternatives page after successful update
        header('location:./alternatif.php');
        exit(); // Ensure script stops execution after redirection
    } else {
        // Handle update error
        echo "Error updating record: " . mysqli_error($koneksi);
    }
} else {
    // Retrieve data for the selected alternative
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $tampil = mysqli_query($koneksi, "SELECT * FROM tbalternatif WHERE idalternatif = '$id'");
        $data = mysqli_fetch_array($tampil);

        if ($data) {
            $vnama = $data['namaalternatif'];
            $vketerangan = $data['keteranganalternatif'];
        } else {
            echo "Alternative not found.";
            exit(); // Stop execution if alternative not found
        }
    } else {
        echo "Alternative ID not provided.";
        exit(); // Stop execution if alternative ID not provided
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alternatif</title>
    <?php include './src/header.php'; ?>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include './src/navbar.php'; ?>

    <div class="container mt-3">
        <h2>Edit Alternatif</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="tkode1" value="<?= $id; ?>">
            <div class="form-group">
                <label for="tnamaalternatif">Nama Alternatif:</label>
                <input type="text" class="form-control" id="tnamaalternatif" name="tnamaalternatif" value="<?= $vnama; ?>" required>
            </div>
            <div class="form-group">
                <label for="tketeranganalternatif">Keterangan:</label>
                <input type="text" class="form-control" id="tketeranganalternatif" name="tketeranganalternatif" value="<?= $vketerangan; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="./alternatif.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
