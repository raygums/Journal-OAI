<?php 
include 'header.php';

$fakultas_list = [
    'Fakultas Teknik' => 'fas fa-cogs',
    'Fakultas Pertanian' => 'fas fa-seedling',
    'Fakultas Kedokteran' => 'fas fa-stethoscope',
    'Fakultas Hukum' => 'fas fa-gavel',
    'Fakultas Ilmu Sosial dan Ilmu Politik' => 'fas fa-users',
    'Fakultas Matematika dan Ilmu Pengetahuan Alam' => 'fas fa-flask',
    'Fakultas Keguruan dan Ilmu Pendidikan' => 'fas fa-chalkboard-teacher',
    'Fakultas Ekonomi dan Bisnis' => 'fas fa-chart-line'
];

$fakultas_abbreviations = [
    'Fakultas Teknik' => 'FT',
    'Fakultas Pertanian' => 'FP',
    'Fakultas Kedokteran' => 'FK',
    'Fakultas Hukum' => 'FH',
    'Fakultas Ilmu Sosial dan Ilmu Politik' => 'FISIP',
    'Fakultas Matematika dan Ilmu Pengetahuan Alam' => 'FMIPA',
    'Fakultas Keguruan dan Ilmu Pendidikan' => 'FKIP',
    'Fakultas Ekonomi dan Bisnis' => 'FEB'
];

require_once './database/config.php';
$conn = connect_to_database();

$journal_counts = [];
$chart_data_json_sinta = '[]';
$chart_data_json_scopus = '[]';
$raw_chart_data_sinta = [];
$raw_chart_data_scopus = [];

if (!$conn->connect_error) { 
    $count_sql = "SELECT fakultas, COUNT(id) as jumlah 
                  FROM jurnal_sumber 
                  WHERE fakultas IS NOT NULL AND fakultas != '' 
                  GROUP BY fakultas";
    $result_counts = $conn->query($count_sql);
    if ($result_counts) {
        while ($row = $result_counts->fetch_assoc()) {
            $journal_counts[$row['fakultas']] = $row['jumlah'];
        }
    }

    $chart_sql_sinta = "SELECT fakultas, akreditasi_sinta, COUNT(id) as jumlah
                  FROM jurnal_sumber
                  WHERE fakultas IS NOT NULL AND fakultas != '' AND akreditasi_sinta IS NOT NULL AND akreditasi_sinta LIKE 'Sinta%'
                  GROUP BY fakultas, akreditasi_sinta";
    $result_chart_sinta = $conn->query($chart_sql_sinta);
    
    if ($result_chart_sinta) {
        while ($row = $result_chart_sinta->fetch_assoc()) {
            $raw_chart_data_sinta[$row['fakultas']][$row['akreditasi_sinta']] = $row['jumlah'];
        }
    }

    $non_sinta_sql = "SELECT fakultas, COUNT(id) as jumlah
                      FROM jurnal_sumber
                      WHERE fakultas IS NOT NULL AND fakultas != '' 
                      AND (akreditasi_sinta IS NULL OR akreditasi_sinta = '' OR akreditasi_sinta NOT LIKE 'Sinta%')
                      GROUP BY fakultas";
    $result_non_sinta = $conn->query($non_sinta_sql);
    
    if ($result_non_sinta) {
        while ($row = $result_non_sinta->fetch_assoc()) {
            $raw_chart_data_sinta[$row['fakultas']]['Belum Terakreditasi SINTA'] = $row['jumlah'];
        }
    }

    $chart_sql_scopus = "SELECT fakultas, index_scopus, COUNT(id) as jumlah
                  FROM jurnal_sumber
                  WHERE fakultas IS NOT NULL AND fakultas != '' AND index_scopus IS NOT NULL AND index_scopus != ''
                  GROUP BY fakultas, index_scopus";
    $result_chart_scopus = $conn->query($chart_sql_scopus);
    
    if ($result_chart_scopus) {
        while ($row = $result_chart_scopus->fetch_assoc()) {
            $raw_chart_data_scopus[$row['fakultas']][$row['index_scopus']] = $row['jumlah'];
        }
    }

    $non_scopus_sql = "SELECT fakultas, COUNT(id) as jumlah
                      FROM jurnal_sumber
                      WHERE fakultas IS NOT NULL AND fakultas != '' 
                      AND (index_scopus IS NULL OR index_scopus = '')
                      GROUP BY fakultas";
    $result_non_scopus = $conn->query($non_scopus_sql);
    
    if ($result_non_scopus) {
        while ($row = $result_non_scopus->fetch_assoc()) {
            $raw_chart_data_scopus[$row['fakultas']]['Tidak Terindeks Scopus'] = $row['jumlah'];
        }
    }

    $fakultas_full_names = array_keys($fakultas_list);
    $chart_labels_short = array_values($fakultas_abbreviations);
    
    $sinta_levels = ['Sinta 1', 'Sinta 2', 'Sinta 3', 'Sinta 4', 'Sinta 5', 'Sinta 6', 'Belum Terakreditasi SINTA'];
    $sinta_colors = [
        'Sinta 1' => 'rgba(217, 30, 24, 0.7)', 'Sinta 2' => 'rgba(30, 139, 195, 0.7)',
        'Sinta 3' => 'rgba(241, 196, 15, 0.7)', 'Sinta 4' => 'rgba(46, 204, 113, 0.7)',
        'Sinta 5' => 'rgba(142, 68, 173, 0.7)', 'Sinta 6' => 'rgba(230, 126, 34, 0.7)',
        'Belum Terakreditasi SINTA' => 'rgba(149, 165, 166, 0.7)'
    ];

    $datasets_sinta = [];
    foreach ($sinta_levels as $sinta) {
        $data_points = [];
        foreach ($fakultas_full_names as $fakultas) {
            $data_points[] = $raw_chart_data_sinta[$fakultas][$sinta] ?? 0;
        }
        
        $datasets_sinta[] = [
            'label' => $sinta, 'data' => $data_points,
            'backgroundColor' => $sinta_colors[$sinta], 'borderRadius' => 4,
        ];
    }
    
    $chart_data_sinta = ['labels' => $chart_labels_short, 'datasets' => $datasets_sinta];
    $chart_data_json_sinta = json_encode($chart_data_sinta);

    $scopus_levels = ['Q1', 'Q2', 'Q3', 'Q4', 'Tidak Terindeks Scopus'];
    $scopus_colors = [
        'Q1' => 'rgba(26, 188, 156, 0.7)',
        'Q2' => 'rgba(52, 152, 219, 0.7)',
        'Q3' => 'rgba(155, 89, 182, 0.7)',
        'Q4' => 'rgba(241, 196, 15, 0.7)',
        'Tidak Terindeks Scopus' => 'rgba(149, 165, 166, 0.7)'
    ];

    $datasets_scopus = [];
    foreach ($scopus_levels as $scopus) {
        $data_points = [];
        foreach ($fakultas_full_names as $fakultas) {
            $data_points[] = $raw_chart_data_scopus[$fakultas][$scopus] ?? 0;
        }
        
        $datasets_scopus[] = [
            'label' => $scopus, 'data' => $data_points,
            'backgroundColor' => $scopus_colors[$scopus], 'borderRadius' => 4,
        ];
    }
    
    $chart_data_scopus = ['labels' => $chart_labels_short, 'datasets' => $datasets_scopus];
    $chart_data_json_scopus = json_encode($chart_data_scopus);

    $conn->close();
}
?>

<main>
    <div class="page-title-container">
        <div class="container">
            <h1>Telusuri Berdasarkan Fakultas</h1>
            <p>Pilih fakultas untuk melihat semua jurnal yang berafiliasi.</p>
        </div>
    </div>

    <div class="container page-content">
        <div class="fakultas-grid">
            <?php
            foreach ($fakultas_list as $nama_lengkap => $icon) {
                $nama_tampil_kartu = str_replace('Fakultas ', '', $nama_lengkap);
                $jumlah_jurnal = $journal_counts[$nama_lengkap] ?? 0;

                echo '<a href="jurnal_fak.php?fakultas=' . urlencode($nama_lengkap) . '" class="fakultas-card">';
                echo '  <div class="fakultas-icon"><i class="' . $icon . '"></i></div>';
                echo '  <h3>' . htmlspecialchars($nama_tampil_kartu) . '</h3>';
                echo '  <span class="fakultas-link">' . $jumlah_jurnal . ' Jurnal</span>';
                echo '</a>';
            }
            ?>
        </div>

        <div class="stats-chart-container" style="margin-top: 50px;">
            <div class="spss-table-header">
                <h3>Statistik Jurnal Terakreditasi per Fakultas</h3>
            </div>
            
            <div class="tab-navigation" style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e0e0e0;">
                <button class="tab-btn active" onclick="switchTab('sinta')" id="tab-sinta" style="padding: 12px 24px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; color: #666; border-bottom: 3px solid transparent; transition: all 0.3s;">
                    Akreditasi SINTA
                </button>
                <button class="tab-btn" onclick="switchTab('scopus')" id="tab-scopus" style="padding: 12px 24px; border: none; background: none; cursor: pointer; font-size: 16px; font-weight: 600; color: #666; border-bottom: 3px solid transparent; transition: all 0.3s;">
                    Akreditasi Scopus
                </button>
            </div>

            <div class="chart" id="chart-sinta">
                <canvas id="fakultasChartSinta"></canvas>
            </div>

            <div class="chart" id="chart-scopus" style="display: none;">
                <canvas id="fakultasChartScopus"></canvas>
            </div>
        </div>

        <div class="stats-table-container spss-style" id="table-sinta" style="margin-top: 50px;">
            <div class="spss-table-header">
                <h3>Rincian Jurnal Terakreditasi SINTA per Fakultas</h3>
            </div>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Nama Fakultas</th>
                        <th>Total</th>
                        <th>S1</th>
                        <th>S2</th>
                        <th>S3</th>
                        <th>S4</th>
                        <th>S5</th>
                        <th>S6</th>
                        <th>Belum Terakreditasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sinta_totals = array_fill_keys($sinta_levels, 0);
                    $grand_total_sinta = 0;

                    foreach ($fakultas_list as $nama_fakultas => $icon):
                        $total_per_fakultas = 0;
                        $s1 = $raw_chart_data_sinta[$nama_fakultas]['Sinta 1'] ?? 0;
                        $s2 = $raw_chart_data_sinta[$nama_fakultas]['Sinta 2'] ?? 0;
                        $s3 = $raw_chart_data_sinta[$nama_fakultas]['Sinta 3'] ?? 0;
                        $s4 = $raw_chart_data_sinta[$nama_fakultas]['Sinta 4'] ?? 0;
                        $s5 = $raw_chart_data_sinta[$nama_fakultas]['Sinta 5'] ?? 0;
                        $s6 = $raw_chart_data_sinta[$nama_fakultas]['Sinta 6'] ?? 0;
                        $belum = $raw_chart_data_sinta[$nama_fakultas]['Belum Terakreditasi SINTA'] ?? 0;
                        
                        $total_per_fakultas = $s1 + $s2 + $s3 + $s4 + $s5 + $s6 + $belum;
                        $sinta_totals['Sinta 1'] += $s1; $sinta_totals['Sinta 2'] += $s2;
                        $sinta_totals['Sinta 3'] += $s3; $sinta_totals['Sinta 4'] += $s4;
                        $sinta_totals['Sinta 5'] += $s5; $sinta_totals['Sinta 6'] += $s6;
                        $sinta_totals['Belum Terakreditasi SINTA'] += $belum;
                        $grand_total_sinta += $total_per_fakultas;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nama_fakultas); ?></td>
                        <td><strong><?php echo $total_per_fakultas; ?></strong></td>
                        <td><?php echo $s1; ?></td>
                        <td><?php echo $s2; ?></td>
                        <td><?php echo $s3; ?></td>
                        <td><?php echo $s4; ?></td>
                        <td><?php echo $s5; ?></td>
                        <td><?php echo $s6; ?></td>
                        <td><?php echo $belum; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Keseluruhan</th>
                        <th><strong><?php echo $grand_total_sinta; ?></strong></th>
                        <th><?php echo $sinta_totals['Sinta 1']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 2']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 3']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 4']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 5']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 6']; ?></th>
                        <th><?php echo $sinta_totals['Belum Terakreditasi SINTA']; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="stats-table-container spss-style" id="table-scopus" style="margin-top: 50px; display: none;">
            <div class="spss-table-header">
                <h3>Rincian Jurnal Terindeks Scopus per Fakultas</h3>
            </div>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Nama Fakultas</th>
                        <th>Total</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th>Tidak Terindeks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $scopus_totals = array_fill_keys($scopus_levels, 0);
                    $grand_total_scopus = 0;

                    foreach ($fakultas_list as $nama_fakultas => $icon):
                        $total_per_fakultas = 0;
                        $q1 = $raw_chart_data_scopus[$nama_fakultas]['Q1'] ?? 0;
                        $q2 = $raw_chart_data_scopus[$nama_fakultas]['Q2'] ?? 0;
                        $q3 = $raw_chart_data_scopus[$nama_fakultas]['Q3'] ?? 0;
                        $q4 = $raw_chart_data_scopus[$nama_fakultas]['Q4'] ?? 0;
                        $tidak = $raw_chart_data_scopus[$nama_fakultas]['Tidak Terindeks Scopus'] ?? 0;
                        
                        $total_per_fakultas = $q1 + $q2 + $q3 + $q4 + $tidak;
                        $scopus_totals['Q1'] += $q1;
                        $scopus_totals['Q2'] += $q2;
                        $scopus_totals['Q3'] += $q3;
                        $scopus_totals['Q4'] += $q4;
                        $scopus_totals['Tidak Terindeks Scopus'] += $tidak;
                        $grand_total_scopus += $total_per_fakultas;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nama_fakultas); ?></td>
                        <td><strong><?php echo $total_per_fakultas; ?></strong></td>
                        <td><?php echo $q1; ?></td>
                        <td><?php echo $q2; ?></td>
                        <td><?php echo $q3; ?></td>
                        <td><?php echo $q4; ?></td>
                        <td><?php echo $tidak; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Keseluruhan</th>
                        <th><strong><?php echo $grand_total_scopus; ?></strong></th>
                        <th><?php echo $scopus_totals['Q1']; ?></th>
                        <th><?php echo $scopus_totals['Q2']; ?></th>
                        <th><?php echo $scopus_totals['Q3']; ?></th>
                        <th><?php echo $scopus_totals['Q4']; ?></th>
                        <th><?php echo $scopus_totals['Tidak Terindeks Scopus']; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chartSinta = null;
let chartScopus = null;

document.addEventListener('DOMContentLoaded', function() {
    const ctxSinta = document.getElementById('fakultasChartSinta');
    if (ctxSinta) {
        const chartDataSinta = <?php echo $chart_data_json_sinta; ?>;
        
        chartSinta = new Chart(ctxSinta, {
            type: 'bar',
            data: chartDataSinta,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: { display: true, text: 'Jumlah Jurnal Berdasarkan Peringkat SINTA' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                }
            }
        });
    }

    const ctxScopus = document.getElementById('fakultasChartScopus');
    if (ctxScopus) {
        const chartDataScopus = <?php echo $chart_data_json_scopus; ?>;
        
        chartScopus = new Chart(ctxScopus, {
            type: 'bar',
            data: chartDataScopus,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: { display: true, text: 'Jumlah Jurnal Berdasarkan Indeksasi Scopus (Quartile)' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                }
            }
        });
    }
});

function switchTab(tabName) {
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(btn => {
        btn.classList.remove('active');
        btn.style.color = '#666';
        btn.style.borderBottom = '3px solid transparent';
    });
    
    const activeTab = document.getElementById('tab-' + tabName);
    if (activeTab) {
        activeTab.classList.add('active');
        activeTab.style.color = '#2c3e50';
        activeTab.style.borderBottom = '3px solid #3498db';
    }
    
    if (tabName === 'sinta') {
        document.getElementById('chart-sinta').style.display = 'block';
        document.getElementById('chart-scopus').style.display = 'none';
        document.getElementById('table-sinta').style.display = 'block';
        document.getElementById('table-scopus').style.display = 'none';
    } else if (tabName === 'scopus') {
        document.getElementById('chart-sinta').style.display = 'none';
        document.getElementById('chart-scopus').style.display = 'block';
        document.getElementById('table-sinta').style.display = 'none';
        document.getElementById('table-scopus').style.display = 'block';
    }
}
</script>

<style>
.tab-btn.active {
    color: #2c3e50 !important;
    border-bottom: 3px solid #3498db !important;
}

.tab-btn:hover {
    color: #2c3e50 !important;
}
</style>

<?php include 'footer.php'; ?>