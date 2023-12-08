<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Pengecekan login untuk admin
    $queryAdmin = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $queryAdmin->bind_param("s", $username);
    $queryAdmin->execute();
    $resultAdmin = $queryAdmin->get_result();

    // Pengecekan login untuk siswa
    $querySiswa = $conn->prepare("SELECT * FROM siswa WHERE username = ?");
    $querySiswa->bind_param("s", $username);
    $querySiswa->execute();
    $resultSiswa = $querySiswa->get_result();

    // Setelah memverifikasi username dan password
if ($resultAdmin->num_rows == 1) {
    $user = $resultAdmin->fetch_assoc();
    if ($password == $user['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin'; // Menambahkan peran ke sesi
        header("location: ../Admin/dashboard.php");
    } else {
        // Handle error password salah
    }
} elseif ($resultSiswa->num_rows == 1) {
    $user = $resultSiswa->fetch_assoc();
    if ($password == $user['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'siswa'; // Menambahkan peran ke sesi
        header("location: ../user/homepagelogin.php");
    } else {
        // Handle error password salah
    }
} else {
    // Handle error pengguna tidak ditemukan
}


    $queryAdmin->close();
    $querySiswa->close();
    $conn->close();
}
?>