<?php

session_start();

// Cek jika pengguna tidak login atau bukan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'siswa') {
    header('Location: error.php');
    exit();
}


// Menggabungkan koneksi dan query untuk mendapatkan data buku dari database
include 'config.php';
$queryBuku = $conn->query("SELECT * FROM buku");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIPERPUS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="css/homepagelogin.css" />
    <style>
    /* Tambahkan CSS untuk menyesuaikan tata letak tombol Tambahkan */
    .boxcard .box .stok-text {
        margin-bottom: 10px;
        /* Sesuaikan dengan nilai yang sesuai */
    }

    .boxcard .box .btn {
        margin-top: 10px;
        cursor: pointer;
        /* Sesuaikan dengan nilai yang sesuai */
    }
    </style>



    <style>
    /* Aturan CSS untuk mengatur gambar */
    .boxcard .box img {
        max-width: 100%;
        /* batasi lebar gambar agar tidak melebihi kontainernya */
        max-height: 150px;
        /* batasi tinggi gambar */
        object-fit: contain;
        /* pastikan gambar tidak terdistorsi */
        margin: 25px;
        /* beri ruang di atas dan bawah gambar */
        display: block;
        /* membuat gambar menjadi block-level element */

    }
    </style>

</head>

<body>
    <header class="header">
        <a href="#" class="logo"><img src="img/sman12.png" alt="" /></a>
        <nav class="navbar">
            <a href="">Beranda</a>
            <div class="dropdown">
                <a href="#">Kategori <i class="bx bx-chevron-down"></i> </a>
                <div class="dropdown-content">
                    <a href="pendidikan.php">Pendidikan</a>
                    <a href="fiksi.php">Fiksi</a>
                    <a href="nonfiksi.php">Non-Fiksi</a>
                </div>
            </div>
            <a href="profile.php">Profil Saya</a>
            <a href="../backend/logout.php">Keluar</a>
        </nav>

        <div class="icons">
            <div class="dropdownicons">
                <a href="keranjangpinjam.php" style="color: white"><i class="bx bxs-cart-alt"></i></a>
            </div>
        </div>
        </div>
    </header>

    <section class="home">
        <div class="content">
            <h3>Selamat Datang !</h3>
            <h3>Mau Baca Buku Apa Hari Ini ?</h3>
            <form action="">
                <div class="form-input">
                    <input type="search" placeholder="cari bukumu..." />
                    <button type="submit" class="search-btn">
                        <i class="bx bx-search-alt"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="imghome">
            <img src="img/book.png" alt="" />
        </div>
    </section>

    <section class="card" id="card">
        <div class="text">
            <h3>Pilih Bukunya dan Tambahkan Ke Keranjang Mu</h3>
            <p>
                Pinjam buku kini jadi lebih mudah. Ayok pinjam dan baca buku sekarang!
            </p>
        </div>
        <div class="boxcard">
            <?php
            // Loop through hasil query dan tampilkan data buku di dalam box
while ($row = $queryBuku->fetch_assoc()) {
?>
            <div class="box">
                <!-- detail buku -->
                <img src="uploads/<?php echo $row['sampul']; ?>" alt="">
                <p><?php echo $row['judul_buku']; ?></p>
                <p class="stok-text">Stok Tersedia: <?php echo $row['jumlah']; ?></p>

                <!-- Form untuk menambahkan buku ke keranjang -->
                <form action="tambah_ke_keranjang.php" method="post">
                    <input type="hidden" name="id_buku" value="<?php echo $row['id']; ?>">
                    <input type="submit" class="btn" value="Tambahkan">
                </form>
            </div>



            <?php
            }
            ?>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        var currentIndex = 0;
        var numBooks = $(".boxcard .box").length;
        var visibleBooks = 4;

        $("#prevBtn").click(function() {
            if (currentIndex > 0) {
                currentIndex -= visibleBooks;
                if (currentIndex < 0) {
                    currentIndex = 0;
                }
                updateBooks();
            }
        });

        $("#nextBtn").click(function() {
            if (currentIndex + visibleBooks < numBooks) {
                currentIndex += visibleBooks;
                updateBooks();
            }
        });

        function updateBooks() {
            var translateX = -currentIndex * (200 + 20) + "px";
            $(".boxcard").css("transform", "translateX(" + translateX + ")");
        }
    });

    function logout() {
        // Add your logout logic here
        alert("Anda Telah Logout");

        // Hapus session dan redirect ke halaman login
        window.location.href = "../BackEnd/logout.php";
    }
    </script>
</body>

</html>