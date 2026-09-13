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

## 📂 Berkas yang Diperbarui

| No | Berkas | Deskripsi Perubahan |
|:---|:---|:---|
| 1 | `assets/backend/css/neumorphism.css` | Penambahan Bagian 11 (*Frozen / Sticky Customer Name Panel*), Bagian 6.1 (*Sidebar Minimized State Desktop*), perbaikan pembungkusan teks nama pelanggan (`white-space: normal`, `word-break: break-word`, lebar 220px), perbaikan simetri dan emblem melingkar logo wifi brand, perbaikan stacking drawer mobile, tombol close drawer, styling backdrop blur, perbaikan z-index Select2, dan transisi smooth. |
| 2 | `assets/backend/js/sb-admin-2.js` | Logika kontrol mobile drawer (`toggleMobileSidebar`), event listener penutupan (backdrop, close btn, escape, link click), dynamic scroll listener untuk sticky topbar, auto-close Select2, dan inisialisasi hover tooltip (`initSidebarTooltips`). |
| 3 | `application/views/backend.php` | Penyesuaian layout utama, penyisipan elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, perbaikan CSS responsif drawer & minimized brand header, penggantian `overflow-x` menjadi `clip`, dan pembersihan skrip toggle saat *document ready*. |
| 4 | `application/views/backend/bill/unpaid.php` | Penambahan kelas `table-sticky-customer` pada tabel `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox saat digulir ke kanan/kiri. |
| 5 | `application/views/backend/bill/paid.php` | Penambahan kelas `table-sticky-customer` pada tabel `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox. |
| 6 | `application/views/backend/bill/bill.php` | Penambahan kelas `table-sticky-customer` pada tabel `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox. |
| 7 | `application/views/backend/bill/get-data-bill.php` | Penambahan kelas `table-sticky-customer` pada tabel server-side `#example` untuk pembekuan panel nama pelanggan, nomor, dan checkbox. |
| 8 | `application/views/mikrotik.php` | Penambahan link stylesheet `neumorphism.css`, elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, kelas `sticky-top`, paritas layout brand `justify-content-md-center`, dan skrip inisialisasi reset mobile drawer. |
| 9 | `application/views/olt.php` | Penambahan link stylesheet `neumorphism.css`, elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, kelas `sticky-top`, paritas layout brand `justify-content-md-center`, dan skrip inisialisasi reset mobile drawer. |

---

## 🔍 Panduan Verifikasi & Pengujian

1. **Pengujian Batas & Pembungkusan Teks Nama Pelanggan:**
   * Buka halaman tagihan (contoh: `http://billtest.gayuh.net.id.test/bill/paid` atau `/bill/unpaid`).
   * Cari baris dengan nama pelanggan panjang (contoh: baris ke-5 `YOGA FACHRUDIN PERDANA-(Q14B)`).
   * Verifikasi bahwa teks terbungkus rapi menjadi 2 baris di dalam batas sel Kolom 3 tanpa menembus atau menabrak tombol WhatsApp / Nomor Telepon di Kolom 4.
2. **Pengujian Freeze Panel Nama Pelanggan (Desktop):**
   * Buka halaman tagihan (contoh: `http://billtest.gayuh.net.id.test/bill/unpaid`).
   * Gulung (*scroll*) tabel ke kanan untuk melihat kolom *Total*, *Status*, *Coverage*, atau *Aksi*.
   * Pastikan kolom **No**, **Checkbox**, dan **Nama Pelanggan** tetap diam terkunci (*sticky*) di sisi kiri layar dengan bayangan pembatas yang rapi.
   * Coba centang salah satu checkbox saat tabel sedang digulung ke kanan: checkbox tetap berfungsi normal dan baris tetap dapat dipilih untuk aksi massal.
3. **Pengujian Freeze Panel Nama Pelanggan (Mobile):**
   * Buka browser ponsel atau aktifkan *Device Toolbar* (`Ctrl + Shift + M`) dengan resolusi ponsel (misal: 375px atau 412px).
   * Masuk ke halaman `bill/unpaid` atau `bill/paid` dan gulung tabel ke kanan.
   * Pastikan nama pelanggan tetap terbaca jelas di kiri layar bersama nomor dan checkbox, terbungkus rapi tanpa menembus kolom telepon.
4. **Pengujian Mobile Drawer & Sticky Topbar:**
   * Verifikasi drawer menu hamburger dan sticky topbar tetap berfungsi mulus dan tidak terganggu oleh scrolling tabel.
5. **Pengujian Dark Mode:**
   * Aktifkan dark mode: panel nama pelanggan yang dibekukan beradaptasi otomatis dengan latar `#111625` dan bayangan pekat, bebas dari teks bocor (*bleed through*).
