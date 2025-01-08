<?php
session_start();
$nama = $_POST['nama'];
$email = $_POST['email'];
$kamar = $_POST['kamar'];
$tanggal = $_POST['tanggal'];
$jumlah_kamar = $_POST['jumlah_kamar'];
$durasi = $_POST['durasi'];

$harga = 0;
if ($kamar == 'standard') {
    $harga = 500000;
} elseif ($kamar == 'deluxe') {
    $harga = 1000000;
} elseif ($kamar == 'suite') {
    $harga = 2000000;
}
$total_harga = $harga * $jumlah_kamar * $durasi;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan</title>
    <link rel="stylesheet" href="confirmation.css">
</head>
<body>
    <header>
        <h1>Konfirmasi Pemesanan</h1>
        <p>Periksa kembali detail pemesanan Anda sebelum melanjutkan.</p>
    </header>

    <main>
        <section class="confirmation-details">
            <h2>Detail Pemesanan</h2>
            <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Jenis Kamar:</strong> <?= htmlspecialchars($kamar) ?></p>
            <p><strong>Tanggal Check-in:</strong> <?= htmlspecialchars($tanggal) ?></p>
            <p><strong>Jumlah Kamar:</strong> <?= htmlspecialchars($jumlah_kamar) ?></p>
            <p><strong>Durasi Menginap:</strong> <?= htmlspecialchars($durasi) ?> malam</p>
            <p><strong>Total Harga:</strong> Rp <?= number_format($total_harga, 0, ',', '.') ?></p>

            <form action="resi.php" method="GET">
                <input type="hidden" name="nama" value="<?= htmlspecialchars($nama) ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <input type="hidden" name="jenis_booking" value="<?= htmlspecialchars($kamar) ?>">
                <input type="hidden" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>">
                <input type="hidden" name="harga" value="<?= $total_harga ?>">
                <input type="hidden" name="total_harga" value="<?= $total_harga ?>">

                <button type="submit" name="confirm_booking">Lanjutkan ke Pembayaran</button>
            </form>
            <form action="pesan.php" method="get">
                <button type="submit" class="btn-back">Kembali</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Tiket-Go. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
