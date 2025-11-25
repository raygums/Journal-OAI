<?php include 'header.php'; ?>

<style>
/* Hero Section */
.hero-tentang {
    background: linear-gradient(to right, #0a1628, #1e3a5f, #2563a8);
    color: white;
    padding: 120px 0;
    position: relative;
    overflow: hidden;
}

.hero-tentang::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.05" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,122.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
    background-size: cover;
    background-position: bottom;
}

.hero-content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    position: relative;
    z-index: 1;
}

.hero-text h1 {
    font-size: 3.5rem;
    margin-bottom: 25px;
    font-weight: 800;
    line-height: 1.2;
}

.hero-text h1 span {
    background: linear-gradient(to right, #ffd89b, #2563eb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-text p {
    font-size: 1.2rem;
    line-height: 1.9;
    opacity: 0.9;
    margin-bottom: 30px;
}

.hero-stats {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.stat-item {
    flex: 1;
    min-width: 150px;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: #ffd89b;
    display: block;
}

.stat-label {
    font-size: 0.95rem;
    opacity: 0.8;
    margin-top: 5px;
}

.hero-illustration {
    position: relative;
    height: 400px;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    animation: float 3s ease-in-out infinite;
}

.floating-card:nth-child(1) {
    top: 50px;
    left: 50px;
    animation-delay: 0s;
}

.floating-card:nth-child(2) {
    top: 150px;
    right: 50px;
    animation-delay: 1s;
}

.floating-card:nth-child(3) {
    bottom: 50px;
    left: 100px;
    animation-delay: 2s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.floating-card i {
    font-size: 2.5rem;
    margin-bottom: 10px;
    display: block;
    color: #ffd89b;
}

.floating-card h4 {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.floating-card p {
    font-size: 0.9rem;
    opacity: 0.8;
}

/* Section Styles */
.about-section {
    padding: 100px 0;
}

.section-header {
    text-align: center;
    margin-bottom: 70px;
}

.section-tag {
    display: inline-block;
    background: linear-gradient(to right, #1e3a8a, #2563eb);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.section-title {
    font-size: 2.8rem;
    color: #1a202c;
    margin-bottom: 20px;
    font-weight: 800;
}

.section-description {
    font-size: 1.2rem;
    color: #4a5568;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.8;
}

/* Feature Cards */
.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 35px;
    margin-top: 50px;
}

.feature-card {
    background: white;
    border-radius: 20px;
    padding: 40px 35px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(to right, #1e3a8a, #3b82f6);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.feature-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    position: relative;
}

.feature-icon::after {
    content: '';
    position: absolute;
    width: 70px;
    height: 70px;
    background: inherit;
    border-radius: inherit;
    opacity: 0.3;
    filter: blur(10px);
    z-index: -1;
}

.feature-icon i {
    font-size: 32px;
    color: white;
}

.feature-card h3 {
    font-size: 1.5rem;
    color: #1a202c;
    margin-bottom: 15px;
    font-weight: 700;
}

.feature-card p {
    color: #718096;
    line-height: 1.8;
    font-size: 1.05rem;
}

/* About Content */
.about-content {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 60px;
    align-items: center;
    margin-top: 60px;
}

.about-text {
    font-size: 1.15rem;
    line-height: 2;
    color: #4a5568;
}

.about-text strong {
    color: #1a202c;
    font-weight: 700;
}

.highlight-box {
    background: linear-gradient(135deg, #f6f8fb, #e9ecef);
    border-left: 5px solid #2563eb;
    padding: 30px;
    border-radius: 15px;
    margin-top: 30px;
}

.highlight-box h4 {
    font-size: 1.3rem;
    color: #1a202c;
    margin-bottom: 15px;
    font-weight: 700;
}

.highlight-box ul {
    list-style: none;
    padding: 0;
}

.highlight-box ul li {
    padding: 12px 0;
    color: #4a5568;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
    gap: 12px;
}

.highlight-box ul li i {
    color: #2563eb;
    font-size: 1.1rem;
}

/* Mission Vision Cards */
.mission-vision {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-top: 60px;
}

.mv-card {
    background: white;
    border-radius: 25px;
    padding: 50px 40px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
}

.mv-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, rgba(30, 58, 138, 0.05), rgba(37, 99, 235, 0.05));
    border-radius: 50%;
    transform: translate(50%, -50%);
}

.mv-card .icon-badge {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
}

.mv-card .icon-badge i {
    font-size: 36px;
    color: white;
}

.mv-card h3 {
    font-size: 2rem;
    color: #1a202c;
    margin-bottom: 20px;
    font-weight: 700;
}

.mv-card p, .mv-card ul li {
    font-size: 1.1rem;
    line-height: 1.9;
    color: #4a5568;
}

.mv-card ul {
    list-style: none;
    padding: 0;
}

.mv-card ul li {
    padding: 15px 0;
    padding-left: 35px;
    position: relative;
}

.mv-card ul li::before {
    content: '✓';
    position: absolute;
    left: 0;
    top: 15px;
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: bold;
}


/* Data Sources */
.data-sources {
    background: #f7fafc;
    padding: 100px 0;
}

.sources-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    margin-top: 60px;
}

.source-card {
    background: white;
    border-radius: 25px;
    padding: 45px 35px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    position: relative;
}

.source-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(to right, #1e3a8a, #3b82f6);
    border-radius: 0 0 25px 25px;
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.source-card:hover::after {
    transform: scaleX(1);
}

.source-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.source-logo {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    font-size: 2.5rem;
    color: white;
    font-weight: 700;
}

.source-card h3 {
    font-size: 1.6rem;
    color: #1a202c;
    margin-bottom: 10px;
    font-weight: 700;
}

.source-card .tag {
    display: inline-block;
    background: #e2e8f0;
    color: #4a5568;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    margin-bottom: 20px;
    font-weight: 600;
}

.source-card p {
    color: #718096;
    line-height: 1.8;
    font-size: 1.05rem;
}

/* Team Section */
.team-section {
    padding: 100px 0;
    background: white;
}

.team-intro {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 70px;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin-top: 60px;
}

.team-member {
    background: white;
    border-radius: 20px;
    padding: 35px;
    text-align: center;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    border: 2px solid #f7fafc;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.team-member::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(to right, #1e3a8a, #3b82f6);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.team-member:hover::before {
    transform: scaleX(1);
}

.team-member:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1);
    border-color: #3b82f6;
}

.team-avatar {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    margin: 0 auto 25px;
    background: linear-gradient(135deg, #f7fafc, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.team-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.team-member h4 {
    font-size: 1.2rem;
    color: #1a202c;
    margin-bottom: 8px;
    font-weight: 700;
}

.team-member .role {
    color: #2563eb;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 15px;
}

.team-member .department {
    color: #718096;
    font-size: 0.9rem;
    line-height: 1.6;
}

/* Leadership Cards */
.leadership-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
    max-width: 900px;
    margin: 60px auto 0;
}

.leader-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    gap: 35px;
    border-left: 6px solid #3b82f6;
    transition: all 0.3s ease;
}

.leader-card:hover {
    transform: translateX(10px);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
}

.leader-avatar {
    width: 110px;
    height: 110px;
    border-radius: 18px;
    background: linear-gradient(135deg, #f7fafc, #e2e8f0);
    flex-shrink: 0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.leader-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.leader-info h3 {
    font-size: 1.5rem;
    color: #1a202c;
    margin-bottom: 8px;
    font-weight: 700;
}

.leader-info .position {
    color: #2563eb;
    font-size: 1.05rem;
    font-weight: 600;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 968px) {
    .hero-content-wrapper {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .hero-illustration {
        height: 300px;
    }
    
    .hero-text h1 {
        font-size: 2.5rem;
    }
    
    .about-content {
        grid-template-columns: 1fr;
    }
    
    .mission-vision {
        grid-template-columns: 1fr;
    }
    
    .sources-grid {
        grid-template-columns: 1fr;
    }
    
    .leader-card {
        flex-direction: column;
        text-align: center;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 640px) {
    .hero-text h1 {
        font-size: 2rem;
    }
    
    .hero-stats {
        flex-direction: column;
        gap: 20px;
    }
}
</style>

<main>
    <!-- Hero Section -->
    <section class="hero-tentang">
        <div class="container">
            <div class="hero-content-wrapper">
                <div class="hero-text">
                    <h1>Portal <span>Jurnal Ilmiah</span> Universitas Lampung</h1>
                    <p>
                        Sistem informasi terintegrasi yang menghubungkan seluruh jurnal ilmiah dari berbagai fakultas, 
                        memberikan akses mudah dan cepat untuk penelitian akademik berkualitas.
                    </p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Jurnal Terintegrasi</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">5,000+</span>
                            <span class="stat-label">Artikel Ilmiah</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">8</span>
                            <span class="stat-label">Fakultas</span>
                        </div>
                    </div>
                </div>
                <div class="hero-illustration">
                    <div class="floating-card">
                        <i class="fas fa-book-open"></i>
                        <h4>Akses Mudah</h4>
                        <p>Cari & Temukan</p>
                    </div>
                    <div class="floating-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h4>Terakreditasi</h4>
                        <p>SINTA & Scopus</p>
                    </div>
                    <div class="floating-card">
                        <i class="fas fa-chart-line"></i>
                        <h4>Update Berkala</h4>
                        <p>Real-time Data</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Portal Section -->
    <section class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Tentang Sistem</span>
                <h2 class="section-title">Portal Agregator Jurnal Ilmiah</h2>
                <p class="section-description">
                    Platform digital terpadu untuk mengakses, mencari, dan mengeksplorasi ribuan 
                    publikasi ilmiah dari seluruh fakultas di Universitas Lampung
                </p>
            </div>

            <div class="about-content">
                <div>
                    <p class="about-text">
                        <strong>Portal Jurnal Ilmiah Unila</strong> adalah sistem informasi terintegrasi yang dikembangkan 
                        untuk memfasilitasi akses terhadap publikasi ilmiah berkualitas dari berbagai disiplin ilmu. 
                        Platform ini mengintegrasikan data dari <strong>jurnal-jurnal terindeks nasional dan internasional</strong> 
                        melalui protokol OAI-PMH (Open Archives Initiative Protocol for Metadata Harvesting).
                    </p>
                    <p class="about-text" style="margin-top: 20px;">
                        Dengan antarmuka yang intuitif dan fitur pencarian yang powerful, pengguna dapat dengan mudah 
                        menemukan artikel, paper, dan publikasi yang relevan dengan bidang penelitian mereka. 
                        Portal ini juga menyediakan informasi lengkap mengenai akreditasi SINTA dan indeksasi Scopus 
                        untuk setiap jurnal.
                    </p>
                </div>
                <div class="highlight-box">
                    <h4>Keunggulan Platform</h4>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Agregasi otomatis melalui OAI-PMH</li>
                        <li><i class="fas fa-check-circle"></i> Pencarian multi-kriteria</li>
                        <li><i class="fas fa-check-circle"></i> Filter berdasarkan fakultas & penerbit</li>
                        <li><i class="fas fa-check-circle"></i> Informasi akreditasi lengkap</li>
                        <li><i class="fas fa-check-circle"></i> Statistik publikasi visual</li>
                        <li><i class="fas fa-check-circle"></i> Responsive & mobile-friendly</li>
                    </ul>
                </div>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Pencarian Cerdas</h3>
                    <p>Temukan artikel dengan cepat menggunakan fitur pencarian advanced dengan filter berdasarkan tahun, penulis, subjek, dan fakultas.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Update Otomatis</h3>
                    <p>Data artikel dipanen secara berkala melalui harvesting otomatis, memastikan informasi selalu up-to-date.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Info Akreditasi</h3>
                    <p>Informasi lengkap tentang peringkat SINTA dan quartile Scopus untuk setiap jurnal yang terdaftar.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Statistik Visual</h3>
                    <p>Dashboard interaktif dengan visualisasi data publikasi per fakultas, tahun, dan kategori akreditasi.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Multi-Role Access</h3>
                    <p>Sistem role-based untuk admin, pengelola jurnal, dan public users dengan hak akses yang berbeda.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Fully Responsive</h3>
                    <p>Tampilan optimal di semua perangkat - desktop, tablet, dan smartphone untuk akses dimana saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision Mission -->
    <section class="about-section" style="background: #f7fafc;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Visi & Misi</span>
                <h2 class="section-title">Komitmen Kami</h2>
            </div>

            <div class="mission-vision">
                <div class="mv-card">
                    <div class="icon-badge">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Visi</h3>
                    <p>
                        Menjadi portal referensi utama publikasi ilmiah Universitas Lampung yang mendukung 
                        ekosistem riset dan inovasi menuju World Class University dengan menyediakan akses 
                        informasi ilmiah yang mudah, cepat, dan terintegrasi.
                    </p>
                </div>
                <div class="mv-card">
                    <div class="icon-badge">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Misi</h3>
                    <ul>
                        <li>Mengintegrasikan seluruh jurnal ilmiah dari berbagai fakultas dalam satu platform terpadu</li>
                        <li>Memfasilitasi akses publikasi ilmiah berkualitas untuk mendukung penelitian akademik</li>
                        <li>Meningkatkan visibilitas dan dampak publikasi ilmiah Universitas Lampung</li>
                        <li>Menyediakan data dan statistik publikasi untuk evaluasi dan pengambilan keputusan</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Sources -->
    <section class="data-sources">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Sumber Data</span>
                <h2 class="section-title">Integrasi Multi-Platform</h2>
                <p class="section-description">
                    Portal ini mengintegrasikan data dari berbagai sumber terpercaya untuk memberikan 
                    informasi yang akurat dan komprehensif
                </p>
            </div>

            <div class="sources-grid">
                <div class="source-card">
                    <div class="source-logo">OAI</div>
                    <h3>OAI-PMH</h3>
                    <span class="tag">Protokol Harvesting</span>
                    <p>
                        Open Archives Initiative Protocol for Metadata Harvesting - standar protokol untuk 
                        mengumpulkan metadata artikel dari berbagai repository jurnal secara otomatis.
                    </p>
                </div>
                <div class="source-card">
                    <div class="source-logo">S</div>
                    <h3>SINTA</h3>
                    <span class="tag">Akreditasi Nasional</span>
                    <p>
                        Science and Technology Index Indonesia - database akreditasi jurnal nasional dari 
                        Kementerian Riset, Teknologi, dan Pendidikan Tinggi RI.
                    </p>
                </div>
                <div class="source-card">
                    <div class="source-logo">Sc</div>
                    <h3>Scopus</h3>
                    <span class="tag">Indeksasi Global</span>
                    <p>
                        Database abstrak dan sitasi jurnal internasional terbesar di dunia, menyediakan 
                        informasi quartile dan metrics publikasi ilmiah.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Tim Kami</span>
                <h2 class="section-title">Struktur Organisasi</h2>
                <p class="section-description">
                    Tim profesional yang berdedikasi dalam pengembangan dan pengelolaan Portal Jurnal Ilmiah
                </p>
            </div>

            <div class="leadership-grid">
                <div class="leader-card">
                    <div class="leader-avatar">
                        <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                    </div>
                    <div class="leader-info">
                        <h3>Prof. Dr. Ir. Lusmeilia Afriani, D.E.A, IPM, ASEAN Eng.</h3>
                        <p class="position">Rektor Universitas Lampung</p>
                    </div>
                </div>
                <div class="leader-card">
                    <div class="leader-avatar">
                        <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                    </div>
                    <div class="leader-info">
                        <h3>Prof. Dr. Ayi Ahadiat, S.E., M.B.A.</h3>
                        <p class="position">Wakil Rektor Bidang Perencanaan, Kerja Sama, dan Sistem Informasi</p>
                    </div>
                </div>
                <div class="leader-card">
                    <div class="leader-avatar">
                        <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                    </div>
                    <div class="leader-info">
                        <h3>Dr. Eng. Mardiana, S.T., M.T.</h3>
                        <p class="position">Kepala UPA TIK</p>
                    </div>
                </div>
            </div>

            <div style="margin-top: 80px;">
                <div class="team-intro">
                    <h3 style="font-size: 2rem; color: #1a202c; margin-bottom: 15px; font-weight: 700;">Tim Pengembang</h3>
                    <p style="color: #718096; font-size: 1.1rem;">
                        Dikelola oleh tim profesional UPA TIK dengan keahlian di bidang pengembangan sistem, 
                        analisis data, dan quality assurance
                    </p>
                </div>

                <div class="team-grid">
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Mahendra Pratama, S.T., M.Eng.</h4>
                        <p class="role">Lead Developer</p>
                        <p class="department">Tim Manajemen dan Integrasi Sistem TI</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Muhammad Ikhsan, S.Kom., M.Cs.</h4>
                        <p class="role">System Analyst</p>
                        <p class="department">Tim Sumber Daya Sistem Informasi</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Rika Ningitas Azhari, S.Kom., M.Kom.</h4>
                        <p class="role">System Analyst</p>
                        <p class="department">Analisis & Perancangan Sistem</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Mizar Zulmi Ramadhan, S.Kom.</h4>
                        <p class="role">Fullstack Developer</p>
                        <p class="department">Backend & Frontend Development</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Kholiq Farizal, S.Kom.</h4>
                        <p class="role">Fullstack Developer</p>
                        <p class="department">Backend & Frontend Development</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Atika Istiqomah, S.Kom., M.T.</h4>
                        <p class="role">Quality Assurance</p>
                        <p class="department">Testing & Quality Control</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Zuliana Nur Fadillah, S.Kom.</h4>
                        <p class="role">Quality Assurance</p>
                        <p class="department">Testing & Quality Control</p>
                    </div>
                    <div class="team-member">
                        <div class="team-avatar">
                            <i class="fas fa-user" style="font-size: 3rem; color: #cbd5e0;"></i>
                        </div>
                        <h4>Aprily Ayu Anbar, S.T.</h4>
                        <p class="role">Quality Assurance</p>
                        <p class="department">Testing & Quality Control</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>
