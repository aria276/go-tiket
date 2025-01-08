<?php
session_start();
include('db.php');
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM userss WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

      
        if (password_verify($password, $user['password'])) {
            echo 'Password benar';  
          
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: pesan.php");
            }
            exit();
        } else {
            echo 'Password salah';  
            $error = 'Email atau Password salah.';
        }
    } else {
        $error = 'Email atau Password salah.';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1>Login Akun</h1>
        <p>Akses pemesanan kamar hotel dan tiket wisata favorit Anda!</p>
    </header>

    <main>
        <div class="form-container">
            <h2>Masuk ke Akun Anda</h2>

            <?php if (!empty($error)): ?>
                <div class="error"><?= $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>

            <p class="register-link">Belum punya akun? 
                <button class="btn-Daftar" onclick="window.location.href='register.php';">Daftar Sekarang</button>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Tiket-Go. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
