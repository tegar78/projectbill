<?php
$role = $this->db->get_where('role_management', ['role_id' => 2])->row_array();
$clean_company_name = trim(preg_replace('/\s*\(?BILL GAYUH BARU\)?/i', '', $company['company_name'] ?? 'PT. GAYUH MEDIA INFORMATIKA'));
if (empty($clean_company_name)) {
    $clean_company_name = 'PT. GAYUH MEDIA INFORMATIKA';
}
$wa_number = indo_tlp($company['whatsapp'] ?? '');
?>

<!-- ==========================================================================
     1. HERO SECTION (2-Column Desktop, 1-Column Mobile, Dual CTA & Stat Badges)
     ========================================================================== -->
<section class="ml-hero-section" id="hero">
    <div class="container">
        <div class="ml-hero-grid">
            
            <!-- Kolom Kiri: Headline & CTA Group -->
            <div class="ml-hero-content">
                <div class="ml-badge-pill">
                    <i class="fas fa-bolt" style="color: var(--ml-primary);"></i>
                    <span>100% Ultra-Fast Fiber Optic</span>
                </div>

                <h1 class="ml-hero-headline">
                    Internet Rumah Cepat, Stabil & <br>
                    <span class="ml-text-gradient">Bebas Hambatan</span> Tanpa FUP
                </h1>

                <p class="ml-hero-desc">
                    Nikmati streaming film 4K tanpa buffering, gaming minim latensi, dan bekerja dari rumah lebih produktif dengan jaringan simetris berkecepatan tinggi dari <?= htmlspecialchars($clean_company_name) ?>.
                </p>

                <div class="ml-hero-cta-group">
                    <a href="#paket" class="ml-btn ml-btn-primary">
                        <span>Pilih Paket Internet</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=<?= $wa_number ?>&text=Halo%20GayuhNet,%20saya%20ingin%20konsultasi%20pasang%20internet%20baru" target="_blank" class="ml-btn ml-btn-secondary">
                        <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.15rem;"></i>
                        <span>Hubungi Sales</span>
                    </a>
                </div>

                <!-- Indikator Metrik Kepercayaan -->
                <div class="ml-hero-metrics">
                    <div class="ml-metric-item">
                        <h4>99.9%</h4>
                        <p>Uptime Garansi</p>
                    </div>
                    <div class="ml-metric-item">
                        <h4>100%</h4>
                        <p>True Unlimited</p>
                    </div>
                    <div class="ml-metric-item">
                        <h4>&lt; 5 ms</h4>
                        <p>Latensi Rendah</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Graphic Mockup & Floating Badges -->
            <div class="ml-hero-visual">
                <div class="ml-hero-card-container">
                    
                    <!-- Floating Badge 1 (Top Left) -->
                    <div class="ml-floating-stat ml-stat-top-left">
                        <div class="ml-icon-squircle" style="width: 38px; height: 38px; font-size: 1.05rem;">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.72rem; color: var(--ml-muted); font-weight: 600;">Dedicated Speed</div>
                            <div style="font-size: 0.92rem; font-weight: 800;">Up to 100 Mbps</div>
                        </div>
                    </div>

                    <!-- Graphic Centerpiece Box -->
                    <div class="ml-hero-graphic-box">
                        <div class="ml-hero-mascot-wrap">
                            <img src="<?= base_url('assets/images/gayuh-mascot.png') ?>?v=<?= filemtime(FCPATH . 'assets/images/gayuh-mascot.png') ?>" alt="Maskot GayuhNet" class="ml-hero-mascot-img">
                        </div>
                        <p style="font-size: 0.9rem; color: #cbd5e1; max-width: 310px; margin: 0 auto; line-height: 1.5;">
                            Cakupan sinyal kuat dan stabil menjangkau setiap sudut ruangan hunian Anda.
                        </p>
                        <div class="mt-3">
                            <span class="badge badge-pill px-3 py-1" style="background: rgba(255,255,255,0.12); color: #f8fafc; font-size: 0.78rem;">
                                <i class="fas fa-check-circle text-success mr-1"></i> 100% Fiber Optic Ready
                            </span>
                        </div>
                    </div>

                    <!-- Floating Badge 2 (Bottom Right) -->
                    <div class="ml-floating-stat ml-stat-bottom-right">
                        <div class="ml-icon-squircle" style="width: 38px; height: 38px; font-size: 1.05rem; background-color: #ecfdf5; color: #10b981;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.72rem; color: var(--ml-muted); font-weight: 600;">Customer Care</div>
                            <div style="font-size: 0.92rem; font-weight: 800;">24/7 Siaga Respon</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ==========================================================================
     2. CEK TAGIHAN & INFO KONTAK SECTION (Retained Operational Core)
     ========================================================================== -->
<?php if ($role['cek_bill'] == 1) { ?>
<section class="ml-bill-section" id="cek-tagihan">
    <div class="container">
        <div class="row">
            
            <!-- Form Cek Tagihan Mandiri -->
            <div class="col-lg-8 mb-4">
                <div class="ml-clean-card">
                    <div class="ml-card-header">
                        <div class="ml-icon-squircle">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h3 class="ml-card-title">Cek Tagihan Pelanggan</h3>
                            <div class="small text-muted">Periksa rincian tagihan bulanan internet Anda secara mandiri</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="no_services" class="ml-form-label">
                                <i class="fas fa-id-card mr-1 text-muted"></i> No. Pelanggan / Layanan
                            </label>
                            <input class="ml-form-input" id="no_services" name="no_services" type="number" placeholder="Masukkan nomor layanan Anda" required>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label for="month" class="ml-form-label">
                                <i class="far fa-calendar-alt mr-1 text-muted"></i> Bulan
                            </label>
                            <select name="month" id="month" class="ml-form-input" required>
                                <option value="<?= date('m') ?>"><?= indo_month(date('m')) ?></option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <label for="year" class="ml-form-label">
                                <i class="far fa-calendar mr-1 text-muted"></i> Tahun
                            </label>
                            <select class="ml-form-input" id="year" name="year" required>
                                <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                <?php for ($i = date('Y'); $i >= date('Y') - 1; $i -= 1) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 flex-wrap" style="gap: 12px;">
                        <span class="small text-muted d-none d-md-inline">
                            <i class="fas fa-info-circle mr-1" style="color: var(--ml-primary);"></i> Klik tombol periksa untuk melihat detail pembayaran dan invoice.
                        </span>
                        <button class="ml-btn ml-btn-primary ml-auto" type="submit" onclick="cek_bill()">
                            <i class="fas fa-search mr-1"></i> Periksa Tagihan
                        </button>
                    </div>

                    <!-- AJAX Loading & Response Container -->
                    <div class="loading mt-3"></div>
                    <div class="view_data mt-3"></div>
                </div>
            </div>

            <!-- Kontak & Kanal Komunikasi Resmi -->
            <div class="col-lg-4 mb-4">
                <div class="ml-clean-card d-flex flex-column justify-content-between">
                    <div>
                        <div class="ml-card-header">
                            <div class="ml-icon-squircle">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div>
                                <h3 class="ml-card-title">Kanal Bantuan</h3>
                                <div class="small text-muted">Layanan Pelanggan Resmi</div>
                            </div>
                        </div>
                        <p class="small text-muted mb-4">
                            Butuh informasi paket baru atau mengalami kendala teknis? Tim kami siap melayani melalui media sosial dan kontak resmi:
                        </p>
                    </div>

                    <div class="ml-social-list">
                        <a href="https://api.whatsapp.com/send?phone=<?= $wa_number ?>" target="_blank" class="ml-social-btn">
                            <i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.25rem;"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a href="https://www.instagram.com/<?= htmlspecialchars($company['instagram'] ?? ''); ?>" target="_blank" class="ml-social-btn">
                            <i class="fab fa-instagram" style="color: #E4405F; font-size: 1.25rem;"></i>
                            <span>Instagram</span>
                        </a>
                        <a href="https://www.facebook.com/<?= htmlspecialchars($company['facebook'] ?? ''); ?>" target="_blank" class="ml-social-btn">
                            <i class="fab fa-facebook-f" style="color: #1877F2; font-size: 1.25rem;"></i>
                            <span>Facebook</span>
                        </a>
                        <a href="mailto:<?= htmlspecialchars($company['email'] ?? ''); ?>" target="_blank" class="ml-social-btn">
                            <i class="fas fa-envelope" style="color: var(--ml-primary); font-size: 1.25rem;"></i>
                            <span>Email CS</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php } ?>

<!-- ==========================================================================
     3. FEATURES & PRICING PACKAGES (Grid + Best Seller Card Highlight)
     ========================================================================== -->
<section class="ml-pricing-section" id="paket">
    <div class="container">
        
        <div class="ml-section-header">
            <div class="ml-badge-pill">Pilihan Paket Internet</div>
            <h2 class="ml-section-title">Koneksi Tepat Sesuai Kebutuhan Anda</h2>
            <p class="ml-section-desc">Pilih paket internet rumah tanpa batasan kuota (FUP) dengan kecepatan simetris dan biaya bulanan transparan.</p>
        </div>

        <div class="ml-pricing-grid">
            
            <!-- Paket 1: Home Basic (20 Mbps) -->
            <div class="ml-plan-card">
                <div class="ml-ribbon-badge-wrap text-center mb-3">
                    <img src="<?= base_url('assets/images/product/product-20mbps.png') ?>?v=<?= filemtime(FCPATH . 'assets/images/product/product-20mbps.png') ?>" alt="Paket 20 Mbps" class="ml-product-badge-img">
                </div>
                <div class="ml-plan-badge-title text-center mb-3 pb-3" style="border-bottom: 1px solid var(--ml-border);">
                    <h4 class="font-weight-bold text-dark mb-1" style="font-size: 1.15rem;">Home Basic</h4>
                    <span class="badge px-3 py-1 font-weight-semibold" style="background: var(--ml-primary-light); color: var(--ml-primary); border-radius: 50px; font-size: 0.8rem;">3 - 5 Perangkat</span>
                </div>
                
                <ul class="ml-plan-features">
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Ideal untuk 3 - 5 Perangkat</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>100% Jaringan Full Fiber Optic</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>True Unlimited (Tanpa Batas FUP)</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Gratis Sewa Modem ONT WiFi</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Bantuan Customer Care 24/7</span>
                    </li>
                </ul>

                <a href="https://api.whatsapp.com/send?phone=<?= $wa_number ?>&text=Halo%20GayuhNet,%20saya%20ingin%20pasang%20paket%20Home%20Basic%2020Mbps" target="_blank" class="ml-btn ml-btn-secondary w-100">
                    <span>Pilih Paket Ini</span>
                </a>
            </div>

            <!-- Paket 2: Family Gamer (40 Mbps - POPULER / BEST SELLER) -->
            <div class="ml-plan-card is-popular">
                <div class="ml-popular-ribbon">Paling Populer ⭐</div>
                <div class="ml-ribbon-badge-wrap text-center mb-3">
                    <img src="<?= base_url('assets/images/product/product-40mbps.png') ?>?v=<?= filemtime(FCPATH . 'assets/images/product/product-40mbps.png') ?>" alt="Paket 40 Mbps" class="ml-product-badge-img">
                </div>
                <div class="ml-plan-badge-title text-center mb-3 pb-3" style="border-bottom: 1px solid var(--ml-border);">
                    <h4 class="font-weight-bold text-dark mb-1" style="font-size: 1.15rem;">Family Gamer</h4>
                    <span class="badge px-3 py-1 font-weight-semibold" style="background: var(--ml-primary-light); color: var(--ml-primary); border-radius: 50px; font-size: 0.8rem;">5 - 8 Perangkat Aktif</span>
                </div>
                
                <ul class="ml-plan-features">
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span><strong>Ideal untuk 5 - 8 Perangkat Aktif</strong></span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Download & Upload Simetris 1:1</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Direct Peering Game Minim Latensi</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>True Unlimited Tanpa Turun Kecepatan</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Prioritas Penanganan Bantuan Teknisi</span>
                    </li>
                </ul>

                <a href="https://api.whatsapp.com/send?phone=<?= $wa_number ?>&text=Halo%20GayuhNet,%20saya%20ingin%20pasang%20paket%20Family%20Gamer%2040Mbps" target="_blank" class="ml-btn ml-btn-primary w-100">
                    <span>Daftar Sekarang</span>
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Paket 3: Pro Streamer (100 Mbps) -->
            <div class="ml-plan-card">
                <div class="ml-ribbon-badge-wrap text-center mb-3">
                    <img src="<?= base_url('assets/images/product/product-100mbps.png') ?>?v=<?= filemtime(FCPATH . 'assets/images/product/product-100mbps.png') ?>" alt="Paket 100 Mbps" class="ml-product-badge-img">
                </div>
                <div class="ml-plan-badge-title text-center mb-3 pb-3" style="border-bottom: 1px solid var(--ml-border);">
                    <h4 class="font-weight-bold text-dark mb-1" style="font-size: 1.15rem;">Pro Streamer</h4>
                    <span class="badge px-3 py-1 font-weight-semibold" style="background: var(--ml-primary-light); color: var(--ml-primary); border-radius: 50px; font-size: 0.8rem;">8 - 12 Perangkat</span>
                </div>
                
                <ul class="ml-plan-features">
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Kapasitas 8 - 12 Perangkat & Smart Home</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Streaming 4K Ultra HD & Live Broadcast</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Dukungan Router Dual-Band Gigabit</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>True Unlimited Tanpa FUP Seharian</span>
                    </li>
                    <li class="ml-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Garansi SLA Uptime Jaringan 99.9%</span>
                    </li>
                </ul>

                <a href="https://api.whatsapp.com/send?phone=<?= $wa_number ?>&text=Halo%20GayuhNet,%20saya%20ingin%20pasang%20paket%20Pro%20Streamer%20100Mbps" target="_blank" class="ml-btn ml-btn-secondary w-100">
                    <span>Pilih Paket Ini</span>
                </a>
            </div>

        </div>

        <!-- Info Paket Lengkap & Link Katalog -->
        <div class="text-center mt-5">
            <p class="text-muted mb-2" style="font-size: 0.95rem;">
                Tersedia juga paket hemat <strong>10 Mbps (Rp 100.000/bln)</strong> dan paket ultra <strong>150 Mbps (Rp 585.000/bln)</strong>.
            </p>
            <a href="<?= site_url('layanan.html') ?>" class="ml-btn ml-btn-secondary px-4 py-2 mt-2">
                <i class="fas fa-boxes mr-1" style="color: var(--ml-primary);"></i> Lihat Semua 5 Pilihan Paket Internet
            </a>
        </div>

    </div>
</section>

<!-- ==========================================================================
     4. WHY CHOOSE US / KEUNGGULAN SECTION (6 Value Propositions)
     ========================================================================== -->
<section class="ml-why-section" id="keunggulan">
    <div class="container">
        
        <div class="ml-section-header">
            <div class="ml-badge-pill">Keunggulan Layanan</div>
            <h2 class="ml-section-title">Mengapa Memilih GayuhNet?</h2>
            <p class="ml-section-desc">Komitmen kami memberikan standar layanan internet andal, terjangkau, dan didukung teknisi lokal berpengalaman.</p>
        </div>

        <div class="ml-features-grid">
            
            <!-- Keunggulan 1 -->
            <div class="ml-feature-card">
                <div class="ml-feature-icon">
                    <i class="fas fa-network-wired"></i>
                </div>
                <h3>100% Full Fiber Optic</h3>
                <p>Menggunakan infrastruktur kabel kaca modern berkecepatan tinggi yang tahan terhadap gangguan cuaca ekstrem dan petir.</p>
            </div>

            <!-- Keunggulan 2 -->
            <div class="ml-feature-card">
                <div class="ml-feature-icon">
                    <i class="fas fa-infinity"></i>
                </div>
                <h3>True Unlimited Tanpa FUP</h3>
                <p>Bebas download, streaming, dan bermain game sepuasnya tanpa rasa cemas kecepatan akan diturunkan secara mendadak.</p>
            </div>

            <!-- Keunggulan 3 -->
            <div class="ml-feature-card">
                <div class="ml-feature-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <h3>Ultra-Low Latency Peering</h3>
                <p>Rute direct peering ke server game terpopuler dan CDN lokal (Google, Cloudflare, Meta) menjamin ping stabil dan responsif.</p>
            </div>

            <!-- Keunggulan 4 -->
            <div class="ml-feature-card">
                <div class="ml-feature-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3>Transparan Tanpa Biaya Tersembunyi</h3>
                <p>Biaya tagihan bulanan flat dan jelas sesuai paket yang Anda pilih, tanpa biaya tersembunyi pada saat pembayaran.</p>
            </div>

            <!-- Keunggulan 5 -->
            <div class="ml-feature-card">
                <div class="ml-feature-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
                <h3>Customer Care Siaga 24/7</h3>
                <p>Layanan bantuan teknis dan customer service responsif siap membantu mengatasi kendala Anda kapan pun dibutuhkan.</p>
            </div>

            <!-- Keunggulan 6 -->
            <div class="ml-feature-card">
                <div class="ml-feature-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3>Instalasi Cepat & Rapi</h3>
                <p>Proses pemasangan dilakukan oleh teknisi tersertifikasi dengan standar penataan kabel yang aman, tertib, dan rapi.</p>
            </div>

        </div>

    </div>
</section>

<!-- ==========================================================================
     5. JAVASCRIPT AJAX CEK BILL
     ========================================================================== -->
<script>
    function cek_bill() {
        var no = $('#no_services').val();
        var m = $('#month').val();
        var y = $('#year').val();
        var no_services = $('[name="no_services"]');
        var month = $('[name="month"]');
        var year = $('[name="year"]');
        
        if (no === '') {
            $('#no_services').focus();
            return false;
        }
        if (m === '') {
            $('#month').focus();
            return false;
        }
        if (y === '') {
            $('#year').focus();
            return false;
        }

        $.ajax({
            type: 'POST',
            data: "cek_bill=" + 1 + "&no_services=" + no_services.val() + "&month=" + month.val() + "&year=" + year.val(),
            url: '<?= site_url('front/view_bill') ?>',
            cache: false,
            beforeSend: function() {
                no_services.attr('disabled', true);
                $('.loading').html(`
                    <div class="text-center py-3">
                        <div class="spinner-border" style="width: 2.5rem; height: 2.5rem; color: var(--ml-primary);" role="status">
                            <span class="sr-only">Memeriksa...</span>
                        </div>
                        <div class="small text-muted font-weight-bold mt-2">Sedang memeriksa data tagihan Anda...</div>
                    </div>
                `);
            },
            success: function(data) {
                no_services.attr('disabled', false);
                $('.loading').html('');
                $('.view_data').html(data);
            },
            error: function() {
                no_services.attr('disabled', false);
                $('.loading').html('');
                $('.view_data').html('<div class="alert alert-danger">Gagal memeriksa tagihan. Pastikan koneksi internet Anda aktif.</div>');
            }
        });

        return false;
    }
</script>