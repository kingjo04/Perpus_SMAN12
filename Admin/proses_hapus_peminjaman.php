<?php
include 'koneksi.php'; // Pastikan 'koneksi.php' adalah file yang benar untuk koneksi database

if (isset($_POST['id'])) {
    $idPeminjaman = mysqli_real_escape_string($conn, $_POST['id']);

    // Query untuk menghapus data peminjaman berdasarkan ID
    $queryHapus = "DELETE FROM peminjaman WHERE id = '$idPeminjaman'";

    // Eksekusi query
    if (mysqli_query($conn, $queryHapus)) {
        echo "Peminjaman berhasil dihapus.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Tutup koneksi database
mysqli_close($conn);

// Redirect ke halaman peminjaman
header('Location: peminjaman.php');
exit();
?>