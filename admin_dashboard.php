<?php
session_start();
include('db.php'); 


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}


if (isset($_GET['name']) && isset($_GET['email']) && isset($_GET['room_type']) && isset($_GET['check_in_date']) && isset($_GET['num_rooms']) && isset($_GET['duration']) && isset($_GET['total_price']) && isset($_GET['kode_booking'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $room_type = $_GET['room_type'];
    $check_in_date = $_GET['check_in_date'];
    $num_rooms = $_GET['num_rooms'];
    $duration = $_GET['duration'];
    $total_price = $_GET['total_price'];
    $kode_booking = $_GET['kode_booking'];


    $query_user = "SELECT * FROM userss WHERE email = ?";
    $stmt_user = mysqli_prepare($conn, $query_user);
    mysqli_stmt_bind_param($stmt_user, "s", $email);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    
    if (mysqli_num_rows($result_user) == 0) {
        echo "User dengan email ini tidak ditemukan. Silakan tambah user terlebih dahulu.";
    } else {
    
        $user = mysqli_fetch_assoc($result_user);
        $user_id = $user['id'];
        $query = "INSERT INTO bookingss (name, email, room_type, check_in_date, num_rooms, duration, total_price, user_id, jenis_booking, detail_booking, tanggal, harga, kode_booking) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssiisssssdss", $name, $email, $room_type, $check_in_date, $num_rooms, $duration, $total_price, $user_id, $room_type, 'Detail booking belum ada', $check_in_date, $total_price, $kode_booking);

        if (mysqli_stmt_execute($stmt)) {
            echo "Data pemesanan berhasil disimpan!";
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }

 
    mysqli_stmt_close($stmt_user);
}
$query = "SELECT * FROM bookingss ORDER BY id DESC"; 
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn)); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css"> 
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h3>Riwayat Pemesanan</h3>
    <h3>Daftar Pemesanan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jenis Kamar</th>
                <th>Tanggal Check-in</th>
                <th>Jumlah Kamar</th>
                <th>Durasi</th>
                <th>Total Harga</th>
                <th>Kode Booking</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['room_type']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['check_in_date']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['num_rooms']) . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['duration']) . " malam</td>"; 
                    echo "<td>Rp " . number_format($row['total_price'], 0, ',', '.') . "</td>"; 
                    echo "<td>" . htmlspecialchars($row['kode_booking']) . "</td>"; 
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>Tidak ada data pemesanan.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <form action="logout.php" method="POST">
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);  
?>
