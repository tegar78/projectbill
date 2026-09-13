<?php
$clean_company_name = trim(preg_replace('/\s*\(?BILL GAYUH BARU\)?/i', '', $company['company_name'] ?? 'PT. GAYUH MEDIA INFORMATIKA'));
if (empty($clean_company_name)) {
    $clean_company_name = 'PT. GAYUH MEDIA INFORMATIKA';
}
$wa_number = indo_tlp($company['whatsapp'] ?? '');
?>

<div class="ml-product-catalog my-4">
    <div class="container-fluid ml-header-container">
        
        <!-- Section Header -->
        <div class="ml-section-header text-center mb-5">
            <div class="ml-badge-pill">
                <i class="fas fa-wifi" style="color: var(--ml-primary);"></i>
                <span>Koneksi Internet Terbaik</span>
            </div>
            <h1 class="ml-section-title">Pilihan Paket Internet GayuhNet</h1>
            <p class="ml-section-desc mx-auto" style="max-width: 680px;">
                Nikmati akses internet 100% full fiber optic tanpa FUP dengan kecepatan simetris untuk kebutuhan rumah, kos, kantor, dan gaming.
            </p>
        </div>

        <!-- Product Cards Row -->
        <div class="row justify-content-center">
            <?php foreach ($product as $key => $data) {
                // Extract speed
                preg_match('/(\d+)\s*(?:Mbps|mbps|MB)/i', $data->name, $s_match);
                $speed_num = $s_match[1] ?? '10';

                // Official prices as requested
                $prices = [
                    '10' => '100.000',
                    '20' => '175.000',
                    '40' => '285.000',
                    '100' => '385.000',
                    '150' => '585.000'
                ];
                $price_display = $prices[$speed_num] ?? '100.000';

                $subtitles = [
                    '10' => 'Home Starter • 1-3 User',
                    '20' => 'Home Basic • 3-5 User',
                    '40' => 'Family Gamer • 5-8 User',
                    '100' => 'Pro Streamer • 8-12 User',
                    '150' => 'Ultra Biz • 15+ User'
                ];
                $sub_display = $subtitles[$speed_num] ?? 'Internet Dedicated';
                $is_popular = ($speed_num == '40');
                $wa_url = "https://api.whatsapp.com/send?phone=" . $wa_number . "&text=" . urlencode("Halo GayuhNet, saya ingin berlangganan " . $data->name . " (Rp " . $price_display . "/bln)");
                
                // Picture filename resolution with cache buster
                $pic_file = !empty($data->picture) ? $data->picture : ('product-' . $speed_num . 'mbps.png');
                $pic_path = FCPATH . 'assets/images/product/' . $pic_file;
                $pic_version = file_exists($pic_path) ? filemtime($pic_path) : time();
            ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex align-items-stretch">
                    <div class="ml-plan-card w-100 <?= $is_popular ? 'is-popular' : '' ?>">
                        <?php if ($is_popular) { ?>
                            <div class="ml-popular-ribbon">Paling Populer ⭐</div>
                        <?php } ?>

                        <!-- Ribbon Badge Banner from User Design -->
                        <div class="ml-ribbon-badge-wrap text-center mb-3">
                            <img src="<?= base_url('assets/images/product/' . $pic_file) ?>?v=<?= $pic_version ?>" alt="<?= htmlspecialchars($data->name) ?>" class="ml-product-badge-img">
                        </div>

                        <!-- Package Title & Subtitle Badge -->
                        <div class="ml-plan-badge-title text-center mb-3 pb-3" style="border-bottom: 1px solid var(--ml-border);">
                            <h4 class="font-weight-bold text-dark mb-1" style="font-size: 1.15rem;"><?= htmlspecialchars($data->name) ?></h4>
                            <span class="badge px-3 py-1 font-weight-semibold" style="background: var(--ml-primary-light); color: var(--ml-primary); border-radius: 50px; font-size: 0.8rem; letter-spacing: 0.2px;"><?= htmlspecialchars($sub_display) ?></span>
                        </div>

                        <ul class="ml-plan-features">
                            <li class="ml-feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>100% Full Fiber Optic</span>
                            </li>
                            <li class="ml-feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>True Unlimited (Tanpa FUP)</span>
                            </li>
                            <li class="ml-feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Kecepatan Simetris 1:1</span>
                            </li>
                            <li class="ml-feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Gratis Sewa Modem ONT WiFi</span>
                            </li>
                            <li class="ml-feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Dukungan Teknis Siaga 24/7</span>
                            </li>
                        </ul>

                        <div class="d-flex flex-column mt-auto pt-2" style="gap: 0.65rem;">
                            <a href="<?= $wa_url ?>" target="_blank" class="ml-btn ml-btn-primary w-100">
                                <i class="fab fa-whatsapp mr-1"></i>
                                <span>Pilih Paket Ini</span>
                            </a>
                            <a href="<?= site_url('detail-layanan/' . $data->link) ?>" class="ml-btn ml-btn-secondary w-100" style="font-size: 0.85rem; padding: 0.5rem 1rem;">
                                <span>Lihat Spesifikasi Detail</span>
                                <i class="fas fa-angle-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Trust Section Banner -->
        <div class="mt-5 p-4 p-md-5 text-center" style="background: var(--ml-surface); border: 1px solid var(--ml-border); border-radius: var(--ml-radius-xl); box-shadow: var(--ml-shadow-sm);">
            <h3 class="font-weight-bold text-dark mb-2" style="font-size: 1.4rem;">Semua Paket Termasuk Layanan Premium</h3>
            <p class="text-muted mx-auto mb-4" style="max-width: 600px;">
                Tanpa biaya tersembunyi, tanpa pembatasan kuota (FUP), dan didukung tim teknisi yang siap melayani Anda setiap saat.
            </p>
            <div class="row text-left justify-content-center">
                <div class="col-md-4 mb-3 mb-md-0 d-flex align-items-center" style="gap: 0.75rem;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: var(--ml-primary-light); color: var(--ml-primary); flex-shrink: 0; font-size: 1.1rem;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 0.95rem;">Simetris 1:1</strong>
                        <small class="text-muted">Kecepatan upload dan download sama kencangnya</small>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0 d-flex align-items-center" style="gap: 0.75rem;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: var(--ml-primary-light); color: var(--ml-primary); flex-shrink: 0; font-size: 1.1rem;">
                        <i class="fas fa-infinity"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 0.95rem;">True Unlimited</strong>
                        <small class="text-muted">Bebas kuota tanpa penurunan kecepatan FUP</small>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center" style="gap: 0.75rem;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: var(--ml-primary-light); color: var(--ml-primary); flex-shrink: 0; font-size: 1.1rem;">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 0.95rem;">CS Siaga 24/7</strong>
                        <small class="text-muted">Bantuan responsif via WhatsApp dan teknisi siaga</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>