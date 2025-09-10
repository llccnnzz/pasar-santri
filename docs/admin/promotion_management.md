# Dokumentasi Manajemen Promosi Admin

## Deskripsi Umum

Sistem Manajemen Promosi memungkinkan administrator **Pasar Santri Marketplace** untuk membuat, mengelola, dan memantau kode promosi yang dapat digunakan pembeli untuk mendapatkan diskon pada pesanan mereka. Sistem ini mendukung berbagai jenis promosi dengan validasi otomatis dan pelacakan penggunaan.

---

## Fitur Utama

### 1. **Manajemen Kode Promosi**
- Pembuatan kode promosi unik
- Pengaturan diskon tetap (fixed discount)
- Validasi keunikan kode promosi
- Kontrol status aktif/non-aktif

### 2. **Kontrol Periode Promosi**
- Pengaturan tanggal mulai dan berakhir
- Validasi periode promosi
- Status otomatis berdasarkan waktu
- Penjadwalan promosi masa depan

### 3. **Pembatasan Penggunaan**
- Batas minimum order
- Batas maksimal penggunaan
- Pelacakan jumlah penggunaan
- Kontrol ketersediaan promosi

### 4. **Monitoring dan Statistik**
- Statistik promosi aktif, expired, dan scheduled
- Pelacakan penggunaan real-time
- Filter berdasarkan status promosi
- Pencarian berdasarkan kode, nama, atau deskripsi

---

## Struktur Data Promosi

### Field Utama:
- **Kode Promosi**: Kode unik (otomatis uppercase)
- **Nama Promosi**: Nama deskriptif promosi
- **Deskripsi**: Penjelasan detail promosi (opsional)
- **Nilai Diskon**: Jumlah diskon dalam Rupiah (minimum Rp 1.000)
- **Minimum Order**: Batas minimum total pesanan
- **Batas Penggunaan**: Maksimal berapa kali promosi bisa digunakan
- **Tanggal Mulai**: Kapan promosi mulai berlaku
- **Tanggal Berakhir**: Kapan promosi berakhir
- **Status Aktif**: Apakah promosi aktif atau tidak

---

## Panduan Penggunaan

### 1. Mengakses Halaman Promosi

1. Login ke panel admin
2. Navigasi ke menu **"Promosi"** atau **"Promo Codes"**
3. Sistem akan menampilkan dashboard promosi dengan statistik:
   - **Total Promosi**: Jumlah keseluruhan promosi
   - **Aktif**: Promosi yang sedang berjalan
   - **Kedaluwarsa**: Promosi yang sudah berakhir
   - **Terjadwal**: Promosi yang akan dimulai

### 2. Membuat Promosi Baru

#### Langkah-langkah:
1. Klik tombol **"Tambah Promosi Baru"**
2. Isi formulir dengan data berikut:

**Data Wajib:**
- **Kode Promosi**: 
  - Maksimal 50 karakter
  - Harus unik (belum pernah digunakan)
  - Akan otomatis diubah ke huruf besar
  
- **Nama Promosi**:
  - Maksimal 255 karakter
  - Nama yang mudah diingat dan deskriptif
  
- **Nilai Diskon**:
  - Minimum Rp 1.000
  - Hanya dalam bentuk nominal tetap (bukan persentase)
  
- **Tanggal Mulai**:
  - Tidak boleh di masa lalu
  - Format: YYYY-MM-DD HH:MM
  
- **Tanggal Berakhir**:
  - Harus setelah tanggal mulai
  - Format: YYYY-MM-DD HH:MM

**Data Opsional:**
- **Deskripsi**: Penjelasan detail promosi (maksimal 1.000 karakter)
- **Minimum Order**: Batas minimum total pesanan (default: Rp 0)
- **Batas Penggunaan**: Maksimal berapa kali bisa digunakan (kosong = unlimited)
- **Status Aktif**: Centang untuk mengaktifkan promosi

3. Klik **"Simpan"** untuk membuat promosi

#### Validasi Sistem:
- Kode promosi harus unik
- Tanggal berakhir harus setelah tanggal mulai
- Tanggal mulai tidak boleh di masa lalu
- Nilai diskon minimal Rp 1.000

### 3. Mengedit Promosi

1. Di halaman daftar promosi, klik tombol **"Edit"** pada promosi yang diinginkan
2. Ubah data sesuai kebutuhan
3. Perhatikan validasi yang sama seperti saat membuat promosi baru
4. Klik **"Update"** untuk menyimpan perubahan

**Catatan**: Promosi yang sudah digunakan sebaiknya tidak diubah nilai diskon atau syaratnya untuk menjaga konsistensi.

### 4. Menghapus Promosi

1. Di halaman daftar promosi, klik tombol **"Hapus"** 
2. Konfirmasi penghapusan
3. Promosi akan dihapus permanen dari sistem

**Peringatan**: Hati-hati saat menghapus promosi yang sedang aktif atau sudah digunakan, karena dapat mempengaruhi pesanan yang sedang berjalan.

### 5. Melihat Detail Promosi

1. Klik nama promosi atau tombol **"Detail"**
2. Sistem akan menampilkan informasi lengkap:
   - Data promosi
   - Status terkini
   - Statistik penggunaan
   - Log aktivitas (jika ada)

### 6. Filter dan Pencarian

#### Filter berdasarkan Status:
- **Semua**: Menampilkan semua promosi
- **Aktif**: Promosi yang sedang berjalan dan dapat digunakan
- **Tidak Aktif**: Promosi yang dinonaktifkan manual
- **Kedaluwarsa**: Promosi yang sudah melewati tanggal berakhir
- **Terjadwal**: Promosi yang belum dimulai

#### Pencarian:
- Ketik di kolom pencarian untuk mencari berdasarkan:
  - Kode promosi
  - Nama promosi
  - Deskripsi promosi

---

## Status Promosi

### 1. **Active (Aktif)**
- Promosi sedang berjalan
- Dapat digunakan oleh pembeli
- Masih dalam periode yang ditentukan
- Belum mencapai batas penggunaan

### 2. **Inactive (Tidak Aktif)**
- Promosi dinonaktifkan secara manual
- Tidak dapat digunakan meskipun masih dalam periode

### 3. **Scheduled (Terjadwal)**
- Promosi sudah dibuat tapi belum dimulai
- Akan otomatis aktif saat mencapai tanggal mulai

### 4. **Expired (Kedaluwarsa)**
- Promosi sudah melewati tanggal berakhir
- Tidak dapat digunakan lagi

### 5. **Limit Reached (Batas Tercapai)**
- Promosi sudah mencapai batas maksimal penggunaan
- Status otomatis berubah meskipun masih dalam periode

---

## Sistem Validasi Promosi

### Validasi untuk Pembeli:
1. **Status Promosi**: Harus aktif
2. **Periode Waktu**: Tanggal saat ini harus dalam rentang tanggal mulai dan berakhir
3. **Minimum Order**: Total pesanan harus memenuhi minimum order
4. **Batas Penggunaan**: Belum mencapai batas maksimal (jika ditetapkan)

### Perhitungan Diskon:
- Sistem hanya mendukung diskon nominal tetap
- Nilai diskon langsung dipotong dari total pesanan
- Tidak ada perhitungan persentase

### Contoh Penggunaan:
```
Kode Promosi: DISKON50K
Nilai Diskon: Rp 50.000
Minimum Order: Rp 200.000
Batas Penggunaan: 100 kali

Skenario:
- Total pesanan: Rp 250.000 ✓ (memenuhi minimum)
- Sudah digunakan: 85 kali ✓ (belum mencapai batas)
- Tanggal: Dalam periode ✓
- Status: Aktif ✓

Hasil: Pembeli mendapat diskon Rp 50.000
Total bayar: Rp 200.000
```

---

## Tips dan Best Practices

### 1. **Penamaan Promosi**
- Gunakan kode yang mudah diingat (contoh: RAMADAN2024, DISKON100K)
- Hindari karakter khusus yang membingungkan
- Pertimbangkan periode berlaku dalam nama kode

### 2. **Pengaturan Periode**
- Tentukan periode yang realistis
- Hindari overlap promosi dengan syarat serupa
- Pertimbangkan zona waktu Indonesia (WIB)

### 3. **Nilai Diskon**
- Sesuaikan dengan margin produk
- Pertimbangkan minimum order yang wajar
- Monitor dampak terhadap profitabilitas

### 4. **Monitoring Penggunaan**
- Pantau statistik penggunaan secara berkala
- Evaluasi efektivitas promosi
- Siapkan promosi pengganti jika diperlukan

### 5. **Komunikasi dengan Tim**
- Koordinasikan dengan tim marketing untuk promosi
- Informasikan ke customer service tentang promosi aktif
- Pastikan tim teknis siap jika ada masalah

---

## Troubleshooting

### Problem: "Kode promosi sudah ada"
**Solusi**: 
- Gunakan kode yang berbeda
- Periksa apakah kode pernah digunakan sebelumnya
- Tambahkan suffix seperti angka atau tanggal

### Problem: "Tanggal mulai tidak valid"
**Solusi**:
- Pastikan tanggal mulai tidak di masa lalu
- Periksa format tanggal (YYYY-MM-DD HH:MM)
- Sesuaikan dengan zona waktu server

### Problem: "Promosi tidak muncul untuk pembeli"
**Solusi**:
- Periksa status promosi (harus aktif)
- Pastikan masih dalam periode berlaku
- Cek apakah belum mencapai batas penggunaan
- Verifikasi minimum order sudah terpenuhi

### Problem: "Error saat menghapus promosi"
**Solusi**:
- Periksa apakah promosi sedang digunakan dalam transaksi aktif
- Coba nonaktifkan dulu sebelum menghapus
- Hubungi tim teknis jika masalah berlanjut

### Problem: "Diskon tidak terpotong dengan benar"
**Solusi**:
- Pastikan nilai diskon sesuai dengan yang diatur
- Periksa apakah minimum order sudah terpenuhi
- Verifikasi perhitungan total pesanan
- Cek log sistem untuk detail error

---

## Integrasi dengan Sistem Lain

### 1. **Sistem Pesanan**
- Promosi otomatis diterapkan saat checkout
- Validasi real-time saat pembeli memasukkan kode
- Update otomatis jumlah penggunaan setelah pembayaran sukses

### 2. **Sistem Notifikasi**
- Notifikasi otomatis saat promosi hampir berakhir
- Alert saat mencapai 80% batas penggunaan
- Reminder untuk perpanjangan promosi populer

### 3. **Sistem Laporan**
- Data promosi masuk ke laporan penjualan
- Analisis efektivitas promosi
- ROI tracking untuk setiap promosi

---

## Informasi Teknis

### Database Schema:
```sql
Table: promotions
- id: Primary Key
- code: VARCHAR(50) UNIQUE
- name: VARCHAR(255)
- description: TEXT
- discount_type: ENUM('fixed')
- discount_value: DECIMAL(12,0) -- IDR format
- minimum_order_amount: DECIMAL(12,0)
- usage_limit: INTEGER
- used_count: INTEGER
- starts_at: DATETIME
- expires_at: DATETIME
- is_active: BOOLEAN
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

### API Endpoints:
- `GET /admin/promos` - Daftar promosi
- `POST /admin/promos` - Buat promosi baru
- `GET /admin/promos/{id}` - Detail promosi
- `PUT /admin/promos/{id}` - Update promosi
- `DELETE /admin/promos/{id}` - Hapus promosi

---

## Dukungan dan Bantuan

Untuk bantuan lebih lanjut terkait sistem promosi:

**Email Support**: support@pasarsantri.com  
**WhatsApp**: +62 812-3456-7890  
**Website**: www.pasarsantri.com  
**Developer**: PT. Sidogiri Fintech Utama

**Jam Operasional Support**:  
Senin - Jumat: 08:00 - 17:00 WIB  
Sabtu: 08:00 - 12:00 WIB

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: Januari 2025*
