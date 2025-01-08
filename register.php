<?php
session_start();
include('db.php'); 
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
   
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];  

   
    if (empty($nama) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $error = 'Semua kolom harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } else {
        
        $query = "SELECT * FROM userss WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error = 'Email sudah terdaftar!';
        } else {
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $query = "INSERT INTO userss (nama, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $hashed_password, $role);
            
            if (mysqli_stmt_execute($stmt)) {
              
                $user_id = mysqli_insert_id($conn);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role;

                
                if ($role == 'admin') {
                    header('Location: admin_dashboard.php');  
                } else {
                    header('Location: pesan.php'); 
                }
                exit();
            } else {
         
                $error = 'Gagal mendaftar, coba lagi nanti. ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <h1>Daftar Akun</h1>
        <p>Pesan kamar hotel dan tiket wisata favorit Anda dengan mudah!</p>
    </header>

    <main>
        <div class="form-container">
            <h2>Buat Akun Baru</h2>

            <?php if (!empty($error)): ?>
                <div class="error"><?= $error; ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-group">
                    <label for="role">Pilih Role</label>
                    <select name="role" id="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn">Daftar</button>
            </form>

            <p class="register-link">Sudah punya akun? 
                <button class="btn-login" onclick="window.location.href='login.php';">Login Sekarang</button>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Tiket-Go. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
