<?php
include_once 'database.php';

$success = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Melakukan sanitasi input untuk mencegah XSS
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
    $capacity = htmlspecialchars($_POST['capacity'], ENT_QUOTES, 'UTF-8');
    $opening_hour = htmlspecialchars($_POST['opening_hour'], ENT_QUOTES, 'UTF-8');
    $closing_hour = htmlspecialchars($_POST['closing_hour'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8'); // Mendapatkan nilai status dari dropdown

    $db = new database();
    $conn = $db->getConnection();

    $query = "INSERT INTO gudang (name, location, capacity, opening_hour, closing_hour, status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $location, $capacity, $opening_hour, $closing_hour, $status]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gudang Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Gudang Baru</h1>
        <form id ="gudangForm" method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Gudang</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Kapasitas</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>
            <div class="mb-3">
                <label for="opening_hour" class="form-label">Jam Buka</label>
                <input type="time" class="form-control" id="opening_hour" name="opening_hour" required>
            </div>
            <div class="mb-3">
                <label for="closing_hour" class="form-label">Jam Tutup</label>
                <input type="time" class="form-control" id="closing_hour" name="closing_hour" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
            </div>
            <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button> 
        </form>
    </div>
    <script>
        document.getElementById('submitBtn').addEventListener('click', function(event) {
            // Munculkan SweetAlert sebelum mengirim form
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menambahkan gudang baru!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, kirim form
                    document.getElementById('gudangForm').submit();
                }
            });
        });
    </script>
</body>
</html>
