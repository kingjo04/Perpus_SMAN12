

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
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
                                    <a href="dashboard.php">Dashboard</a>
                                </div>';
    ?>

        <!-- Include the header.php file -->
        <?php include 'header.php'; ?>

        <!-- Konten -->
        <div class="content" id="dashboardContent">

            <h1 style="font-size: 15px; position: absolute; left: 350px; top: 110px;">
                Dashboard >
            </h1>
            <!-- Stock Box -->

            <!-- Stock Box -->
            <table
                style="position: absolute; left: 350px; top: 205px; width: 409px; height: 149px; border-radius: 20px; background-color: #9EDDFF;">
                <thead>
                    <tr>
                        <td
                            style="text-align: center; padding: 10px; font-size: 22px; font-weight: bold; justify-content:center">
                            Stock Buku
                        </td>
                        <td style="text-align: center; padding: 10px; font-size: 22px; font-weight: bold;">
                            <img src="assets/dashboard/bukuhitam.png" alt="buku hitam" style="scale: 0.5;">
                            <?php echo $totalStock; ?>
                        </td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


            <!-- Anggota Box -->

            <table
                style="position: absolute; left : 800px; top: 205px; width: 409px; height: 149px; border-radius: 20px; background-color: #9EDDFF;">
                <thead>
                    <td
                        style="text-align: center; padding: 10px; font-size : 22px; font-weight:bold; justify-content:center">
                        Anggota
                    </td>
                    <td style="text-align: center; padding: 10px; font-size : 22px; font-weight:bold;"> <img
                            src="assets/dashboard/orghitam.png" alt="org hitam" style="scale: 1;">
                        <?php echo $totalSiswa; ?>
                    </td>
                </thead>
            </table>

            <!-- Laporan Box -->
            <h1 style="font-size: 22px; position: absolute; left: 350px; top: 430px;">
                Laporan >
            </h1>

            <!-- Laporan Box -->
            <table
                style="position: absolute; left: 350px; top: 490px; width: 858px; height: 149px; border-radius: 20px; background-color: #9EDDFF;">
                <h3 style=" position: absolute; left: 60px; top: 28px; ">
                    <thead>
                        <tr>
                            <!-- Kolom " no" -->
                            <td style="text-align: center; padding: 10px; font-size : 22px; font-weight:bold;">
                                Peminjaman</td>

                            <!-- Kolom "sampul" -->
                            <td style="text-align: center; padding: 10px; font-size : 22px; font-weight:bold;">
                                Pengembalian</td>

                            <!-- Kolom "judul" -->
                            <td style="text-align: center; padding: 10px; font-size : 22px; font-weight:bold;">Denda
                            </td>
                        </tr>
                    </thead>
                    <tbody style="text-align:center;">
                        <td style="font-size:32px; font-weight:bold;"><?php echo $totalPeminjaman; ?></td>
                        <td style="font-size:32px; font-weight:bold;"><?php echo $totalPengembalian; ?></td>
                        <td style="font-size:32px; font-weight:bold;">
                            <?php echo 'Rp.' . number_format($totalDenda, 0, ',', '.'); ?></td>

                    </tbody>
            </table>

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
