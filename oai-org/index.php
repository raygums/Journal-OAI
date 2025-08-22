<?php include 'header.php';?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Agregator Jurnal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Unila E-Journal System</h1>
        <p>Temukan artikel dari berbagai Fakultas di Universitas Lampung.</p>
    </header>

    <main>
        <form id="form-pencarian-hero" action="search.php" method="GET">
             <input type="search" name="keyword" placeholder="Cari artikel, judul, penulis..." required>
            <button type="submit">Cari</button>
        </form>

        <div id="loading" style="display:none;">
            <p>Mencari...</p>
        </div>

        <section id="hasil-pencarian">
            </section>
        

    <section class="stats-section">
        <div class="container">
            <div class="stat-item">
                <h2>-</h2>
                <p>Jurnal Terindeks</p>
            </div>
            <div class="stat-item">
                <h2>-</h2>
                <p>Artikel Ditemukan</p>
            </div>
            <div class="stat-item">
                <h2>8</h2>
                <p>Fakultas</p>
            </div>
        </div>
    </section>    
    </main>





