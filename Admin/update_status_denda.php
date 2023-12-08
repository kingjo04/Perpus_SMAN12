<?php
include 'koneksi.php';

if (isset($_POST['id_denda'])) {
    $idDenda = mysqli_real_escape_string($conn, $_POST['id_denda']);

    // Query untuk mengupdate status denda menjadi "lunas"
    $queryUpdate = "UPDATE denda SET status = 'lunas' WHERE id = '$idDenda'";

    // Eksekusi query UPDATE
    if (mysqli_query($conn, $queryUpdate)) {
        // Mendapatkan nama pengguna (username) dari tabel denda berdasarkan ID
        $queryGetUsername = "SELECT nama FROM denda WHERE id = '$idDenda'";
        $resultUsername = mysqli_query($conn, $queryGetUsername);

        if ($resultUsername) {
            $rowUsername = mysqli_fetch_assoc($resultUsername);
            $username = $rowUsername['nama'];

            // Query untuk menghapus data di tabel pengembalian berdasarkan nama pengguna (username)
            $queryDeletePengembalian = "DELETE FROM pengembalian WHERE nama = '$username'";
            
            // Eksekusi query DELETE
            if (mysqli_query($conn, $queryDeletePengembalian)) {
                // Redirect ke halaman denda setelah berhasil mengupdate dan menghapus data
                header('Location: denda.php');
                exit();
            } else {
                echo "Error saat menghapus data pengembalian: " . mysqli_error($conn);
            }
        } else {
            echo "Error saat mengambil nama pengguna: " . mysqli_error($conn);
        }
    } else {
        echo "Error saat mengupdate status denda: " . mysqli_error($conn);
    }
} else {
    // Jika id_denda tidak ada, redirect ke halaman denda
    header('Location: denda.php');
    exit();
}

// Tutup koneksi database
mysqli_close($conn);
?>