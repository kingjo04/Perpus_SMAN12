<?php
session_start();

// Check if the user is not logged in or not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

include 'koneksi.php';

$queryDenda = "SELECT * FROM denda WHERE status = 'belum lunas'";
$resultDenda = mysqli_query($conn, $queryDenda);

if (!$resultDenda) {
    die("Query failed: " . mysqli_error($conn));
}

$dendaPerPengguna = [];

while ($rowDenda = mysqli_fetch_assoc($resultDenda)) {
    $tanggalTenggat = new DateTime($rowDenda['tenggat']);
    $tanggalSekarang = new DateTime();

    if ($tanggalSekarang > $tanggalTenggat) {
        $hariTerlambat = $tanggalSekarang->diff($tanggalTenggat)->days;
        $totalDenda = $hariTerlambat * 1000;

        $dendaPerPengguna[$rowDenda['no_hp']]['nama'] = $rowDenda['nama'];
        $dendaPerPengguna[$rowDenda['no_hp']]['buku'][] = [
            'judul' => $rowDenda['judul'],
            'tenggat' => $rowDenda['tenggat'],
            'total' => $rowDenda['total']
        ];
    }
}

foreach ($dendaPerPengguna as $no_hp => $data) {
    $message = "{$data['nama']}, \n \nAnda telah memasuki tenggat denda untuk buku berikut:\n";
    
    foreach ($data['buku'] as $buku) {
        $message .= "\nJudul Buku: {$buku['judul']}\nTenggat: {$buku['tenggat']}\nDenda: Rp. {$buku['total']}\n";
    }

    // Initialize cURL session for Fontee API
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('target' => $no_hp, 'message' => $message),
        CURLOPT_HTTPHEADER => array(
            'Authorization: jamZEby7jV@e3724Ii7q'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    // Handle the response accordingly
}

header("Location: denda.php?status=success");
    exit();
    
mysqli_close($conn);
?>