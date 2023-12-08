<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("location: ../Admin/login.php");
    exit();
}

include 'koneksi.php';

// Fetch data from the "peminjaman" table
$queryRiwayatPinjam = "SELECT * FROM riwayat_pinjam";
$resultRiwayatPinjam = mysqli_query($conn, $queryRiwayatPinjam);

// Check if the query was successful
if (!$resultRiwayatPinjam) {
    die("Query failed: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pinjam</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/global.css">
</head>

<body>
    <div class="container-fluid">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Header -->
        <?php
        // Set a variable to be used in header.php
        $customHeaderContent = '<div class="halamansaatini">
                                    <a href="peminjaman.php">Peminjaman</a>
                                </div>';
    ?>

        <!-- Include the header.php file -->
        <?php include 'header.php'; ?>

        <!-- Konten -->
    </div>

    <div class="content" id="peminjamanContent">
        <h1 style=" font-size: 15px; position: absolute; left: 350px;  top: 110px;">
            Dashboard > Peminjaman > Riwayat Peminjaman
        </h1>

        <h2 style="font-size: 15px; position: absolute; left: 350px; top: 240px;">
            Riwayat Peminjaman
        </h2>

        <form id="carinamaform" style="position: absolute; left: 881px; top: 184px;">
            <label for="search" style="position: relative; display: inline-block;">
                <input type="search" name="search" id="search" placeholder="Search ..."
                    style="width: 300px; height: 32px; border-radius: 20px; box-shadow: inset 0px 4px 4px rgba(0, 0, 0, 0.25);">
                <img src="assets/global/iconsearch.png" alt="Search Icon"
                    style="position: absolute; left: 210px; top: 50%; transform: translateY(-50%) scale(0.2); cursor:pointer">
            </label>
        </form>

        <table style="position: absolute;
              background-color: #9EDDFF;
              border-collapse: collapse;
              border-top-left-radius: 20px;
              border-top-right-radius: 20px;
              width: 838px;
              left: 350px;
              top: 280px;
              
              font-size: 20px;">
            <thead>
                <tr style="font-weight: bold;">
                    <!-- Kolom "No" -->
                    <td style="text-align: center; padding: 10px;">No</td>

                    <!-- Kolom "Nama" -->
                    <td style="text-align: center; padding: 10px;">Nama</td>

                    <!-- Kolom "Nomor" -->
                    <td style="text-align: center; padding: 10px;">Nomor</td>

                    <!-- Kolom "Judul" -->
                    <td style="text-align: center; padding: 10px;">Judul</td>

                    <!-- Kolom "Tanggal" -->
                    <td style="text-align: center; padding: 10px;">Tanggal</td>

                    <!-- Kolom "Tenggat" -->
                    <td style="text-align: center; padding: 10px;">Tenggat</td>

                    <!-- Kolom "jumlah" -->
                    <td style="text-align: center; padding: 10px;">Jumlah</td>
                </tr>
            </thead>
            <tbody>
                <?php
$no = 1; // Initialize a variable to store the sequential number
while ($rowRiwayatPinjam = mysqli_fetch_assoc($resultRiwayatPinjam)) {
    $rowColor = ($no % 2 == 0) ? '#9EDDFF' : '#F4F4F4 '; // Set background color based on row number
    echo "<tr style='background-color: {$rowColor};'>";
    echo "<td style='text-align: center;'>{$no}</td>"; // Display the sequential number
    echo "<td style='text-align: center;'>{$rowRiwayatPinjam['nama']}</td>";
    echo "<td style='text-align: center;'>{$rowRiwayatPinjam['nomor']}</td>";
    echo "<td style='text-align: center;'>{$rowRiwayatPinjam['judul']}</td>";
    echo "<td style='text-align: center;'>{$rowRiwayatPinjam['tanggal']}</td>";
    echo "<td style='text-align: center;'>{$rowRiwayatPinjam['tenggat']}</td>";
    echo "<td style='text-align: center;'>{$rowRiwayatPinjam['jumlah']}</td>";
    $no++; // Increment the sequential number for the next row
}
?>
            </tbody>
        </table>
    </div>



    <!-- Popup -->
    <?php include 'popup.php'; ?>
    </div>

    <script src=" https://code.jquery.com/jquery-3.2.1.slim.min.js "></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js "></script>
    <script src=" https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js "></script>
    <script src=" script/global.js">
    </script>

</body>

</html>