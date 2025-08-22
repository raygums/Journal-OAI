<?php
session_start();
// Keamanan: Cek apakah user sudah login dan role-nya adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
// Sertakan header navigasi
include 'header.php';
?>
<title>Dashboard Admin - Portal Jurnal</title>

<main class="page-container">
    <div class="container">
        <div class="page-header">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        </div>

        <div class="admin-content">
            <div class="admin-form-container">
                <h3>Tambah Sumber Jurnal Baru</h3>
                <p>Isi semua detail jurnal pada form di bawah ini.</p>
                
                <form action="api/submit_journal.php" method="POST" class="admin-form">
                    
                    <fieldset>
                        <legend>Informasi Utama Jurnal</legend>
                        <div class="form-group">
                            <label for="journal_title">Nama Jurnal*</label>
                            <input type="text" id="journal_title" name="journal_title" required>
                        </div>
                        <div class="form-group">
                            <label for="oai_url">URL OAI-PMH*</label>
                            <input type="url" id="oai_url" name="oai_url" placeholder="https://.../oai" required>
                        </div>
                        <div class="form-group">
                            <label for="journal_website_url">URL Website Jurnal*</label>
                            <input type="url" id="journal_website_url" name="journal_website_url" placeholder="https://..." required>
                        </div>
                         <div class="form-group">
                            <label for="fakultas">Fakultas*</label>
                            <select id="fakultas" name="fakultas" required>
                                <option value="">-- Pilih Fakultas --</option>
                                <option value="Teknik">Teknik</option>
                                <option value="Pertanian">Pertanian</option>
                                <option value="Kedokteran">Kedokteran</option>
                                <option value="Hukum">Hukum</option>
                                <option value="Ilmu Sosial dan Politik">Ilmu Sosial dan Politik</option>
                                <option value="MIPA">MIPA</option>
                                <option value="Keguruan dan Ilmu Pendidikan">Keguruan dan Ilmu Pendidikan</option>
                                <option value="Ekonomi dan Bisnis">Ekonomi dan Bisnis</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="aim_and_scope">Deskripsi (Aim & Scope)</label>
                            <textarea id="aim_and_scope" name="aim_and_scope" rows="4"></textarea>
                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Informasi Penerbit & Kontak</legend>
                         <div class="form-group">
                            <label for="publisher_name">Nama Penerbit</label>
                            <input type="text" id="publisher_name" name="publisher_name">
                        </div>
                        <div class="form-group">
                            <label for="publisher_country">Negara Penerbit</label>
                            <input type="text" id="publisher_country" name="publisher_country" value="Indonesia">
                        </div>
                        <div class="form-group">
                            <label for="contact_name">Nama Kontak PIC</label>
                            <input type="text" id="contact_name" name="contact_name">
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email Kontak PIC</label>
                            <input type="email" id="contact_email" name="contact_email">
                        </div>
                    </fieldset>
                    
                    <fieldset>
                        <legend>Detail & Identifier</legend>
                        <div class="form-group">
                            <label for="issn">ISSN (Cetak)</label>
                            <input type="text" id="issn" name="issn">
                        </div>
                        <div class="form-group">
                            <label for="eissn">EISSN (Online)</label>
                            <input type="text" id="eissn" name="eissn">
                        </div>
                        <div class="form-group">
                            <label for="doi_prefix">Prefix DOI</label>
                            <input type="text" id="doi_prefix" name="doi_prefix" placeholder="Contoh: 10.1234">
                        </div>
                        <div class="form-group">
                            <label for="start_year">Tahun Mulai Online</label>
                            <input type="number" id="start_year" name="start_year" placeholder="YYYY" min="1980" max="2100">
                        </div>
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select id="bulan" name="bulan">
                                <option value="">-- Pilih Bulan --</option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>

                    </fieldset>
                    
                     <fieldset>
                        <legend>Informasi Tambahan (URL)</legend>
                        <div class="form-group">
                            <label for="cover_url">URL Cover Jurnal</label>
                            <input type="url" id="cover_url" name="cover_url" placeholder="https://.../cover.jpg">
                        </div>
                        <div class="form-group">
                            <label for="google_scholar_url">URL Google Scholar</label>
                            <input type="url" id="google_scholar_url" name="google_scholar_url">
                        </div>
                         <div class="form-group">
                            <label for="editorial_board_url">URL Dewan Editorial</label>
                            <input type="url" id="editorial_board_url" name="editorial_board_url">
                        </div>
                    </fieldset>
                    
                    <button type="submit" class="submit-btn">Simpan Jurnal</button>
                </form>
            </div>

            <hr style="margin: 40px 0;">
            <div class="admin-action-container">
                <h3>Jalankan Proses Panen (Harvesting)</h3>
                <p>Klik tombol di bawah untuk memulai proses pengambilan metadata...</p>
                <button onclick="window.open('harvester.php', '_blank');" class="submit-btn" style="background-image: none; background-color: #27ae60;">
                    Mulai Proses Panen Semua Jurnal
                </button>
            </div>
        </div>
    </div>
</main>

</body>
</html>