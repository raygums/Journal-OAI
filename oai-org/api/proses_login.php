<?php
// Wajib ada di awal untuk memulai atau melanjutkan session
session_start();

// Pengaturan Database
$host = "localhost"; $user = "root"; $pass = ""; $db = "oai";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) { 
    die("Koneksi gagal: " . $conn->connect_error); 
}

$email = $_POST['email'];
$password = $_POST['password'];

// Ambil data user dari DB
$stmt = $conn->prepare("SELECT nip, nama, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user_data = $result->fetch_assoc();

    // Verifikasi password yang di-hash
    if (password_verify($password, $user_data['password'])) {
        // Password cocok, simpan data ke session
        $_SESSION['user_id'] = $user_data['nip'];
        $_SESSION['user_name'] = $user_data['nama'];
        $_SESSION['user_role'] = $user_data['role'];

        // Arahkan ke dashboard admin jika role-nya admin
        if ($user_data['role'] === 'admin') {
            header("Location: ../dashboard_admin.php");
        } else {
            // Arahkan ke halaman utama jika user biasa
            header("Location: ../index.php");
        }
        exit(); // Hentikan eksekusi skrip setelah redirect
    }
}

// Jika login gagal (email tidak ditemukan atau password salah)
echo "<h1>Login Gagal</h1>";
echo "<p>Email atau password yang Anda masukkan salah.</p>";
echo "<a href='../login.html'>Coba Lagi</a>";

$stmt->close();
$conn->close();
?>