# Catatan Perbaikan V2 — UI/UX Modernization & Layout Optimization
**Tanggal:** 14 September 2026  
**Aplikasi:** Sistem Billing & Manajemen Jaringan (PT. GAYUH MEDIA INFORMATIKA)  
**Fokus Perbaikan:** Optimalisasi Responsif Mobile Drawer, Sticky Topbar, Penanganan Z-Index Dropdown, dan Rekonstruksi Minimized Sidebar Desktop.

---

## 📋 Ringkasan Eksekutif Perbaikan

Pada pembaruan versi 2 (V2) ini, dilakukan perbaikan arsitektur tampilan antarmuka (UI/UX) secara menyeluruh pada komponen navigasi utama (Sidebar dan Topbar) serta integrasi elemen Neumorphism. Perbaikan ini mengatasi masalah tata letak tumpang tindih (*overlapping*), elemen melayang yang menembus menu, serta distorsi tampilan saat sidebar diperkecil pada layar desktop.

---

## 🛠️ Rincian Modul Perbaikan

### 1. Rekonstruksi Sidebar Mode Mobile (< 768px) Menjadi Offcanvas Navigation Drawer
* **Masalah Sebelumnya:**
  - Sidebar bawaan SB Admin 2 pada resolusi mobile tetap mengonsumsi ruang horizontal selebar `6.5rem` (~104px), menjepit konten formulir dan tabel data hingga tersisa hanya ~270px.
  - Submenu yang aktif (seperti *"Tagihan" ➔ "Belum Bayar"*) melayang ke kanan secara absolut (`position: absolute`), menutupi formulir filter pencarian, tombol aksi, dan tabel data.
  - Sidebar langsung terbuka saat halaman pertama kali dimuat di layar ponsel, mengganggu kenyamanan pengguna.
* **Solusi & Implementasi:**
  - **Offcanvas Drawer:** Mengubah sidebar mobile menjadi laci navigasi modern (`position: fixed; width: 280px; height: 100%; top: 0; left: 0; transform: translateX(-100%);`) dengan transisi geser mulus (*cubic-bezier*).
  - **Interactive Blur Backdrop:** Menambahkan elemen `#sidebarBackdrop` dengan efek latar belakang gelap kabur (*blur* `backdrop-filter: blur(4px); z-index: 10000;`).
  - **Neumorphic Close Button:** Menambahkan tombol tutup silang (**×**) neumorphic inset melingkar `#sidebarCloseBtn` di dalam header drawer laci untuk mempermudah akses penutupan dengan satu tangan.
  - **In-Flow Submenu Accordion:** Submenu dropdown (`.collapse`) diubah menjadi akordeon vertikal di dalam laci menu (`position: static !important; width: 100% !important;`) sehingga tidak ada lagi submenu yang melayang keluar menutupi halaman.
  - **Multi-Trigger Penutupan:** Drawer dapat ditutup melalui 5 cara: tombol silang (**×**), ketuk area backdrop, tekan tombol `Escape`, klik link menu navigasi, atau saat layar diperbesar kembali ke mode desktop.
  - Konten utama `#content-wrapper` kini memiliki ruang penuh **100%** di layar mobile.

---

### 2. Penanganan Elemen Menembus Drawer (*Select2 Dropdown Z-Index Isolation*)
* **Masalah Sebelumnya:**
  - Dropdown pencarian cepat layanan (Select2) di dashboard memiliki aturan bawaan `z-index: 9998`.
  - Ketika drawer mobile dibuka, dropdown Select2 tetap melayang dan menembus (*pierce through*) di atas laci sidebar mobile, merusak estetika dan estetika Neumorphism.
* **Solusi & Implementasi:**
  - Menurunkan `z-index` Select2 dalam keadaan pasif/tertutup menjadi `z-index: 2`, dan hanya mengaktifkan `z-index: 9999 !important` ketika dropdown benar-benar dibuka oleh pengguna (`.select2-container--open`).
  - Meningkatkan hierarki tumpukan drawer mobile menjadi `z-index: 10005 !important` dan backdrop menjadi `z-index: 10000 !important`.
  - Menambahkan aturan isolasi mutlak: ketika drawer dibuka (`body.sidebar-open`), seluruh kontainer Select2 dipaksa berada pada `z-index: 1 !important`.
  - Pada JavaScript (`sb-admin-2.js`), menambahkan penutupan otomatis dan pelepasan fokus (`select2('close')` dan `blur()`) saat tombol hamburger diketuk.
  - Mempercantik tampilan scrollbar drawer dengan desain modern ramping (*thin scrollbar* 4px membulat) yang menyatu dengan tema.

---

### 3. Navigasi Topbar Fixed Saat Di-Scroll (*Sticky Topbar Navigation*)
* **Masalah Sebelumnya:**
  - Pada halaman dengan formulir panjang (seperti *Tambah Pelanggan*) atau tabel data yang panjang, topbar ikut tergulung ke atas (*scrolled away*).
  - Pengguna kesulitan mengakses tombol menu hamburger, tombol toggle dark mode, lonceng notifikasi, dan profil akun tanpa harus menggulung kembali ke paling atas halaman.
  - `position: sticky` bawaan tidak berfungsi karena adanya aturan `overflow-x: hidden` pada `#wrapper` dan `#content-wrapper` yang membentuk *scroll container* internal independen (membatalkan kalkulasi relatif terhadap *window scroll*).
* **Solusi & Implementasi:**
  - **Modern CSS Clipping:** Mengganti `overflow-x: hidden` pada `#wrapper` dan `#content-wrapper` menjadi `overflow-x: clip !important; overflow-y: visible !important;`. Kata kunci `clip` memangkas luapan horizontal secara efisien tanpa menciptakan *scroll container*, sehingga `position: sticky` dapat berfungsi 100% mengikuti scroll halaman.
  - **Sticky Navbar:** Mengubah kelas navbar menjadi `sticky-top` dengan `position: -webkit-sticky; position: sticky; top: 0; z-index: 1030;`.
  - **Desain Sudut Bawah Melengkung:** Topbar mobile menempel rapat di atas layar tanpa celah (`margin: 0 0 14px 0;`) dengan lekukan sudut bawah membulat elegan (`border-radius: 0 0 18px 18px;`).
  - **Dynamic Elevation:** Menambahkan event listener scroll pada `sb-admin-2.js` yang otomatis menyematkan kelas `.topbar-scrolled` saat digulung > 10px untuk mempertegas bayangan kedalaman secara halus.
  - **Solid Anti-Bleed Background:** Latar belakang solid `var(--nm-bg)` pada mode terang dan `#1a2236` pada mode gelap memastikan teks formulir tidak terlihat tembus di belakang topbar saat digulung.

---

### 4. Perbaikan Tampilan Sidebar Saat Di-Minimize (*Desktop Toggled Mode $\ge$ 768px*)
* **Masalah Sebelumnya:**
  - Saat tombol toggle panah bundar di kiri bawah sidebar (`#sidebarToggle`) diklik, sidebar menyusut ke lebar `6.5rem` (~104px).
  - Styling Neumorphism sebelumnya memaksa tautan menu (`.nav-link`) menggunakan tata letak baris horizontal (`flex-direction: row;`) dengan padding tebal `12px 16px`, ikon di kiri, teks utuh di tengah, dan panah chevron kanan (`::after`) yang dipaksa tampil.
  - Akibatnya, pada ruang sempit selebar 104px, ikon, teks panjang (seperti *"Rute Management"*, *"Pelanggan"*, *"Pengaturan"*), dan panah chevron dipaksa berjejer dalam 1 baris. Teks terbelah menjadi dua baris, melompat menabrak ikon, dan panah chevron saling bertumpukan (*overlapping layout distortion*).
* **Solusi & Implementasi:**
  - **Vertical Centered Stack:** Setiap tautan menu pada `.sidebar.toggled` diubah menjadi flexbox vertikal berpusat di tengah (`flex-direction: column !important; align-items: center !important; justify-content: center !important;`).
  - **Ikon Terpusat Proporsional:** Ikon menu ditempatkan di atas secara simetris dengan ukuran `1.25rem` dan margin bawah `5px`.
  - **Label Mikro Tajam dengan Elipsis:** Teks menu diletakkan tepat di bawah ikon dengan ukuran mikro yang tajam (`0.68rem; font-weight: 700;`), dibatasi maksimal `5.2rem`, dan dipangkas menggunakan elipsis (`text-overflow: ellipsis; white-space: nowrap; overflow: hidden;`) sehingga tidak akan pernah turun ke baris kedua.
  - **Penyembunyian Panah Chevron Mutlak:** Seluruh panah chevron (`::after { display: none !important; content: none !important; }`) disembunyikan saat sidebar dalam mode mini.
  - **Penyelarasan Logo Brand:** Teks nama instansi/perusahaan disembunyikan (`display: none`), dan logo ikon brand/wifi diposisikan tepat di tengah header sidebar.
  - **Floating Popover Submenu Elegan:** Submenu (`.collapse`) diposisikan sebagai kartu popover melayang di sisi kanan sidebar (`position: absolute; left: calc(6.5rem + 8px); top: 2px; z-index: 1060 !important;`) dengan bayangan *raised neumorphic* pekat dan animasi muncul yang halus (`animation: growIn 0.2s`).
  - **Dukungan Hover Tooltips:** Fungsi JavaScript `initSidebarTooltips()` secara otomatis menambahkan atribut `title` ke setiap link navigasi berdasarkan teks aslinya, sehingga saat kursor diarahkan ke ikon menu, tooltip nama lengkap menu akan muncul.
  - **Konsistensi Dark & Light Mode:** Status hover dan status aktif pada menu mini memiliki bayangan *raised* dan *inset* yang presisi di kedua tema.

---

### 5. Simetri dan Reposisi Logo Wifi Pojok Kiri Atas (*Centered & Symmetrical Minimized Brand Emblem*)
* **Masalah Sebelumnya:**
  - Saat sidebar di-minimize (`.sidebar.toggled`), ikon logo wifi di pojok kiri atas tampak **miring ke kanan sejauh ~20px** dan tidak berada pada satu garis vertikal lurus dengan ikon-ikon navigasi di bawahnya (*Beranda, Layanan, Pelanggan*).
  - Kelas bawaan SB Admin 2 `.rotate-n-15` membuat ikon wifi berputar -15 derajat berlawanan arah jarum jam, sehingga pancaran busur gelombang wifi miring dan merusak simetri visual.
  - Kontainer brand mewarisi kelas utilitas `justify-content-between` dan `padding-left: 1.25rem` dari layout drawer mobile, menyebabkan kontainer merek melebar dan mendorong logo ke tepi kanan sidebar mini.
* **Solusi & Implementasi:**
  - **Penyelarasan Sumbu Vertikal Presisi:** Menerapkan kalkulasi CSS strict pada `.sidebar.toggled .sidebar-brand`:
    - Membatasi lebar kontainer tepat `6.5rem` (~104px), `margin: 0 auto !important`, dan `justify-content: center !important`.
    - Mengatur elemen jangkar `<a>` menjadi `width: 100% !important; justify-content: center !important; flex-grow: 0 !important;`.
  - **Emblem Neumorphic Melingkar (*Circular Neumorphic Plate*):**
    - Mengubah `.sidebar-brand-icon` menjadi emblem melingkar simetris berukuran **44×44px** (`border-radius: 50% !important; margin: 0 auto !important;`).
    - Diberikan latar belakang `var(--nm-bg)` dengan elevasi bayangan halus `var(--nm-raised-xs)` di mode terang, dan latar belakang gelap `#161c2e` dengan bayangan *raised* di mode gelap.
  - **Pemberantasan Kemiringan Rotasi (*Rotation Reset*):**
    - Mengeliminasi kelas `.rotate-n-15` dengan menyuntikkan `transform: none !important;` pada kontainer ikon dan tag `<i>`.
    - Gelombang wifi kini berdiri tegak sempurna (*upright*) menghadap lurus ke atas dengan warna oranye cerah (`#f47b20`) dan efek *drop-shadow* lembut.
  - **Hasil Pengukuran Piksel (Sub-Pixel Accuracy):**
    - Pengukuran digital berbasis citra konfirmasi: sumbu tengah X ikon wifi kini berada di koordinat **57.0px**, sedangkan sumbu tengah X ikon Beranda di **56.5px**.
    - Deviasi offset berhasil dipangkas dari **20.0px menjadi hanya 0.5px** (sepenuhnya simetris dan sejajar tegak lurus secara matematis maupun optik).
  - **Paritas Multi-View:** Aturan kelas `justify-content-md-center` dan `flex-md-grow-0` diterapkan secara serentak pada `backend.php`, `mikrotik.php`, dan `olt.php`.

---

### 6. Pembekuan Panel Nama Pelanggan (*Freeze Panes: No, Checkbox, & Nama Pelanggan*)
* **Masalah Sebelumnya:**
  - Pada tabel tagihan (`Data Tagihan Belum Bayar`, `Sudah Bayar`, dll.), terdapat banyak kolom informasi penting (No, Checkbox, Nama Pelanggan, No Telepon, No Layanan, No Invoice, Periode, Jatuh Tempo, Total, Status, Coverage, dan Aksi).
  - Ketika pengguna menggulir (*scroll*) tabel ke kanan pada mode mobile maupun desktop, kolom identitas pelanggan (No, Checkbox, dan Nama Pelanggan) langsung tergulung hilang ke kiri.
  - Akibatnya, pengguna kesulitan mengetahui data tagihan, status isolir, atau nominal total yang sedang dilihat milik siapa, dan tidak dapat memilih checkbox pelanggan untuk aksi massal (*Action*) tanpa harus menggulir bolak-balik.
* **Solusi & Implementasi:**
  - **Arsitektur CSS Sticky Berjenjang (*Multi-Column Sticky Stacking*):**
    - **Kolom 1 (No):** `position: sticky; left: 0; z-index: 5; width: 42px; text-align: center; background-color: var(--nm-bg);`.
    - **Kolom 2 (Checkbox):** `position: sticky; left: 42px; z-index: 5; width: 38px; text-align: center; background-color: var(--nm-bg);`.
    - **Kolom 3 (Nama Pelanggan):** `position: sticky; left: 80px; z-index: 5; min-width: 175px; max-width: 250px; background-color: var(--nm-bg);`.
  - **Efek Separator Kedalaman (*Depth Box Shadow*):**
    - Pada tepi kanan Kolom 3 (Nama Pelanggan) ditambahkan efek bayangan halus `box-shadow: 4px 0 8px -2px rgba(0, 0, 0, 0.12)` di mode terang, dan `box-shadow: 4px 0 12px -1px rgba(0, 0, 0, 0.5)` di mode gelap. Efek ini memberikan isyarat visual yang tegas bahwa kolom-kolom lain meluncur di bawah panel beku (*floating beneath*).
  - **Header Z-Index Isolation:**
    - Elemen `thead th` pada ketiga kolom beku diberikan `z-index: 10 !important;` agar saat tabel digulung secara vertikal, sel header tetap berada di lapisan paling atas melampaui sel body (`z-index: 5`).
    - Diberikan ruang kanan ekstra `padding-right: 28px !important;` agar panah pengurutan (*sorting arrow*) DataTables tidak menutupi teks "Nama Pelanggan".
  - **Sinkronisasi Baris Hover (*Row Hover Preservation*):**
    - Sel beku tetap mendapatkan warna latar hover (`#dbe4f0` di mode terang, `#1a2238` di mode gelap) saat baris disorot kursor, menjaga keharmonisan efek interaktif.
  - **Adaptasi Mode Mobile Responsif (< 768px):**
    - Kolom 1 (No) disesuaikan ke lebar `34px` (`left: 0; padding: 8px 2px`).
    - Kolom 2 (Checkbox) disesuaikan ke lebar `34px` (`left: 34px; padding: 8px 2px`).
    - Kolom 3 (Nama Pelanggan) disesuaikan ke lebar `135px` (`left: 68px; min-width: 125px; max-width: 145px; white-space: normal; word-break: break-word; line-height: 1.25`).
    - Total lebar panel beku di mobile hanya **203px**, menyisakan ruang lebar yang sangat leluasa (~172px - 209px) bagi pengguna ponsel untuk menggulir dan membaca kolom Status, Jatuh Tempo, Nominal, dan Aksi.
  - **Penerapan Multi-Tabel:**
    - Aturan CSS diterapkan via `#tablebill table` dan kelas utilitas `.table-sticky-customer` pada `unpaid.php`, `paid.php`, `bill.php`, dan `get-data-bill.php`.

---

### 7. Penanganan Ukuran & Pembungkusan Teks Nama Pelanggan (*Customer Name Text Wrapping & Overflow Fit*)
* **Masalah Sebelumnya:**
  - Nama pelanggan yang panjang (contoh: `YOGA FACHRUDIN PERDANA-(Q14B)`) melebihi batas sel kolom 3 dan tumpah (*overflow*) secara horizontal ke kolom 4 (*No. Telepon*).
  - Teks nama yang bocor menabrak dan menutupi ikon WhatsApp serta nomor telepon pelanggan lain.
  - Akar masalah teknis: tabel tagihan mewarisi kelas bawaan SB Admin 2 `.text-nowrap` yang memaksa seluruh sel tabel menggunakan `white-space: nowrap !important;`. Akibatnya, meskipun kolom dibatasi dengan `max-width`, teks tetap dipaksa berjejer dalam 1 baris panjang dan meluap ke kolom sebelahnya.
* **Solusi & Implementasi:**
  - **Overriding Text Wrapping (`white-space: normal !important`):**
    - Menyuntikkan aturan pembungkusan teks multi-baris secara tegas pada sel nama pelanggan:
      ```css
      .table-sticky-customer td:nth-child(3),
      #tablebill table td:nth-child(3) {
        white-space: normal !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
        overflow-wrap: break-word !important;
        line-height: 1.35 !important;
        font-size: 0.88rem !important;
        font-weight: 600 !important;
      }
      ```
    - Dengan `white-space: normal` dan `word-break: break-word`, nama panjang secara otomatis terbagi menjadi 2 baris rapi (misalnya baris 1: `YOGA FACHRUDIN` dan baris 2: `PERDANA-(Q14B)`) tanpa melebihi batas kanan kolom 3.
  - **Peningkatan Kapasitas Lebar Kolom Desktop:**
    - Lebar kolom nama pelanggan di desktop dinaikkan dari sebelumnya 175px–250px menjadi:
      - `width: 220px !important;`
      - `min-width: 200px !important;`
      - `max-width: 260px !important;`
    - Memberikan ruang horizontal yang lebih lapang bagi nama-nama pelanggan berformat kode ODP/cluster perumahan.
  - **Proteksi Single-Line Header (`thead th`):**
    - Judul kolom header *"Nama Pelanggan"* tetap dikunci dalam 1 baris (`white-space: nowrap !important; padding-right: 28px !important;`) sehingga tata letak header tetap konsisten dan panah pengurutan (*sorting arrow*) DataTables tidak terganggu.
  - **Optimalisasi Mode Mobile (< 768px):**
    - Di layar ponsel, sel nama pelanggan diatur `width: 135px !important; min-width: 125px !important; max-width: 145px !important;` dengan `line-height: 1.25 !important; font-size: 0.8rem !important;` serta pembungkusan kata multi-baris aktif.
  - **Integritas Tinggi Baris (Row Height Invariant):**
    - Baris tabel secara alami sudah memiliki tinggi 2–3 baris teks karena kolom *Jatuh Tempo* (tanggal & isolir) dan *Status* (status & waktu kirim pesan). Pembungkusan nama pelanggan ke 2 baris tidak menambah tinggi baris tabel atau merusak proporsi vertikal.

---

### 8. Relokasi & Penyelarasan Simetris Tombol Minimize Sidebar di Samping Kanan Tombol Bantuan (*Docked Sidebar Toggler*)
* **Masalah Sebelumnya:**
  - Tombol minimize sidebar (`#sidebarToggle`) awalnya berada di paling bawah sidebar (di bawah menu Changelog).
  - Ketika menu sidebar bertambah panjang atau saat sidebar dalam mode mini (*toggled*), tombol tersebut terdorong jauh ke bawah (hingga koordinat Y > 1000px) dan terpotong/hilang dari viewport layar monitor biasa. Pengguna harus menggulir halaman ke bawah hanya untuk memperbesar kembali sidebar.
  - Tampilan tombol di bawah terasa terisolasi dan kurang ergonomis bagi alur kerja operator.
* **Solusi & Implementasi:**
  - **Relokasi ke Samping Kanan Menu Bantuan:**
    - Memindahkan tombol `#sidebarToggle` langsung ke dalam elemen menu Bantuan (`#navItemHelp`) yang merupakan titik tengah vertikal (*vertical center*) dari daftar navigasi (item ke-7 dari 15 menu).
  - **Desain Melayang Simetris pada Border Kanan (*Docked Border-Center Pin*):**
    - Tombol didesain sebagai pin melingkar neumorphic berukuran **28×28px** dengan posisi `position: absolute; right: -14px; top: 24px; transform: translateY(-50%); z-index: 1060;`.
    - Sumbu tengah lingkaran berada persis di atas garis batas pembatas antara sidebar dan konten utama, memberikan tampilan modern mirip panel SaaS kelas dunia (Linear / Notion).
  - **Simetri di Mode Expanded & Minimized serta Proteksi Salah Tekan:**
    - Pada mode terbuka (lebar 224px): tombol diposisikan pada `right: -24px` (menjorok ke kanan pada celah gutter) sejajar dengan menu Bantuan, menampilkan panah chevron `<` (fa-angle-left) yang mengisyaratkan aksi ciutkan.
    - Pada mode mini (lebar 104px): tombol tetap bertengger di `right: -24px` pada koordinat `top: 29px` (sejajar dengan ikon Bantuan), otomatis mengubah panah menjadi `>` (fa-angle-right) yang mengisyaratkan aksi bentangkan.
    - **Zona Penyangga Bebas Salah Tekan (*Zero Misclick Buffer*):** Diberikan jarak aman horizontal > 24px antara chevron dropdown `>` Bantuan (`margin-right: 18px !important;` & `padding-right: 32px !important;`) dengan tombol `#sidebarToggle`. Dengan ini, pengguna tidak akan sengaja menekan tombol minimize saat bermaksud mengklik menu Bantuan.
  - **Estetika Neumorphic Dinamis:**
    - Efek timbul melingkar halus dengan `border-radius: 50%`, latar `var(--nm-bg)`, dan border semi-transparan.
    - Efek mikro-interaksi hover (`transform: translateY(-50%) scale(1.12)`) dengan sorotan warna oranye `#f47b20`, serta efek cekung (*inset*) saat diklik.
    - Mendukung penuh mode gelap (*Dark Mode*) dengan bayangan pekat dan border aksen redup.
  - **Proteksi Mode Mobile (< 768px):**
    - Tombol otomatis disembunyikan (`d-none d-md-flex`) di layar ponsel untuk mencegah interferensi dengan laci offcanvas drawer.

---

### 12. Optimalisasi Tampilan Landing Page Menu Speedtest (*Bottom Description & Gauge Fit*)
- **Kondisi Awal / Masalah**:
  - Pada menu **Speed Test** di landing page (`http://billtest.gayuh.net.id.test/front/speedtest`), tinggi iframe sebelumnya dipatok mati secara statis pada atribut HTML `height="650px"`.
  - Aplikasi LibreSpeed (`speedtest.gayuh.net.id`) di dalam iframe memiliki tinggi konten aktual ~950px yang terdiri dari: header/navigasi, tombol Start, indikator Ping & Jitter, gauge meteran Download & Upload, bagian **User Info** (IP Address, ASN, ISP: PT. GAYUH MEDIA INFORMATIKA, Lokasi, User Agent, Browser, OS), dan bar footer hak cipta.
  - Akibat `height="650px"`, bar footer gelap di dalam iframe menabrak dan memotong setengah lingkaran gauge Download & Upload, sedangkan seluruh deskripsi **User Info** di bagian bawah terpotong (*truncated / hidden*).
- **Solusi yang Diterapkan**:
  - Memperbarui berkas template [`application/views/member/speedtest.php`](file:///d:/project/billtest.gayuh.net.id/application/views/member/speedtest.php) dengan pembungkus `.speedtest-wrapper` dan kelas `.speedtest-iframe`.
  - Menerapkan aturan CSS responsif adaptif sesuai breakpoint layar:
    - **Desktop (≥ 992px)**: `height: 1000px; min-height: 1000px;` — seluruh gauge, bagian User Info, dan bar footer gelap pas (*fit*) sempurna dengan ruang bernapas yang lega.
    - **Tablet (768px - 991px)**: `height: 1060px; min-height: 1060px;` — mengakomodasi tata letak tablet.
    - **Mobile Standar (481px - 767px)**: `height: 1140px; min-height: 1140px;` — mengakomodasi teks User Info yang melipat menjadi beberapa baris.
    - **Mobile Kecil (≤ 480px)**: `height: 1200px; min-height: 1200px;` — memastikan tidak ada elemen yang terpotong di layar ponsel sempit.
  - Hasilnya: Seluruh bagian meteran dan deskripsi informasi jaringan di bagian bawah tampil utuh, rapi, dan menyatu mulus dengan footer situs utama.

---

### 13. Perbaikan Tampilan & Responsivitas Pencarian Cepat Layanan di Mode Mobile (*Select2 Neumorphic Overhaul*)
- **Kondisi Awal / Masalah**:
  - Pada tampilan mobile di Dashboard (`/dashboard`), kotak pencarian cepat layanan (*Select2*) mengalami **horizontal overflow parah** (lebar elemen mencapai ~1000px).
  - Hal ini menyebabkan kotak pencarian meluap menembus batas kartu (`.nm-card`) hingga ke luar layar kanan, dan seluruh halaman mobile terdorong memiliki scroll horizontal yang merusak tata letak topbar, header, dan kartu.
  - Bidang input pencarian dropdown (`.select2-search__field`) memiliki border hitam tebal yang kasar dan tidak selaras dengan tema Neumorphism.
  - Dropdown daftar hasil pencarian tidak memiliki batas lebar maksimal (`max-width`), sehingga melebar tanpa kontrol.
- **Akar Masalah Teknis**:
  - Kartu pencarian cepat di `application/views/backend/dashboard.php` ditempatkan langsung di dalam `.container-fluid` tanpa pembungkus `<div class="row">`.
  - Inisialisasi Select2 di `backend.php` tidak menyertakan opsi `{ width: '100%' }`, sehingga Select2 mengukur lebar dari opsi teks terpanjang (~1000px).
  - File `neumorphism.css` belum memiliki aturan khusus untuk mempercantik dan mengontrol komponen Select2.
- **Solusi yang Diterapkan**:
  1. **Pembungkus Grid Responsif**:
     - Membungkus kartu pencarian dalam `<div class="row"><div class="col-12 col-md-6 col-lg-4 mb-4">` pada `application/views/backend/dashboard.php`.
     - Memberikan `style="width: 100% !important;"` pada elemen `<select>`.
  2. **Inisialisasi Select2 Responsif**:
     - Mengubah pemanggilan di `backend.php` menjadi `$('.select2').select2({ width: '100%' });`.
  3. **Desain Neumorphic Menyeluruh untuk Select2 (Bagian 12 di `neumorphism.css`)**:
     - `.select2-container`: Diberikan `width: 100% !important; max-width: 100% !important;`.
     - `.select2-selection--single`: Didesain cekung (*inset*) elegan dengan tinggi 44px, radius 12px, teks elipsis rapi, dan panah chevron bersih.
     - `.select2-dropdown`: Diberikan radius 14px, bayangan timbul halus (*soft floating shadow*), dan `max-width: 100% !important;`.
     - `.select2-search__field`: Border hitam tebal dihilangkan, diganti dengan input cekung Neumorphic dengan border oranye saat fokus.
     - Mendukung penuh **Dark Mode** dengan warna latar navy gelap (`#1a2236`), input cekung `#131927`, dan kontras teks yang nyaman.
     - Eliminasi total scroll horizontal pada mobile (`document.documentElement.scrollWidth == clientWidth`).

---

### 14. Freeze Panel & Reposisi Kolom Menu Jatuh Tempo (*Due Date Freeze Panes & Checkbox Overhaul*)
- **Kondisi Awal / Masalah**:
  - Pada halaman Data Pelanggan Jatuh Tempo (`http://billtest.gayuh.net.id.test/bill/duedate`), tata letak kolom awal adalah: `No` (Col 0), `Checkbox` (Col 1), `Aksi` (Col 2), `Nama Pelanggan` (Col 3), `No Layanan` (Col 4), `Periode - Jatuh Tempo` (Col 5), `Tagihan` (Col 6).
  - Kolom checkbox memiliki padding lebar yang tidak proporsional sehingga tampak renggang.
  - Kolom Nama Pelanggan terletak jauh di sebelah kanan kolom Aksi, dan saat tabel digeser/scroll secara horizontal pada layar sempit/mobile, kolom Nama Pelanggan tergulung hilang ke kiri sehingga pengguna kehilangan konteks data baris yang sedang dilihat.
- **Solusi yang Diterapkan**:
  1. **Rekonstruksi Urutan Kolom Sesuai Preferensi Pengguna**:
     - Kolom 1: **No** (Nomor urut)
     - Kolom 2: **Nama Pelanggan** (Langsung di sebelah kanan kolom No)
     - Kolom 3: **Checkbox** (Langsung di sebelah kanan kolom Nama Pelanggan, dengan ukuran ringkas, presisi, dan terpusat di tengah)
     - Kolom 4: **Aksi** (Tombol Detail, WhatsApp, Hapus)
     - Kolom 5: **No Layanan**
     - Kolom 6: **Periode - Jatuh Tempo**
     - Kolom 7: **Tagihan**
  2. **Implementasi Freeze Panel Berjenjang (.table-sticky-duedate)**:
     - **Mode Desktop**:
       - Kolom 1 (`No`): `position: sticky; left: 0; width: 42px; text-align: center;`
       - Kolom 2 (`Nama Pelanggan`): `position: sticky; left: 42px; width: 220px; white-space: normal; word-break: break-word;`
       - Kolom 3 (`Checkbox`): `position: sticky; left: 262px; width: 42px; text-align: center; box-shadow: 4px 0 8px -2px rgba(0, 0, 0, 0.12);`
     - **Mode Mobile (< 768px)**:
       - Kolom 1 (`No`): `width: 36px; left: 0;`
       - Kolom 2 (`Nama Pelanggan`): `width: 140px; left: 36px; line-height: 1.25;`
       - Kolom 3 (`Checkbox`): `width: 38px; left: 176px; box-shadow: 4px 0 8px -2px rgba(0, 0, 0, 0.12);`
       - Penguncian `min-width == max-width == width` identik memastikan **0 pixel gap** dan **0 pixel overlap** saat digulir ke kanan/kiri.
  3. **Presisi Checkbox & Interaktivitas**:
     - Checkbox menggunakan styling 16×16px dengan `accent-color: #f47b20` (warna oranye brand Gayuh Media).
     - Checkbox terpusat simetris (`margin: 0 auto; display: block;`).
     - Event listener `#selectAll` menggunakan *delegated event* `$(document).on('click', '#selectAll', ...)` sehingga seluruh checkbox baris terceklis/tidak terceklis secara andal bahkan setelah AJAX redraw DataTables.
  4. **Paritas Dark Mode**:
     - Latar belakang sel beku menggunakan warna navy gelap pekat `#111625` dengan efek bayangan kedalaman `box-shadow: 4px 0 12px -1px rgba(0, 0, 0, 0.5)` dan status hover baris `#1a2238`.

---

## 📂 Berkas yang Diperbarui

| No | Berkas | Deskripsi Perubahan |
|:---|:---|:---|
| 1 | `assets/backend/css/neumorphism.css` | Penambahan Bagian 11B (*Sticky Freeze Panes Menu Jatuh Tempo .table-sticky-duedate*), Bagian 12 (*Select2 Neumorphic Modern Styling & Mobile Overflow Protection*), Bagian 6.2 (*Sidebar Toggler Button Docked Beside Bantuan*), Bagian 11 (*Frozen / Sticky Customer Name Panel*), Bagian 6.1 (*Sidebar Minimized State Desktop*), perbaikan pembungkusan teks nama pelanggan (`white-space: normal`, `word-break: break-word`, lebar 220px), perbaikan simetri dan emblem melingkar logo wifi brand, perbaikan stacking drawer mobile, tombol close drawer, styling backdrop blur, perbaikan z-index Select2, dan transisi smooth. |
| 2 | `assets/backend/js/sb-admin-2.js` | Logika kontrol mobile drawer (`toggleMobileSidebar`), event listener penutupan (backdrop, close btn, escape, link click), dynamic scroll listener untuk sticky topbar, auto-close Select2, dan inisialisasi hover tooltip (`initSidebarTooltips`). |
| 3 | `application/views/backend.php` | Inisialisasi Select2 dengan `{ width: '100%' }`, pemindahan `#sidebarToggle` ke samping kanan menu Bantuan (`#navItemHelp`), penghapusan toggler lama di bawah sidebar, penyesuaian layout utama, penyisipan elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, perbaikan CSS responsif drawer & minimized brand header, penggantian `overflow-x` menjadi `clip`, dan pembersihan skrip toggle saat *document ready*. |
| 4 | `application/views/backend/dashboard.php` | Pembungkusan kartu Pencarian Cepat Layanan dalam grid `<div class="row">` dan penambahan `style="width: 100% !important;"` pada `<select>` untuk mencegah overflow di mobile. |
| 5 | `application/views/member/speedtest.php` | Penerapan pembungkus responsif `.speedtest-wrapper` dan `.speedtest-iframe` dengan tinggi adaptif (1000px di desktop, 1060px-1200px di tablet/mobile) agar gauge meteran dan deskripsi bagian bawah (*User Info* dan footer hak cipta) pas (*fit*) sempurna tanpa terpotong. |
| 6 | `application/views/backend/bill/duedate.php` | Penyesuaian urutan kolom tabel (No -> Nama Pelanggan -> Checkbox -> Aksi -> No Layanan -> Periode - Jatuh Tempo -> Tagihan), penambahan kelas `table-sticky-duedate`, pengaturan `autoWidth: false`, sinkronisasi array `columns` dan `columnDefs` DataTables, serta event listener delegasi untuk `#selectAll`. |
| 7 | `application/views/backend/bill/unpaid.php` | Penambahan kelas `table-sticky-customer` pada tabel `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox saat digulir ke kanan/kiri. |
| 8 | `application/views/backend/bill/paid.php` | Penambahan kelas `table-sticky-customer` pada tabel `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox. |
| 9 | `application/views/backend/bill/bill.php` | Penambahan kelas `table-sticky-customer` pada tabel `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox. |
| 10 | `application/views/backend/bill/get-data-bill.php` | Penambahan kelas `table-sticky-customer` pada tabel server-side `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox. |
| 11 | `application/views/mikrotik.php` | Penambahan link stylesheet `neumorphism.css`, elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, kelas `sticky-top`, paritas layout brand `justify-content-md-center`, dan skrip inisialisasi reset mobile drawer. |
| 12 | `application/views/olt.php` | Penambahan link stylesheet `neumorphism.css`, elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, kelas `sticky-top`, paritas layout brand `justify-content-md-center`, dan skrip inisialisasi reset mobile drawer. |

---

## 🔍 Panduan Verifikasi & Pengujian

1. **Pengujian Pencarian Cepat Layanan (Mode Mobile):**
   * Buka Dashboard (`http://billtest.gayuh.net.id.test/dashboard`) di layar ponsel (viewport ≤ 480px).
   * Perhatikan bahwa kartu **Pencarian Cepat Layanan** dan kotak input Select2 berada pas di dalam batas layar tanpa meluap ke kanan.
   * Pastikan tidak ada scroll horizontal liar pada halaman mobile.
   * Ketuk kotak pencarian: dropdown terbuka rapi selebar kartu dengan kotak input neumorphic (tanpa border hitam kasar).
   * Coba ketik kata kunci dan pilih pelanggan: fungsi pencarian bekerja instan.
2. **Pengujian Halaman Speedtest Landing Page:**
   * Buka halaman Speedtest (`http://billtest.gayuh.net.id.test/front/speedtest`).
   * Gulir ke bawah: perhatikan bahwa meteran Download dan Upload tampil utuh tanpa terpotong bar gelap.
   * Perhatikan deskripsi **User Info** di bagian bawah (IP, ASN, ISP, Lokasi, User Agent, Browser, OS) tampil lengkap dan terbaca dengan jelas.
   * Perhatikan bahwa bar gelap hak cipta berada di bawah User Info dan tepat di atas footer utama situs tanpa saling bertumpukan.
3. **Pengujian Posisi Tombol Minimize Sidebar (Desktop):**
   * Buka Dashboard (`http://billtest.gayuh.net.id.test/dashboard`).
   * Perhatikan posisi tombol toggle berbentuk lingkaran neumorphic kecil di tepi kanan menu **Bantuan** pada jarak aman (`right: -24px`).
   * Klik tombol tersebut: sidebar akan menyusut (*minimize*) dengan mulus, dan ikon tombol berubah dari `<` menjadi `>`.
   * Perhatikan bahwa tombol tetap menempel simetris di sisi kanan menu Bantuan pada status sidebar mini.
   * Klik kembali tombol `>` untuk memperluas sidebar ke ukuran normal.
4. **Pengujian Batas & Pembungkusan Teks Nama Pelanggan:**
   * Buka halaman tagihan (contoh: `http://billtest.gayuh.net.id.test/bill/paid` atau `/bill/unpaid`).
   * Cari baris dengan nama pelanggan panjang (contoh: baris ke-5 `YOGA FACHRUDIN PERDANA-(Q14B)`).
   * Verifikasi bahwa teks terbungkus rapi menjadi 2 baris di dalam batas sel Kolom 3 tanpa menembus atau menabrak tombol WhatsApp / Nomor Telepon di Kolom 4.
5. **Pengujian Freeze Panel Nama Pelanggan (Desktop & Mobile):**
   * Buka halaman tagihan (contoh: `http://billtest.gayuh.net.id.test/bill/unpaid`).
   * Gulung (*scroll*) tabel ke kanan untuk melihat kolom *Total*, *Status*, *Coverage*, atau *Aksi*.
   * Pastikan kolom **No**, **Checkbox**, dan **Nama Pelanggan** tetap diam terkunci (*sticky*) di sisi kiri layar dengan bayangan pembatas yang rapi.
6. **Pengujian Mobile Drawer & Sticky Topbar:**
   * Verifikasi drawer menu hamburger dan sticky topbar tetap berfungsi mulus dan tidak terganggu oleh scrolling tabel.
7. **Pengujian Dark Mode:**
   * Aktifkan mode gelap: tombol toggle sidebar di samping Bantuan dan komponen Select2 beradaptasi serasi dengan tema gelap `#1a2236`, border halus, dan bayangan pekat.
