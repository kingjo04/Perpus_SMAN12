<?php
session_start();

// Cek jika pengguna tidak login atau bukan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil ID pengembalian dari formulir
    $id_pengembalian = $_POST['id_pengembalian'];

    // Cari data pengembalian berdasarkan ID
    $queryPengembalian = "SELECT * FROM pengembalian WHERE id = $id_pengembalian";
    $resultPengembalian = mysqli_query($conn, $queryPengembalian);

    if (!$resultPengembalian) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Periksa apakah data pengembalian ditemukan
    if (mysqli_num_rows($resultPengembalian) == 1) {
        $rowPengembalian = mysqli_fetch_assoc($resultPengembalian);

        // Hapus data pengembalian dari tabel "pengembalian"
        $queryDeletePengembalian = "DELETE FROM pengembalian WHERE id = $id_pengembalian";
        $resultDeletePengembalian = mysqli_query($conn, $queryDeletePengembalian);

        if (!$resultDeletePengembalian) {
            die("Query failed: " . mysqli_error($conn));
        }

        // Perbarui status denda menjadi "lunas" di tabel "denda"
        $queryUpdateDenda = "UPDATE denda SET status = 'lunas' WHERE nama = '{$rowPengembalian['nama']}' AND judul = '{$rowPengembalian['judul']}'";
        $resultUpdateDenda = mysqli_query($conn, $queryUpdateDenda);

        if (!$resultUpdateDenda) {
            die("Query failed: " . mysqli_error($conn));
        }

        // Redirect kembali ke halaman "Pengembalian" atau halaman lain yang sesuai
        header('Location: pengembalian.php');
        exit();
    } else {
        // Data pengembalian tidak ditemukan
        echo "Data pengembalian tidak ditemukan.";
    }
}

// Tutup koneksi database
mysqli_close($conn);
?>