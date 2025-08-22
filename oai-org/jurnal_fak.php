<?php
include 'header.php';

// --- PENGATURAN & PENGAMBILAN PARAMETER ---
$results_per_page = 10; // Jumlah jurnal per halaman

// Ambil parameter dari URL
$nama_fakultas = isset($_GET['fakultas']) ? urldecode($_GET['fakultas']) : '';
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Jika tidak ada nama fakultas, hentikan eksekusi
if (empty($nama_fakultas)) {
    echo "<main class='page-container'><div class='container'><h1>Fakultas tidak ditemukan.</h1></div></main></body></html>";
    exit();
}

// --- LOGIKA DATABASE & QUERY DINAMIS ---
$host = "localhost"; $user = "root"; $pass = ""; $db = "oai";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

// Siapkan query dinamis berdasarkan ada tidaknya pencarian
$sql_where_clauses = ["fakultas = ?"];
$sql_params_types = "s";
$sql_params_values = [$nama_fakultas];

if (!empty($search_query)) {
    $sql_where_clauses[] = "(journal_title LIKE ? OR issn LIKE ? OR eissn LIKE ?)";
    $sql_params_types .= "sss";
    $search_term = "%" . $search_query . "%";
    $sql_params_values[] = $search_term;
    $sql_params_values[] = $search_term;
    $sql_params_values[] = $search_term;
}
$where_sql = " WHERE " . implode(" AND ", $sql_where_clauses);

// Query untuk menghitung total hasil (untuk pagination)
$count_sql = "SELECT COUNT(*) FROM jurnal_sumber" . $where_sql;
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param($sql_params_types, ...$sql_params_values);
$count_stmt->execute();
$total_results = $count_stmt->get_result()->fetch_row()[0];
$total_pages = ceil($total_results / $results_per_page);
$count_stmt->close();

// Query utama untuk mengambil data jurnal
$data_sql = "SELECT journal_title, publisher_name, issn, eissn, cover_url FROM jurnal_sumber" . $where_sql . " LIMIT ? OFFSET ?";
$sql_params_types .= "ii";
$sql_params_values[] = $results_per_page;
$sql_params_values[] = $offset;

$data_stmt = $conn->prepare($data_sql);
$data_stmt->bind_param($sql_params_types, ...$sql_params_values);
$data_stmt->execute();
$result = $data_stmt->get_result();
?>

<title>Jurnal Fakultas <?php echo htmlspecialchars($nama_fakultas); ?></title>

<main class="page-container">
    <div class="container">
        <div class="page-header publisher-header">
            <img src="https://via.placeholder.com/100x100.png?text=<?php echo substr($nama_fakultas, 0, 1); ?>" alt="Logo Fakultas" class="publisher-logo">
            <div>
                <h2>Fakultas <?php echo htmlspecialchars($nama_fakultas); ?></h2>
                <p>Universitas Lampung</p>
                <span><?php echo $total_results; ?> Jurnal Ditemukan</span>
            </div>
        </div>

        <div class="filter-bar">
            <div class="mini-search-bar">
                <form action="jurnal_fak.php" method="GET">
                    <input type="hidden" name="fakultas" value="<?php echo htmlspecialchars($nama_fakultas); ?>">
                    <input type="search" name="q" placeholder="Cari Jurnal di fakultas ini..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>
            <nav class="pagination">
                <ul>
                    <?php
                    if ($total_pages > 1) {
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active_class = ($i == $page) ? 'active' : '';
                            $query_string = http_build_query(['fakultas' => $nama_fakultas, 'q' => $search_query, 'page' => $i]);
                            echo '<li><a href="jurnal_fakultas.php?' . $query_string . '" class="' . $active_class . '">' . $i . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>

        <div class="journal-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cover = !empty($row['cover_url']) ? $row['cover_url'] : 'https://via.placeholder.com/100x140.png?text=No+Cover';
                    echo '<div class="journal-item">';
                    echo '<img src="' . htmlspecialchars($cover) . '" alt="Cover Jurnal" class="journal-cover">';
                    echo '<div class="journal-info">';
                    echo '<h4><a href="#">' . htmlspecialchars($row['journal_title']) . '</a></h4>'; // Link ke detail jurnal nanti
                    echo '<p class="journal-publisher">' . htmlspecialchars($row['publisher_name'] ?? 'Universitas Lampung') . '</p>';
                    echo '<span class="journal-issn">ISSN: ' . htmlspecialchars($row['issn'] ?? '-') . '</span>';
                    echo '<span class="journal-issn">EISSN: ' . htmlspecialchars($row['eissn'] ?? '-') . '</span>';
                    echo '<div class="journal-tags"><span class="tag">' . htmlspecialchars($nama_fakultas) . '</span></div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Tidak ada jurnal yang ditemukan dengan kriteria Anda.</p>';
            }
            $data_stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</main>

</body>
</html>