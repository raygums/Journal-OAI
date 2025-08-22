<?php
echo "<!DOCTYPE html><html><head><title>Proses Panen Otomatis</title></head><body style='font-family: sans-serif; line-height: 1.6;'>";
echo "<h1>Memulai Proses Panen Menyeluruh</h1>";
echo "<a href='dashboard_admin.php'>&laquo; Kembali ke Dashboard</a><hr>";

// --- PENGATURAN DATABASE ---
$host = "localhost";
$user = "root";
$pass = "";
$db = "oai";

// Tingkatkan batas waktu eksekusi
set_time_limit(0); 

// 1. KONEKSI KE DATABASE UNTUK MENGAMBIL DAFTAR JURNAL
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("KONEKSI GAGAL: " . $conn->connect_error);
}
echo "Koneksi database berhasil.<br>";

$jurnal_list_from_db = [];
$sql = "SELECT journal_title, oai_url FROM jurnal_sumber WHERE oai_url IS NOT NULL AND oai_url != ''";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $jurnal_list_from_db[$row['journal_title']] = $row['oai_url'];
    }
} else {
    echo "Tidak ada jurnal dengan URL OAI yang valid di database untuk dipanen.";
    exit;
}

echo "Ditemukan " . count($jurnal_list_from_db) . " jurnal untuk dipanen.<hr>";

// 2. LAKUKAN PROSES PANEN UNTUK SETIAP JURNAL DARI DATABASE
foreach ($jurnal_list_from_db as $nama_jurnal => $base_oai_url) {
    
    echo "<h2>Memproses Jurnal: " . htmlspecialchars($nama_jurnal) . "</h2>";
    echo "<p><strong>Target OAI URL:</strong> " . htmlspecialchars($base_oai_url) . "</p>";

    // --- LOGIKA RESUMPTION TOKEN DIMULAI DI SINI (SAMA SEPERTI SEBELUMNYA) ---
    $resumptionToken = null;
    $isFirstRequest = true;
    $total_new_articles = 0;
    $total_skipped_articles = 0;
    $total_deleted_records = 0;
    $page = 1;

    do {
        echo "<hr><strong>Halaman: " . $page . "</strong><br>";

        // Bangun URL secara dinamis
        if ($isFirstRequest) {
            $oai_url = $base_oai_url . "?verb=ListRecords&metadataPrefix=oai_dc";
            $isFirstRequest = false;
        } else {
            $oai_url = $base_oai_url . "?verb=ListRecords&resumptionToken=" . urlencode($resumptionToken);
        }
        
        echo "URL Target Halaman Ini: " . htmlspecialchars($oai_url) . "<br>";

        // Ambil dan proses XML
        $xmlContent = @file_get_contents($oai_url);
        if (!$xmlContent) { echo "GAGAL mengambil data XML. Lanjut ke jurnal berikutnya.<br>"; break; }
        
        // Menggunakan error handling untuk SimpleXML
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlContent);
        if ($xml === false) { 
            echo "GAGAL parsing XML. Lanjut ke jurnal berikutnya.<br>";
            libxml_clear_errors();
            break; 
        }

        $xml->registerXPathNamespace('oai', 'http://www.openarchives.org/OAI/2.0/');
        $xml->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');

        $records = $xml->xpath('//oai:record');
        if (empty($records)) { echo "Tidak ada record ditemukan di halaman ini.<br>"; break; }

        // Proses semua record di halaman ini (TIDAK ADA PERUBAHAN DI SINI)
        foreach ($records as $record) {
             if (!isset($record->metadata)) { $total_deleted_records++; continue; }
            $dc = $record->metadata->children('http://www.openarchives.org/OAI/2.0/oai_dc/')->dc->children('http://purl.org/dc/elements/1.1/');
            $unique_identifier = isset($dc->identifier[0]) ? (string)$dc->identifier[0] : null;
            if (!$unique_identifier) continue;
            
            $checkStmt = $conn->prepare("SELECT id FROM artikel_oai WHERE unique_identifier = ?");
            $checkStmt->bind_param("s", $unique_identifier);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            
            if ($result->num_rows === 0) {
                // --- KODE LENGKAP UNTUK MENGAMBIL VARIABEL ---
                $title = (string)$dc->title ?: null;
                $description = (string)$dc->description ?: null;
                $publisher = (string)$dc->publisher ?: null;
                $date = (string)$dc->date ?: null;
                $language = (string)$dc->language ?: null;
                $coverage = (string)$dc->coverage ?: null;
                $rights = (string)$dc->rights ?: null;

                $creator1 = isset($dc->creator[0]) ? (string)$dc->creator[0] : null;
                $creator2 = isset($dc->creator[1]) ? (string)$dc->creator[1] : null;
                $creator3 = isset($dc->creator[2]) ? (string)$dc->creator[2] : null;

                $subject1 = isset($dc->subject[0]) ? (string)$dc->subject[0] : null;
                $subject2 = isset($dc->subject[1]) ? (string)$dc->subject[1] : null;
                $subject3 = isset($dc->subject[2]) ? (string)$dc->subject[2] : null;

                $contributor1 = isset($dc->contributor[0]) ? (string)$dc->contributor[0] : null;
                $contributor2 = isset($dc->contributor[1]) ? (string)$dc->contributor[1] : null;

                $type1 = isset($dc->type[0]) ? (string)$dc->type[0] : null;
                $type2 = isset($dc->type[1]) ? (string)$dc->type[1] : null;

                $format1 = isset($dc->format[0]) ? (string)$dc->format[0] : null;
                $format2 = isset($dc->format[1]) ? (string)$dc->format[1] : null;

                $identifier1 = isset($dc->identifier[0]) ? (string)$dc->identifier[0] : null;
                $identifier2 = isset($dc->identifier[1]) ? (string)$dc->identifier[1] : null;
                $identifier3 = isset($dc->identifier[2]) ? (string)$dc->identifier[2] : null;

                $source1 = isset($dc->source[0]) ? (string)$dc->source[0] : null;
                $source2 = isset($dc->source[1]) ? (string)$dc->source[1] : null;

                $relation1 = isset($dc->relation[0]) ? (string)$dc->relation[0] : null;
                $relation2 = isset($dc->relation[1]) ? (string)$dc->relation[1] : null;

                // --- KODE LENGKAP UNTUK INSERT KE DATABASE ---
                $insertStmt = $conn->prepare(
                    "INSERT INTO artikel_oai (
                        unique_identifier, title, description, publisher, date, language, coverage, rights,
                        creator1, creator2, creator3,
                        subject1, subject2, subject3,
                        contributor1, contributor2,
                        type1, type2,
                        format1, format2,
                        identifier1, identifier2, identifier3,
                        source1, source2,
                        relation1, relation2
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $insertStmt->bind_param("sssssssssssssssssssssssssss", 
                    $unique_identifier, $title, $description, $publisher, $date, $language, $coverage, $rights,
                    $creator1, $creator2, $creator3,
                    $subject1, $subject2, $subject3,
                    $contributor1, $contributor2,
                    $type1, $type2,
                    $format1, $format2,
                    $identifier1, $identifier2, $identifier3,
                    $source1, $source2,
                    $relation1, $relation2
                );
                $insertStmt->execute();
                $insertStmt->close();
                
                $total_new_articles++;
            } else {
                $total_skipped_articles++;
            }
            $checkStmt->close();
        }
        
        // 3. Cari resumptionToken untuk iterasi berikutnya
        $resumptionToken = (string)$xml->ListRecords->resumptionToken;
        echo "Token untuk halaman berikutnya ditemukan: " . (!empty($resumptionToken) ? 'Ya' : 'Tidak') . "<br>";

        sleep(1); // Beri jeda 1 detik
        $page++;

    } while (!empty($resumptionToken));

    echo "<hr><strong>PROSES PANEN UNTUK JURNAL INI SELESAI.</strong><br>";
    echo "Total artikel baru ditambahkan: " . $total_new_articles . "<br>";
    echo "Total artikel sudah ada (dilewati): " . $total_skipped_articles . "<br>";
    echo "Total record kosong/dihapus (dilewati): " . $total_deleted_records . "<br><hr style='border: 2px solid red;'>";

} // Akhir dari loop foreach jurnal

echo "<h2>SEMUA PROSES PANEN TELAH SELESAI.</h2>";
echo "</body></html>";

$conn->close();
?>


