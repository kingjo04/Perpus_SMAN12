<?php

session_start();

// Cek jika pengguna tidak login atau bukan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'siswa') {
    header('Location: error.php');
    exit();
}

include 'config.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM keranjang_pinjam WHERE username = '$username'";
    $result = $conn->query($query);

    // Inisialisasi variabel $Tgl_pinjam dan $Tgl_kembali (sesuai dengan huruf besar/kecil asli)
    $Tgl_pinjam = date('Y-m-d');
    $Tgl_kembali = date('Y-m-d', strtotime('+7 days'));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>keranjang pinjam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="css/keranjangpinjam.css" />
    <style>
    /* Styling for the overlay */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
        z-index: 1;
    }

    /* Styling for the modal */
    .modal {
        background-color: #fff;
        width: 860px;
        height: 135px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .modal p {
        font-size: 18px;
        color: red;
    }

    /* Close button styling */
    .close-btn {
        cursor: pointer;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        border: none;
        border-radius: 5px;
    }
    </style>

    <!-- Di dalam tag <style> Anda -->
    <style>
    /* ... */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    img {
        max-width: 50px;
        /* Sesuaikan lebar maksimum gambar sesuai kebutuhan Anda */
        height: auto;
        display: block;
        /* Agar gambar tetap di tengah dan tidak merusak layout */
        margin: 0 auto;
        /* Menengahkan gambar */
    }

    /* ... */
    </style>



</head>

<body>
    <header class="header">
        <a href="#" class="logo"><img src="img/sman12.png" alt="" /></a>
        <nav class="navbar">
            <a href="homepagelogin.php">Beranda</a>
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
    </header>

    <section class="home">
        <div class="content">
            <h3>Keranjang Buku Mu</h3>
            <h3>Ayo Pinjam Sekarang</h3>
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

    <section class="hero">
        <div class="table-data">
            <div class="head">
                <p class="right" style="bottom: 40px;"><a href="riwayatpinjam.php">riwayat peminjaman</a></p>
            </div>

            <form action="proses_peminjaman.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><input type="checkbox" id="checkAllRows"></th>
                            <th>Sampul</th>
                            <th>Nomor Buku</th>
                            <th>Judul Buku</th>
                            <!-- Tambahkan kolom untuk input tanggal pinjam -->
                            <th>Tanggal Pinjam</th>
                            <!-- Tambahkan kolom untuk input tanggal kembali -->
                            <th>Tanggal Kembali</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$no = 1;
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $no++ . '</td>';
    echo '<td><input type="checkbox" name="bukuDipilih[]" value="' . $row['id'] . '"></td>';
    echo '<td><img src="uploads/' . $row['sampul'] . '" alt=""></td>';
    echo '<td>' . $row['nomor_buku'] . '</td>';
    echo '<td>' . $row['judul_buku'] . '</td>';

    // Inisialisasi variabel $tgl_pinjam dan $tgl_kembali dengan nilai dari database
    $tgl_pinjam = $row['tgl_pinjam'];
    $tgl_kembali = $row['tgl_kembali'];

    echo '<td><input type="date" name="tanggal_pinjam[]" value="' . $tgl_pinjam . '"></td>';
    
    // Tambahkan input tersembunyi untuk tanggal default
    echo '<input type="hidden" name="tanggal_pinjam_default[]" value="' . $tgl_pinjam . '">';
    echo '<td><input type="date" name="tanggal_kembali[]" value="' . $tgl_kembali . '"></td>';
    echo '<input type="hidden" name="tanggal_kembali_default[]" value="' . $tgl_kembali . '">';
    echo '<td>' . $row['jumlah'] . '</td>';
    echo '<td><a href="#" class="button" onclick="hapusBuku(' . $row['id'] . ')">Hapus</a></td>';
    echo '</tr>';
}
?>

                    </tbody>
                </table>

                <div class="btnpinjam" style="position: sticky; left: 2250px; top: 400px;">
                    <button type="submit">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </section>


    <script>
    // Function to open the modal
    function openModal() {
        document.getElementById('myModal').style.display = 'flex';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }
    </script>

    <script>
    // Function to open the modal
    function openModal() {
        document.getElementById('myModal').style.display = 'flex';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    // Function to delete a book from the cart
    function hapusBuku(id) {
        // Tampilkan konfirmasi penghapusan
        if (confirm('Apakah Anda yakin ingin menghapus buku ini dari keranjang?')) {
            // Kirim permintaan AJAX untuk menghapus buku
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'hapus_buku.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Refresh halaman setelah penghapusan berhasil
                    location.reload();
                }
            };
            xhr.send('id=' + id);
        }
    }
    </script>

    <script>
    // Function to select all rows when the "Select All" checkbox is clicked
    document.getElementById('checkAllRows').addEventListener('click', function() {
        var checkboxes = document.getElementsByName('bukuDipilih[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    // ... (your other JavaScript code) ...
    </script>

</body>

</html>