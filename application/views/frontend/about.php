<?php
$raw_name = $company['company_name'] ?? 'PT. GAYUH MEDIA INFORMATIKA';
$company_name_clean = trim(preg_replace('/\s*\(?BILL GAYUH BARU\)?/i', '', $raw_name));
if (empty($company_name_clean)) {
    $company_name_clean = 'PT. GAYUH MEDIA INFORMATIKA';
}
?>

<!-- Neumorphic Hero Header -->
<div class="container my-4">
    <div class="card nm-card text-center p-4 p-md-5 border-0">
        <div class="nm-icon-squircle mx-auto mb-3" style="width: 62px; height: 62px; font-size: 1.7rem; border-radius: 18px;">
            <i class="fas fa-building" style="color: var(--nm-brand);"></i>
        </div>
        <h1 class="font-weight-bold mb-2" style="color: var(--nm-text-main); font-size: clamp(1.8rem, 3.5vw, 2.4rem); letter-spacing: -0.5px;">
            Tentang Kami
        </h1>
        <div class="nm-section-title-bar"></div>
        <p class="lead font-weight-normal mx-auto mb-0" style="color: var(--nm-text-muted); max-width: 720px; font-size: 1.05rem; line-height: 1.6;">
            Mengenal lebih dekat <strong><?= htmlspecialchars($company_name_clean) ?></strong> &mdash; Penyedia Layanan Internet Cepat, Stabil, dan Terpercaya.
        </p>
    </div>
</div>

<div class="container my-4">
    <!-- Main Company Description & Brand Card -->
    <div class="row align-items-stretch mb-5">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card nm-card h-100 border-0 p-4">
                <div class="card-body p-2 p-md-3">
                    <div class="mb-3">
                        <span class="nm-badge-primary">
                            <i class="fas fa-certificate mr-2" style="color: var(--nm-brand);"></i> Profil Perusahaan
                        </span>
                    </div>
                    <h2 class="font-weight-bold mb-3" style="color: var(--nm-text-main); font-size: 1.6rem; letter-spacing: -0.3px;">
                        <?= htmlspecialchars($company_name_clean) ?>
                    </h2>
                    <div class="nm-company-desc" style="color: var(--nm-text-muted); line-height: 1.85; font-size: 1.02rem;">
                        <?= !empty($company['description']) ? $company['description'] : 'PT. Gayuh Media Informatika merupakan Internet Service Provider (ISP) atau Penyedia Layanan Internet yang memberikan layanan koneksi internet dedicated berkualitas baik melalui Fiber optic (FO) maupun Wireless. Dengan layanan prima dan berpengalaman kami berusaha untuk memberikan solusi bagi perusahaan, sekolah, warnet dan lain-lain. Kami juga merupakan perusahaan legal yang memberikan layanan paket internet secara profesional.' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 text-center">
            <div class="card nm-card h-100 border-0 p-4">
                <div class="card-body p-2 p-md-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="nm-feature-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.2rem; border-radius: 22px;">
                            <i class="fas fa-wifi" style="color: var(--nm-brand);"></i>
                        </div>
                        <h3 class="font-weight-bold mb-2" style="color: var(--nm-text-main); font-size: 1.35rem;">
                            <?= htmlspecialchars($company_name_clean) ?>
                        </h3>
                        <p class="small font-weight-bold text-uppercase mb-3" style="color: var(--nm-brand); letter-spacing: 1px;">
                            <?= htmlspecialchars(!empty($company['sub_name']) ? $company['sub_name'] : 'Internet Services Provider') ?>
                        </p>
                        <p class="small text-muted mb-4 px-2" style="line-height: 1.6;">
                            Komitmen kami menghadirkan jaringan internet fiber optik cepat & berdaya jangkau luas dengan layanan pelanggan prima.
                        </p>
                    </div>
                    <div class="mt-2">
                        <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp'] ?? ''); ?>&text=Halo%20kami%20ingin%20bertanya%20mengenai%20layanan%20internet" target="_blank" class="btn nm-btn nm-btn-primary btn-block py-3 font-weight-bold shadow-sm">
                            <i class="fab fa-whatsapp mr-2" style="font-size: 1.2rem;"></i> Hubungi Customer Service
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Advantages Grid -->
    <div class="my-5">
        <div class="nm-section-header">
            <h3 class="nm-section-title">Mengapa Memilih Kami?</h3>
            <p class="nm-section-subtitle">Komitmen kami dalam memberikan kualitas jaringan dan pelayanan terbaik untuk kepuasan Anda</p>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="nm-feature-card">
                    <div class="nm-feature-icon" style="color: #2563eb;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h5 class="font-weight-bold mb-2" style="color: var(--nm-text-main);">Koneksi Cepat</h5>
                    <p class="small text-muted mb-0">Nikmati kecepatan akses internet tinggi tanpa kompromi untuk semua kebutuhan streaming & kerja.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="nm-feature-card">
                    <div class="nm-feature-icon" style="color: #10b981;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="font-weight-bold mb-2" style="color: var(--nm-text-main);">Jaringan Stabil</h5>
                    <p class="small text-muted mb-0">Infrastruktur fiber optik modern memastikan uptime jaringan tetap handal 24 jam nonstop.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="nm-feature-card">
                    <div class="nm-feature-icon" style="color: #f59e0b;">
                        <i class="fas fa-tags"></i>
                    </div>
                    <h5 class="font-weight-bold mb-2" style="color: var(--nm-text-main);">Harga Hemat</h5>
                    <p class="small text-muted mb-0">Pilihan paket berlangganan bulanan yang terjangkau sesuai anggaran keluarga & bisnis Anda.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
                <div class="nm-feature-card">
                    <div class="nm-feature-icon" style="color: #06b6d4;">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="font-weight-bold mb-2" style="color: var(--nm-text-main);">Dukungan 24/7</h5>
                    <p class="small text-muted mb-0">Tim teknis responsif yang siap membantu mengatasi keluhan dan kebutuhan teknis kapan saja.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Address Section -->
    <?php if (!empty($company['address']) || !empty($company['email']) || !empty($company['whatsapp'])) { ?>
        <div class="card nm-card border-0 p-4 mt-4">
            <div class="card-body p-2 p-md-3">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-3 mb-lg-0 text-center text-lg-left">
                        <div class="d-inline-flex align-items-center mb-2">
                            <div class="nm-icon-squircle mr-3" style="width: 42px; height: 42px; font-size: 1.15rem;">
                                <i class="fas fa-map-marker-alt" style="color: var(--nm-brand);"></i>
                            </div>
                            <h4 class="font-weight-bold mb-0" style="color: var(--nm-text-main); font-size: 1.25rem;">Alamat & Kontak</h4>
                        </div>
                        <p class="text-muted small mb-0">Hubungi kami untuk informasi pemasangan baru atau pertanyaan umum.</p>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <?php if (!empty($company['address'])) { ?>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        <div class="nm-icon-squircle mr-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                            <i class="fas fa-building text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="d-block small text-muted font-weight-bold text-uppercase">Alamat Kantor</span>
                                            <span class="small font-weight-bold" style="color: var(--nm-text-main);"><?= htmlspecialchars($company['address']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (!empty($company['email'])) { ?>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="nm-icon-squircle mr-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                            <i class="fas fa-envelope text-warning"></i>
                                        </div>
                                        <div>
                                            <span class="d-block small text-muted font-weight-bold text-uppercase">Email Resmi</span>
                                            <span class="small font-weight-bold" style="color: var(--nm-text-main);"><?= htmlspecialchars($company['email']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>