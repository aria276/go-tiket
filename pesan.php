<?php
session_start();

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kamar dan Tempat Wisata</title>
    <link rel="stylesheet" href="pesan.css">
</head>
<body>
    <header>
        <h1>Booking Kamar dan Tempat Wisata</h1>
        <p>Pesan kamar hotel dan tiket tempat wisata dengan mudah!</p>
    </header>

    <main>
    <section>
    <h2>Booking Kamar</h2>
  
    <form action="confirmation.php" method="POST">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user_name); ?>" required>

        <label for="email_kamar">Email:</label>
        <input type="email" id="email_kamar" name="email" value="<?= htmlspecialchars($user_email); ?>" required>

        <label for="kamar">Jenis Kamar:</label>
        <div class="image-container">
            <div class="image-item">
                <input type="radio" id="standard" name="kamar" value="standard" required>
                <label for="standard">Standard</label>
                <img src="STANDART.jpg" alt="Standard Room" class="image-preview">
                <p class="image-description">Kamar dengan fasilitas standar yang nyaman untuk penginapan singkat.</p>
                <p class="price">Harga: Rp 500.000/malam</p>
            </div>
            <div class="image-item">
                <input type="radio" id="deluxe" name="kamar" value="deluxe" required>
                <label for="deluxe">Deluxe</label>
                <img src="DELUXE.jpeg" alt="Deluxe Room" class="image-preview">
                <p class="image-description">Kamar Deluxe dengan ruang lebih luas dan fasilitas premium.</p>
                <p class="price">Harga: Rp 1.000.000/malam</p>
            </div>
            <div class="image-item">
                <input type="radio" id="suite" name="kamar" value="suite" required>
                <label for="suite">Suite</label>
                <img src="SUITE.jpg" alt="Suite Room" class="image-preview">
                <p class="image-description">Kamar Suite mewah dengan pemandangan indah dan fasilitas terbaik.</p>
                <p class="price">Harga: Rp 2.000.000/malam</p>
            </div>
        </div>

        <label for="tanggal_kamar">Tanggal Check-in:</label>
        <input type="date" id="tanggal_kamar" name="tanggal" required>

        <label for="jumlah_kamar">Jumlah Kamar:</label>
        <input type="number" id="jumlah_kamar" name="jumlah_kamar" min="1" required>

        <label for="durasi">Durasi Menginap (malam):</label>
        <input type="number" id="durasi" name="durasi" min="1" required>

        <button type="submit" name="submit_booking">Pesan Kamar</button>
    </form>
</section>
<section>
    <h2>Booking Tempat Wisata</h2>
    <form action="proses_booking.php" method="POST">
        <label for="nama_wisata">Nama Lengkap:</label>
        <input type="text" id="nama_wisata" name="nama_wisata" value="<?= htmlspecialchars($user_name); ?>" required>

        <label for="email_wisata">Email:</label>
        <input type="email" id="email_wisata" name="email_wisata" value="<?= htmlspecialchars($user_email); ?>" required>

        <label for="wisata">Pilih Tempat Wisata:</label>
        <div class="image-container">
            <div class="image-item">
                <input type="radio" id="pantai" name="wisata" value="pantai" required>
                <label for="pantai">Pantai</label>
                <img src="PANGASAN.webp" alt="Pantai" class="image-preview">
                <p class="image-description">Nikmati suasana pantai yang indah dan pasir putih yang menenangkan.</p>
                <p class="price">Harga: Rp 15.000/tiket</p>
            </div>
            <div class="image-item">
                <input type="radio" id="gunung" name="wisata" value="gunung" required>
                <label for="gunung">Gunung</label>
                <img src="BROMO.jpeg" alt="Gunung" class="image-preview">
                <p class="image-description">Petualangan mendaki gunung dengan pemandangan alam yang luar biasa.</p>
                <p class="price">Harga: Rp 50.000/tiket</p>
            </div>
            <div class="image-item">
                <input type="radio" id="taman" name="wisata" value="taman" required>
                <label for="taman">Taman Wisata</label>
                <img src="BALURAN.png" alt="Taman Wisata" class="image-preview">
                <p class="image-description">Taman hiburan yang cocok untuk liburan keluarga dengan berbagai wahana seru.</p>
                <p class="price">Harga: Rp 25.000/tiket</p>
            </div>
        </div>

        <label for="tanggal_wisata">Tanggal Kunjungan:</label>
        <input type="date" id="tanggal_wisata" name="tanggal_wisata" required>

        <label for="jumlah_tiket">Jumlah Tiket:</label>
        <input type="number" id="jumlah_tiket" name="jumlah_tiket" min="1" required>

        <button type="submit" name="submit_wisata">Pesan Tiket</button>
    </form>
</section>
    </main>

    <footer>
        <p>&copy; 2024 Tiket-Go. Semua Hak Dilindungi.</p>

        <?php if (isset($_SESSION['user_name'])): ?>
            <form action="logout.php" method="POST">
                <button type="submit" name="logout" class="btn-logout">Logout</button>
            </form>
        <?php endif; ?>
    </footer>
</body>
</html>
