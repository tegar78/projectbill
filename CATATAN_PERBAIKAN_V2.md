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

## 📂 Berkas yang Diperbarui

| No | Berkas | Deskripsi Perubahan |
|:---|:---|:---|
| 1 | `assets/backend/css/neumorphism.css` | Penambahan Bagian 6.1 (*Sidebar Minimized State Desktop*), perbaikan stacking drawer mobile, tombol close drawer, styling backdrop blur, perbaikan z-index Select2, dan transisi smooth. |
| 2 | `assets/backend/js/sb-admin-2.js` | Logika kontrol mobile drawer (`toggleMobileSidebar`), event listener penutupan (backdrop, close btn, escape, link click), dynamic scroll listener untuk sticky topbar, auto-close Select2, dan inisialisasi hover tooltip (`initSidebarTooltips`). |
| 3 | `application/views/backend.php` | Penyesuaian layout utama, penyisipan elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, perbaikan CSS responsif drawer, penggantian `overflow-x` menjadi `clip`, dan pembersihan skrip toggle saat *document ready*. |
| 4 | `application/views/mikrotik.php` | Penambahan link stylesheet `neumorphism.css`, elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, kelas `sticky-top`, dan skrip inisialisasi reset mobile drawer. |
| 5 | `application/views/olt.php` | Penambahan link stylesheet `neumorphism.css`, elemen `#sidebarBackdrop`, tombol `#sidebarCloseBtn`, kelas `sticky-top`, dan skrip inisialisasi reset mobile drawer. |

---

## 🔍 Panduan Verifikasi & Pengujian

1. **Pengujian Tampilan Mobile Drawer:**
   * Buka aplikasi pada browser ponsel atau aktifkan *Device Toolbar* (`Ctrl + Shift + M`) dengan lebar layar ponsel (misal: 375px atau 412px).
   * Verifikasi bahwa konten halaman mengambil lebar penuh 100%.
   * Ketuk tombol hamburger (`☰`) di topbar: drawer sidebar meluncur mulus dari kiri dengan backdrop gelap kabur di belakangnya.
   * Uji penutupan drawer dengan mengetuk tombol silang (**×**), mengetuk area latar kabur (*backdrop*), atau memilih salah satu menu.
2. **Pengujian Sticky Topbar:**
   * Pada halaman formulir panjang (seperti Tambah Pelanggan), gulung (*scroll*) halaman ke bawah.
   * Pastikan topbar tetap menempel kokoh di posisi atas (*fixed/sticky*), bayangannya bertambah tegas, dan konten formulir meluncur rapi di bawahnya tanpa teks yang bocor di atas topbar.
   * Tombol hamburger dan toggle tema tetap dapat diakses setiap saat.
3. **Pengujian Minimized Sidebar (Desktop):**
   * Pada layar desktop penuh, klik tombol toggle panah bundar di kiri bawah sidebar (`#sidebarToggle`).
   * Pastikan lebar sidebar mengecil menjadi ramping (~104px).
   * Verifikasi bahwa ikon menu berada di tengah di atas, teks menu di bawahnya rapi satu baris dengan elipsis, dan tidak ada panah chevron yang menabrak teks.
   * Arahkan kursor (*hover*) ke salah satu menu untuk melihat tooltip nama menu lengkap.
   * Klik menu yang memiliki submenu (seperti *Pelanggan* atau *Keuangan*) dan pastikan popover submenu melayang rapi di kanan sidebar tanpa tertutup kartu dashboard.
4. **Pengujian Dark Mode:**
   * Alihkan tema menggunakan tombol bulan/matahari di topbar.
   * Pastikan seluruh komponen (drawer mobile, topbar sticky, sidebar minimized, dan popover submenu) beradaptasi sempurna dengan palet warna gelap (`#161c2e` dan `#1a2236`) tanpa ada elemen yang kontras berlebih atau pecah.
