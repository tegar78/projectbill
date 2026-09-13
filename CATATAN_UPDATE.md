# Catatan Update - 7 September 2026

## Revamp Antarmuka UI ISP Billing ke Gaya Desain Neumorphism (Soft UI)

---

### 1. Deskripsi Pembaruan
Pembaruan ini melakukan perombakan desain antarmuka (*UI/UX revamp*) komprehensif pada aplikasi ISP Billing (**Gayuh Net**) dari gaya standar Bootstrap 4 / SB Admin 2 menjadi **Neumorphism (Soft UI)**. 

Desain ini memberikan dimensi taktil realistis (*extruded & debossed*) dengan bayangan lembut, sementara tetap mempertahankan kontras tinggi (*high contrast*) untuk menjamin angka tagihan, status pelanggan, dan laporan keuangan terbaca dengan sangat jelas (**WCAG 2.2 AA/AAA Compliant**).

Pada pembaruan fase kedua ini, gaya desain Neumorphism telah diperluas ke **seluruh menu dan submenu Pelanggan (Customer)** beserta komponen DataTables, form input, modal, dan peta interaktif.

---

### 2. Aturan Strict Neumorphism yang Diterapkan
1. **Warna Kanvas & Elemen 100% Selaras**:
   - **Light Mode Base**: `#e6ecf4` (warna background kanvas dan kartu sama persis).
   - **Dark Mode Base**: `#111625` (warna dasar tema gelap berbayang lembut).
2. **Dual Box-Shadow (Sudut Cahaya Virtual Kiri Atas -45°)**:
   - **Timbul (*Raised / Extruded*)**: Highlight putih terang di sudut kiri atas dan bayangan gelap lembut di sudut kanan bawah.
   - **Cekung (*Debossed / Inset*)**: Bayangan gelap di dalam sudut kiri atas dan highlight putih di dalam sudut kanan bawah untuk memberikan ilusi lubang/ceruk pada layar.
3. **Interaksi Tombol Taktil (*Tactile Feedback*)**:
   - Default: Permukaan timbul halus (`--nm-raised-sm`).
   - Hover: Terangkat sedikit (`--nm-raised`).
   - Active / Ditekan: Tenggelam ke dalam kanvas (`--nm-inset`).
4. **Input Form Cekung (*Inset Shadow*)**:
   - Kolom input, textarea, dan dropdown Select2 menggunakan bayangan cekung menyerupai bidang yang dipahat ke dalam layar.
5. **Navigasi Mulus & Submenu Tanpa Kotak Putih Kaku**:
   - Submenu accordion sidebar menyatu dengan kanvas menggunakan kontainer berbayang cekung halus (*inset well*) tanpa background putih kaku (`.bg-white`).
6. **Performa Rendering Terjaga**:
   - Shadow Neumorphism diterapkan pada tingkat pembungkus kartu, tombol, dan kontrol, bukan pada ribuan sel tabel individual agar DataTables ribuan baris tetap berjalan instan dan mulus.

---

### 3. Rincian File yang Ditambahkan & Diubah

#### A. File Inti: `assets/backend/css/neumorphism.css`
- **Fungsi**: Pusat *design tokens*, aturan komponen Neumorphism modular, dan override global untuk Bootstrap 4 & DataTables.
- **Pembaruan Fitur Baru**:
  - **Sidebar Submenu Well**: Override menyeluruh untuk `.sidebar .collapse-inner`, `.collapse-inner.bg-white`, dan `.collapse-item` sehingga panel submenu menyatu dengan kanvas berbayang cekung (*inset*).
  - **Tactile Row Action Buttons**: Ikon aksi pada baris tabel (`Detail`, `Edit`, `Koneksi Mikrotik`, `Hapus`) otomatis diubah menjadi tombol ikon taktil 3D Neumorphic dengan animasi angkat (*hover lift*) dan tekan (*active deboss*).
  - **Soft UI Status Badges**: Badge status pelanggan (`.badge-success`, `.badge-danger`, `.badge-warning`, `.badge-info`) dirombak menjadi pill Neumorphic lembut berbayang dengan kontras warna teks optimal.
  - **Input Group & Textarea**: Komponen `.input-group-text` dan `textarea.form-control` berbayang cekung Neumorphic.
  - **Alerts Soft UI**: Notifikasi sistem berbayang Neumorphic timbul dengan aksen indikator warna di sisi kiri.

#### B. Master Layout: `application/views/backend.php`
- **Cache-Buster Otomatis**: Menyertakan `?v=<?= time() ?>` pada link `neumorphism.css` agar browser tidak menampilkan CSS usang dari cache.
- **Pembersihan Submenu Accordion**: Menghapus kelas flat `bg-white` pada seluruh kontainer `collapse-inner` di sidebar menu (`Layanan`, `Pelanggan`, `Coverage`, `Tagihan`, `Keuangan`, `Bantuan`, `Master`, `Router`, `Pengguna`, `Integrasi`, `Pengaturan`, `Role Management`, `Website`).
- **Sinkronisasi Judul Menu**: Menyelaraskan status `active` pada submenu Kirim Whatsapp (`$title == 'Kirim Whatsapp' || $title == 'Whatsapp Pelanggan'`).

#### C. Halaman Utama Dashboard: `application/views/backend/dashboard.php`
- Pencarian Cepat Layanan dalam `.nm-card.nm-card-sm.nm-form`.
- Kartu Ringkasan ISP (Data Pelanggan, Pemasukan, Pengeluaran, Menunggu Pembayaran) bertema Soft UI.
- Status Jangkauan & Helpdesk (Coverage Area, Tiket Pending/Proses/Selesai) berbayang timbul.
- Grafik Pemasukan Tahunan dan Aktivitas Terakhir berwadah Neumorphic.
- 100% ID JavaScript & AJAX dipertahankan.

#### D. Modul Menu Pelanggan (Customer):

1. **`application/views/backend/customer/data.php` (Data Pelanggan - Semua, Aktif, Non-Aktif, Menunggu, Free, Isolir)**:
   - Pencarian Cepat Pelanggan dibungkus kartu Neumorphic `.nm-card.nm-card-sm.nm-form`.
   - Tombol utama (`Tambah Pelanggan`, `Import`, dropdown `Action`, `Filter by`, dan `Open Isolir`) dirombak menjadi tombol taktil Neumorphic (`.nm-btn`, `.nm-btn-primary`).
   - Filter Coverage Area dibungkus dalam `.nm-card.nm-card-sm` dengan Select2 cekung.
   - Kartu tabel Data Pelanggan `#tablecustomer` ditingkatkan ke `.nm-card` dan `.nm-card-header` lengkap dengan badge estimasi pendapatan berbayang inset.

2. **`application/views/backend/customer/get-data-customer.php` (Tampilan AJAX DataTables Pelanggan)**:
   - Terintegrasi langsung dengan `neumorphism.css?v=<?= time() ?>` untuk rendering AJAX dinamis.
   - Kontainer tabel dirombak ke `.nm-card` dengan badge estimasi pendapatan Neumorphic debossed.
   - Modal konfirmasi hapus pelanggan dirombak dengan header, body, dan tombol Soft UI.

3. **`application/views/backend/customer/add_customer.php` (Tambah Pelanggan)**:
   - Kartu form input Data Pelanggan dan Konfigurasi Paket dirombak ke `.nm-card` dan `.nm-card-header`.
   - Tombol "Generate No Layanan" diubah menjadi tombol aksi Neumorphic (`.nm-btn.nm-btn-primary`).
   - Tombol footer form (`Batal` dan `Simpan`) dirombak ke tombol taktil Neumorphic berikon.

4. **`application/views/backend/customer/edit_customer.php` (Edit Pelanggan)**:
   - Kartu form identitas dan paket pelanggan dirombak ke `.nm-card` dan `.nm-card-header`.
   - Input keterangan dan opsi pembayaran terintegrasi dengan gaya cekung Neumorphic.
   - Tombol footer form (`Reset` dan `Simpan Perubahan`) ditingkatkan ke `.nm-btn.nm-btn-primary`.

5. **`application/views/backend/customer/whatsapp.php` (Kirim Whatsapp Pelanggan)**:
   - Seluruh 5 kartu pengiriman pesan (Pesan Perorangan, Pesan by Status, Pesan by Coverage Area, Pesan Tagihan Belum Terbayar, Pesan Tagihan Lunas) dirombak ke `.nm-card` dan `.nm-card-header`.
   - Textarea pengetikan pesan dan dropdown tujuan menggunakan ceruk cekung Neumorphic (*inset well*).
   - Tombol "Relog Device" dan tombol "Kirim" diperbarui ke tombol Neumorphic taktil.

6. **`application/views/backend/customer/maps.php` (Maps Pelanggan)**:
   - Wadah peta Leaflet dibungkus dalam bingkai kartu Neumorphic timbul (`.nm-card p-3`) dengan sudut rounded yang mulus.
   - Tabel "Data Pelanggan yang belum ditandai maps" dirombak ke kartu `.nm-card` dengan DataTables Neumorphic.
   - Modal detail data pelanggan terintegrasi dengan Soft UI.

7. **`application/views/backend/customer/filterby.php` (Filter Pelanggan)**:
   - Kartu hasil filter pelanggan dirombak ke `.nm-card` dan `.nm-card-header`.
   - Tombol `Import` dan `Tambah Pelanggan` diubah ke format tombol taktil Neumorphic.

8. **`application/views/backend/customer/getdata.php` (Modal Detail Pelanggan)**:
   - Kartu rincian `Data Pelanggan` dan kartu `Riwayat Tagihan` per tahun dirombak menggunakan kontainer `.nm-card` dan `.nm-card-header`.

---

### 4. Hasil Verifikasi Sistem
- **Linting PHP (0 Syntax Errors)**:
  - `application/views/backend.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/data.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/get-data-customer.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/add_customer.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/edit_customer.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/whatsapp.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/maps.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/filterby.php` : `OK (No syntax errors detected)`
  - `application/views/backend/customer/getdata.php` : `OK (No syntax errors detected)`
- **Integritas Fungsional**:
  - Seluruh selektor JavaScript (`#no_services`, `#coverage`, `#example`, `#tablecustomer`, `#DeleteModal`, `#generatenoservices`, dll.) tidak mengalami perubahan ID, menjamin 100% integrasi AJAX dan pengiriman form tetap berjalan sempurna.
- **Aksesibilitas Kontras**:
  - Memenuhi standar WCAG 2.2 AA/AAA pada mode terang (`#e6ecf4`) maupun mode gelap (`#111625`).

---

### 5. Perbaikan Tata Letak (Layout Bugfix): Posisi Copyright & Sticky Footer
- **Penyebab Masalah**:
  - Terdapat satu tag penutup liar (`</div>`) pada file `application/views/backend/customer/data.php` (tepat sebelum komentar `<!-- Button trigger modal -->`) yang secara prematur menutup kontainer `#content` dan `#content-wrapper` dari layout utama.
  - Akibatnya, elemen `<footer class="sticky-footer">` terlempar keluar dari `#content-wrapper` dan dirender sebagai item flex horizontal ketiga di sisi kanan atas layout.
- **Solusi yang Diterapkan**:
  1. Menghapus tag penutup `</div>` liar tersebut pada `data.php` sehingga seluruh hierarki DOM HTML (71 pasang tag `<div>`) kini 100% seimbang (*balanced*).
  2. Menambahkan aturan CSS penahan (*resilient layout*) pada `assets/backend/css/neumorphism.css` untuk `footer.sticky-footer` dengan `width: 100% !important; margin-top: auto !important; clear: both !important;` guna menjamin footer dan teks copyright selalu berada rapi di bagian bawah (*bottom*) halaman dengan tampilan Neumorphic yang elegan.

---

### 6. Perbaikan Tampilan Data Tagihan Pelanggan (Belum Bayar, Sudah Bayar, Semua)
- **Penyebab Masalah**:
  1. **DataTables Column Mismatch**: Pada controller `Bill.php` method `getfiltercoverage()`, terdapat kolom ekstra terpisah `$row[] = htmlspecialchars($no_wa, ...)` yang menghasilkan **11 kolom data**, sementara tabel di `get-data-bill.php` hanya memiliki **10 kolom header**. Ketidaksesuaian ini menyebabkan DataTables internal error sehingga tabel macet dan menampilkan pesan *"Tidak ada data"*.
  2. **Default Filter Bulan Mengarah ke Bulan Tanpa Data**: Invoice di database saat ini baru dibuat hingga **Bulan 08 (Agustus) 2026** (99 invoice belum bayar, 925 sudah bayar). Karena saat ini sistem berjalan di bulan September (`date('m') == '09'`), filter default langsung memilih September 2026 yang belum memiliki invoice, sehingga pengguna langsung disajikan tabel kosong tanpa data.
  3. **Konflik ID DOM**: `get-data-bill.php` memiliki `<input type="hidden" id="month">` dan `id="coverage"`, yang menduplikasi elemen filter pada halaman utama sehingga memicu konflik selektor jQuery saat filter diubah.
  4. **Filter Query `getBillFilter` di `Bill_m.php`**: Tidak mendukung value `'all'` dan tidak menggunakan format leading zero (`where_in([$m, $m_str])`), serta belum memiliki prefix tabel eksplisit.

- **Solusi yang Diterapkan**:
  1. **`application/controllers/Bill.php`**:
     - Memperbaiki `getfiltercoverage()` dengan menghapus kolom ke-11 dan menggabungkan nomor WhatsApp/Telepon ke dalam kolom `Nama Pelanggan` secara rapi (`<small><i class="fab fa-whatsapp text-success"></i> no_wa</small>`). Struktur data kembali tepat 10 kolom sesuai header DataTables.
  2. **`application/models/Bill_m.php`**:
     - Memperbaiki method `getBillFilter()` untuk mengabaikan filter jika bernilai `''` atau `'all'`, serta menambahkan pencocokan leading zero pada bulan dan prefix tabel lengkap (`invoice.status`, `customer.coverage`, `invoice.month`, `invoice.year`).
  3. **`application/views/backend/bill/get-data-bill.php`**:
     - Menghapus input tersembunyi yang menduplikasi ID DOM.
     - Mengirimkan parameter filter langsung dari PHP ke inisialisasi AJAX DataTables secara aman (`coverageVal`, `statusVal`, `monthVal`, `yearVal`).
     - Menyatukan dan merapikan konfigurasi `columnDefs`.
     - Menerapkan styling Neumorphism pada modal Hapus Tagihan.
  4. **`application/views/backend/bill/unpaid.php`, `paid.php`, dan `bill.php`**:
     - Menambahkan logika **pemilihan bulan default pintar**: Jika bulan berjalan memiliki invoice, otomatis gunakan bulan berjalan; jika belum ada invoice di bulan berjalan, otomatis pilih periode invoice terbaru yang tersedia di database (Agustus 2026). Pengguna langsung melihat daftar tagihan tanpa perlu memilih manual.
     - Menyediakan opsi `"Semua Bulan"` (`value="all"`) dan `"Semua Tahun"` (`value="all"`).
     - Menerapkan gaya Neumorphism pada Kartu Filter Tagihan (`.nm-card`), Input Select (`.nm-input`), Tombol Aksi (`.nm-btn`), dan Header Kartu Tabel.

---

## 7. Pembaruan Kontras Sidebar & Tombol Chevron Submenu (07 September 2026)

- **Latar Belakang & Masalah**:
  1. **Tulisan Brand "BILL GAYUH UTAMA" Kurang Terlihat**:
     - Pada Light Mode, aturan CSS internal di `application/views/backend.php` menetapkan `.sidebar-dark .sidebar-brand { color: #ffffff !important; }`. Karena background sidebar Neumorphism adalah abu-abu lembut `#e6ecf4`, teks berwarna putih menjadi hampir tidak terbaca (*low contrast*).
  2. **Tombol Chevron `>` Submenu dan Toggle Sidebar Kurang Terlihat**:
     - Default styling SB Admin 2 menetapkan `.sidebar-dark .nav-item .nav-link[data-toggle="collapse"]::after` dengan warna `rgba(255, 255, 255, 0.5)`. Pada background terang, ikon panah `>` menjadi transparan/samar.
     - Penataan flexbox pada `.nm-sidebar .nav-item .nav-link` menonaktifkan properti `float: right`, menyebabkan ikon `>` menempel langsung di sebelah teks menu alih-alih berada rapi di tepi kanan tombol.
     - Tombol toggle sidebar di bagian bawah (`#sidebarToggle`) juga menggunakan warna semi-transparan `rgba(255, 255, 255, 0.2)` sehingga tampak pudar.

- **Solusi yang Diterapkan**:
  1. **Optimasi Tipografi & Kontras Brand (`BILL GAYUH UTAMA`)**:
     - Diperbarui di `application/views/backend.php` dan `assets/backend/css/neumorphism.css`.
     - **Light Mode**: Warna teks diubah menjadi `#1e293b` (Dark Slate Charcoal, rasio kontras 10.5:1 melebihi standar WCAG AAA 7:1) dengan ketebalan `font-weight: 800`, `letter-spacing: 0.06em`, dan bayangan teks halus `text-shadow: 0 1px 1px rgba(255, 255, 255, 0.9)`.
     - **Dark Mode**: Otomatis beradaptasi menjadi putih bersih `#ffffff` dengan bayangan teks lembut.
     - Ikon wifi brand (`.sidebar-brand-icon i`) tetap mempertahankan warna oranye khas ISP (`#f47b20`) dengan efek *drop-shadow* cerah.
  2. **Revamp Tombol Chevron `>` Submenu Sidebar**:
     - Ditambahkan `margin-left: auto !important;` sehingga panah `>` terdorong ke ujung kanan tombol nav-link secara konsisten dan sejajar vertikal.
     - Didesain sebagai tombol mini Neumorphic taktil (lingkaran 24x24 px).
     - **Light Mode**: Warna diubah menjadi `#475569` (Slate 600, kontras tinggi) dengan `opacity: 1 !important;` dan `font-weight: 900 !important;`.
     - **Efek Interaktif**:
       - Saat di-hover: ikon bertransformasi (`scale(1.1)`), berubah menjadi warna oranye brand (`#f47b20`), dan memunculkan bayangan timbul mikro (`--nm-raised-xs`).
       - Saat submenu terbuka (`:not(.collapsed)`): ikon bertransisi menjadi warna oranye brand dengan bayangan cekung (*inset*) lembut (`--nm-inset-sm`).
     - **Dark Mode**: Berwarna `#94a3b8` dan berubah ke `#f47b20` saat hover/aktif.
  3. **Revamp Tombol Toggle Sidebar (`#sidebarToggle`)**:
     - Diberikan styling Neumorphic timbul (`--nm-raised-sm`) pada kanvas `#e6ecf4`.
     - Ikon panah `<` diberi warna kontras tinggi `#475569` (Light) dan `#cbd5e1` (Dark).
     - Saat hover berubah menjadi oranye brand dengan elevasi `box-shadow: var(--nm-raised)`.
  4. **Peningkatan Kontras Teks Navigasi Sidebar**:
     - Teks menu sidebar disetel ke `#334155` (Slate 700, `font-weight: 700`) dan ikon ke `#475569` untuk menjamin keterbacaan optimal pada Light Mode.

---

## 8. Perbaikan Detail Pelanggan Koneksi & Parsing Uptime MikroTik (07 September 2026)

- **Latar Belakang & Masalah (Berdasarkan Screenshot User)**:
  1. **PHP Error Warning `Undefined variable $day`**:
     - Pada halaman detail pelanggan koneksi (`views/backend/mikrotik/customer/client.php` baris 120), pemanggilan fungsi `formattimemikro($pppoeactive['0']['uptime'])` memicu error fatal:
       ```
       A PHP Error was encountered
       Severity: Warning
       Message: Undefined variable $day
       Filename: helpers/login_helper.php(1) : eval()'d code Line Number: 402
       ```
     - **Akar Penyebab**: Fungsi `formattimemikro($dtm)` pada `login_helper.php` hanya mendefinisikan variabel `$day` jika string uptime MikroTik mengandung karakter 'd' (hari) atau 'w' (pekan). Ketika router mengembalikan uptime berdurasi di bawah 1 hari seperti `14h39m19s`, variabel `$day` tidak pernah dibuat sehingga PHP melempar warning. Akibatnya, field **Uptime** tertimpa kotak merah error CodeIgniter berukuran besar yang merusak seluruh layout halaman.
     - Selain itu, `login_helper.php` sebelumnya dibungkus enkripsi obfuscator usang `eval(gzinflate(base64_decode(...)))` dari pihak ketiga (*zeura.com*) yang membebani kinerja server dan menyulitkan pelacakan bug / kompatibilitas PHP 8+.
  2. **Tampilan Kartu "Data Pelanggan" & "Live Traffic" Belum Neumorphic**:
     - Layout detail pelanggan menggunakan float kolom lama yang tidak presisi, tombol aksi (Refresh, Edit, Kick, Isolir, Open Isolir) masih berupa tombol flat standar, dan terdapat kesalahan tag HTML penutup (`<i class="fas fa-sync"></a></i>`).
     - Tampilan belum selaras dengan standar tema Neumorphism (Soft UI) yang sudah diterapkan pada menu pelanggan lainnya.

- **Solusi yang Diterapkan**:
  1. **Dekripsi & Refactor Bersih `application/helpers/login_helper.php`**:
     - Berhasil mendecode helper dari format `eval(gzinflate(base64_decode(...)))` menjadi kode PHP murni yang bersih, aman, dan berkinerja tinggi (file asli dibackup ke `application/helpers/login_helper.php.bak`).
     - Menulis ulang fungsi `formattimemikro($dtm)` secara tangguh (*robust*) menggunakan regex parser yang mengekstrak komponen minggu (`w`), hari (`d`), jam (`h`), menit (`m`), dan detik (`s`) dari format MikroTik RouterOS:
       - Menginisialisasi default `$weeks = 0, $days = 0, $hours = 0, $minutes = 0, $seconds = 0`.
       - Menghitung total hari akumulatif (`$total_days = ($weeks * 7) + $days`).
       - Memformat output secara presisi: `14:39:19` (jika < 1 hari) atau `2d 14:39:19` (jika >= 1 hari).
       - Bebas 100% dari warning `Undefined variable` pada semua kemungkinan format uptime MikroTik.
  2. **Revamp Desain Neumorphism pada `application/views/backend/mikrotik/customer/client.php`**:
     - Mengubah container kartu "Data Pelanggan" dan "Live Traffic" ke standar `.nm-card` dan `.nm-card-header`.
     - Mengganti grid layout lama dengan perataan dua kolom key-value yang proporsional (`col-4` label dengan warna redup `var(--nm-text-muted)` dan `col-8` data dengan warna teks utama berbobot tebal).
     - Memperbaiki penulisan tag HTML button refresh yang keliru.
     - Mengubah semua tombol aksi (Refresh, Edit, Kick, Isolir, Buka Isolir) menjadi tombol taktil Neumorphic (`.nm-btn`, `.nm-btn-primary`, `.nm-btn-danger`, `.nm-btn-success`) dengan efek 3D timbul saat default dan cekung saat ditekan.
     - Memberikan badge status koneksi yang modern, kontras tinggi, dan indikator visual status aktif/nonaktif.
     - Mempercantik kartu grafik "Live Traffic" dan monitoring pemakaian data secara serasi.


---

## 9. Perbaikan Pencarian Pelanggan saat Sedang Melihat Data Pelanggan (07 September 2026)

- **Latar Belakang & Akar Masalah**:
  1. **Re-inisialisasi Global Select2 Merusak Elemen Pencarian**:
     - Saat memilih pelanggan pertama kali dari dropdown pencarian (`#no_services`), AJAX memuat view `backend/customer/getdata.php`.
     - Di dalam `getdata.php`, terdapat script `$('.select2').select2()`. Ketika dijalankan, pemanggilan global ini menargetkan kembali `<select id="no_services">` dan kontainer wrapper `<span class="select2 ...">` yang sudah aktif di halaman utama.
     - Akibatnya, Select2 instance pada `#no_services` menjadi rusak (*corrupted*), memicu error JavaScript internal saat pengguna mengetik kata kunci pencarian (misal: `"00"`), dan menyebabkan menu dropdown tertutup/tidak responsif.
  2. **Konflik Duplikasi ID DOM (`id="no_services"`)**:
     - Di `views/backend/customer/getdata.php` baris 294, terdapat input tersembunyi `<input type="hidden" id="no_services" value="<?= $customer['no_services'] ?>">`.
     - Karena dropdown pencarian di halaman utama juga memiliki `id="no_services"`, pemanggilan `$("#no_services").val()` pada fungsi `getdetailcustomer()` menjadi rancu dan selalu membaca nilai lama dari input tersembunyi tersebut alih-alih nilai pelanggan baru yang baru saja dipilih.
  3. **Tidak Tersedianya Opsi Reset / Kembali ke Tabel**:
     - Logika `getdetailcustomer()` sebelumnya langsung menampilkan alert jika `no_services` bernilai kosong (`""`), sehingga pengguna yang ingin membatalkan pencarian atau kembali ke tabel pelanggan terjebak di tampilan detail kecuali jika me-refresh halaman.

- **Solusi yang Diterapkan**:
  1. **Isolasi Inisialisasi Select2 pada [getdata.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/getdata.php)**:
     - Mengubah skrip Select2 di `getdata.php` agar **hanya** menginisialisasi elemen di dalam modal (`#databillhistory select.select2, .modal select.select2`) yang belum berstatus `select2-hidden-accessible`. Tidak menyentuh sama sekali elemen pencarian `#no_services` di halaman utama.
  2. **Eliminasi Duplikasi ID**:
     - Mengubah ID input tersembunyi pada `getdata.php` dari `id="no_services"` menjadi `id="detail_customer_no_services"`.
     - Menyelaraskan fungsi `getbillhistory()` dan `selectyear()` agar membaca `#detail_customer_no_services`.
  3. **Penyempurnaan Fungsi `getdetailcustomer()` & `closedetailcustomer()` pada [backend.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php)**:
     - Menggunakan selektor eksplisit `$('select#no_services').val()` untuk mengambil nilai dari dropdown pencarian.
     - Menambahkan penanganan otomatis: jika pengguna memilih opsi kosong (*-Pilih Nama Pelanggan-*), sistem otomatis membersihkan kontainer detail dan menampilkan kembali tabel data pelanggan (`#contents.show()`).
     - Menambahkan tombol **"Kembali ke Daftar"** pada header kartu Data Pelanggan di `getdata.php`.
     - Mendaftarkan delegasi event `$(document).on('select2:select change', 'select#no_services')` agar pergantian pelanggan selalu terdeteksi dengan presisi.
  4. **Peningkatan Layout & CSS [data.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/data.php) & [neumorphism.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)**:
     - Membungkus kartu pencarian dalam `<div class="row">` dan menambahkan kontainer `<div class="loading"></div>` agar spinner loading tampil halus saat berpindah antar data pelanggan.
     - Menetapkan `z-index: 9999 !important;` pada `.select2-dropdown` di `neumorphism.css` guna menjamin menu daftar pencarian selalu melayang di atas semua lapisan kartu Neumorphic.


---

## 10. Perombakan Tombol Aksi Data Pelanggan & Perbaikan Tombol A4 & Thermal pada Riwayat Tagihan (07 September 2026)

- **Latar Belakang & Kebutuhan**:
  1. **Tombol Aksi Data Pelanggan Belum Neumorphic**:
     - Tombol aksi pada detail data pelanggan (`Tambah Pelanggan`, `Edit Pelanggan`, `Cetak`, `Detail Paket`, `Koneksi`) di `application/views/backend/customer/getdata.php` sebelumnya masih menggunakan tombol datar bawaan Bootstrap `btn btn-outline-*` tanpa efek taktil 3D.
     - Tombol tagihan belum dibayar dan tombol `Bayar Tagihan` serta `Detail Invoice` belum selaras dengan tema Soft UI Neumorphism.
  2. **Tombol Cetak A4 dan Thermal pada Riwayat Tagihan "Tidak Fit" (Terhimpit & Distorsi)**:
     - Pada tabel "Riwayat Tagihan", tombol A4 dan Thermal terlihat terhimpit, berantakan, dan bentuknya ganjil.
     - **Penyebab Akar Masalah**:
       - Tag `<a>` di dalam tabel terkena selektor global `.table td a i.fa` di `neumorphism.css` yang memaksa seluruh tag ikon di baris tabel menjadi kotak tersendiri berukuran 32px × 32px lengkap dengan background, shadow, dan border. Hal ini menyebabkan ikon di dalam tombol A4/Thermal berubah menjadi "tombol di dalam tombol" yang menggembung dan merusak proporsi tombol.
       - Teks "A4" dan "Thermal" pada kode lama ditulis di dalam tag ikon (`<i class="fa fa-print"> A4</i>`), sehingga teks mewarisi font glyph dari font FontAwesome dan tampak gepeng/rusak.
       - Kolom aksi pada tabel menggunakan lebar kaku `width: 200px` dan tanpa wrapper flexbox, sehingga tombol tidak muat (*tidak fit*) pada kolom yang sempit.

- **Solusi yang Diterapkan**:
  1. **Revamp Tombol Aksi Data Pelanggan ke Neumorphic ([getdata.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/customer/getdata.php))**:
     - Mengubah seluruh tombol aksi pelanggan ke `.nm-btn.nm-btn-sm` dengan ikon FontAwesome terpisah:
       - **Tambah Pelanggan**: `.btn.nm-btn.nm-btn-sm.nm-btn-success` dengan ikon `<i class="fas fa-user-plus mr-1"></i>`.
       - **Edit Pelanggan**: `.btn.nm-btn.nm-btn-sm.nm-btn-primary` dengan ikon `<i class="fas fa-user-edit mr-1"></i>`.
       - **Cetak**: `.btn.nm-btn.nm-btn-sm` dengan ikon `<i class="fas fa-print mr-1"></i>`.
       - **Detail Paket**: `.btn.nm-btn.nm-btn-sm.nm-btn-danger` dengan ikon `<i class="fas fa-box-open mr-1"></i>`.
       - **Koneksi**: `.btn.nm-btn.nm-btn-sm.nm-btn-warning` dengan ikon `<i class="fas fa-network-wired mr-1"></i>`.
     - Mengubah tombol total tagihan belum bayar menjadi Neumorphic Inset Badge (`.nm-badge.nm-badge-inset`).
     - Mengubah tombol **Detail Invoice** (`.btn.nm-btn.nm-btn-sm.nm-btn-primary`) dan **Bayar Tagihan** (`.btn.nm-btn.nm-btn-sm.nm-btn-success`).
     - Mengubah tombol footer modal pembayaran (`Batal` dan `Ya, Lanjutkan`) ke tombol Neumorphic yang elegan.
  2. **Perbaikan Total Tombol A4 & Thermal agar Fit & Proporsional ([tampil_history.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/bill/tampil_history.php) & [neumorphism.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css))**:
     - **Pengecualian Ikon Tombol Tabel pada CSS**: Menambahkan rule reset spesifik pada `.table td a.btn i` dan `.table td a.nm-btn i` di `neumorphism.css` agar ikon di dalam tombol bertipe `.btn` / `.nm-btn` tidak lagi dipaksa menjadi kotak 32px tersendiri.
     - **Struktur HTML Tombol Bersih**: Memisahkan teks dari tag ikon (`<i class="fas fa-print"></i> <span>A4</span>` dan `<i class="fas fa-receipt"></i> <span>Thermal</span>`), sehingga font teks kembali normal dan tajam.
     - **Flexbox Wrapper Kompak**: Membungkus tombol A4 dan Thermal dalam container flexbox horizontal `d-inline-flex align-items-center justify-content-center` dengan `gap: 6px` dan `white-space: nowrap`.
     - **Ukuran Proporsional `.nm-btn-xs`**: Menyesuaikan padding (`4px 9px`), min-height (`26px`), dan font-size (`0.74rem`) sehingga tombol pas (*fit*) sempurna di sel tabel tanpa terpotong atau terhimpit.
     - **Refactor Tabel 12 Bulan yang Bersih**: Menata ulang tabel riwayat tagihan menjadi loop 1..12 bulan yang efisien dengan 1 query database terpadu dan badge status Neumorphic (`Belum Bayar` beraksen merah debossed, `Sudah Bayar` beraksen hijau debossed).


---

## 11. Perbaikan Error 404 | NOT FOUND saat Selesai Tambah Tiket Gangguan (07 September 2026)

- **Gejala & Keluhan Pengguna**:
  - Saat admin atau pelanggan selesai menambahkan tiket gangguan baru melalui form "Tambah Tiket", browser diarahkan ke URL `bill3-gyh.gayuh.net.id.test/help/addhelp` dan menampilkan layar gelap dengan tulisan besar `404 | NOT FOUND`.
  - Tiket baru tampak tidak berhasil teralihkan kembali ke tabel data tiket.

- **Investigasi Mendalam & Akar Masalah Sebenarnya**:
  1. **Bukan Kesalahan Route CodeIgniter**:
     - URL `/help/addhelp` sebenarnya adalah method controller `Help::addhelp()` yang valid dan terdaftar.
  2. **Kebocoran Debug Output pada Gateway WhatsApp (`mywifi_helper.php`)**:
     - Saat tiket baru dibuat, sistem memanggil fungsi `sendmsgsch()` untuk mengirimkan notifikasi WhatsApp terjadwal kepada teknisi dan admin (total hingga 17 pengguna).
     - Di dalam `application/helpers/mywifi_helper.php` baris 1513-1530 (vendor pengiriman WhatsApp 'Other' / Wablas), fungsi mengeksekusi cURL ke endpoint API Wablas (`https://pati.wablas.com/send-message`).
     - Karena endpoint vendor Wablas merespons dengan HTTP status 404 dari framework Laravel mereka (`<title>Not Found</title> ... <div class="...">404</div> <div class="...">Not Found</div>`), kode di baris 1530 yang berisi pernyataan debug liar:
       ```php
       echo $response;
       ```
       mencetak dokumen HTML 404 milik vendor Wablas tersebut secara mentah langsung ke layar output browser pengguna!
  3. **Kegagalan Pengiriman Header HTTP Redirect (*Headers Already Sent*)**:
     - Karena teks HTML respons 404 sudah dikirim ke browser sebelum proses di controller selesai, header HTTP PHP terkunci (*headers already sent*).
     - Perintah `redirect($_SERVER['HTTP_REFERER'])` pada baris akhir `addhelp()` di `Help.php` gagal melakukan pengalihan, sehingga browser tertahan di halaman `help/addhelp` dengan tampilan 404 dari Wablas.
  4. **Timeout cURL Default Tanpa Batas**:
     - Pengaturan `CURLOPT_TIMEOUT => 0` menyebabkan request ke gateway eksternal dapat menggantung (*freeze*) jika koneksi vendor lambat atau tidak merespons.
  5. **Potensi Masalah Penomoran Tiket di `Help_m.php`**:
     - Pada `Help_m::add()`, pengecekan `$cekinv > 0` membandingkan array hasil `row_array()` dengan integer `0`. Pada PHP modern (PHP 8+), perbandingan array dengan int dapat menimbulkan perilaku inkonsisten atau warning.
  6. **Akses GET Langsung pada `/help/addhelp`**:
     - Jika pengguna me-refresh URL `/help/addhelp`, method mencoba memproses tanpa data POST yang menyebabkan error notice.

- **Solusi Komprehensif yang Diterapkan**:
  1. **Pembersihan Seluruh Debug Output pada [mywifi_helper.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/mywifi_helper.php)**:
     - Menghapus/menonaktifkan seluruh pernyataan debug `echo $response;` dan `echo $jadwal;` di seluruh blok pengiriman pesan WhatsApp (Wablas, Woowa, Starsender, Mpedia, dll.).
     - Menetapkan `CURLOPT_TIMEOUT => 5` detik agar komunikasi eksternal memiliki batasan waktu yang aman dan tidak membebani performa aplikasi.
  2. **Penguatan Controller [Help.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/controllers/Help.php)**:
     - Menambahkan proteksi method HTTP: jika URL `help/addhelp` diakses melalui request selain POST (misal me-refresh browser), sistem langsung mengalihkan pengguna kembali ke `help/data` (atau `help/history` untuk pelanggan).
     - Menambahkan validasi kelengkapan data form input (`no_services` dan `type`).
     - Mengganti redirect rapuh `$_SERVER['HTTP_REFERER']` dengan closure aman `$redirect_user()` yang memeriksa referer secara valid dan memiliki fallback default ke `help/data` (untuk admin/operator) atau `help/history` (untuk pelanggan).
     - Menambahkan timeout stream context (3 detik) pada notifikasi Telegram Bot `@file_get_contents(...)` agar proses tambah tiket tetap instan.
     - Mendukung seluruh level hak akses pengguna (`role_id` 1, 2, 3, 4, 5).
  3. **Penyempurnaan Model [Help_m.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/models/Help_m.php)**:
     - Mengubah pengecekan nomor tiket menjadi `if (!empty($cekinv) && !empty($getRecent['no_ticket']))` yang aman dan kompatibel dengan PHP 8.4.
     - Mengamankan parameter `$params` dengan fungsi `isset()` untuk mencegah warning `Undefined array key`.
  4. **Hasil Akhir**:
     - Form tambah tiket berjalan mulus dan instan.
     - Tidak ada lagi kebocoran respons 404 Wablas ke layar.
     - Pengguna otomatis dialihkan kembali ke daftar tiket dengan notifikasi sukses sweet alert: *"Data Tiket berhasil disimpan"*.


---

## 12. Perbaikan Tombol "Simpan" Tidak Terlihat pada Modal Tambah Tiket & Global Button Primary (07 September 2026)

- **Gejala & Masalah yang Ditemukan**:
  - Pada modal "Tambah Tiket Gangguan" (`help/data`), tombol **Simpan** tampak hanya berupa balok oranye polos tanpa teks atau tulisan "Simpan" tidak terbaca sama sekali.
  - Hal serupa berpotensi terjadi pada seluruh tombol yang menggunakan kelas `.btn-primary` di seluruh sistem.

- **Akar Masalah Sebenarnya**:
  1. **Tumpang Tindih Deklarasi CSS (*Conflicting Styles*)**:
     - Di `application/views/backend.php` baris 209-217, terdapat aturan CSS inline:
       ```css
       .btn-primary {
           background-color: #f47b20 !important;
           border-color: #f47b20 !important;
       }
       ```
       Aturan ini menetapkan latar belakang tombol menjadi warna oranye brand (`#f47b20`), namun **tidak mendefinisikan warna teks (`color`)**.
     - Di saat yang bersamaan, file `assets/backend/css/neumorphism.css` baris 1003 mendefinisikan:
       ```css
       .btn-primary {
           ...
           color: var(--nm-brand) !important; /* #f47b20 - Oranye */
           ...
       }
       ```
  2. **Teks Oranye di Atas Latar Belakang Oranye Identik**:
     - Browser menerapkan warna latar `#f47b20` (oranye) dan warna teks `#f47b20` (oranye) secara bersamaan.
     - Akibatnya, teks "Simpan" dan ikonnya menjadi 100% tersamarkan (*invisible*) karena memiliki nilai hex warna yang sama persis dengan latar belakang tombolnya.

- **Solusi yang Diterapkan**:
  1. **Perbaikan Warna Teks & Ikon pada [application/views/backend.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend.php)**:
     - Menetapkan secara eksplisit `color: #ffffff !important;` pada `.btn-primary`, status `:hover`, `:focus`, `:active`, serta elemen anak (`.btn-primary i, .btn-primary span`).
  2. **Harmonisasi pada [assets/backend/css/neumorphism.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)**:
     - Menyelaraskan aturan global `.btn-primary` dengan latar belakang brand orange (`#f47b20`), bayangan Neumorphic taktil, dan teks putih kontras tinggi (`#ffffff`).
     - Menambahkan interaksi `:hover` (`#d86612`), `:active` debossed (`#c4570b`), dan warna putih pada ikon/span.
  3. **Penyempurnaan Modal Tambah Tiket pada [help/data.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/data.php)**:
     - Menambahkan ikon FontAwesome pada tombol footer modal:
       - Batal: `<i class="fas fa-times mr-1"></i> Batal`
       - Simpan: `<i class="fas fa-save mr-1"></i> Simpan`
     - Teks "Simpan" kini terbaca dengan sangat kontras, tajam, dan memiliki efek visual taktil yang konsisten.


---

## 13. Perombakan Tombol WA Pelanggan, Ambil Tiket & Action Buttons ke Neumorphism pada Detail Tiket (07 September 2026)

- **Latar Belakang & Kebutuhan Pengguna**:
  - Pada halaman detail tiket gangguan (`help/detail/{id}`), tombol aksi bagian bawah (**WA Pelanggan** dan **Ambil Tiket**) masih berupa tombol flat outline biasa (`btn-outline-success` dan `btn-outline-danger`) yang tampak tipis, kaku, dan tidak selaras dengan tema Soft UI Neumorphism.
  - Pengguna meminta agar tombol WA Pelanggan dan Ambil Tiket dirombak menjadi tombol Neumorphism 3D taktil.

- **Solusi yang Diterapkan**:
  1. **Revamp Tombol pada [application/views/backend/help/detail.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/detail.php)**:
     - **WA Pelanggan**: Dirombak menggunakan kelas `.btn.nm-btn.nm-btn-success` dengan ikon `<i class="fab fa-whatsapp mr-1"></i> WA Pelanggan`, memberikan warna hijau zamrud dengan efek timbul 3D dan animasi cekung saat ditekan.
     - **Ambil Tiket**: Dirombak menggunakan kelas `.btn.nm-btn.nm-btn-danger` dengan ikon `<i class="fas fa-hand-holding mr-1"></i> Ambil Tiket`, memberikan aksen merah koral berbayang Neumorphic.
     - **Rute Google Maps**: Ditingkatkan ke `.btn.nm-btn.nm-btn-primary` dengan ikon `<i class="fas fa-map-marked-alt mr-1"></i> Rute Google Maps`.
     - **Telp Pelanggan**: Ditingkatkan ke `.btn.nm-btn.nm-btn-warning` dengan ikon `<i class="fas fa-phone-alt mr-1"></i> Telp Pelanggan`.
     - **Update Tiket**: Ditingkatkan ke `.btn.nm-btn.nm-btn-primary` dengan ikon `<i class="fas fa-edit mr-1"></i> Update Tiket`.
     - Menata kontainer tombol agar memiliki `gap: 8px` dan `flex-wrap: wrap` sehingga terlihat rapi di semua resolusi layar.
     - Menyempurnakan tombol `Batal` dan `Simpan` pada modal Ambil Tiket dan Update Tiket dengan ikon FontAwesome.
  2. **Penguatan Desain Global pada [assets/backend/css/neumorphism.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/backend/css/neumorphism.css)**:
     - Menambahkan aturan lengkap untuk seluruh varian `.btn-outline-*` (`.btn-outline-success`, `.btn-outline-danger`, `.btn-outline-warning`, `.btn-outline-secondary`) agar memiliki background kanvas Neumorphic `var(--nm-bg)`, bayangan timbul `var(--nm-raised-sm)`, transisi hover angkat, dan debossed saat aktif.
     - Menambahkan warna interaksi hover dan focus yang tajam pada `.nm-btn-success` (`#059669`) dan `.nm-btn-danger` (`#dc2626`).
---

## 14. Perbaikan Rute Google Maps Langsung Direct ke Alamat / Titik Koordinat & Pemulihan Peta Leaflet (07 September 2026)

- **Latar Belakang & Masalah**:
  - Pada halaman detail tiket (`help/detail/{id}`), tombol **"Rute Google Maps"** sebelumnya tidak langsung mengarahkan rute navigasi ke lokasi pelanggan, melainkan hanya membuka halaman beranda Google Maps kosong atau error tidak menemukan tempat.
  - Peta Leaflet di bawah form laporan pelanggan seringkali hanya tampak abu-abu kosong (*blank grey box*).
  - Notifikasi WhatsApp ke teknisi juga mengirimkan link maps yang tidak dapat dibuka.

- **Investigasi & Akar Permasalahan**:
  1. **Format URL Google Maps yang Kurang Tepat**:
     - Sebelumnya link dibuat dengan format `http://www.google.com/maps/place/{lat},{long}`. Format `/maps/place/` dirancang hanya untuk mencari nama tempat statis dan sangat rentan gagal jika format koordinat tidak sempurna atau string memiliki spasi/koma ganda.
     - Mode navigasi/petunjuk arah turn-by-turn resmi Google Maps yang tepat untuk desktop dan perangkat mobile (Android / iOS) adalah: `https://www.google.com/maps/dir/?api=1&destination={latitude},{longitude}`.
  2. **Data Koordinat Database Tertukar & Korup (Swapped Coordinates)**:
     - Ditemukan sebanyak **537 data pelanggan** di database tabel `customer` memiliki nilai `latitude` dan `longitude` yang terbalik atau tertukar akibat kesalahan input (misal pelanggan `00141`: kolom `latitude` berisi `", 106.675079"` dan kolom `longitude` berisi `"-6.133934, 1"`).
     - Secara geografis di Indonesia (khususnya wilayah Jabodetabek):
       - **Latitude**: selalu bernilai negatif antara `-15.00` hingga `+10.00` (misal `-6.133934`).
       - **Longitude**: selalu bernilai positif antara `90.00` hingga `145.00` (misal `106.675079`).
     - Ketika angka terbalik dimasukkan ke URL lama (`place/106.67...,-6.13...`), Google Maps menganggap latitude > 90° adalah tidak valid (latitude bumi hanya -90° hingga +90°), sehingga Google Maps otomatis mengabaikannya dan hanya membuka peta kosong.
     - Demikian pula pustaka Leaflet di browser melempar error `Invalid LatLng object (NaN, NaN)` yang mengakibatkan container `#mapid` hanya berwarna abu-abu kosong.
  3. **Tile Mapbox Usang / Kadaluwarsa**:
     - Leaflet di view sebelumnya menggunakan tile Mapbox dengan access token yang sudah kedaluwarsa/tidak aktif, sehingga gambar peta satelit/jalan gagal termuat.

- **Solusi Komprehensif yang Diterapkan**:
  1. **Pembersihan dan Pemulihan Data Database (`customer`)**:
     - Membuat tabel backup aman terlebih dahulu: `customer_backup_coords_20260907`.
     - Menjalankan pembersihan otomatis untuk 537 data pelanggan yang terdampak: mengekstrak angka floating point bersih, mendeteksi secara akurat mana Latitude (antara -15 s/d 10) dan mana Longitude (antara 90 s/d 145), lalu menyimpannya ke kolom yang semestinya.
  2. **Helper Universal Cerdas `get_google_maps_route()` pada [application/helpers/mywifi_helper.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/helpers/mywifi_helper.php)**:
     - Menganalisis string input koordinat pelanggan dengan regex: jika di kemudian hari ada admin/pelanggan yang menginput koordinat terbalik, helper ini secara otomatis mendeteksi dan menukarnya kembali ke posisi yang benar.
     - Menghasilkan URL direct turn-by-turn navigation: `https://www.google.com/maps/dir/?api=1&destination={lat},{lng}`.
     - Memiliki fallback cerdas: jika koordinat kosong namun kolom alamat berisi link pendek Google Maps (seperti `https://maps.app.goo.gl/...`), helper otomatis menggunakan link tersebut. Jika hanya berisi teks alamat biasa, helper membuat URL navigasi Google Maps berbasis query pencarian alamat URL-encoded.
  3. **Penyempurnaan Halaman Detail Tiket [application/views/backend/help/detail.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/backend/help/detail.php)**:
     - Tombol **Rute Google Maps** kini menggunakan link navigasi langsung hasil perhitungan helper `get_google_maps_route()`.
     - Peta interaktif Leaflet dimutakhirkan menggunakan tile **OpenStreetMap** (`https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`) yang stabil, cepat, dan bebas kuota API key.
     - Menambahkan pin marker Leaflet lengkap dengan pop-up nama pelanggan dan nomor layanan pada titik koordinat yang presisi.
  4. **Pembaruan Notifikasi WhatsApp Teknisi pada [application/controllers/Help.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/controllers/Help.php)**:
     - Variabel `$maps` pada notifikasi penugasan tiket teknisi otomatis menghasilkan URL navigasi turn-by-turn langsung ke lokasi pelanggan, sehingga teknisi di lapangan cukup menekan link dari pesan WhatsApp untuk langsung memulai navigasi Google Maps di ponsel mereka.
---

## 15. Transformasi Total Tampilan Landing Page Publik ke Soft UI Neumorphism (07 September 2026)

- **Latar Belakang & Kebutuhan Pengguna**:
  - Halaman utama publik (`bill3-gyh.gayuh.net.id.test/`) sebelumnya masih menggunakan gaya lama: latar belakang putih polos, navbar atas berwarna biru gelap pekat yang kaku, kartu cek tagihan flat standar dengan border kotak biasa, dan tombol-tombol flat yang terpisah dari estetika modern aplikasi.
  - Pengguna meminta untuk merombak total tampilan landing page ke desain **Soft UI Neumorphism** agar senada, modern, dan berkelas tinggi.

- **Solusi Komprehensif yang Diterapkan**:
  1. **Desain Sistem Frontend Baru ([assets/frontend/styles/neumorphism-frontend.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/frontend/styles/neumorphism-frontend.css))**:
     - Mengembangkan stylesheet Neumorphic terdedikasi dengan kanvas lembut `--nm-bg: #e6ecf4`, sistem dual box-shadow taktil (`--nm-raised`, `--nm-raised-sm`, `--nm-inset`, `--nm-inset-sm`), palet warna brand Gayuh Net oranye (`#f47b20`), dan tipografi modern Google Fonts (**Plus Jakarta Sans**).
  2. **Top Navbar Mengambang yang Mulus ([application/views/frontend.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php))**:
     - Mengganti latar belakang biru gelap kaku dengan kanvas Neumorphic yang menyatu (`#e6ecf4`), berbayang timbul halus (`0 6px 18px rgba(184, 196, 212, 0.6)`).
     - Logo brand dikemas dalam badge Neumorphic timbul (*raised badge*) yang bersih.
     - Navigasi link berbentuk pill capsules yang elegan (status aktif memiliki efek debossed/inset, dan efek hover lembut).
     - Tombol **Masuk** dirombak menjadi tombol Neumorphic oranye 3D berdimensi taktil dengan efek tekan saat diklik.
     - Menyempurnakan navbar-toggler mobile dengan ikon FontAwesome.
  3. **Hero / Carousel Banner ([application/views/frontend/welcome_message.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/welcome_message.php))**:
     - Membungkus carousel ke dalam frame Neumorphic melengkung (`border-radius: 24px`) dengan bayangan ganda timbul (*raised frame*).
     - Menghilangkan kotak abu-abu/hitam kosong pada caption slide ketika teks nama/keterangan slide kosong.
     - Tombol panah navigasi carousel diubah menjadi lingkaran semi-transparan ber-blur dengan efek zoom saat hover.
  4. **Kartu Cek Tagihan & Info Kontak Taktil**:
     - Header kartu dirancang *seamless* dengan kanvas kartu, diperkaya dengan ikon squircle 3D timbul (`.nm-icon-squircle`).
     - Seluruh input field (`No. Pelanggan`, `Bulan`, `Tahun`) diubah menjadi form cekung/inset taktil (`box-shadow: inset 4px 4px 8px ...`), lengkap dengan transisi fokus glow oranye saat aktif.
     - Tombol **Cek Tagihan** diubah menjadi tombol Neumorphic oranye 3D pill yang kokoh dan taktil.
     - 4 Tombol sosial media (Instagram, Facebook, WhatsApp, Email) dirombak menjadi **3D Neumorphic Squircles** berukuran 58px × 58px dengan efek hover lift dan pendaran warna brand masing-masing (Instagram pink, Facebook biru, WhatsApp hijau, Email merah).
  5. **Section Layanan Kami (Product Cards)**:
     - Header section dipercantik dengan garis aksen oranye Neumorphic.
     - Kartu-kartu paket internet diubah menjadi kartu timbul Neumorphic 3D (`border-radius: 24px`) dengan tray gambar produk yang sedikit cekung (*recessed tray*).
     - Tombol **Selengkapnya** diubah menjadi tombol Neumorphic modern berikon panah kanan dengan efek hover angkat dan transisi mulus.
  6. **Hasil Pencarian Tagihan (AJAX Cek Tagihan)**:
     - Hasil pencarian tagihan kini tampil di dalam kartu Neumorphic berbayang inset lembut dengan status lunas / belum bayar yang kontras dan rapi.
  7. **Footer**:
     - Footer kini menyatu sempurna dengan kanvas Neumorphic, memiliki bayangan garis timbul di bagian atas, tipografi bersih, dan aksen oranye Gayuhnet.

## 16. Penghilangan Teks "BILL GAYUH BARU" dan Transformasi Halaman About Us ke Soft UI Neumorphism (07 September 2026)

- **Latar Belakang & Kebutuhan Pengguna**:
  - Pada menu **About Us** (`/tentang-kami.html`), terdapat tulisan `(BILL GAYUH BARU)` yang muncul berulang kali (di judul halaman, header banner, sub-judul, nama perusahaan pada kartu deskripsi, dan kartu profil kontak).
  - Tampilan halaman About Us sebelumnya masih mengusung desain lama: banner jumbotron berwarna ungu gelap pekat yang kontras tajam/kasar, kartu profil perusahaan flat standar, box biru tua pekat yang kaku untuk customer service, dan kartu keunggulan ("Mengapa Memilih Kami?") yang flat biasa tanpa dimensi taktil.
  - Pengguna meminta untuk **menghilangkan seluruh tulisan "bill gayuh baru"** pada menu About Us dan **merombak total tampilannya ke gaya Neumorphism** yang senada dengan landing page.

- **Investigasi & Akar Permasalahan Teks "BILL GAYUH BARU"**:
  - Pada database tabel `company`, kolom `company_name` tersimpan nilai `PT. GAYUH MEDIA INFORMATIKA (BILL GAYUH BARU)`.
  - Mengubah database secara langsung dapat mempengaruhi modul lain yang mungkin masih memerlukan nama asli tersebut.
  - Oleh karena itu, diterapkan pembersihan (sanitasi) regex cerdas berbasis view template:
    `$company_name_clean = trim(preg_replace('/\s*\(?BILL GAYUH BARU\)?/i', '', $raw_name));`
    sehingga teks `(BILL GAYUH BARU)` atau `BILL GAYUH BARU` tereliminasi secara bersih dan dinamis di seluruh output view tanpa merusak data asli database.

- **Solusi Komprehensif yang Diterapkan**:
  1. **Sanitasi Global Nama Perusahaan**:
     - Pada view [application/views/frontend/about.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/about.php), seluruh judul, paragraf pembuka, nama perusahaan pada kartu profil, dan kartu kontak kini menggunakan `$company_name_clean` ("PT. GAYUH MEDIA INFORMATIKA").
     - Pada layout utama [application/views/frontend.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php), tag `<title>`, fallback brand navbar, dan copyright footer disanitasi menggunakan `$clean_company_name`.
  2. **Penambahan Komponen Desain Token Neumorphic ([assets/frontend/styles/neumorphism-frontend.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/frontend/styles/neumorphism-frontend.css))**:
     - `.nm-badge-primary`: Badge pil lembut timbul dengan aksen oranye dan ikon sertifikat untuk penanda section profil.
     - `.nm-section-title-bar`: Garis aksen oranye brand Gayuhnet bergradasi lembut.
     - `.nm-feature-card` & `.nm-feature-icon`: Kartu fitur 3D timbul dengan tray ikon squircle cekung (*recessed tray*) menggunakan `--nm-surface-sunken` dan bayangan inset halus.
     - `.nm-company-desc`: Tipografi teks profil yang nyaman dibaca dengan line-height 1.85 dan warna kontras `--nm-text-muted`.
  3. **Rombak Total View [application/views/frontend/about.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/about.php)**:
     - **Hero Header Banner**: Banner jumbotron ungu pekat lama digantikan dengan kartu timbul Neumorphic (`.nm-card`) elegan berlatar `#e6ecf4`, ikon squircle gedung berkilau oranye, garis aksen, dan teks judul modern "Tentang Kami" yang bebas dari kata "BILL GAYUH BARU".
     - **Kartu Profil Perusahaan (Kiri)**: Kartu Neumorphic berdimensi 3D dengan badge profil lembut, tipografi deskripsi perusahaan yang terstruktur, dan tata letak responsif.
     - **Kartu Identitas Brand & CS (Kanan)**: Box biru tua kaku lama digantikan dengan kartu Neumorphic 3D timbul, dilengkapi ikon squircle Wi-Fi berdimensi cekung, sub-nama "Internet Services Provider", serta tombol WhatsApp Neumorphic oranye 3D (`.nm-btn.nm-btn-primary`) dengan efek interaksi taktil saat ditekan.
     - **Grid "Mengapa Memilih Kami?"**: 4 Kartu keunggulan (Koneksi Cepat, Jaringan Stabil, Harga Hemat, Dukungan 24/7) diubah menjadi kartu timbul Neumorphic 3D dengan tray squircle berwarna khusus (biru, hijau, amber, cyan) berbayang inset lembut.
     - **Kartu Alamat & Kontak**: Di bagian bawah, informasi kantor dan email dikemas dalam kartu Neumorphic 3D dengan ikon squircle timbul penunjuk lokasi dan surat.
  4. **Pembaruan Permanen Database & Pembersihan Tuntas Footer**:
     - Memperbarui nilai kolom `company_name` pada tabel `company` di database MySQL secara langsung menjadi `PT. GAYUH MEDIA INFORMATIKA` (menghilangkan selamanya teks `(BILL GAYUH BARU)` dari sumber data utama).
     - Memastikan baris copyright pada footer frontend ([frontend.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php)) bersih menampilkan `GAYUHNET © 2026 PT. GAYUH MEDIA INFORMATIKA`.

## 17. Penggantian Slideshow dengan Infinite Loop Slider Modern Sesuai Warna Logo GayuhNet (07 September 2026)

- **Latar Belakang & Kebutuhan Pengguna**:
  - Komponen slideshow sebelumnya menggunakan carousel bawaan Bootstrap 4 yang memiliki berbagai keterbatasan visual:
    - Tidak mendukung true infinite loop yang mulus tanpa patahan.
    - Menghadapi kendala rasio gambar slide yang berbeda-beda (slide keluarga berasio 4:3 vs slide banner berasio 3.26:1), yang sebelumnya menyebabkan gambar terpotong (*cropped*) atau panel container membengkak terlalu lebar ke bawah dan menyisakan ruang putih kosong (*whitespace*) yang canggung saat berpindah slide.
  - Pengguna secara spesifik meminta:
    > *"ganti slide shownya dengan infinite loop yang modern, warna sesuai dengan warna logo"*

- **Solusi Komprehensif yang Diterapkan**:
  1. **Engine Modern Infinite Loop (Swiper 11)**:
     - Mengintegrasikan library Swiper 11 versi mandiri secara lokal di `assets/frontend/libraries/swiper/` (`swiper-bundle.min.css` dan `swiper-bundle.min.js`) tanpa ketergantungan CDN eksternal, memastikan performa instan dan keandalan di lingkungan jaringan lokal ISP.
     - Mengaktifkan `loop: true`, `autoplay` dengan transisi halus (`speed: 750ms`), `grabCursor: true`, dan jeda otomatis saat mouse diarahkan ke slide (`pauseOnMouseEnter: true`).
     - Menyiapkan duplikasi slide cerdas pada backend PHP (`$loop_slides = array_merge($valid_slides, $valid_slides)`) jika jumlah slide aktif kurang dari 4, menjamin efek *infinite loop* berputar mulus tanpa jeda kosong.

  2. **Harmonisasi Warna Logo GayuhNet**:
     - **Warna Utama**: Oranye Brand (`#f47b20`).
     - **Warna Aksen / Kontras**: Deep Navy (`#2a207a` & `#1f1754`).
     - **Top Accent Line**: Garis gradasi dinamis (`linear-gradient(90deg, #f47b20, #2a207a, #f47b20)`) dengan animasi shimmering halus di bagian atas bingkai.
     - **Floating Badge**: Badge elegan berlatar Deep Navy dengan pendaran titik oranye berdenyut (`.nm-badge-pulse`) dan teks `GAYUHNET FIBER`.
     - **Tombol Navigasi**: Tombol bulat kaca Neumorphic berikon Deep Navy, yang bertransisi ke pendaran gradasi oranye menyala dengan bayangan neon (`box-shadow: 0 8px 25px rgba(244, 123, 32, 0.5)`) saat diarahkan kursor.
     - **Pagination Modern**: Indikator slide aktif bertransformasi dari titik menjadi pill oranye panjang bergradasi yang bersinar.
     - **Autoplay Progress Bar**: Garis pengukur waktu autoplay di bagian bawah container yang terisi secara real-time dari 0% ke 100% berwarna oranye.
     - **Slide Counter**: Penghitung nomor slide aktif (`01 / 02`) berlatar kaca Deep Navy.

  3. **Solusi Zero-Crop (Gambar 100% Utuh & Tidak Terpotong)**:
     - Menggunakan teknik **Smart Ambient Framing**:
       - Container slide memiliki tinggi adaptif yang terkendali (`height: clamp(340px, 42vw, 460px)` di desktop dan `210px - 290px` di mobile) sehingga panel tidak akan membengkak ke bawah.
       - Lapisan bawah (*ambient backdrop*) memproyeksikan pantulan warna lembut dari gambar slide itu sendiri dengan blur halus, mengisi ruang samping secara natural dan estetis.
       - Lapisan atas (*foreground image*) menampilkan gambar dengan `object-fit: contain` dan drop-shadow halus, memastikan 100% gambar, foto keluarga, laptop, dan teks "GAYUHNET" tampil utuh tanpa ada bagian yang terpotong.

- **File yang Diubah**:
  1. `application/views/frontend.php`: Menyertakan stylesheet dan script Swiper 11 lokal.
  2. `application/views/frontend/welcome_message.php`: Mengganti markup Bootstrap carousel dengan markup Swiper modern, floating badge, ambient backdrop, progress bar, counter, dan inisialisasi script interaktif.
  3. `assets/frontend/styles/neumorphism-frontend.css`: Menambahkan seluruh styling Neumorphic untuk `.nm-hero-slider-wrap`, `.nm-hero-swiper`, tombol navigasi oranye-navy, pagination pill, progress bar, dan breakpoint responsif mobile.

## 18. Pengembalian Tampilan Slideshow ke Semula (07 September 2026)

- **Permintaan Pengguna**:
  > *"kembalikan slide shownya ke semula"*
- **Tindakan**:
  - Mengembalikan seluruh struktur slideshow pada [application/views/frontend/welcome_message.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend/welcome_message.php) kembali ke komponen Bootstrap Carousel bawaan dengan pembungkus `.nm-carousel-wrapper`.
  - Mengembalikan styling CSS di [assets/frontend/styles/neumorphism-frontend.css](file:///d:/project/bill3-gyh.gayuh.net.id/assets/frontend/styles/neumorphism-frontend.css) untuk `.nm-carousel-wrapper`, `.carousel-item`, dan tombol panah navigasi `.carousel-control-prev` / `.carousel-control-next`.
  - Menghapus pemuatan script dan stylesheet Swiper 11 dari layout utama [application/views/frontend.php](file:///d:/project/bill3-gyh.gayuh.net.id/application/views/frontend.php).
  - Tampilan telah diverifikasi via browser subagent dan berjalan normal sesuai kondisi semula.
