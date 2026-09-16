# Catatan Perbaikan V3 — Stabilitas Role Management, PHP 8.2+ Compatibility, & Refinement UI/UX Maps Pelanggan
**Tanggal:** 16 September 2026  
**Aplikasi:** Sistem Billing & Manajemen Jaringan (PT. GAYUH MEDIA INFORMATIKA)  
**Fokus Perbaikan:** Penanganan Blank Page & Keseimbangan DOM Role Menu, Eliminasi Undefined Variable `$package` pada Role Management, Harmonisasi Toolbar & Eliminasi Duplikasi Icon Fullscreen Maps Pelanggan, Mitigasi Warning PHP 8.2+ Coverage Operator, serta Standarisasi Tipe Data & PHPDoc Type Annotations.

---

## 📋 Ringkasan Eksekutif Perbaikan

Pada pembaruan versi 3 (V3) ini, dilakukan rangkaian audit, perbaikan stabilitas (*bug fixing*), dan peningkatan arsitektur sistem pada modul administrasi dan pemetaan:
1. **Pemberantasan Layar Putih (Blank Page) & Kerusakan Tata Letak DOM** pada halaman `Role Management > Menu` (`/role/menu`).
2. **Penanganan Notice & Fatal Error PHP** pada halaman `Role Management > Role` (`/role`) terkait variabel `$package` yang belum terdefinisi.
3. **Penyelarasan Kolom Database Permission**: Sinkronisasi nama field `setting_terms_condition` (singular) pada tabel `role_management` untuk hak akses Syarat & Ketentuan.
4. **Refinement UI/UX & Eliminasi Duplikasi Kontrol Fullscreen Peta** pada menu `Pelanggan > Maps` (`/customer/maps` dan `/maps`), merapikan ikon-ikon toolbar dari warna kontras pelangi menjadi palet *calm slate* yang terintegrasi dengan Neumorphism dan oranye brand `#f47b20`.
5. **Mitigasi Masalah Kompatibilitas PHP 8.2+**: Inisialisasi eksplisit variabel `$row = []` pada 10 method query model `Customer_m.php` untuk mencegah *Undefined Variable* saat akun operator belum memiliki cakupan wilayah (*empty coverage*).
6. **Perbaikan Signature Parameter Helper**: Penambahan nilai bawaan opsional (`$source = null`) pada fungsi `openisolir()` di `login_helper.php` untuk mencegah `ArgumentCountError` di PHP 8.0+.
7. **Standarisasi Anotasi Tipe PHPDoc**: Dokumentasi tipe parameter dan return `@param` / `@return` pada seluruh fungsi `mywifi_helper.php` dan method controller `Customer.php` guna mendukung analisis statis bebas error.

---

## 🛠️ Rincian Modul Perbaikan

### 1. Perbaikan Blank Page & Keseimbangan Tag DOM pada Menu Role Management > Menu
* **Lokasi Berkas:** [application/views/backend/role/menu.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/role/menu.php) & [application/controllers/Role.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Role.php)
* **Masalah Sebelumnya:**
  - Saat membuka menu **Role Management > Role Menu** (`http://billtest.gayuh.net.id.test/role/menu`), halaman mengalami tampilan blank atau tata letak kontainer bawah terpotong parah (*DOM layout collapse*).
  - Terdapat tag pembuka `<div class="col-lg-12">` pada baris 650 yang tidak memiliki pasangan tag penutup `</div>` sebelum skrip template JavaScript `select_template()`. Hal ini menyebabkan hierarki penutupan elemen di master template `backend.php` rusak (*broken DOM tree*), membatalkan penutupan kontainer kartu dan footer.
  - Pada pembacaan hak akses submenu pengaturan (Operator, Teknisi, dan Mitra), pemanggilan array input checkbox menggunakan nama kolom jamak `setting_terms_conditions` (berakhiran 's') padahal kolom asli di tabel database `role_management` adalah `setting_terms_condition` (tunggal/singular). Hal ini menimbulkan *PHP Warning: Undefined array key "setting_terms_conditions"* dan membuat status checkbox Syarat & Ketentuan gagal tersimpan/terbaca.
  - Tampilan pohon menu (`.list-group-tree`) belum mengadopsi palet warna gelap (*Dark Mode*), sehingga teks dan batas border kotak menu sulit terbaca saat mode malam aktif.
* **Solusi & Implementasi:**
  - **Penutupan Tag DOM Presisi:** Menambahkan tag penutup `</div>` pada baris 651 untuk menutup `<div class="col-lg-12">` secara valid sebelum blok `<script>`.
  - **Koreksi Kolom Database Schema:** Mengubah pemanggilan atribut data pada baris 240, 424, dan 606 menjadi `isset($menu*['setting_terms_condition']) && $menu*['setting_terms_condition'] == 1 ? 'checked' : ''` serta menyamakan atribut input `name="setting_terms_condition"`.
  - **Adaptasi Neumorphic Dark/Light Mode:** Menambahkan aturan CSS modern untuk `.list-group-item`:
    ```css
    .list-group-item {
        background-color: var(--nm-bg, #f0f3f8);
        color: var(--nm-text-main, #2d3748) !important;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }
    html.dark-mode .list-group-item,
    body.dark-mode .list-group-item {
        background-color: #1a2236 !important;
        color: #f1f5f9 !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }
    ```
  - **Penyempurnaan Ikon Panah Ekspansi:** Menambahkan deklarasi bobot `font-family: "Font Awesome 5 Free"; font-weight: 900;` dan transisi animasi putar halus (`transition: transform 0.2s ease`) pada pemilih kelas `.fa-chevron`.
  - **Penerusan Data Controller:** Pada `Role::menu()`, menambahkan `$data['package'] = $this->db->get('package')->row_array();` untuk konsistensi layout template.

---

### 2. Penanganan Undefined Variable `$package` pada Menu Role Management > Role Access
* **Lokasi Berkas:** [application/controllers/Role.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Role.php) & [application/views/backend/role/role.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/role/role.php)
* **Masalah Sebelumnya:**
  - Saat membuka menu **Role Management > Role** (`http://billtest.gayuh.net.id.test/role`), muncul pesan kesalahan PHP:
    `A PHP Error was encountered — Severity: Notice — Message: Undefined variable: package — Filename: role/role.php — Line Number: 39`.
  - Pada baris 39 view `role.php`, sistem memeriksa apakah konfigurasi paket mengaktifkan fitur pembatasan wilayah operator (`if ($package['coverage_operator'] == 1)`). Namun, controller `Role::index()` tidak mengambil maupun mengoper variabel `$package` ke dalam array `$data`.
* **Solusi & Implementasi:**
  - **Injeksi Data di Controller:** Pada `Role::index()`, menyertakan pemanggilan query tabel package:
    ```php
    $data['package'] = $this->db->get('package')->row_array();
    ```
  - **Defensive Fallback di View:** Menambahkan pengaman ganda (*defensive coding*) di baris 12 dan baris 39 pada `role.php`:
    ```php
    <?php $package = isset($package) && is_array($package) ? $package : $this->db->get('package')->row_array() ?>
    ...
    <?php if (!empty($package['coverage_operator']) && $package['coverage_operator'] == 1) { ?>
    ```
  - Hal ini menjamin bahwa view `role.php` tetap kebal terhadap error (*fault-tolerant*) bahkan jika dipanggil dari modul eksternal tanpa menyertakan variabel `$package`.

---

### 3. Eliminasi Duplikasi Icon Fullscreen & Refinement UI/UX Maps Pelanggan
* **Lokasi Berkas:** [application/views/backend.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend.php), [application/views/backend/maps/maps.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/maps/maps.php), & [application/views/backend/customer/maps.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/customer/maps.php)
* **Masalah Sebelumnya:**
  - Pada halaman pemetaan pelanggan (`Pelanggan > Maps`), tombol Fullscreen (Layar Penuh) di sudut kiri atas kanvas peta Leaflet muncul bertumpuk/ganda (dua ikon kotak layar penuh bertumpuk satu sama lain).
  - Investigasi akar masalah menemukan dua penyebab simultan:
    1. Berkas `backend.php` pada baris 1884-1885 memuat pustaka Mapbox `Leaflet.fullscreen.min.js` dan stylesheet-nya secara global untuk seluruh halaman backend, sementara berkas `maps.php` memuat pustaka Leaflet Fullscreen lokalnya sendiri.
    2. Konfigurasi inisialisasi `L.map('mapid', { ... fullscreenControl: true })` secara otomatis menginjeksi kontrol layar penuh bawaan Leaflet, yang kemudian ditimpa lagi oleh injeksi kontrol dari plugin Leaflet Fullscreen.
  - Toolbar aksi peta di atas kanvas peta menggunakan warna-warni kontras (*rainbow styling*: tombol `text-warning`, `text-info`, `text-primary`, `text-success`) yang terlihat ramai, acak, dan tidak serasi dengan konsep estetika Neumorphic Gayuh Media.
  - Kelima tombol aksi disajikan sebagai deretan datar tanpa pengelompokan semantik fungsional.
  - Berkas pembungkus `application/views/backend/customer/maps.php` memanggil `$this->load->view('backend/maps/maps')` tanpa meneruskan variabel lingkungan global view, sehingga jika view anak membutuhkan variabel `$stats` atau `$coverage`, variabel tersebut berisiko kosong.
* **Solusi & Implementasi:**
  - **Pembersihan Dependency Global:** Menghapus tag script dan stylesheet `Leaflet.fullscreen` yang redundan pada baris 1884-1885 di `application/views/backend.php`.
  - **Inisialisasi Tunggal Fullscreen Terkendali:** Mengubah opsi peta di `maps.php` menjadi `fullscreenControl: false`, kemudian menambahkan kontrol layar penuh secara eksplisit hanya satu kali dengan proteksi deteksi tipe:
    ```javascript
    mymap = L.map('mapid', {
        center: [defaultLat, defaultLng],
        zoom: 13,
        layers: [initialLayer],
        fullscreenControl: false
    });

    if (typeof L.control.fullscreen === 'function') {
        mymap.addControl(L.control.fullscreen({
            position: 'topleft',
            title: { 'false': 'Layar Penuh', 'true': 'Keluar Layar Penuh' }
        }));
    } else if (typeof L.Control.Fullscreen === 'function') {
        mymap.addControl(new L.Control.Fullscreen({
            position: 'topleft',
            title: { 'false': 'Layar Penuh', 'true': 'Keluar Layar Penuh' }
        }));
    }
    ```
  - **Harmonisasi Palet Warna Toolbar (.map-tool-icon):**
    - Menghapus kelas warna pelangi acak (`text-warning`, `text-info`, `text-primary`, dll.).
    - Menerapkan kelas penataan seragam `.map-tool-icon` dengan warna dasar *calm slate* netral (`#64748b` pada mode terang dan `#94a3b8` pada mode gelap).
    - Menambahkan interaktivitas dinamis: saat kursor diarahkan (*hover*) atau tombol aktif (`.active-tool`), ikon bertransisi mulus ke warna oranye brand `#f47b20` dengan pembesaran halus (`transform: scale(1.12)`).
  - **Pengelompokan Toolbar Semantik (Grouped Layout):**
    - Mengelompokkan tombol menjadi dua grup fungsional berdekatan:
      - **Grup Navigasi Peta:** Tombol `Pusatkan` dan `Lokasi Saya`.
      - **Grup Lapisan (Layer):** Tombol `Coverage Area` dan `Sync Tabel`.
      - **Aksi Cepat Mandiri:** Tombol reload data (`fas fa-sync-alt`) dalam ukuran kompak.
  - **Penerusan Variabel Aman & Fallback:**
    - Pada `customer/maps.php`, memperbarui pemanggilan view menjadi `$this->load->view('backend/maps/maps', $this->load->get_vars());`.
    - Menambahkan inisialisasi default `$stats` yang aman di bagian teratas `maps.php` untuk mencegah error saat variabel statistik tidak disediakan oleh controller pemanggil.

---

### 4. Mitigasi Warning PHP 8.2+ & Inisialisasi `$row = []` pada Operator Coverage Filter
* **Lokasi Berkas:** [application/models/Customer_m.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/models/Customer_m.php)
* **Masalah Sebelumnya:**
  - Pada lingkungan PHP 8.2 dan PHP 8.3, aturan penanganan variabel yang belum diinisialisasi (*uninitialized variables*) menjadi sangat ketat dan memicu `PHP Warning: Undefined variable $row`.
  - Pada 10 method query model `Customer_m.php`:
    - `_get_data_queryactive()`
    - `getfilterbydraf()`
    - `_get_data_querynonactive()`
    - `_get_data_querywait()`
    - `getcapeloperator()`
    - `_get_data_query()`
    - `_get_data_querypaket()`
    - `_get_datatables_query()`
    - `count_filtered()`
    - `count_all()`
    Terdapat pengecekan hak akses operator:
    ```php
    if ($role['coverage_operator'] == 1) {
        $operator = $this->db->get_where('cover_operator', ['operator' => $this->session->userdata('id')])->result();
        foreach ($operator as $roww) {
            $row[] = $roww->coverage_id;
        }
        $this->db->where_in('coverage', $row);
    }
    ```
  - Jika seorang pengguna dengan role Operator belum ditetapkan ke wilayah cakupan mana pun pada tabel `cover_operator`, loop `foreach` tidak pernah dieksekusi. Akibatnya variabel `$row` tidak pernah tercipta, dan pemanggilan `$this->db->where_in('coverage', $row)` menimbulkan *Undefined Variable* dan menyebabkan query SQL crash.
* **Solusi & Implementasi:**
  - Menginisialisasi secara eksplisit `$row = [];` tepat sebelum pembacaan data operator pada seluruh 10 blok method di `Customer_m.php`.
  - Memastikan variabel `$row` selalu berupa array yang valid (meskipun kosong), sehingga query database dapat berjalan dengan aman dan mematuhi standar PHP 8.2+.

---

### 5. Penanganan Signature Parameter Opsional `openisolir()`
* **Lokasi Berkas:** [application/helpers/login_helper.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/helpers/login_helper.php)
* **Masalah Sebelumnya:**
  - Fungsi `openisolir($noservices, $source)` didefinisikan dengan 2 parameter wajib tanpa nilai default.
  - Di beberapa bagian controller (seperti saat sinkronisasi profil atau pembukaan isolir otomatis), fungsi ini dipanggil hanya dengan 1 argumen: `openisolir($noservices)`.
  - Pada PHP 8.0+, pemanggilan fungsi tanpa menyertakan argumen yang tidak memiliki nilai bawaan memicu `Fatal Error: Uncaught ArgumentCountError: Too few arguments to function openisolir(), 1 passed and exactly 2 expected`.
* **Solusi & Implementasi:**
  - Mengubah deklarasi parameter kedua menjadi opsional dengan nilai bawaan `null`:
    ```php
    function openisolir($noservices, $source = null)
    ```
  - Menjamin kompatibilitas mundur penuh baik saat fungsi dipanggil dengan 1 argumen maupun 2 argumen.

---

### 6. Standarisasi Tipe Data & PHPDoc Type Annotations
* **Lokasi Berkas:** [application/helpers/mywifi_helper.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/helpers/mywifi_helper.php) & [application/controllers/Customer.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Customer.php)
* **Masalah Sebelumnya:**
  - Fungsi helper inti di `mywifi_helper.php` dan method controller di `Customer.php` tidak memiliki blok anotasi tipe PHPDoc standar PSR-5.
  - Linter statis (Intelephense, PHPStan, Psalm) memunculkan berbagai peringatan *missing parameter type*, *undefined return type*, atau potensi *type coercion failure*.
* **Solusi & Implementasi:**
  - Menambahkan blok PHPDoc `@param` dan `@return` yang komprehensif pada fungsi-fungsi helper:
    - `indo_currency(float|int|string $nominal): string`
    - `indo_tlp(string|int|null $nohp): string`
    - `format_whatsapp_number(string|int $number): string`
    - `get_google_maps_route(float|string|null $lat_raw, float|string|null $lng_raw, string $address = ''): array`
    - `indo_date(string $date): string`
    - `indo_month(int|string $month): string`
    - `sendmsg(string|int $target, string $message): mixed`
    - `sendmsgbill(string|int $target, string $message, string|int $invoice): mixed`
    - `sendmsgpaid(string|int $target, string $message, string|int $invoice): mixed`
    - `sendmsgschbill(...)`, `sendmsgschbillpaid(...)`, `sendmsgsch(...)`, `sendmsgschduedate(...)`, `sendmsgschbeforedue(...)`
  - Menambahkan anotasi tipe pada method controller `Customer.php`:
    - `setidmikrotik(int|string $id): void`
    - `setdue(int|string $date): void`
    - `sinkron(int|string $id): void`
    - `print(string $no_services): void`

---

## 📂 Matriks Berkas yang Diperbarui

| No | Berkas | Status | Ringkasan Perubahan |
|:---|:---|:---:|:---|
| 1 | `application/views/backend/role/menu.php` | Diperbarui | Menambahkan tag penutup `</div>` pada baris 651 untuk menutup `<div class="col-lg-12">`, memperbaiki nama field checkbox dari `setting_terms_conditions` menjadi `setting_terms_condition`, styling Neumorphism adaptif Dark/Light Mode untuk `.list-group-item`, dan menyempurnakan ikon chevron. |
| 2 | `application/controllers/Role.php` | Diperbarui | Menambahkan inisialisasi query `$data['package'] = $this->db->get('package')->row_array();` pada method `index()` dan `menu()`. |
| 3 | `application/views/backend/role/role.php` | Diperbarui | Menerapkan *defensive coding fallback* `$package = isset($package) && is_array($package) ? $package : ...` dan pengecekan aman `!empty($package['coverage_operator'])`. |
| 4 | `application/views/backend/maps/maps.php` | Diperbarui | Mengatur `fullscreenControl: false` pada `L.map` dan menginisialisasi single fullscreen control eksplisit, harmonisasi tombol toolbar dengan kelas `.map-tool-icon` (warna slate tenang dengan efek hover oranye brand), pengelompokan tombol navigasi & layer, serta defensive fallback `$stats`. |
| 5 | `application/views/backend/customer/maps.php` | Diperbarui | Meneruskan seluruh variabel view global melalui `$this->load->get_vars()` saat memanggil view `backend/maps/maps`. |
| 6 | `application/views/backend.php` | Diperbarui | Menghapus pemuatan script dan stylesheet `Leaflet.fullscreen` ganda yang menyebabkan duplikasi ikon di kanvas Leaflet. |
| 7 | `application/models/Customer_m.php` | Diperbarui | Menambahkan inisialisasi eksplisit `$row = [];` pada 10 method query coverage operator untuk kompatibilitas penuh PHP 8.2+. |
| 8 | `application/helpers/login_helper.php` | Diperbarui | Menetapkan default value `$source = null` pada parameter kedua fungsi `openisolir()` guna mencegah `ArgumentCountError` di PHP 8.0+. |
| 9 | `application/helpers/mywifi_helper.php` | Diperbarui | Menambahkan blok anotasi PHPDoc `@param` dan `@return` standar PSR-5 untuk seluruh fungsi manipulasi mata uang, nomor telepon, tanggal, koordinat maps, dan gateway pesan. |
| 10 | `application/controllers/Customer.php` | Diperbarui | Menambahkan anotasi PHPDoc untuk method `setidmikrotik`, `setdue`, `sinkron`, dan `print`. |

---

## 🔍 Panduan Verifikasi & Pengujian

1. **Pengujian Menu Role Management > Menu (`role/menu`):**
   * Buka URL: `http://billtest.gayuh.net.id.test/role/menu`.
   * Verifikasi bahwa halaman terbuka dengan lancar tanpa ada layar putih/kosong (*no blank page*).
   * Periksa struktur pohon menu: ikon folder, chevron panah, dan teks hak akses tampil rapi dengan warna latar kontras pada mode terang maupun mode gelap.
   * Pilih dropdown role template: verifikasi fungsi JavaScript `select_template()` berjalan normal.
   * Centang hak akses **Syarat & Ketentuan** pada salah satu role dan simpan: pastikan status centang tersimpan permanen di database pada kolom `setting_terms_condition`.

2. **Pengujian Menu Role Management > Role (`role`):**
   * Buka URL: `http://billtest.gayuh.net.id.test/role`.
   * Verifikasi bahwa tidak ada lagi pesan kesalahan `Notice: Undefined variable: package on Line 39`.
   * Form pengaturan role untuk Admin, Operator, Teknisi, Mitra, Kolektor, dan Finance terbuka secara utuh.

3. **Pengujian Menu Pelanggan > Maps (`customer/maps` & `maps`):**
   * Buka URL: `http://billtest.gayuh.net.id.test/customer/maps` atau `http://billtest.gayuh.net.id.test/maps`.
   * Perhatikan sudut kiri atas peta Leaflet: **hanya terdapat tepat 1 tombol Fullscreen** (tidak ada lagi ikon ganda yang saling bertumpuk).
   * Klik tombol Fullscreen: peta berekspansi ke seluruh layar monitor dengan mulus; klik kembali untuk keluar dari mode layar penuh.
   * Perhatikan toolbar tombol di atas peta:
     - Ikon tidak lagi berwarna-warni acak seperti pelangi.
     - Seluruh ikon menggunakan warna *calm slate* profesional.
     - Arahkan kursor (*hover*) ke salah satu tombol (`Pusatkan`, `Lokasi Saya`, `Coverage`, `Sync Tabel`): ikon bertransisi secara halus menjadi oranye brand Gayuh Media (`#f47b20`) dan membesar 1.12x.
     - Tombol terbagi rapi menjadi blok **Navigasi**, blok **Layer**, dan tombol **Reload**.

4. **Pengujian Kompatibilitas PHP 8.2+ (Operator Coverage):**
   * Login sebagai akun dengan role Operator yang belum memiliki wilayah cakupan di tabel `cover_operator`.
   * Buka halaman data pelanggan aktif (`/customer/active`) atau draf tagihan (`/bill/draf`).
   * Pastikan tabel DataTables memuat data kosong tanpa memicu crash `PHP Warning: Undefined variable $row` atau error Ajax 500.

5. **Pengujian Buka Isolir (`openisolir`):**
   * Uji pemanggilan fungsi `openisolir($noservices)` dengan 1 parameter.
   * Pastikan proses eksekusi berjalan mulus tanpa adanya exception `ArgumentCountError`.
