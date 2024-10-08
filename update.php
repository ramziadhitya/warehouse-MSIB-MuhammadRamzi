<?php
include_once 'database.php';

$id = $_GET['id'];

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM gudang WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);
$gudang = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Melakukan sanitasi input untuk mencegah XSS
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
    $capacity = htmlspecialchars($_POST['capacity'], ENT_QUOTES, 'UTF-8');
    $opening_hour = htmlspecialchars($_POST['opening_hour'], ENT_QUOTES, 'UTF-8');
    $closing_hour = htmlspecialchars($_POST['closing_hour'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8'); // Mendapatkan nilai status dari dropdown

    $query = "UPDATE gudang SET name = ?, location = ?, capacity = ?, opening_hour = ?, closing_hour = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$name, $location, $capacity, $opening_hour, $closing_hour, $status, $id]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Gudang</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Gudang</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($gudang['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($gudang['location'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Kapasitas</label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo htmlspecialchars($gudang['capacity'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="opening_hour" class="form-label">Jam Buka</label>
                <input type="time" class="form-control" id="opening_hour" name="opening_hour" value="<?php echo htmlspecialchars($gudang['opening_hour'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="closing_hour" class="form-label">Jam Tutup</label>
                <input type="time" class="form-control" id="closing_hour" name="closing_hour" value="<?php echo htmlspecialchars($gudang['closing_hour'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="aktif" <?php if ($gudang['status'] == 'aktif') echo 'selected'; ?>>Aktif</option>
                    <option value="tidak_aktif" <?php if ($gudang['status'] == 'tidak_aktif') echo 'selected'; ?>>Tidak Aktif</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
