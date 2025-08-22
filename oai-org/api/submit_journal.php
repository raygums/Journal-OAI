<?php
session_start();

// Keamanan: Pastikan hanya admin yang bisa mengakses skrip ini
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Akses ditolak. Anda harus login sebagai admin.");
}

// Validasi data yang wajib diisi
if (empty($_POST['journal_title']) || empty($_POST['oai_url']) || empty($_POST['fakultas']) || empty($_POST['journal_website_url'])) {
    die("Field yang ditandai bintang (*) wajib diisi. Silakan kembali dan lengkapi form.");
}

// Koneksi ke Database
$host = "localhost"; $user = "root"; $pass = ""; $db = "oai";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Menyiapkan semua variabel dari POST, gunakan null coalescing operator (??) untuk field opsional
$contact_name = $_POST['contact_name'] ?? null;
$contact_email = $_POST['contact_email'] ?? null;
$journal_title = $_POST['journal_title'];
$doi_prefix = $_POST['doi_prefix'] ?? null;
$issn = $_POST['issn'] ?? null;
$eissn = $_POST['eissn'] ?? null;
$publisher_name = $_POST['publisher_name'] ?? null;
$publisher_country = $_POST['publisher_country'] ?? null;
$fakultas = $_POST['fakultas'];
$journal_website_url = $_POST['journal_website_url'];
$start_year = !empty($_POST['start_year']) ? (int)$_POST['start_year'] : null;
$bulan = $_POST['bulan'];
$aim_and_scope = $_POST['aim_and_scope'] ?? null;
$oai_url = $_POST['oai_url'];
$editorial_board_url = $_POST['editorial_board_url'] ?? null;
$google_scholar_url = $_POST['google_scholar_url'] ?? null;
$cover_url = $_POST['cover_url'] ?? null;

// Query INSERT sekarang mencakup semua kolom
$stmt = $conn->prepare(
    "INSERT INTO jurnal_sumber (
        contact_name, contact_email, journal_title, doi_prefix, issn, eissn, 
        publisher_name, publisher_country, fakultas, journal_website_url, 
        start_year, bulan, aim_and_scope, oai_url, editorial_board_url, 
        google_scholar_url, cover_url
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

// Tipe data untuk bind_param: s=string, i=integer
// Sesuaikan jumlah 's' dengan jumlah kolom
$types = "ssssssssssissssss";

// Bind semua parameter ke statement
$stmt->bind_param($types, 
    $contact_name, $contact_email, $journal_title, $doi_prefix, $issn, $eissn,
    $publisher_name, $publisher_country, $fakultas, $journal_website_url,
    $start_year, $bulan, $aim_and_scope, $oai_url, $editorial_board_url,
    $google_scholar_url, $cover_url
);

// Eksekusi query dan berikan feedback
if ($stmt->execute()) {
    echo "<h1>Sukses!</h1>";
    echo "<p>Jurnal '" . htmlspecialchars($journal_title) . "' telah berhasil ditambahkan dengan detail lengkap.</p>";
    echo "<a href='../dashboard_admin.php'>Kembali ke Dashboard</a>";
} else {
    echo "<h1>Error!</h1>";
    echo "<p>Terjadi kesalahan saat menyimpan data: " . $stmt->error . "</p>";
    echo "<a href='../dashboard_admin.php'>Kembali ke Dashboard</a>";
}

$stmt->close();
$conn->close();
?>