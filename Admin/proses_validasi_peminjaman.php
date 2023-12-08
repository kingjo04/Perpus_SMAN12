<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $idPeminjaman = mysqli_real_escape_string($conn, $_POST['id']);

    // Ambil data dari tabel peminjaman
    $queryPeminjaman = "SELECT * FROM peminjaman WHERE id = '$idPeminjaman'";
    $resultPeminjaman = mysqli_query($conn, $queryPeminjaman);
    if (!$resultPeminjaman) {
        die("Error fetching data: " . mysqli_error($conn));
    }
    
    $dataPeminjaman = mysqli_fetch_assoc($resultPeminjaman);

    // Ambil nomor telepon (no_hp) dari tabel siswa berdasarkan nama peminjam
    $namaPeminjam = $dataPeminjaman['nama'];
    $queryNomorTelepon = "SELECT no_hp FROM siswa WHERE namasiswa = '$namaPeminjam'";
    $resultNomorTelepon = mysqli_query($conn, $queryNomorTelepon);
    $nomorTelepon = "";
    
    if ($resultNomorTelepon) {
        $rowNomorTelepon = mysqli_fetch_assoc($resultNomorTelepon);
        $nomorTelepon = $rowNomorTelepon['no_hp'];
    }

    // Masukkan data ke tabel pengembalian termasuk no_hp
    $queryInsertPengembalian = "INSERT INTO pengembalian (nama, judul, tanggal, tenggat, jumlah, no_hp) VALUES ('{$dataPeminjaman['nama']}', '{$dataPeminjaman['judul']}', '{$dataPeminjaman['tanggal']}', '{$dataPeminjaman['tenggat']}', '{$dataPeminjaman['jumlah']}', '$nomorTelepon')";
    
    if (!mysqli_query($conn, $queryInsertPengembalian)) {
        die("Error inserting data: " . mysqli_error($conn));
    }

    // Hapus data dari tabel peminjaman
    $queryDeletePeminjaman = "DELETE FROM peminjaman WHERE id = '$idPeminjaman'";
    if (!mysqli_query($conn, $queryDeletePeminjaman)) {
        die("Error deleting data: " . mysqli_error($conn));
    }

    // Update status berdasarkan tanggal sekarang
    $tanggalTenggat = strtotime($dataPeminjaman['tenggat']);
    $tanggalSekarang = strtotime(date('Y-m-d'));

    // Bandingkan tanggal tenggat dengan tanggal sekarang
    if ($tanggalSekarang <= $tanggalTenggat) {
        // Tanggal sekarang masih kurang dari atau sama dengan tanggal tenggat
        $status = "belum terlambat";
    } else {
        // Tanggal sekarang sudah melewati tanggal tenggat
        $status = "terlambat";
    }

    // Update status di tabel pengembalian
    $queryUpdateStatus = "UPDATE pengembalian SET status = '$status' WHERE id = LAST_INSERT_ID()";
    if (!mysqli_query($conn, $queryUpdateStatus)) {
        die("Error updating status: " . mysqli_error($conn));
    }
}
header("Location: peminjaman.php?status=success");
exit();

mysqli_close($conn);
?>