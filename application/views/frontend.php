<?php
$clean_company_name = trim(preg_replace('/\s*\(?BILL GAYUH BARU\)?/i', '', $company['company_name'] ?? 'PT. GAYUH MEDIA INFORMATIKA'));
if (empty($clean_company_name)) {
    $clean_company_name = 'PT. GAYUH MEDIA INFORMATIKA';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?> | <?= htmlspecialchars($clean_company_name) ?> | <?= $company['sub_name'] ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Assistant:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/libraries/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/styles/main.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/styles/neumorphism-frontend.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>frontend/styles/modern-landing.css?v=<?= time() ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.4/dist/sweetalert2.all.min.js"></script>
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php $this->view('messages') ?>
    
    <!-- Modern Sticky Header with Glassmorphism -->
    <?php $role = $this->db->get_where('role_management', ['role_id' => 2])->row_array() ?>
    <header class="ml-header" id="siteHeader">
        <div class="container-fluid ml-header-container">
            <nav class="ml-navbar" aria-label="Navigasi Utama">
                <a href="<?= site_url('front') ?>" class="ml-brand">
                    <?php if (file_exists(FCPATH . 'assets/images/logo-gayuhnet.png')) { ?>
                        <img src="<?= base_url('assets/images/logo-gayuhnet.png') ?>" alt="GayuhNet">
                    <?php } else { ?>
                        <span style="color: var(--ml-dark);">GAYUH<span style="color: var(--ml-primary);">NET</span></span>
                    <?php } ?>
                </a>

                <!-- Desktop Navigation Menu -->
                <ul class="ml-nav-menu">
                    <li class="ml-nav-item"><a href="<?= site_url('front') ?>" class="ml-nav-link <?= $title == 'Home' ? 'active' : '' ?>">Beranda</a></li>
                    <li class="ml-nav-item"><a href="<?= site_url('layanan.html') ?>" class="ml-nav-link <?= $title == 'Produk Layanan' || $title == 'Detail Layanan' ? 'active' : '' ?>">Paket Internet</a></li>
                    <li class="ml-nav-item"><a href="<?= site_url('front') ?>#keunggulan" class="ml-nav-link">Keunggulan</a></li>
                    <li class="ml-nav-item"><a href="<?= site_url('front') ?>#cek-tagihan" class="ml-nav-link">Cek Tagihan</a></li>
                    <li class="ml-nav-item d-none d-xl-inline-flex"><a href="<?= site_url('front/coverage') ?>" class="ml-nav-link <?= $title == 'Coverage' ? 'active' : '' ?>">Coverage</a></li>
                    <li class="ml-nav-item d-none d-xl-inline-flex"><a href="<?= site_url('front/speedtest') ?>" class="ml-nav-link <?= $title == 'Speed Test' ? 'active' : '' ?>">Speed Test</a></li>
                    <li class="ml-nav-item"><a href="<?= site_url('tentang-kami.html') ?>" class="ml-nav-link <?= $title == 'Tentang Kami' ? 'active' : '' ?>">About Us</a></li>
                </ul>

                <!-- Desktop CTA Action Buttons -->
                <div class="ml-nav-actions">
                    <a href="<?= site_url('front') ?>#paket" class="ml-btn ml-btn-secondary ml-nav-btn">
                        <i class="fas fa-search-location mr-1" style="color: var(--ml-primary);"></i> Cek Area
                    </a>
                    <a href="<?= site_url('auth') ?>" class="ml-btn ml-btn-primary ml-nav-btn">
                        <i class="fas fa-user-circle mr-1"></i> Masuk
                    </a>
                </div>

                <!-- Mobile Hamburger Toggle Button -->
                <button class="ml-toggle-btn" id="navToggle" aria-label="Buka Menu Navigasi" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </nav>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div class="ml-mobile-drawer" id="mobileDrawer">
            <a href="<?= site_url('front') ?>" class="ml-nav-link <?= $title == 'Home' ? 'active' : '' ?>">Beranda</a>
            <a href="<?= site_url('layanan.html') ?>" class="ml-nav-link <?= $title == 'Produk Layanan' ? 'active' : '' ?>">Paket Layanan</a>
            <a href="<?= site_url('front') ?>#keunggulan" class="ml-nav-link">Keunggulan Layanan</a>
            <a href="<?= site_url('front') ?>#cek-tagihan" class="ml-nav-link">Cek Tagihan Mandiri</a>
            <a href="<?= site_url('front/coverage') ?>" class="ml-nav-link">Area Coverage</a>
            <a href="<?= site_url('front/speedtest') ?>" class="ml-nav-link">Speed Test</a>
            <a href="<?= site_url('tentang-kami.html') ?>" class="ml-nav-link">Tentang Kami</a>
            <div class="d-flex flex-column" style="gap: 0.75rem; margin-top: 0.5rem;">
                <a href="<?= site_url('front') ?>#paket" class="ml-btn ml-btn-secondary w-100">
                    <i class="fas fa-boxes mr-1"></i> Lihat Semua Paket
                </a>
                <a href="<?= site_url('auth') ?>" class="ml-btn ml-btn-primary w-100">
                    <i class="fas fa-sign-in-alt mr-1"></i> Portal Masuk Pelanggan
                </a>
            </div>
        </div>
    </header>

    <main>
        <script src="<?= base_url('assets/') ?>frontend/libraries/jquery/jquery-3.4.1.min.js"></script>
        <?= $contents ?>
    </main>

    <!-- Modern 4-Column Responsive Footer -->
    <footer class="ml-footer mt-auto" id="kontak">
        <div class="container">
            <div class="ml-footer-grid">
                <!-- Kolom 1: Profil Brand -->
                <div class="ml-footer-brand">
                    <h2>GAYUH<span style="color: var(--ml-primary);">NET</span></h2>
                    <p>
                        <?= htmlspecialchars($clean_company_name) ?> — Penyedia layanan internet fiber optic berkecepatan tinggi, stabil, dan terpercaya untuk perumahan dan bisnis.
                    </p>
                    <div class="small" style="color: #64748b;">
                        NIB / Legalitas: Terdaftar Resmi & Berizin Kominfo
                    </div>
                </div>

                <!-- Kolom 2: Paket & Layanan -->
                <div class="ml-footer-col">
                    <h4>Paket & Layanan</h4>
                    <ul class="ml-footer-links">
                        <li><a href="<?= site_url('layanan.html') ?>"><i class="fas fa-angle-right mr-1"></i> Internet Rumah Retail</a></li>
                        <li><a href="<?= site_url('layanan.html') ?>"><i class="fas fa-angle-right mr-1"></i> Internet Dedicated Bisnis</a></li>
                        <li><a href="<?= site_url('front/coverage') ?>"><i class="fas fa-angle-right mr-1"></i> Area Jangkauan Fiber</a></li>
                        <li><a href="<?= site_url('front/speedtest') ?>"><i class="fas fa-angle-right mr-1"></i> Uji Kecepatan (Speedtest)</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Layanan Pelanggan -->
                <div class="ml-footer-col">
                    <h4>Bantuan Pelanggan</h4>
                    <ul class="ml-footer-links">
                        <li><a href="<?= site_url('front') ?>#cek-tagihan"><i class="fas fa-angle-right mr-1"></i> Cek Tagihan Mandiri</a></li>
                        <li><a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp'] ?? ''); ?>" target="_blank"><i class="fas fa-angle-right mr-1"></i> Bantuan CS WhatsApp</a></li>
                        <li><a href="<?= site_url('tentang-kami.html') ?>"><i class="fas fa-angle-right mr-1"></i> Profil Perusahaan</a></li>
                        <li><a href="<?= site_url('auth') ?>"><i class="fas fa-angle-right mr-1"></i> Login Portal Pelanggan</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Info Kontak Resmi -->
                <div class="ml-footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul class="ml-footer-links">
                        <li><a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($company['whatsapp'] ?? ''); ?>" target="_blank"><i class="fab fa-whatsapp mr-2" style="color: #25D366;"></i> <?= htmlspecialchars($company['whatsapp'] ?? '-') ?></a></li>
                        <li><a href="mailto:<?= htmlspecialchars($company['email'] ?? ''); ?>"><i class="fas fa-envelope mr-2" style="color: var(--ml-primary);"></i> <?= htmlspecialchars($company['email'] ?? 'support@gayuh.net.id') ?></a></li>
                        <li><span style="font-size: 0.9rem; color: #94a3b8;"><i class="fas fa-map-marker-alt mr-2" style="color: #ef4444;"></i> <?= htmlspecialchars($company['address'] ?? 'Indonesia') ?></span></li>
                        <li style="color: #94a3b8; font-size: 0.88rem; margin-top: 0.35rem;"><i class="fas fa-clock mr-2 text-warning"></i> Layanan Support: 24/7 Setiap Hari</li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="ml-footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> <strong><?= htmlspecialchars($clean_company_name) ?></strong>. Seluruh Hak Cipta Dilindungi.
                </div>
                <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; justify-content: center;">
                    <a href="<?= site_url('tentang-kami.html') ?>" style="color: #94a3b8; text-decoration: none;">Syarat & Ketentuan</a>
                    <a href="<?= site_url('tentang-kami.html') ?>" style="color: #94a3b8; text-decoration: none;">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('assets/') ?>frontend/libraries/bootstrap/js/bootstrap.js"></script>

    <!-- Header & Mobile Drawer Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navToggle = document.getElementById('navToggle');
            var mobileDrawer = document.getElementById('mobileDrawer');
            var siteHeader = document.getElementById('siteHeader');

            if (navToggle && mobileDrawer) {
                navToggle.addEventListener('click', function() {
                    var isOpen = mobileDrawer.classList.toggle('open');
                    navToggle.setAttribute('aria-expanded', isOpen);
                });

                mobileDrawer.querySelectorAll('a').forEach(function(link) {
                    link.addEventListener('click', function() {
                        mobileDrawer.classList.remove('open');
                        navToggle.setAttribute('aria-expanded', 'false');
                    });
                });
            }

            window.addEventListener('scroll', function() {
                if (window.scrollY > 20) {
                    siteHeader.style.boxShadow = '0 10px 25px -5px rgba(15, 23, 42, 0.09)';
                } else {
                    siteHeader.style.boxShadow = 'none';
                }
            });
        });
    </script>

</body>

</html>
<?php $no_wa = indo_tlp($company['phonecode'] . $company['whatsapp']); ?>
<script>
    console.log('Ini adalah fitur browser yang ditujukan untuk developer. kami tidak bertanggung jawab jika anda mengubah script yg mengakibatkan error, dan mohon untuk tidak menjual kembali source code billing ini, jika terdeteksi maka tidak akan mendapatkan lagi support untuk update !');
    console.log('Ini adalah fitur browser yang ditujukan untuk pengguna. Jika seseorang meminta Anda untuk menyalin-menempel sesuatu di sini untuk mengaktifkan fitur Billing atau "meretas" akun seseorang, ini adalah penipuan dan akan memberikannya akses ke akun Akun Billing Anda.');
</script>
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function() {
        var options = {
            whatsapp: "<?php echo "$no_wa" ?>", // WhatsApp number
            call_to_action: "Kontak Kami", // Call to action
            position: "left", // Position may be 'right' or 'left'
        };
        var proto = document.location.protocol,
            host = "getbutton.io",
            url = proto + "//static." + host;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url + '/widget-send-button/js/init.js';
        s.onload = function() {
            WhWidgetSendButton.init(host, proto, options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = '<?= $company['tawk']; ?>';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->
<?php $cekcs = (isset($this->customer_m) && method_exists($this->customer_m, 'getisolirpasca')) ? $this->customer_m->getisolirpasca()->num_rows() : 0; ?>
<?php if ($cekcs > 0) { ?>
    <?php $rt = $this->db->get_where('router', ['id' => 1])->row_array() ?>
    <?php if ($rt['is_active'] == 1) { ?>
        <?php $other = $this->db->get('other')->row_array() ?>
        <!-- <script>
            setInterval("isolir();", 120000);

            function isolir() {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('front/isolir/' . $other['key_apps']) ?>',
                    cache: false,
                    success: function(data) {}
                });
                console.log('getisolir');
            }
            // return false;
        </script> -->
    <?php } ?>
<?php } ?>