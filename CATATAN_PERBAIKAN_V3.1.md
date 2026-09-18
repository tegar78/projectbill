# Catatan Perbaikan & Update V3.1: Keamanan, Pembersihan API Keys, Eliminasi Backdoor Data Leakage, & Refinement UI/UX Maps

**Tanggal:** 18 September 2026  
**Aplikasi:** Sistem Billing & Manajemen Jaringan (PT. GAYUH MEDIA INFORMATIKA)  
**Versi:** 3.1 (Security Hardening, Bug Fixing, & UI/UX Refinement)  
**Fokus Pembaruan:** Audit & Pembersihan API Keys Hardcoded, Eliminasi Rutinitas Backdoor Kebocoran Database Telegram Pihak Ketiga, Refactor Parameterized Query Builder untuk Mencegah SQL Injection, Sanitasi Riwayat Git (Git History Rewrite), Perbaikan Bug Sintaks PHP, Penanganan Anotasi IDE, serta Eliminasi Emoji Clutter pada Toolbar Maps Pelanggan.

---

## 📋 Ringkasan Eksekutif Pembaruan V3.1

Pembaruan Versi 3.1 (V3.1) merupakan rilis penguatan keamanan menyeluruh (*security hardening*), perbaikan keandalan kode (*code stability*), dan penyempurnaan visual (*UI/UX decluttering*):

1. **Pembersihan Kredensial & API Keys yang Terekspos ke Publik**:
   - Menghapus API key gateway pihak ketiga (Rapiwha & Autonotif) yang sebelumnya tertulis secara mentah (*hardcoded*) di dalam file views.
   - Mengosongkan kredensial default REST Server (`admin => 1234`) pada konfigurasi bawaan.

2. **Eliminasi Celah Kebocoran Data (Backdoor Data Leakage) ke Bot Telegram Pihak Ketiga**:
   - **Temuan Kritis:** Ditemukan rutinitas pencadangan tersembunyi berlabel `// SEND KE OFFICIAL MY-WIFI` pada controller `Customer.php`, `Bill.php`, `Front.php`, `Customer(unfix).php`, dan `Bill(unfix).php`.
   - Kode tersebut secara otomatis mengekstrak berkas arsip database utuh (`.zip` berisi dump database `.sql`) dan mengirimkannya ke bot Telegram pihak ketiga (`1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4`) di chat ID `-581904381` setiap kali data pelanggan atau tagihan dihapus.
   - **Solusi:** Seluruh blok pengiriman backup ke pihak luar tersebut telah dihapus secara total. Pengiriman backup kini hanya diarahkan ke bot Telegram resmi milik perusahaan yang dikonfigurasi pada tabel `bot_telegram`.

3. **Pencegahan Celah SQL Injection pada Callback Pemeriksaan Duplikasi Data**:
   - Mengubah seluruh pemanggilan query raw SQL di controller `Customer.php`, `Coverage.php`, `Odc.php`, dan `Odp.php` menjadi parameterized Query Builder CodeIgniter (`$this->db->get_where()`) dengan pengamanan pengecekan `isset()`.

4. **Penulisan Ulang Riwayat Git (Git History Rewrite) via git-filter-repo**:
   - Melakukan sanitasi menyeluruh terhadap riwayat commit git masa lalu untuk menghapus password live database produksi (`Gayuh@2021!`), host IP server (`103.151.35.19`), token Telegram backdoor, dan seluruh API key lainnya.
   - Seluruh nilai sensitif digantikan secara permanen dengan placeholder `REDACTED`.
   - Backup repositori lokal utuh sebelum sanitasi telah disimpan dengan aman di `c:\PROJECT-TEGAR\projectbill-pre-filter-backup`.

5. **Penguatan Enkripsi Konfigurasi Framework**:
   - Menghasilkan dan menyetel string token acak 32 karakter kriptografis (`cadc10629a06aec87aace16fe8928a0b`) pada `$config['encryption_key']` di `config.php`.

6. **Pembersihan File Backup Lokal**:
   - Menghapus berkas cadangan `.bak` (`config.php.bak`, `Maps.php.bak`, `maps.php.bak`) dari direktori aplikasi guna mencegah risiko unduhan berkas konfigurasi oleh pihak yang tidak berhak.

7. **Perbaikan Bug Sintaks PHP & Anotasi Masalah IDE**:
   - Memperbaiki bug sintaksis karakter backslash tersasar (`\`) pada controller [Modem.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Modem.php#L13).
   - Menambahkan deklarasi tipe PHPDoc `/** @var array $bot */` dan fallback null-safe pada [bot-telegram.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/setting/bot-telegram.php) untuk mengatasi peringatan IDE *Undefined variable '$bot'*.
   - Menambahkan metadata parameter `@param int|string` pada method `edit()` dan `doc()` di [Odp.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Odp.php).

8. **Refinement Antarmuka Maps Pelanggan (UI/UX Decluttering)**:
   - Menghapus bulatan-bulatan warna status (`.chip-dot`) yang sebelumnya menyerupai deretan emoji lingkaran warna-warni pada toolbar peta dan tabel bawah di `/maps` dan `/customer/maps`.
   - Merestrukturisasi badge counter header menjadi metrik eksekutif bersih (`Ditandai: 757` dan `Belum Ditandai: 299`).
   - Memperbaiki glitch karakter fallback huruf `'A'` pada tombol Coverage dengan mengganti class icon menjadi `fa-wifi`.

---

## 🛠️ Rincian Modul Perbaikan Teknis

### 1. Audit Keamanan & Pembersihan Kredensial Hardcoded
* **Lokasi Berkas:**
  - [application/views/backend/setting/wa-gateway.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/setting/wa-gateway.php)
  - [application/views/backend/whatsapp/sendblast.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/whatsapp/sendblast.php)
  - [application/views/backend/setting/bot-telegram.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/setting/bot-telegram.php)
  - [application/config/rest.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/config/rest.php)
* **Tindakan Perbaikan:**
  - `wa-gateway.php`: Token statis `$my_apikey = "MH1KQQHJXVTSBQ73NN8X";` diganti dengan pembacaan dinamis `$sms['sms_token']` dari tabel `sms_gateway`, serta ditambahkan proteksi pengecekan jika token belum dikonfigurasi.
  - `sendblast.php`: Kredensial `$APIkey = 'e4cb363657beb3fea241d21517a001bf';`, `$username = 'btranscb';`, dan nomor ponsel target diubah menjadi variabel dinamis konfigurasi.
  - `bot-telegram.php`: Token bot Telegram aktif yang tertinggal di baris komentar HTML (baris 51) dihapus dan diganti dengan URL placeholder dokumentasi generik.
  - `rest.php`: Konfigurasi `$config['rest_valid_logins'] = ['admin' => '1234'];` dikosongkan menjadi `[]`.

---

### 2. Eliminasi Rutinitas Backdoor Kebocoran Arsip Database
* **Lokasi Berkas:**
  - [application/controllers/Customer.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Customer.php) (baris 1008)
  - [application/controllers/Bill.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Bill.php) (baris 2800)
  - [application/controllers/Front.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Front.php) (baris 542, 659, 708)
  - [application/controllers/Customer(unfix).php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Customer(unfix).php)
  - [application/controllers/Bill(unfix).php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Bill(unfix).php)
* **Masalah:**
  - Terdapat skrip rahasia yang mengeksekusi `$this->dbutil->backup()` lalu mengunggah file `.zip` database ke channel Telegram luar via cURL POST multipart saat event penghapusan pelanggan atau tagihan dipicu.
* **Tindakan Perbaikan:**
  - Seluruh blok `// SEND KE OFFICIAL MY-WIFI` dihapus dari kode.
  - Method `Front::backupadmin()` disesuaikan agar hanya mengirimkan arsip backup ke bot Telegram yang dikonfigurasi sendiri oleh admin jika kredensial bot tersedia.

---

### 3. Pencegahan Celah SQL Injection pada Pengecekan Duplikasi
* **Lokasi Berkas:**
  - [application/controllers/Customer.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Customer.php)
  - [application/controllers/Coverage.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Coverage.php)
  - [application/controllers/Odc.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Odc.php)
  - [application/controllers/Odp.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Odp.php)
* **Perubahan Kode:**
  - *Sebelumnya (Raw SQL Rentan Injeksi):*
    ```php
    $query = $this->db->query("SELECT * FROM customer WHERE email = '$post[email]' AND customer_id != '$post[customer_id]'");
    ```
  - *Sesudahnya (Parameterized Query Builder Aman):*
    ```php
    $customerId = isset($post['customer_id']) ? $post['customer_id'] : 0;
    $email = isset($post['email']) ? $post['email'] : '';
    $query = $this->db->get_where('customer', [
        'email' => $email,
        'customer_id !=' => $customerId
    ]);
    ```
  - Pola pengamanan yang sama diterapkan pada method `no_wa_check()`, `no_services_check()`, `no_ktp_check()`, `codearea_check()`, `codeodc_check()`, dan `codeodp_check()`.

---

### 4. Perbaikan Sintaksis & Penanganan Masalah IDE
* **Lokasi Berkas:**
  - [application/controllers/Modem.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Modem.php)
  - [application/views/backend/setting/bot-telegram.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/setting/bot-telegram.php)
  - [application/controllers/Odp.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/controllers/Odp.php)
* **Perbaikan:**
  - Menghapus baris 13 di `Modem.php` yang berisi karakter `\` tersasar sehingga controller dapat dikompilasi bersih oleh PHP parser.
  - Menambahkan header type hinting pada `bot-telegram.php`:
    ```php
    <?php
    /** @var array $bot */
    $bot = isset($bot) && is_array($bot) ? $bot : [];
    $this->view('messages');
    ?>
    ```
  - Menambahkan PHPDoc `@param int|string` pada `Odp::edit($id)` dan `Odp::doc($id_odp)`.

---

### 5. Penulisan Ulang Riwayat Git (Git History Sanitization)
* **Alat yang Digunakan:** `git-filter-repo` (Python 3.14).
* **Entitas yang Disanitasi:**
  - Password database live: `Gayuh@2021!` diganti menjadi `REDACTED_DATABASE_PASSWORD`.
  - Host server: `103.151.35.19` diganti menjadi `127.0.0.1`.
  - Token bot Telegram: `1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4` diganti menjadi `REDACTED_TELEGRAM_BOT_TOKEN`.
  - Target Chat ID: `-581904381` diganti menjadi `REDACTED_CHAT_ID`.
  - API Keys: Token Rapiwha dan Autonotif diganti menjadi `REDACTED_RAPIWHA_KEY` dan `REDACTED_AUTONOTIF_KEY`.
* **Verifikasi:**
  - `git log -S "Gayuh@2021!"` menghasilkan 0 temuan.
  - `git log -S "1577575670:AAF20lnVQsYawwmgXu-BXYZhq8FLZMtYVo4"` menghasilkan 0 temuan.
  - Seluruh tree objek commit telah di-repack bersih.

---

### 6. Refinement UI/UX Maps Pelanggan
* **Lokasi Berkas:** [application/views/backend/maps/maps.php](file:///c:/PROJECT-TEGAR/billingtest.gayuh.net.id/application/views/backend/maps/maps.php)
* **Perubahan Visual:**
  - Menghapus bulatan `.chip-dot` pada filter status chips (Semua, Aktif, Isolir, Non-Aktif, Menunggu, Free) baik di toolbar atas maupun toolbar tabel bawah.
  - Mengganti icon pin dan seru kuning pada header dengan badge format counter eksekutif (`Ditandai: 757` dan `Belum Ditandai: 299`).
  - Mengganti class `fa-broadcast-tower` yang rusak menjadi `fa-wifi` pada tombol navigasi Coverage.
  - Memberikan styling Neumorphic active state yang bersih pada setiap tab status chip untuk Light Mode dan Dark Mode.

---

## 📊 Matriks Status Verifikasi Akhir

| Komponen Pengujian | Metode Verifikasi | Hasil | Status |
| :--- | :--- | :--- | :---: |
| **Sintaks Seluruh File Aplikasi** | `php -l` via PowerShell CLI pada semua file PHP | 0 syntax errors detected | **PASS** |
| **Pembersihan API Keys Hardcoded** | `git grep` pada seluruh direktori `application/` | 0 secret token ditemukan | **PASS** |
| **Sanitasi Riwayat Git Commit** | `git log -S` pencarian string sensitif | 0 temuan di seluruh riwayat commit | **PASS** |
| **Pemeriksaan Kerentanan SQL Injection** | Code review callback validasi duplikasi | Parameterized Query Builder aktif | **PASS** |
| **Penyelesaian Masalah Diagnostik IDE** | Pemeriksaan Language Server IDE | 0 undefined variables & error info teratasi | **PASS** |
| **Kompilasi & Render View Maps** | Browser DOM & CSS audit | Bebas glitch karakter 'A' & bebas dot emoji | **PASS** |

---

## 🚀 Panduan Sinkronisasi ke Remote GitHub

Untuk memperbarui riwayat commit bersih ke remote repository GitHub:

```powershell
git push origin dev --force
```
