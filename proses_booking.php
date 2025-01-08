<?php
$host = 'localhost';
$dbname = 'bookingtiket.id';
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    exit();
}


$nama = isset($_GET['nama']) ? htmlspecialchars($_GET['nama']) : 'Tidak Diketahui';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '-';
$jenis_booking = isset($_GET['jenis_booking']) ? htmlspecialchars($_GET['jenis_booking']) : 'Tidak Diketahui';
$tanggal = isset($_GET['tanggal']) ? htmlspecialchars($_GET['tanggal']) : '-';
$harga = isset($_GET['harga']) ? (int)$_GET['harga'] : 0;
$total_harga = isset($_GET['total_harga']) ? (int)$_GET['total_harga'] : 0;
$kode_booking = uniqid('BOOK-', true);


$room_type = ($jenis_booking === 'tiket_wisata') ? 'N/A' : 'standard';
$detail_booking = ($jenis_booking === 'tiket_wisata') ? 'wisata' : 'standard';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
       
        if ($jenis_booking === 'kamar') {
            $stmt = $pdo->prepare("INSERT INTO bookingss (name, email, room_type, check_in_date, num_rooms, duration, total_price, jenis_booking, detail_booking, tanggal, harga, kode_booking) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $email, $room_type, $tanggal, 1, 1, $total_harga, 'kamar', 'standard', $tanggal, $harga, $kode_booking]);
        } 
      
        else if ($jenis_booking === 'tiket_wisata') {
            $stmt = $pdo->prepare("INSERT INTO bookingss (name, email, room_type, check_in_date, num_rooms, duration, total_price, jenis_booking, detail_booking, tanggal, harga, kode_booking) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $email, $room_type, $tanggal, 1, 1, $total_harga, 'wisata', 'wisata', $tanggal, $harga, $kode_booking]);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pemesanan</title>
    <link rel="stylesheet" href="resi.css">
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Resi Pemesanan</h1>
            <p><strong>Kode Booking:</strong> <?php echo $kode_booking; ?></p> 
        </div>

        <div class="receipt-info">
            <p><span class="bold">Nama:</span> <?php echo htmlspecialchars($nama); ?></p>
            <p><span class="bold">Email:</span> <?php echo htmlspecialchars($email); ?></p>
            <p><span class="bold">Jenis Booking:</span> <?php echo htmlspecialchars($jenis_booking); ?></p>
            <p><span class="bold">Tanggal Check-In:</span> <?php echo htmlspecialchars($tanggal); ?></p>
            <p><span class="bold">Total Harga:</span> Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
        </div>

        <div class="receipt-buttons">
            <button onclick="window.print()">Cetak</button>
            <button onclick="window.location.href='pesan.php';">Kembali</button>
        </div>
    </div>
</body>
</html>
