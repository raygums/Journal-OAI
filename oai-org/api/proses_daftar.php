<?php
// Pengaturan Database
$host = "localhost"; $user = "root"; $pass = ""; $db = "oai";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$name = $_POST['name'];
$nip = $_POST['nip'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi sederhana
if (empty($name) || empty($nip) || empty($email) || empty($password)) {
    die("Semua field harus diisi.");
}

// Hash password untuk keamanan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Masukkan ke database dengan role default 'user'
$stmt = $conn->prepare("INSERT INTO users (name, nip, email, password, role) VALUES (?, ?, ?, ?, 'user')");
$stmt->bind_param("ssss", $name, $nip, $email, $hashed_password);

if ($stmt->execute()) {
    echo "<h1>Registrasi Berhasil!</h1>";
    echo "<p>Akun Anda telah berhasil dibuat. Silakan kembali untuk login.</p>";
    echo "<a href='../login.html'>Kembali ke Halaman Login</a>";
} else {
    echo "<h1>Error!</h1>";
    echo "<p>Terjadi kesalahan saat registrasi: " . $stmt->error . "</p>";
    echo "<a href='../login.html'>Coba Lagi</a>";
}

$stmt->close();
$conn->close();
?>