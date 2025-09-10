# Manajemen Pesanan Toko - Pasar Santri

## Deskripsi
Manajemen Pesanan adalah sistem lengkap yang memungkinkan penjual untuk mengelola seluruh siklus pesanan dari pembeli di **Pasar Santri Marketplace**. Sistem ini mencakup pemantauan status pesanan, pemrosesan pengiriman, integrasi dengan Biteship, dan pengelolaan riwayat transaksi.

## Tujuan
- Mengelola seluruh siklus hidup pesanan dari konfirmasi hingga selesai
- Memproses pengiriman dengan integrasi kurir otomatis
- Memantau status pembayaran dan pengiriman secara real-time
- Memberikan layanan terbaik kepada pembeli
- Mengoptimalkan operasional bisnis dengan tracking lengkap

## Akses & Persyaratan
**Role Required:** Seller dengan toko aktif dan terverifikasi  
**Permission:** Akses penuh ke manajemen pesanan toko  
**URL:** `/seller/orders`

---

## Persyaratan Akses Manajemen Pesanan

### 1. **KYC Disetujui & Toko Aktif**
- Status KYC harus **"Disetujui"**
- Toko sudah dibuat dan berstatus aktif
- Role penjual sudah otomatis diberikan
- Informasi toko lengkap untuk pengiriman

### 2. **Integrasi Sistem Siap**
- Metode pengiriman sudah dikonfigurasi
- Integrasi Biteship API aktif untuk tracking
- Alamat toko valid untuk pickup location
- Metode pembayaran telah disetup

### 3. **Status Toko Operasional**
- Toko tidak dalam status ditangguhkan
- Dapat memproses dan mengubah status pesanan
- Akses penuh ke semua fitur pengelolaan

---

## Siklus Status Pesanan

### 1. **Alur Status Pesanan**
```
Siklus Pesanan Normal:
┌─ Pending → Paid → Confirmed → Processing → Shipped → Delivered → Finished
│
├─ Pembatalan dapat dilakukan di:
│  ├─ Paid → Cancelled
│  ├─ Confirmed → Cancelled  
│  ├─ Processing → Cancelled
│  └─ Shipped → Cancelled (dalam kondisi tertentu)
│
└─ Refund dapat dilakukan dari:
   └─ Delivered/Finished → Refunded
```

### 2. **Penjelasan Status Pesanan**

#### A. **Status Awal (Customer Action)**
- **Pending**: Pesanan dibuat, menunggu pembayaran
- **Paid**: Pembayaran berhasil, menunggu konfirmasi seller

#### B. **Status Seller Action Required**
- **Confirmed**: Seller mengkonfirmasi pesanan, siap diproses
- **Processing**: Pesanan sedang disiapkan/dikemas
- **Shipped**: Pesanan telah dikirim dengan kurir

#### C. **Status Pengiriman**
- **Delivered**: Pesanan sampai di tujuan (konfirmasi kurir)
- **Finished**: Pesanan selesai (pembeli konfirmasi atau auto-complete)

#### D. **Status Khusus**
- **Cancelled**: Pesanan dibatalkan (seller/system)
- **Refunded**: Pesanan dikembalikan dana

---

## Fitur Utama Manajemen Pesanan

### 1. **Dashboard Pesanan Multi-Status**
- Tampilan terpisah untuk setiap status pesanan
- Filter dan pencarian berdasarkan invoice atau nama pembeli
- Sorting berdasarkan tanggal dan prioritas
- Pagination untuk mengelola pesanan dalam jumlah besar

### 2. **Detail Pesanan Komprehensif**
```
Informasi Pesanan Lengkap:
├── Header Information
│   ├── Nomor Invoice (INV/YYYY-MM-DD/XXXX)
│   ├── Status dengan color coding
│   ├── Tanggal pesanan
│   └── Customer information
├── Product Details
│   ├── Daftar produk dan varian
│   ├── Harga, quantity, subtotal
│   └── Gambar produk
├── Payment Summary
│   ├── Subtotal produk
│   ├── Ongkos kirim
│   ├── Diskon (jika ada)
│   └── Total pembayaran
├── Shipping Information
│   ├── Alamat pengiriman lengkap
│   ├── Metode pengiriman dipilih
│   ├── Estimasi waktu pengiriman
│   └── Tracking information
└── Action Buttons
    ├── Update Status
    ├── Print Invoice
    ├── Contact Customer
    └── View Tracking
```

### 3. **Integrasi Biteship untuk Pengiriman**
- Otomatis membuat order pengiriman di Biteship
- Real-time tracking number generation
- Sinkronisasi status pengiriman
- Link tracking otomatis untuk pembeli

### 4. **Manajemen Status Fleksibel**
- Update status dengan validasi workflow
- Bulk action untuk multiple orders
- Alasan pembatalan jika diperlukan
- Log audit trail perubahan status

---

## Kategori Pesanan Berdasarkan Status

### 1. **Pesanan Paid (Butuh Konfirmasi)**
**URL:** `/seller/orders?status=paid`

**Action Required:**
- Verifikasi pembayaran (otomatis dari payment gateway)
- Konfirmasi ketersediaan stok
- Ubah status ke "Confirmed" untuk lanjut ke processing

**Informasi Ditampilkan:**
- Invoice, Date, Customer, Items, Total, Status, Actions
- Badge biru untuk status "Paid"
- Quick action button untuk konfirmasi

### 2. **Pesanan Confirmed (Siap Diproses)**
**URL:** `/seller/orders?status=confirmed`

**Action Required:**
- Mulai persiapan barang
- Pilih metode pengambilan (pickup/drop off)
- Ubah status ke "Processing"

**Informasi Tambahan:**
- Courier information (metode pengiriman dipilih)
- Customer details dan alamat pengiriman
- Estimasi target processing

### 3. **Pesanan Processing (Dalam Persiapan)**
**URL:** `/seller/orders?status=processing`

**Action Required:**
- Menyelesaikan packaging
- Siapkan untuk pengiriman
- Ubah status ke "Shipped" dengan tracking info

**Fitur Khusus:**
- Integrasi otomatis dengan Biteship
- Generate receipt dan tracking number
- Notifikasi otomatis ke pembeli

### 4. **Pesanan Shipped (Dalam Pengiriman)**
**URL:** `/seller/orders?status=shipped`

**Monitoring Features:**
- Real-time tracking status
- Tracking ID dan Waybill number
- Link tracking eksternal
- ETA delivery information

**Informasi Ditampilkan:**
- Invoice, Courier, Customer, Items, Total, Status
- Tracking ID, Waybill, Direct tracking link

### 5. **Pesanan Delivered (Sampai Tujuan)**
**URL:** `/seller/orders?status=delivered`

**Status Information:**
- Konfirmasi pengiriman dari kurir
- Menunggu konfirmasi penerimaan pembeli
- Akan otomatis menjadi "Finished" setelah periode tertentu

### 6. **Pesanan Finished (Selesai)**
**URL:** `/seller/orders?status=finished`

**Completion Features:**
- Transaksi selesai
- Dana siap dicairkan (settlement)
- Dapat memberikan review balasan
- Archive untuk reporting

---

## 💻 Panduan Penggunaan

### 1. **Mengakses Manajemen Pesanan**

1. **Login** ke akun seller Anda
2. **Klik Menu "Orders"** di sidebar navigasi
3. **Pilih Tab Status** pesanan yang ingin dikelola:
   - Paid (perlu konfirmasi)
   - Confirmed (siap diproses)  
   - Processing (dalam persiapan)
   - Shipped (dalam pengiriman)
   - Delivered (sudah sampai)
   - Finished (selesai)

### 2. **Memproses Pesanan Paid ke Confirmed**

1. **Buka tab "Paid"** untuk melihat pesanan yang butuh konfirmasi
2. **Klik pesanan** untuk melihat detail lengkap
3. **Verifikasi informasi**:
   - Cek detail produk dan quantity
   - Pastikan stok tersedia
   - Konfirmasi alamat pengiriman
4. **Klik "Confirm Order"** untuk mengkonfirmasi
5. **Pesanan otomatis pindah** ke tab "Confirmed"

### 3. **Memproses Pesanan Confirmed ke Processing**

1. **Buka tab "Confirmed"** 
2. **Pilih pesanan** yang akan diproses
3. **Pilih Collection Method**:
   - **Pickup**: Kurir akan ambil di toko Anda
   - **Drop Off**: Anda antar ke agen kurir
4. **Klik "Start Processing"**
5. **Sistem otomatis**:
   - Membuat order di Biteship
   - Generate tracking number
   - Update status ke "Processing"

### 4. **Memproses Pesanan Processing ke Shipped**

1. **Buka tab "Processing"**
2. **Selesaikan packaging** produk
3. **Klik pesanan** untuk update status
4. **Isi informasi tracking** (jika belum otomatis):
   - Tracking number
   - Waybill ID  
   - Catatan tambahan
5. **Klik "Ship Order"**
6. **Pembeli otomatis mendapat** notifikasi pengiriman

### 5. **Monitoring Pesanan Shipped**

1. **Buka tab "Shipped"** untuk monitoring
2. **Klik link tracking** untuk cek status real-time
3. **Monitor ETA** dan update pembeli jika perlu
4. **Status otomatis update** ke "Delivered" oleh sistem kurir

### 6. **Mengelola Pesanan Delivered/Finished**

1. **Pesanan Delivered** akan otomatis jadi "Finished" setelah periode tertentu
2. **Bisa manual mark** sebagai settled untuk withdrawal
3. **Respond review** dari pembeli jika ada
4. **Download invoice** untuk recordkeeping

---

## Fitur Pencarian dan Filter

### 1. **Pencarian Pesanan**
```
Search Options:
├── By Invoice Number (INV/2024-09-10/ABCD)
├── By Customer Name (John Doe)
├── By Customer Email (john@example.com)
└── By Product Name (dalam order items)
```

### 2. **Filter Status**
- **All Orders**: Semua pesanan dalam satu view
- **By Specific Status**: Filter per status tertentu
- **Date Range**: Filter berdasarkan periode waktu
- **Payment Method**: Filter berdasarkan metode pembayaran

### 3. **Sorting Options**
- **Latest First**: Pesanan terbaru di atas (default)
- **Oldest First**: Pesanan lama di atas
- **By Total Amount**: Urutkan berdasarkan nilai
- **By Status**: Group berdasarkan status

---

## Informasi Invoice dan Tracking

### 1. **Format Invoice**
```
Invoice Format:
INV/YYYY-MM-DD/XXXX

Contoh: INV/2024-09-10/AB3F
├── INV: Prefix tetap
├── YYYY-MM-DD: Tanggal pembuatan
└── XXXX: Random 4 karakter unik
```

### 2. **Tracking Information**
```
Tracking Details:
├── Tracking ID: Nomor tracking dari kurir
├── Waybill ID: Nomor resi pengiriman  
├── Courier Code: Kode kurir (JNE, SICEPAT, dll)
├── Service Type: Jenis layanan (REG, YES, etc)
├── ETA: Estimasi waktu tiba
└── Current Status: Status terkini dari kurir
```

### 3. **Payment Summary Structure**
```
 Payment Breakdown:
├── Subtotal: Total harga produk
├── Shipping Cost: Ongkos kirim
├── Tax Amount: Pajak (jika applicable)
├── Discount: Diskon/promo (jika ada)
├── Service Fee: Fee platform
└── Total Amount: Total yang dibayar pembeli
```

---

## Troubleshooting

### 1. **Pesanan Tidak Muncul**

**Problem**: Pesanan tidak terlihat di dashboard

**Solusi**:
```bash
# Cek filter status
1. Pastikan filter status sudah benar
2. Coba "All Orders" untuk melihat semua
3. Gunakan pencarian dengan invoice number

# Cek periode waktu  
1. Pesanan mungkin di luar range tanggal
2. Gunakan filter date range yang lebih luas
3. Cek apakah pesanan untuk toko yang benar
```

### 2. **Tidak Bisa Update Status**

**Problem**: Button update status tidak berfungsi atau error

**Solusi**:
```bash
# Cek alur status yang valid
1. Pastikan transisi status sesuai workflow
2. Tidak bisa skip status (harus berurutan)  
3. Cek apakah ada field required yang belum diisi

# Cek permission dan data
1. Pastikan pesanan milik toko Anda
2. Refresh halaman dan coba lagi
3. Logout-login untuk refresh session
```

### 3. **Integrasi Biteship Gagal**

**Problem**: Error saat membuat order pengiriman

**Solusi**:
```bash
# Cek data pengiriman
1. Pastikan alamat toko lengkap dan valid
2. Cek alamat pembeli sudah benar
3. Pastikan metode kurir sudah diaktifkan

# Cek konfigurasi sistem
1. Hubungi admin jika Biteship error
2. Cek koneksi internet stabil
3. Coba beberapa saat kemudian
```

### 4. **Tracking Number Tidak Generate**

**Problem**: Tracking number kosong atau tidak otomatis

**Solusi**:
```bash
# Manual input tracking
1. Update manual di form tracking details
2. Input nomor resi dari kurir langsung
3. Tambahkan link tracking manual

# Hubungi support
1. Laporkan ke admin sistem
2. Berikan invoice number yang bermasalah
3. Screenshot error message jika ada
```

### 5. **Pesanan Stuck di Status Tertentu**

**Problem**: Pesanan tidak bergerak dari status tertentu

**Solusi**:
```php
// Cek workflow status
Status yang valid:
- Paid → Confirmed (manual seller action)
- Confirmed → Processing (manual seller action)  
- Processing → Shipped (manual seller action)
- Shipped → Delivered (otomatis dari kurir)
- Delivered → Finished (otomatis sistem/manual pembeli)

// Action required
1. Cek apakah butuh action dari seller
2. Untuk status "Shipped", tunggu konfirmasi kurir
3. Untuk status "Delivered", akan otomatis jadi "Finished"
```

---

## FAQ

### Q: Berapa lama pesanan otomatis berubah status?
**A**: 
- **Shipped → Delivered**: Bergantung konfirmasi kurir (real-time)
- **Delivered → Finished**: Otomatis setelah 7 hari atau konfirmasi pembeli
- **Status lain**: Membutuhkan action manual dari seller

### Q: Apakah bisa membatalkan pesanan yang sudah shipped?
**A**: 
- **Shipped orders**: Bisa dibatalkan dalam kondisi khusus (koordinasi dengan kurir)
- **Delivered orders**: Tidak bisa dibatalkan, hanya bisa refund
- **Finished orders**: Hanya bisa refund melalui sistem dispute

### Q: Bagaimana cara mengedit detail pesanan?
**A**: 
- **Detail pesanan tidak bisa diubah** setelah status "Confirmed"
- **Tracking info**: Bisa diupdate kapan saja
- **Catatan**: Bisa ditambahkan di kolom notes
- **Perubahan major**: Hubungi customer service

### Q: Apa yang terjadi jika pembeli tidak konfirmasi penerimaan?
**A**: 
- **Auto-complete**: Sistem otomatis ubah ke "Finished" setelah 7 hari
- **Dana otomatis release**: Untuk settlement penjual
- **Review period**: Pembeli masih bisa review dalam 30 hari

### Q: Bagaimana cara mencetak invoice?
**A**: 
1. **Buka detail pesanan** yang ingin dicetak
2. **Klik tombol "Print Invoice"** 
3. **Browser akan buka** preview print
4. **Save as PDF** atau print langsung

### Q: Apakah bisa bulk update status pesanan?
**A**: 
- **Saat ini**: Belum tersedia fitur bulk action
- **Update individual**: Satu per satu pesanan
- **Planning**: Fitur bulk akan ditambahkan di update mendatang

### Q: Bagaimana tracking pesanan yang tidak ada di Biteship?
**A**: 
1. **Manual tracking**: Input manual nomor resi di form
2. **Link eksternal**: Masukkan link tracking dari kurir langsung  
3. **Update berkala**: Update status secara manual
4. **Customer communication**: Inform pembeli via chat/phone

### Q: Apakah ada notifikasi otomatis untuk seller?
**A**: 
- **Email notification**: Untuk pesanan baru dan perubahan status
- **Dashboard alert**: Counter badge untuk pesanan butuh attention
- **Push notification**: Akan ditambahkan di mobile app (coming soon)

### Q: Bagaimana cara mengatasi dispute atau komplain?
**A**: 
1. **Direct contact**: Hubungi pembeli melalui chat/phone
2. **Customer service**: Escalate ke customer service platform
3. **Refund process**: Proses refund jika diperlukan
4. **Documentation**: Simpan bukti komunikasi dan penyelesaian

### Q: Apakah data pesanan bisa diexport untuk laporan?
**A**: 
- **Currently**: Fitur export belum tersedia di halaman orders
- **Alternative**: Screenshot atau copy manual untuk laporan
- **Reports menu**: Gunakan menu Reports untuk data analytics
- **Future update**: Fitur export Excel/CSV akan ditambahkan

---

## Tips Optimasi Manajemen Pesanan

### 1. **Respons Time Optimal**
- **Konfirmasi pesanan dalam 2-4 jam** untuk kepuasan pembeli
- **Processing time maksimal 1-2 hari** kerja  
- **Update tracking information segera** setelah pengiriman

### 2. **Customer Communication**
- **Proaktif inform** jika ada delay atau kendala
- **Gunakan feature notes** untuk komunikasi internal
- **Follow up** pesanan yang delivered untuk memastikan kepuasan

### 3. **Inventory Management**  
- **Sync stock real-time** untuk mencegah overselling
- **Monitor popular products** dari order data
- **Plan restock** berdasarkan trend pesanan

### 4. **Quality Control**
- **Double check** pesanan sebelum shipped
- **Quality packaging** untuk mencegah damage
- **Photo documentation** untuk barang bernilai tinggi

---

*Dokumentasi ini dibuat untuk membantu penjual mengoptimalkan pengelolaan pesanan di Pasar Santri Marketplace. Untuk bantuan lebih lanjut, silakan hubungi tim support.*
