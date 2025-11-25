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
$chart_data_json = '[]';
$raw_chart_data = []; 

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

    $chart_sql = "SELECT fakultas, akreditasi_sinta, COUNT(id) as jumlah
                  FROM jurnal_sumber
                  WHERE fakultas IS NOT NULL AND fakultas != '' AND akreditasi_sinta IS NOT NULL AND akreditasi_sinta LIKE 'Sinta%'
                  GROUP BY fakultas, akreditasi_sinta";
    $result_chart = $conn->query($chart_sql);
    
    if ($result_chart) {
        while ($row = $result_chart->fetch_assoc()) {
            $raw_chart_data[$row['fakultas']][$row['akreditasi_sinta']] = $row['jumlah'];
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
            $raw_chart_data[$row['fakultas']]['Belum Terakreditasi'] = $row['jumlah'];
        }
    }

    $fakultas_full_names = array_keys($fakultas_list);
    $chart_labels_short = array_values($fakultas_abbreviations);
    $sinta_levels = ['Sinta 1', 'Sinta 2', 'Sinta 3', 'Sinta 4', 'Sinta 5', 'Sinta 6', 'Belum Terakreditasi'];
    $sinta_colors = [
        'Sinta 1' => 'rgba(217, 30, 24, 0.7)', 'Sinta 2' => 'rgba(30, 139, 195, 0.7)',
        'Sinta 3' => 'rgba(241, 196, 15, 0.7)', 'Sinta 4' => 'rgba(46, 204, 113, 0.7)',
        'Sinta 5' => 'rgba(142, 68, 173, 0.7)', 'Sinta 6' => 'rgba(230, 126, 34, 0.7)',
        'Belum Terakreditasi' => 'rgba(149, 165, 166, 0.7)'
    ];

    $datasets = [];
    foreach ($sinta_levels as $sinta) {
        $data_points = [];
        foreach ($fakultas_full_names as $fakultas) {
            $data_points[] = $raw_chart_data[$fakultas][$sinta] ?? 0;
        }
        
        $datasets[] = [
            'label' => $sinta, 'data' => $data_points,
            'backgroundColor' => $sinta_colors[$sinta], 'borderRadius' => 4,
        ];
    }
    
    $chart_data_final = ['labels' => $chart_labels_short, 'datasets' => $datasets];
    $chart_data_json = json_encode($chart_data_final);

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
            <div class="chart">
                <canvas id="fakultasChart"></canvas>
            </div>
        </div>

        <div class="stats-table-container spss-style" style="margin-top: 50px;">
            <div class="spss-table-header">
                <h3>Rincian Jurnal Terakreditasi per Fakultas</h3>
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
                    $grand_total = 0;

                    foreach ($fakultas_list as $nama_fakultas => $icon):
                        $total_per_fakultas = 0;
                        $s1 = $raw_chart_data[$nama_fakultas]['Sinta 1'] ?? 0;
                        $s2 = $raw_chart_data[$nama_fakultas]['Sinta 2'] ?? 0;
                        $s3 = $raw_chart_data[$nama_fakultas]['Sinta 3'] ?? 0;
                        $s4 = $raw_chart_data[$nama_fakultas]['Sinta 4'] ?? 0;
                        $s5 = $raw_chart_data[$nama_fakultas]['Sinta 5'] ?? 0;
                        $s6 = $raw_chart_data[$nama_fakultas]['Sinta 6'] ?? 0;
                        $belum = $raw_chart_data[$nama_fakultas]['Belum Terakreditasi'] ?? 0;
                        
                        $total_per_fakultas = $s1 + $s2 + $s3 + $s4 + $s5 + $s6 + $belum;
                        $sinta_totals['Sinta 1'] += $s1; $sinta_totals['Sinta 2'] += $s2;
                        $sinta_totals['Sinta 3'] += $s3; $sinta_totals['Sinta 4'] += $s4;
                        $sinta_totals['Sinta 5'] += $s5; $sinta_totals['Sinta 6'] += $s6;
                        $sinta_totals['Belum Terakreditasi'] += $belum;
                        $grand_total += $total_per_fakultas;
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
                        <th><strong><?php echo $grand_total; ?></strong></th>
                        <th><?php echo $sinta_totals['Sinta 1']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 2']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 3']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 4']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 5']; ?></th>
                        <th><?php echo $sinta_totals['Sinta 6']; ?></th>
                        <th><?php echo $sinta_totals['Belum Terakreditasi']; ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('fakultasChart');
    if (ctx) {
        const chartData = <?php echo $chart_data_json; ?>;
        
        new Chart(ctx, {
            type: 'bar',
            data: chartData,
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
});
</script>

<?php include 'footer.php'; ?>