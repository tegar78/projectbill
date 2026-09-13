# Catatan Perbaikan - 31 Agustus 2026

## Bug: Error DataTables Ajax Saat Show 500 dan 1000 Entries di Halaman Pelanggan

### Deskripsi Masalah
Muncul peringatan error `DataTables warning: table id=example - Ajax error` saat memilih "Show 500/1000 entries" pada halaman Data Pelanggan Aktif (maupun filter coverage area).

### Akar Masalah
Terdapat 2 akar permasalahan utama yang saling berkaitan:
1. **N+1 Query Problem** — Setiap baris data pelanggan di dalam loop memanggil query individual secara berulang untuk:
   - Mencari subtotal pada tabel `services`
   - Mengecek akses pada tabel `user`
   - Mengecek status `router`
   - Mengecek data `company`
   
   Hal ini mengakibatkan ribuan eksekusi query *(timeout)* untuk 1000 baris pelanggan, sehingga respons ke DataTables terputus.

2. **JSON Format Error akibat PHP Warning** — Terdapat *PHP Deprecated Warning* dan *Undefined Variable* yang terpicu dari fungsi `indo_tlp()` jika ada pelanggan yang data `no_wa`-nya bernilai kosong (`NULL`) atau mengandung karakter yang tidak dikenal (misal tanda `-`). PHP menyisipkan teks warning ini di awal struktur JSON sehingga format JSON tersebut rusak dan tidak dapat dibaca oleh DataTables.

---

### File yang Diubah

#### 1. `application/controllers/Customer.php`
- **Method yang diubah**: `getActiveCustomer()`, `getfiltercoverage()`, `getNonActiveCustomer()`, `getCustomerfree()`, `getCustomerisolir()`, `getWaitCustomer()`.
- **Detail Optimasi**:
  - Semua query `services`, `user`, `router`, dan `company` dipindahkan ke luar *loop*.
  - Menggunakan teknik *batch query* dengan `where_in()` dan `array_chunk()` untuk mengambil seluruh data terkait sekaligus di awal eksekusi, yang kemudian disalurkan ke masing-masing baris.
  - Memperbarui parameter output menjadi `json_encode($output, JSON_INVALID_UTF8_SUBSTITUTE)` untuk mencegah malformasi JSON akibat karakter tidak valid dari database.

#### 2. `application/models/Customer_m.php`
- **Method yang diubah**: Seluruh fungsi perhitungan data (seperti `count_filtered_data()`, `count_filtered_data_active()`, `count_all_data()`, dll).
- **Detail Optimasi**:
  - Mengubah `$this->db->get()->num_rows()` menjadi `$this->db->count_all_results()`.
  - Proses perhitungan total baris (untuk sistem *pagination* DataTables) kini menjadi jauh lebih cepat dan ringan karena dihitung langsung dari internal database `SELECT COUNT(*)`, tanpa harus menarik ribuan baris data ke dalam memori RAM PHP.

#### 3. `application/helpers/mywifi_helper.php`
- **Method yang diubah**: `indo_tlp()`
- **Detail Optimasi**:
  - Memperbaiki deklarasi data *company* dengan metode *static cache* (`static $company = null;`) sehingga query ke tabel *company* hanya dieksekusi 1 kali saja per request, alih-alih 1000 kali.
  - Memperkuat pertahanan fungsi dari nilai `NULL` dan membersihkan karakter hubung (`-`) pada variabel masukan.
  - Menambahkan baris fungsi `return` wajib sebagai perisai dari *error Undefined variable* ketika verifikasi format Regex (*Regular Expression*) gagal, sehingga *output* JSON tidak akan bocor/terkontaminasi teks warning dari PHP.
