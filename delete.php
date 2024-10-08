<?php
    require_once 'database.php';
    require_once 'gudang.php';

    $database = new Database();
    $db = $database->getConnection();

    $gudang = new Gudang($db); // Perbaikan kapitalisasi kelas

    // Mendapatkan ID dari URL
    $gudang->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');
    
    // Menghapus gudang berdasarkan ID
    if($gudang->delete()) {
        header("Location: index.php"); // Redirect jika berhasil dihapus
        exit;
    } else {
        echo "ERROR: Unable to delete the record."; // Pesan jika gagal menghapus
    }
?>
