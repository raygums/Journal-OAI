<?php include 'header.php'; ?>
<title>Daftar Fakultas - Portal Jurnal</title>

<main class="page-container">
    <div class="container">
        <div class="page-header">
            <h1>FAKULTAS</h1>
            <p>Telusuri jurnal berdasarkan fakultas.</p>
        </div>

        <div class="fakultas-grid">
            <?php
            $fakultas_list = [
                'Teknik', 'Pertanian', 'Kedokteran', 'Hukum', 
                'Ilmu Sosial dan Politik', 'MIPA', 
                'Keguruan dan Ilmu Pendidikan', 'Ekonomi dan Bisnis'
            ];

            foreach ($fakultas_list as $fakultas) {
                // Buat link ke halaman detail jurnal dengan parameter fakultas
                echo '<a href="jurnal_fak.php?fakultas=' . urlencode($fakultas) . '" class="fakultas-card">';
                echo '<h3>' . htmlspecialchars($fakultas) . '</h3>';
                // Anda bisa menambahkan query untuk menghitung jumlah jurnal per fakultas di sini
                echo '<p>Lihat Jurnal</p>';
                echo '</a>';
            }
            ?>
        </div>
    </div>
</main>

</body>
</html>