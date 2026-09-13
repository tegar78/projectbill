# Rangkuman Komprehensif Pembaruan & Perbaikan Sistem ISP Billing
**PT. GAYUH MEDIA INFORMATIKA (BILL GAYUH)**  
*Dokumentasi Resmi Pembaruan Sistem, Perbaikan Bug, Alasan Teknis, dan File Path Terkait*  
*Tanggal Pembaruan: 07 September 2026*

---

## 📑 Daftar Isi
1. [Ringkasan Eksekutif](#ringkasan-eksekutif)
2. [Kategori 1: Perbaikan Bug Kritis & Logika Sistem (Bug Fixes)](#kategori-1-perbaikan-bug-kritis--logika-sistem-bug-fixes)
   - [1.1 Perbaikan Error 404 \| NOT FOUND saat Selesai Tambah Tiket Gangguan](#11-perbaikan-error-404--not-found-saat-selesai-tambah-tiket-gangguan)
   - [1.2 Perbaikan Teks Tombol "Simpan" Invisible / Tidak Terlihat pada Modal](#12-perbaikan-teks-tombol-simpan-invisible--tidak-terlihat-pada-modal)
   - [1.3 Perbaikan PHP Warning Undefined Variable $day pada Parsing Uptime MikroTik](#13-perbaikan-php-warning-undefined-variable-day-pada-parsing-uptime-mikrotik)
   - [1.4 Perbaikan Pencarian Pelanggan Rusak saat Melihat Detail Pelanggan](#14-perbaikan-pencarian-pelanggan-rusak-saat-melihat-detail-pelanggan)
   - [1.5 Perbaikan Koordinat Terbalik & Rute Google Maps Langsung Direct](#15-perbaikan-koordinat-terbalik--rute-google-maps-langsung-direct)
3. [Kategori 2: Transformasi & Revamp Desain ke Soft UI Neumorphism](#kategori-2-transformasi--revamp-desain-ke-soft-ui-neumorphism)
   - [2.1 Fondasi Sistem Desain Neumorphism Backend & Master Layout](#21-fondasi-sistem-desain-neumorphism-backend--master-layout)
   - [2.2 Revamp Total Halaman Login Admin & Pelanggan](#22-revamp-total-halaman-login-admin--pelanggan)
   - [2.3 Revamp Seluruh Modul Menu Pelanggan (Customer)](#23-revamp-seluruh-modul-menu-pelanggan-customer)
   - [2.4 Revamp Tampilan Riwayat Tagihan & Tombol Cetak A4 / Thermal](#24-revamp-tampilan-riwayat-tagihan--tombol-cetak-a4--thermal)
   - [2.5 Revamp Landing Page Publik](#25-revamp-landing-page-publik)
   - [2.6 Revamp Halaman About Us & Pembersihan Teks "BILL GAYUH BARU"](#26-revamp-halaman-about-us--pembersihan-teks-bill-gayuh-baru)
4. [Kategori 3: Penyempurnaan Elemen Visual & Kontras Aksesibilitas](#kategori-3-penyempurnaan-elemen-visual--kontras-aksesibilitas)
   - [3.1 Peningkatan Kontras Teks Brand Sidebar & Tombol Chevron Submenu](#31-peningkatan-kontras-teks-brand-sidebar--tombol-chevron-submenu)
   - [3.2 Revamp Tombol Aksi Detail Tiket Gangguan](#32-revamp-tombol-aksi-detail-tiket-gangguan)
   - [3.3 Integrasi Identitas Logo GayuhNet & Penyesuaian Slideshow](#33-integrasi-identitas-logo-gayuhnet--penyesuaian-slideshow)
5. [Tabel Matriks Berkas yang Dimodifikasi](#tabel-matriks-berkas-yang-dimodifikasi)

---

## 📌 Ringkasan Eksekutif
Rangkaian pembaruan ini bertujuan untuk mentransformasikan antarmuka aplikasi ISP Billing **GayuhNet** dari tampilan Bootstrap 4 konvensional menjadi antarmuka modern **Soft UI Neumorphism** yang elegan, taktil, dan berstandar **WCAG 2.2 AA/AAA**, sekaligus menuntaskan berbagai kendala teknis *critical bugs* (seperti error kebocoran respons gateway WhatsApp 404, parsing uptime MikroTik, Select2 crash, dan koordinat maps tertukar).

---

## 🛠️ Kategori 1: Perbaikan Bug Kritis & Logika Sistem (Bug Fixes)

### 1.1 Perbaikan Error 404 | NOT FOUND saat Selesai Tambah Tiket Gangguan
- **File Path Terkait**:
  - [`application/helpers/mywifi_helper.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/mywifi_helper.php)
  - [`application/controllers/Help.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/controllers/Help.php)
  - [`application/models/Help_m.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/models/Help_m.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Saat pengguna (admin maupun pelanggan) selesai mengisi form Tambah Tiket di `/help/data`, browser langsung menampilkan layar gelap dengan tulisan besar `404 | NOT FOUND`. Tiket tidak kembali ke daftar tiket.
  - **Akar Masalah**: Saat tiket disimpan, sistem mengirim notifikasi WhatsApp otomatis melalui gateway eksternal (Wablas). Karena server vendor Wablas saat itu merespons HTTP 404, baris kode debug liar `echo $response;` pada `mywifi_helper.php` mencetak mentah-mentah dokumen HTML 404 tersebut ke browser. Akibatnya terjadi *headers already sent*, dan fungsi `redirect()` PHP gagal total sehingga browser terkunci pada halaman error 404 tersebut.
- **Tindakan yang Dilakukan**:
  1. Menghapus seluruh baris debug `echo $response;` dan `echo $jadwal;` di `mywifi_helper.php`.
  2. Menambahkan `CURLOPT_TIMEOUT => 5` detik agar jika gateway WA bermasalah, aplikasi tidak *freeze*.
  3. Memperbaiki controller `Help.php` dengan validasi POST request, penanganan referer aman, dan timeout Telegram bot.
  4. Menyempurnakan model `Help_m.php` agar kompatibel dengan PHP 8+ saat membuat nomor tiket baru.
- **Hasil Akhir**: Proses simpan tiket berjalan instan, notifikasi SweetAlert berhasil muncul, dan pengguna dialihkan kembali ke daftar tiket dengan mulus.

---

### 1.2 Perbaikan Teks Tombol "Simpan" Invisible / Tidak Terlihat pada Modal
- **File Path Terkait**:
  - [`application/views/backend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php)
  - [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)
  - [`application/views/backend/help/data.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/data.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Tombol **Simpan** pada modal "Tambah Tiket Gangguan" hanya tampak berupa balok oranye polos tanpa teks tulisan "Simpan".
  - **Akar Masalah**: Terjadi konflik CSS (*conflicting styles*). File `backend.php` menetapkan background tombol `.btn-primary` menjadi oranye `#f47b20 !important;` tanpa deklarasi warna teks. Di saat yang sama, `neumorphism.css` menetapkan warna teks tombol menjadi `var(--nm-brand) !important;` (juga `#f47b20`). Teks oranye di atas latar belakang oranye identik membuat teks 100% tersamarkan (*invisible*).
- **Tindakan yang Dilakukan**:
  1. Menetapkan secara eksplisit `color: #ffffff !important;` pada `.btn-primary`, `:hover`, `:focus`, `:active`, serta elemen ikon dan span di dalamnya.
  2. Menyelaraskan aturan Neumorphic button global di `neumorphism.css`.
  3. Menambahkan ikon FontAwesome `<i class="fas fa-save mr-1"></i>` pada tombol Simpan dan `<i class="fas fa-times mr-1"></i>` pada tombol Batal.
- **Hasil Akhir**: Tulisan "Simpan" terbaca dengan sangat jelas, tajam (putih di atas oranye), berbobot tebal, dan memiliki kontras warna optimal.

---

### 1.3 Perbaikan PHP Warning Undefined Variable $day pada Parsing Uptime MikroTik
- **File Path Terkait**:
  - [`application/helpers/login_helper.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/login_helper.php)
  - [`application/views/backend/mikrotik/customer/client.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/mikrotik/customer/client.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Pada halaman detail koneksi pelanggan MikroTik, muncul kotak merah error besar CodeIgniter: `A PHP Error was encountered - Severity: Warning - Message: Undefined variable $day in helpers/login_helper.php`.
  - **Akar Masalah**: Fungsi `formattimemikro($dtm)` pada `login_helper.php` hanya mendefinisikan variabel `$day` jika format uptime router mengandung huruf `d` (hari). Saat koneksi pelanggan berdurasi di bawah 1 hari (misal `14h39m19s`), variabel `$day` tidak dibuat sehingga memicu warning PHP yang merusak tata letak kartu Uptime. Selain itu, file helper tersebut sebelumnya terenkripsi obfuscator usang `eval(gzinflate(base64_decode(...)))`.
- **Tindakan yang Dilakukan**:
  1. Mendekripsi dan membersihkan `login_helper.php` menjadi kode PHP murni tanpa ketergantungan enkripsi zeura.
  2. Menulis ulang parser `formattimemikro($dtm)` menggunakan regex tangguh yang mengurai minggu (`w`), hari (`d`), jam (`h`), menit (`m`), dan detik (`s`).
  3. Menginisialisasi nilai default 0 untuk semua unit waktu dan memformat string keluaran dengan presisi (`14:39:19` atau `2d 14:39:19`).
- **Hasil Akhir**: Bebas 100% dari warning PHP pada seluruh skenario uptime MikroTik dan kartu koneksi tampil bersih berestetika Neumorphism.

---

### 1.4 Perbaikan Pencarian Pelanggan Rusak saat Melihat Detail Pelanggan
- **File Path Terkait**:
  - [`application/views/backend/customer/data.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/data.php)
  - [`application/views/backend/customer/getdata.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/getdata.php)
  - [`application/views/backend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php)
  - [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)
- **Latar Belakang & Alasan Perbaikan**:
  - Setelah admin memilih pelanggan pertama melalui dropdown Select2 di menu Pelanggan, pengguna tidak bisa lagi mencari pelanggan lain. Dropdown tertutup sendiri atau melempar error JavaScript.
  - **Akar Masalah**: 
    1. File AJAX `getdata.php` mengeksekusi pemanggilan global `$('.select2').select2()`, yang merusak (*corrupt*) instance Select2 aktif pada elemen dropdown utama `#no_services`.
    2. Terdapat duplikasi ID DOM: di halaman utama ada `<select id="no_services">`, sedangkan di dalam `getdata.php` terdapat `<input type="hidden" id="no_services">`. Fungsi pencarian menjadi salah membaca ID input tersembunyi tersebut.
- **Tindakan yang Dilakukan**:
  1. Mengisolasi inisialisasi Select2 pada `getdata.php` hanya untuk modal lokal (`#databillhistory select.select2`).
  2. Mengubah ID input tersembunyi menjadi `id="detail_customer_no_services"`.
  3. Menambahkan tombol **"Kembali ke Daftar"** dan menangani reset pencarian secara mulus.
  4. Menetapkan `z-index: 9999 !important;` pada dropdown Select2 di `neumorphism.css`.
- **Hasil Akhir**: Admin dapat mencari dan berpindah antar pelanggan berkali-kali tanpa reload halaman dan tanpa error JavaScript.

---

### 1.5 Perbaikan Koordinat Terbalik & Rute Google Maps Langsung Direct
- **File Path Terkait**:
  - Database MySQL: Tabel `customer`
  - [`application/helpers/mywifi_helper.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/mywifi_helper.php)
  - [`application/views/backend/help/detail.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/detail.php)
  - [`application/controllers/Help.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/controllers/Help.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Tombol "Rute Google Maps" pada detail tiket hanya membuka peta kosong tanpa petunjuk arah. Peta Leaflet di form tiket juga hanya berupa kotak abu-abu (*blank gray box*).
  - **Akar Masalah**: Sebanyak **537 data pelanggan** di database memiliki kolom `latitude` dan `longitude` yang terbalik atau tercampur koma ganda (misal Latitude berisi `106.675079` dan Longitude berisi `-6.133934`). Di wilayah Indonesia, Latitude bumi harus antara -15° s/d +10°, sedangkan Longitude 90° s/d 145°. Format terbalik ini memicu error koordinat tidak valid pada Google Maps dan Leaflet.
- **Tindakan yang Dilakukan**:
  1. Membuat tabel backup database: `customer_backup_coords_20260907`.
  2. Menjalankan skrip pembersihan otomatis untuk menormalkan 537 data koordinat ke kolom yang benar.
  3. Membuat helper universal cerdas `get_google_maps_route($lat, $lng, $address)` dengan URL direct turn-by-turn: `https://www.google.com/maps/dir/?api=1&destination={lat},{lng}`.
  4. Memperbarui peta Leaflet dengan tile OpenStreetMap stabil dan pin marker lokasi pelanggan.
  5. Memperbarui notifikasi WhatsApp ke teknisi agar pesan otomatis berisi link rute Google Maps siap navigasi di ponsel.
- **Hasil Akhir**: Tombol rute di web dan link di WhatsApp teknisi langsung membuka navigasi Google Maps turn-by-turn ke lokasi rumah pelanggan.

---

## 🎨 Kategori 2: Transformasi & Revamp Desain ke Soft UI Neumorphism

### 2.1 Fondasi Sistem Desain Neumorphism Backend & Master Layout
- **File Path Terkait**:
  - [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)
  - [`application/views/backend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Tampilan dashboard dan backend administrasi sebelumnya mengusung template flat SB Admin 2 standar yang monoton, tanpa kedalaman visual (*flat design*), dan memiliki submenu putih kaku (`bg-white`) yang bertabrakan dengan konsep antarmuka modern.
- **Tindakan yang Dilakukan**:
  1. Membangun sistem token Neumorphism: Kanvas `--nm-bg: #e6ecf4` (Light) & `#111625` (Dark), dual box-shadow timbul (`--nm-raised`, `--nm-raised-sm`) dan cekung (`--nm-inset`, `--nm-inset-sm`).
  2. Menambahkan efek interaktif taktil: tombol terangkat saat hover dan mencekung (*debossed*) saat ditekan.
  3. Mengubah wadah submenu sidebar accordion menjadi *inset well* yang menyatu lembut dengan kanvas tanpa kotak putih kaku.
  4. Menerapkan cache-buster dinamis `?v=<?= time() ?>` agar browser selalu memuat CSS terbaru.
- **Hasil Akhir**: Seluruh antarmuka admin memiliki estetika 3D taktil yang nyaman dipandang mata dan konsisten di setiap modul.

---

### 2.2 Revamp Total Halaman Login Admin & Pelanggan
- **File Path Terkait**:
  - [`application/views/backend/auth/login.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/auth/login.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Halaman login sebelumnya masih flat, logo tidak proporsional, dan formulir login tidak memiliki identitas khas ISP GayuhNet.
- **Tindakan yang Dilakukan**:
  1. Merombak kartu login menjadi kartu timbul Neumorphic ganda (`--nm-raised-lg`) dengan sudut lengkung 28px.
  2. Memasang logo GayuhNet berukuran besar dan jernih di dalam badge berbayang timbul halus.
  3. Mengubah input email dan password menjadi *debossed inset well* dengan animasi fokus oranye.
  4. Menambahkan fitur interaktif intip password (*show/hide password toggle*).
  5. Menambahkan tombol login taktil oranye 3D berikon.
- **Hasil Akhir**: Tampilan gerbang masuk aplikasi terasa premium, modern, dan profesional sejak pandangan pertama.

---

### 2.3 Revamp Seluruh Modul Menu Pelanggan (Customer)
- **File Path Terkait**:
  - [`application/views/backend/customer/data.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/data.php)
  - [`application/views/backend/customer/getdata.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/getdata.php)
  - [`application/views/backend/customer/get-data-customer.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/get-data-customer.php)
  - [`application/views/backend/customer/add_customer.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/add_customer.php)
  - [`application/views/backend/customer/edit_customer.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/edit_customer.php)
  - [`application/views/backend/customer/whatsapp.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/whatsapp.php)
  - [`application/views/backend/customer/maps.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/maps.php)
  - [`application/views/backend/customer/filterby.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/filterby.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Menu pelanggan adalah modul yang paling sering digunakan oleh operasional ISP setiap hari. Desain lama menggunakan tombol-tombol flat yang padat, tabel tanpa hierarki kedalaman, dan form input konvensional.
- **Tindakan yang Dilakukan**:
  1. Mengubah seluruh kontainer tabel DataTables ke kartu Neumorphic timbul (`.nm-card`) lengkap dengan badge estimasi pendapatan inset.
  2. Merombak form Tambah dan Edit Pelanggan menjadi formulir Neumorphic taktil berbayang cekung.
  3. Mengubah modul Kirim WhatsApp (5 kartu pengiriman) menjadi kartu Neumorphic dengan textarea inset yang elegan.
  4. Membungkus peta Leaflet pelanggan dalam bingkai Neumorphic beradius halus.
- **Hasil Akhir**: Operasional manajemen pelanggan terasa lebih nyaman, responsif, dan rapi secara visual.

---

### 2.4 Revamp Tampilan Riwayat Tagihan & Tombol Cetak A4 / Thermal
- **File Path Terkait**:
  - [`application/views/backend/bill/tampil_history.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/bill/tampil_history.php)
  - [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)
- **Latar Belakang & Alasan Perbaikan**:
  - Tombol cetak **A4** dan **Thermal** pada tabel riwayat pembayaran tagihan pelanggan tampak terhimpit, bentuknya ganjil, dan teksnya gepeng.
  - **Akar Masalah**: Teks "A4" dan "Thermal" tertulis di dalam tag ikon `<i class="fa fa-print"> A4</i>` sehingga mewarisi font glyph ikon. Selain itu, aturan CSS lama memaksa seluruh ikon baris tabel menjadi kotak 32px tersendiri sehingga tombol A4 menjadi "tombol di dalam tombol" yang membengkak.
- **Tindakan yang Dilakukan**:
  1. Menambahkan aturan pengecualian pada `neumorphism.css` untuk `.table td a.btn i`.
  2. Memisahkan teks dari tag ikon (`<i class="fas fa-print"></i> <span>A4</span>`).
  3. Membungkus tombol dalam kontainer flexbox kompak (`.nm-btn-xs`, padding `4px 9px`, tinggi `26px`).
  4. Menata ulang tabel riwayat 12 bulan menjadi 1 query database terpadu dengan badge status bayar debossed.
- **Hasil Akhir**: Tombol A4 dan Thermal pas (*fit*) sempurna, teks tajam, dan tabel riwayat tagihan terlihat rapi dan simetris.

---

### 2.5 Revamp Landing Page Publik
- **File Path Terkait**:
  - [`application/views/frontend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php)
  - [`application/views/frontend/welcome_message.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/welcome_message.php)
  - [`assets/frontend/styles/neumorphism-frontend.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/frontend/styles/neumorphism-frontend.css)
- **Latar Belakang & Alasan Perbaikan**:
  - Halaman depan publik (`/`) merupakan representasi citra ISP kepada calon pelanggan dan pelanggan yang ingin mengecek tagihan. Tampilan lama memiliki navbar biru gelap pekat yang kaku, kartu form tagihan flat biasa, dan tombol sosial media standar.
- **Tindakan yang Dilakukan**:
  1. Membuat stylesheet terdedikasi `neumorphism-frontend.css` bertema kanvas lembut `#e6ecf4` dan tipografi Google Fonts **Plus Jakarta Sans**.
  2. Merombak top navbar menjadi floating header Neumorphic dengan pill navigation link dan tombol Masuk oranye 3D.
  3. Merombak kartu "Cek Tagihan Pelanggan" dengan input form debossed/cekung taktil.
  4. Merombak tombol sosial media (Instagram, Facebook, WhatsApp, Email) menjadi **3D Neumorphic Squircles** berukuran 58px × 58px dengan efek hover pendaran warna masing-masing brand.
  5. Mengubah kartu paket layanan menjadi kartu timbul Neumorphic 3D dengan tray gambar cekung (*recessed tray*).
- **Hasil Akhir**: Landing page publik tampil elegan, modern, taktil, dan memiliki identitas kuat sebagai ISP profesional.

---

### 2.6 Revamp Halaman About Us & Pembersihan Teks "BILL GAYUH BARU"
- **File Path Terkait**:
  - Database MySQL: Tabel `company` (kolom `company_name`)
  - [`application/views/frontend/about.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/about.php)
  - [`application/views/frontend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php)
- **Latar Belakang & Alasan Perbaikan**:
  - Pada halaman About Us (`/tentang-kami.html`), terdapat tulisan `(BILL GAYUH BARU)` yang muncul berulang kali di header, profil, dan kontak. Selain itu, halamannya masih menggunakan banner ungu jumbotron lama yang gelap dan kaku.
- **Tindakan yang Dilakukan**:
  1. Membersihkan nilai database tabel `company` secara permanen menjadi `PT. GAYUH MEDIA INFORMATIKA` murni.
  2. Menerapkan sanitasi regex dinamis pada view template agar teks tersebut tidak akan muncul lagi di `<title>` maupun copyright footer.
  3. Merombak seluruh halaman About Us ke gaya Neumorphism: banner jumbotron lama digantikan kartu profil timbul 3D, grid 4 keunggulan perusahaan dengan squircle berwarna, serta kartu kontak taktil.
- **Hasil Akhir**: Halaman Tentang Kami bersih 100% dari kata "BILL GAYUH BARU" dan serasi dengan tema Neumorphism aplikasi.

---

## 👁️ Kategori 3: Penyempurnaan Elemen Visual & Kontras Aksesibilitas

### 3.1 Peningkatan Kontras Teks Brand Sidebar & Tombol Chevron Submenu
- **File Path Terkait**:
  - [`application/views/backend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php)
  - [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)
- **Latar Belakang & Alasan Perbaikan**:
  - Teks nama brand "BILL GAYUH UTAMA" di pojok kiri atas sidebar sebelumnya berwarna putih di atas kanvas abu-abu terang `#e6ecf4`, sehingga sangat sulit dibaca (*low contrast*). Selain itu, tombol panah chevron `>` submenu menempel di sebelah teks menu dan warnanya pudar.
- **Tindakan yang Dilakukan**:
  1. Mengubah teks brand pada Light Mode menjadi `#1e293b` (Dark Slate, rasio kontras 10.5:1 melampaui standar WCAG AAA) dengan `font-weight: 800`.
  2. Menambahkan `margin-left: auto !important;` pada ikon chevron `>` dan membungkusnya sebagai tombol lingkaran Neumorphic mini 24px × 24px yang otomatis berubah warna oranye saat hover/aktif.
  3. Memperbaiki tombol toggle collapse sidebar di bagian bawah agar timbul dan kontras.
- **Hasil Akhir**: Logo dan tulisan brand di sidebar langsung terbaca jelas dan navigasi submenu terlihat presisi serta rapi.

---

### 3.2 Revamp Tombol Aksi Detail Tiket Gangguan
- **File Path Terkait**:
  - [`application/views/backend/help/detail.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/detail.php)
  - [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)
- **Latar Belakang & Alasan Perbaikan**:
  - Tombol aksi tiket (WA Pelanggan, Ambil Tiket, Update Tiket, Telp) sebelumnya menggunakan outline tipis flat yang tidak memiliki aksen kedalaman.
- **Tindakan yang Dilakukan**:
  1. Mengubah tombol **WA Pelanggan** menjadi tombol Neumorphic hijau zamrud timbul (`.nm-btn-success`).
  2. Mengubah tombol **Ambil Tiket** menjadi tombol Neumorphic merah koral timbul (`.nm-btn-danger`).
  3. Mengubah tombol **Rute Google Maps** dan **Update Tiket** menjadi tombol taktil oranye brand.
- **Hasil Akhir**: Tombol-tombol aksi penanganan gangguan pelanggan tampil mencolok, taktil, dan mudah diakses oleh operator/teknisi.

---

### 3.3 Integrasi Identitas Logo GayuhNet & Penyesuaian Slideshow
- **File Path Terkait**:
  - [`assets/images/logo-gayuhnet.png`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/images/logo-gayuhnet.png)
  - [`application/views/frontend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php)
  - [`application/views/frontend/welcome_message.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/welcome_message.php)
  - [`assets/frontend/styles/neumorphism-frontend.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/frontend/styles/neumorphism-frontend.css)
- **Latar Belakang & Alasan Perbaikan**:
  - Logo GayuhNet di pojok kiri atas navbar sebelumnya kurang terlihat jelas dan ukurannya kecil.
  - Terdapat serangkaian pengujian penyesuaian slideshow agar foto keluarga dan teks "GAYUHNET" tampil proporsional tanpa terpotong (*zero crop*), serta eksplorasi infinite loop slider yang kemudian dikembalikan secara presisi ke carousel semula sesuai kenyamanan pengguna.
- **Tindakan yang Dilakukan**:
  1. Menyimpan file logo resmi beresolusi tinggi di `assets/images/logo-gayuhnet.png`.
  2. Memperbarui navbar frontend dengan logo tersebut dan meningkatkan tinggi maksimum tampilan hingga 100px.
  3. Memastikan seluruh komponen carousel di `welcome_message.php` dan `neumorphism-frontend.css` stabil, responsif, dan kembali ke format carousel semula sesuai arahan pengguna.
- **Hasil Akhir**: Logo GayuhNet tampil jernih dan menonjol di navbar atas, serta slideshow carousel berjalan stabil.

---

## 📊 Tabel Matriks Berkas yang Dimodifikasi

| No | File Path | Modul / Bagian | Ringkasan Perubahan |
| :---: | :--- | :--- | :--- |
| 1 | [`assets/backend/css/neumorphism.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css) | Core Backend | Design tokens Neumorphism, dual shadows, status badges, buttons, form controls. |
| 2 | [`application/views/backend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php) | Layout Admin | Kontras brand sidebar, chevron submenu, tombol primary white text, cache buster. |
| 3 | [`application/views/backend/auth/login.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/auth/login.php) | Autentikasi | Revamp total login page Neumorphic 3D, show/hide password, logo GayuhNet. |
| 4 | [`application/views/backend/dashboard.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/dashboard.php) | Dashboard | Kartu ringkasan ISP, status tiket, pencarian cepat, grafik keuangan Soft UI. |
| 5 | [`application/views/backend/customer/data.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/data.php) | Pelanggan | Kartu pencarian, tombol aksi Neumorphic, integrasi tabel data pelanggan. |
| 6 | [`application/views/backend/customer/getdata.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/getdata.php) | Pelanggan | Isolasi Select2, perbaikan duplikasi ID, tombol aksi taktil, tombol Kembali. |
| 7 | [`application/views/backend/customer/get-data-customer.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/get-data-customer.php) | Pelanggan | Rendering AJAX DataTables Neumorphic, badge pendapatan, modal hapus Soft UI. |
| 8 | [`application/views/backend/customer/add_customer.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/add_customer.php) | Pelanggan | Form input tambah pelanggan & konfigurasi paket berbayang cekung taktil. |
| 9 | [`application/views/backend/customer/edit_customer.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/edit_customer.php) | Pelanggan | Form edit pelanggan Soft UI dan tombol footer taktil. |
| 10 | [`application/views/backend/customer/whatsapp.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/whatsapp.php) | Pelanggan | Revamp 5 kartu kirim pesan WhatsApp pelanggan ke tema Neumorphism. |
| 11 | [`application/views/backend/customer/maps.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/maps.php) | Pelanggan | Bingkai peta Leaflet berbayang timbul dan DataTables Neumorphic. |
| 12 | [`application/views/backend/customer/filterby.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/filterby.php) | Pelanggan | Tampilan hasil filter data pelanggan bertema Soft UI. |
| 13 | [`application/views/backend/bill/tampil_history.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/bill/tampil_history.php) | Tagihan | Perbaikan tombol cetak A4 & Thermal fit, pemisahan teks ikon, query 12 bulan. |
| 14 | [`application/views/backend/bill/unpaid.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/bill/unpaid.php) | Tagihan | Pemilihan filter bulan default cerdas dan form filter tagihan Neumorphic. |
| 15 | [`application/views/backend/bill/paid.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/bill/paid.php) | Tagihan | Pemilihan filter bulan default cerdas dan form filter tagihan lunas Neumorphic. |
| 16 | [`application/views/backend/bill/bill.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/bill/bill.php) | Tagihan | Filter tagihan bulanan dan opsi "Semua Bulan / Semua Tahun". |
| 17 | [`application/views/backend/mikrotik/customer/client.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/mikrotik/customer/client.php) | MikroTik | Penataan kartu Data Pelanggan, perbaikan tombol aksi, kartu live traffic. |
| 18 | [`application/helpers/login_helper.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/login_helper.php) | Helper | Dekripsi kode dari zeura obfuscator, perbaikan regex parser uptime MikroTik. |
| 19 | [`application/helpers/mywifi_helper.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/mywifi_helper.php) | Helper | Eliminasi debug output 404 Wablas, penambahan helper universal Google Maps. |
| 20 | [`application/controllers/Help.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/controllers/Help.php) | Bantuan / Tiket | Penanganan request POST aman, redirect referer, URL maps WhatsApp teknisi. |
| 21 | [`application/models/Help_m.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/models/Help_m.php) | Bantuan / Tiket | Kompatibilitas penomoran tiket PHP 8+ dan pengamanan array parameter. |
| 22 | [`application/views/backend/help/data.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/data.php) | Bantuan / Tiket | Perbaikan tombol Simpan modal Tambah Tiket, teks putih kontras, ikon FontAwesome. |
| 23 | [`application/views/backend/help/detail.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/detail.php) | Bantuan / Tiket | Tombol WA Pelanggan & Ambil Tiket Neumorphic, peta OpenStreetMap pelanggan. |
| 24 | [`application/views/frontend.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php) | Layout Publik | Floating navbar Neumorphic, integrasi logo GayuhNet 100px, footer bersih. |
| 25 | [`application/views/frontend/welcome_message.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/welcome_message.php) | Landing Page | Kartu Cek Tagihan inset, tombol sosial media 3D squircle, carousel Neumorphic. |
| 26 | [`application/views/frontend/about.php`](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/about.php) | Profil Perusahaan | Revamp About Us ke Soft UI, eliminasi seluruh teks "BILL GAYUH BARU". |
| 27 | [`assets/frontend/styles/neumorphism-frontend.css`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/frontend/styles/neumorphism-frontend.css) | Frontend CSS | Pusat aturan styling Neumorphism frontend publik dan breakpoints responsif. |
| 28 | [`assets/images/logo-gayuhnet.png`](file:///d:/project/bill3-gyh.gayuh.net.id/assets/images/logo-gayuhnet.png) | Asset Visual | File logo resmi GayuhNet beresolusi tinggi untuk navbar dan login. |
| 29 | Database MySQL (`customer` & `company`) | Database | Normalisasi 537 titik koordinat pelanggan, pembersihan nama company resmi. |
