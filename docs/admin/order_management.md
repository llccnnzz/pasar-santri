# Dokumentasi Manajemen Pesanan Admin

## Deskripsi Umum

Sistem Manajemen Pesanan memungkinkan administrator **Pasar Santri Marketplace** untuk memantau, mengelola, dan mengintervensi seluruh proses pesanan dari pembeli di platform. Sistem ini memberikan kontrol penuh atas alur pesanan, pembayaran, dan penyelesaian masalah yang mungkin terjadi.

---

## Fitur Utama

### 1. **Monitoring Pesanan Realtime**
- Dashboard comprehensive semua pesanan
- Tracking status pesanan dari pending hingga selesai
- Pencarian berdasarkan nomor invoice
- Filter berdasarkan status pesanan

### 2. **Manajemen Pembayaran**
- Bypass pembayaran untuk pesanan pending
- Bulk bypass untuk multiple pesanan sekaligus
- Monitoring payment gateway integration
- Tracking payment status dan fee

### 3. **Kontrol Status Pesanan**
- Update manual status pesanan
- Validasi transisi status
- Cancellation dan refund management
- Settlement tracking untuk payout seller

### 4. **Analytics dan Reporting**
- Statistik pesanan per periode
- Revenue tracking dan analytics
- Performance monitoring per toko
- Export data untuk reporting

---

## Alur Status Pesanan

### Status Flow Diagram:
```
Pending → Paid → Confirmed → Processing → Shipped → Delivered → Finished
    ↓       ↓        ↓          ↓          ↓         ↓
Cancelled ← Cancelled ← Cancelled ← Cancelled ← Cancelled ← Refunded
```

### Detail Status:

1. **Pending** - Pesanan dibuat, menunggu pembayaran
2. **Paid** - Pembayaran berhasil, menunggu konfirmasi seller  
3. **Confirmed** - Seller konfirmasi pesanan, siap diproses
4. **Processing** - Pesanan sedang diproses/dikemas seller
5. **Shipped** - Pesanan dikirim dengan kurir
6. **Delivered** - Pesanan sampai di tujuan
7. **Finished** - Pesanan selesai, buyer confirm received
8. **Cancelled** - Pesanan dibatalkan (berbagai alasan)
9. **Refunded** - Dana dikembalikan ke buyer

---

## Struktur Data Pesanan

### Field Utama Order:
- **ID**: UUID unique identifier
- **User ID**: ID pembeli
- **Shop ID**: ID toko seller
- **Invoice**: Nomor invoice unik (format: INV/YYYY-MM-DD/XXXX)
- **Status**: Status current pesanan
- **Order Details**: Detail items, alamat, shipping (JSON)
- **Payment Detail**: Detail pembayaran, total, fee (JSON)
- **Cancellation Reason**: Alasan pembatalan (jika ada)
- **Shipment Ref ID**: Referensi ID pengiriman
- **Tracking Details**: Detail tracking kurir (JSON)
- **Has Reviewed**: Apakah sudah di-review buyer
- **Has Settlement**: Apakah sudah settlement ke seller
- **Biteship Order**: Data integrasi Biteship (JSON)

### Field Payment:
- **Order ID**: Referensi ke order
- **Payment Method ID**: ID metode pembayaran
- **Channel**: Gateway pembayaran (xendit, midtrans, dll)
- **Reference ID**: ID transaksi di gateway
- **Status**: Status pembayaran
- **Value**: Nominal pembayaran
- **Payment Fee**: Fee gateway
- **JSON Callback**: Data callback dari gateway
- **Expired At**: Kapan pembayaran expired
- **Paid At**: Waktu pembayaran berhasil

---

## Panduan Penggunaan

### 1. Mengakses Dashboard Pesanan

1. Login ke panel admin
2. Navigasi ke menu **"Orders"** atau **"Manajemen Pesanan"**
3. Dashboard akan menampilkan:
   - Daftar semua pesanan terbaru
   - Filter pencarian berdasarkan invoice
   - Tombol aksi cepat untuk bypass payment
   - Statistik ringkas pesanan

### 2. Melihat Daftar Pesanan

#### Informasi yang Ditampilkan:
- **Data Pembeli**:
  - Nama penerima
  - Alamat lengkap (kelurahan, kota, provinsi)
  
- **Data Toko**:
  - Nama toko seller
  - Lokasi toko
  
- **Info Pesanan**:
  - Nomor invoice
  - Total pembayaran
  - Status current
  
- **Aksi Tersedia**:
  - Mark as Paid (untuk pending orders)
  - View Detail Order
  - Update Status

#### Filter dan Pencarian:
- **Search by Invoice**: Ketik nomor invoice di kolom search
- **Filter by Status**: Pilih status tertentu dari dropdown
- **Date Range Filter**: Filter berdasarkan tanggal order
- **Shop Filter**: Filter berdasarkan toko tertentu

### 3. Detail Pesanan

Klik pada invoice atau tombol "View Detail" untuk melihat:

#### Tab Informasi Utama:
- **Order Information**:
  - Invoice number dan tanggal
  - Status current dan history
  - Total value breakdown
  
- **Customer Information**:
  - Data pembeli lengkap
  - Alamat pengiriman
  - Kontak information
  
- **Shop Information**:
  - Data toko seller
  - Lokasi dan kontak toko
  
- **Items Ordered**:
  - List produk yang dipesan
  - Quantity, harga, subtotal
  - Berat total untuk shipping

#### Tab Payment Details:
- **Payment Method**: Metode pembayaran yang dipilih
- **Payment Status**: Status pembayaran terkini
- **Gateway Info**: Channel pembayaran (Xendit, Midtrans, dll)
- **Reference ID**: ID transaksi di payment gateway
- **Payment Timeline**: History pembayaran
- **Fee Breakdown**: Fee yang dikenakan

#### Tab Shipping Information:
- **Shipping Method**: Kurir yang dipilih
- **Shipping Cost**: Biaya pengiriman
- **Origin**: Alamat toko pengirim
- **Destination**: Alamat penerima
- **Tracking Number**: Resi pengiriman (jika ada)
- **Tracking History**: History status pengiriman

### 4. Bypass Payment (Emergency)

Fitur ini untuk mengatasi masalah pembayaran yang stuck atau error:

#### Single Order Bypass:
1. Di daftar pesanan, cari order dengan status "Pending"
2. Klik tombol hijau dengan icon ✓ (Mark as Paid)
3. Sistem akan otomatis:
   - Update order status ke "Paid"
   - Update payment status ke "Success"
   - Set paid_at timestamp
   - Kirim notifikasi ke seller

#### Bulk Bypass Payment:
1. Klik tombol **"Mark All Pending as Paid"**
2. Sistem akan proses semua pending orders sekaligus
3. Konfirmasi akan muncul dengan jumlah orders yang akan diproses
4. Review dan confirm bulk action

**Peringatan**: 
- Fitur ini hanya untuk emergency atau testing
- Pastikan pembayaran benar-benar sudah diterima
- Dokumentasikan alasan bypass untuk audit

### 5. Update Status Pesanan

Untuk intervensi manual status pesanan:

#### Langkah-langkah:
1. Masuk ke detail pesanan
2. Di bagian **Status Management**, pilih status baru
3. Isi alasan perubahan (wajib untuk beberapa status)
4. Klik **"Update Status"**

#### Validasi Transisi Status:
- **Pending** → Paid, Cancelled
- **Paid** → Confirmed, Cancelled  
- **Confirmed** → Processing, Cancelled
- **Processing** → Shipped, Cancelled
- **Shipped** → Delivered, Cancelled
- **Delivered** → Finished, Refunded
- **Finished** → Refunded

**Catatan**: Sistem akan menolak transisi yang tidak valid.

### 6. Penanganan Pembatalan (Cancellation)

#### Untuk Membatalkan Pesanan:
1. Buka detail pesanan
2. Pilih status **"Cancelled"**
3. **Wajib** isi alasan pembatalan:
   - Stock tidak tersedia
   - Seller tidak responsif
   - Permintaan buyer
   - Fraud detection
   - Technical issue
4. Confirm cancellation

#### Auto Actions setelah Cancellation:
- Payment akan di-refund otomatis (jika sudah paid)
- Stock produk akan dikembalikan
- Notifikasi ke buyer dan seller
- Update analytics data

### 7. Proses Refund

#### Untuk Memproses Refund:
1. Pastikan pesanan sudah status "Delivered" atau "Finished"
2. Di detail pesanan, klik **"Process Refund"**
3. Pilih alasan refund:
   - Produk rusak/cacat
   - Tidak sesuai deskripsi
   - Pengiriman terlambat
   - Permintaan buyer lainnya
4. Input jumlah refund:
   - Full refund (total amount)
   - Partial refund (sebagian)
5. Confirm refund process

#### Refund Processing:
- Sistem akan create refund request ke payment gateway
- Status order berubah ke "Refunded"
- Dana akan kembali ke buyer dalam 3-7 hari kerja
- Settlement seller akan di-adjust

### 8. Settlement Management

Untuk monitoring settlement payout ke seller:

#### Cek Orders yang Butuh Settlement:
1. Filter pesanan dengan status "Delivered"
2. Lihat kolom **"Has Settlement"**
3. Order yang belum settlement akan ditandai 

#### Process Settlement:
1. Buka detail pesanan yang sudah delivered
2. Pastikan tidak ada dispute/complaint
3. Klik **"Mark as Settled"**
4. Settlement akan masuk ke queue payout

#### Settlement Rules:
- Minimum 3 hari setelah delivered
- Maksimal 14 hari auto-settlement
- Dapat di-hold jika ada dispute
- Fee marketplace akan dipotong otomatis

---

## Analytics dan Reports

### 1. Dashboard Analytics

Access melalui **"Order Analytics"** menu:

#### Metrics yang Tersedia:
- **Total Orders**: Jumlah pesanan per periode
- **Revenue**: Total revenue dan growth
- **Average Order Value**: Rata-rata nilai pesanan
- **Conversion Rate**: Rate dari pending ke paid
- **Cancellation Rate**: Rate pembatalan
- **Settlement Amount**: Total yang perlu dibayar ke seller

#### Grafik dan Visualisasi:
- **Orders Timeline**: Grafik pesanan per hari/bulan
- **Status Distribution**: Pie chart distribusi status
- **Revenue Growth**: Trend pertumbuhan revenue
- **Top Performing Shops**: Ranking toko terbaik
- **Payment Method Distribution**: Distribusi metode bayar

### 2. Export Reports

#### Format Export Tersedia:
- **Excel (.xlsx)**: Untuk analisis detail
- **CSV**: Untuk import ke sistem lain
- **PDF**: Untuk presentasi/sharing

#### Data yang Bisa di-Export:
- Order list dengan filter tertentu
- Payment summary per periode
- Settlement reports untuk accounting
- Analytics summary untuk management

#### Cara Export:
1. Set filter sesuai kebutuhan (tanggal, status, toko)
2. Klik **"Export Data"**
3. Pilih format dan range data
4. Download akan dimulai otomatis

---

## Integrasi dengan Sistem Lain

### 1. Payment Gateway Integration

#### Supported Gateways:
- **Xendit**: Virtual Account, E-Wallet, QRIS
- **Midtrans**: Credit Card, Bank Transfer
- **E-Maal**: Islamic banking integration
- **Manual Transfer**: Bank transfer verification

#### Webhook Handling:
- Automatic payment status updates
- Real-time notification ke admin
- Failure handling dan retry mechanism
- Callback data logging untuk audit

### 2. Biteship Shipping Integration

#### Features:
- Automatic shipping cost calculation
- Real-time tracking updates
- Multiple courier support (19+ couriers)
- Pickup/drop-off scheduling
- Delivery confirmation

#### Admin Controls:
- Override shipping cost manual
- Change courier if needed
- Manual tracking number input
- Dispute shipping charges

### 3. Notification System

#### Channels:
- **Email**: Automated order confirmations
- **WhatsApp**: Status update notifications  
- **In-App**: Real-time admin alerts
- **SMS**: Critical payment alerts

#### Triggers:
- New order placed
- Payment received/failed
- Status changes
- Cancellation/refund processed
- Settlement completed

---

## Troubleshooting

### Problem: "Payment stuck di Pending"
**Diagnosis**:
- Check payment gateway status
- Verify callback dari gateway
- Cek network connectivity

**Solusi**:
1. Manual payment verification di gateway dashboard
2. Jika payment confirmed, use bypass payment
3. Update payment status manual
4. Notify customer tentang resolution

### Problem: "Order tidak bisa diupdate status"
**Diagnosis**:
- Cek current status dan target status
- Verify business logic rules
- Check user permissions

**Solusi**:
1. Pastikan transisi status valid sesuai flow
2. Check required fields (tracking, reason, etc.)
3. Verify admin permissions
4. Use force update if necessary dengan approval

### Problem: "Shipping tracking tidak update"
**Diagnosis**:
- Check Biteship API connection
- Verify tracking number format
- Check courier service status

**Solusi**:
1. Manual sync dengan Biteship API
2. Contact courier untuk status update
3. Input manual tracking info
4. Notify buyer tentang delay

### Problem: "Refund tidak terproses"
**Diagnosis**:
- Check payment gateway refund status
- Verify original payment method
- Check refund policy compliance

**Solusi**:
1. Manual refund process di gateway
2. Contact payment provider support
3. Alternative refund method (bank transfer)
4. Escalate ke finance team jika diperlukan

### Problem: "Settlement calculation salah"
**Diagnosis**:
- Check marketplace fee configuration
- Verify order total calculation
- Review discount/promo impact

**Solusi**:
1. Recalculate settlement manual
2. Adjust marketplace fee if needed
3. Update settlement amount
4. Generate correction report

---

## Business Rules dan Policies

### 1. Payment Policy

#### Timeout Rules:
- Virtual Account: 24 jam
- E-Wallet: 15 menit  
- Bank Transfer: 1x24 jam
- Credit Card: Instant

#### Auto-Cancel Rules:
- Pending orders: 24 jam no payment
- Paid orders: 7 hari no seller action
- Processing orders: 14 hari no shipping

### 2. Refund Policy

#### Eligible Conditions:
- Product defect/damage
- Wrong item delivered
- Significant delay (>7 days)
- Seller misconduct

#### Refund Timeline:
- Request processing: 1-2 hari kerja
- Gateway processing: 3-7 hari kerja
- Fund receipt: Depends on bank

### 3. Settlement Policy

#### Hold Conditions:
- Active disputes
- Fraud suspicion  
- New seller (first 30 days)
- High return rate

#### Payout Schedule:
- Regular sellers: Weekly (Fridays)
- Premium sellers: Daily
- New sellers: Bi-weekly

---

## Security dan Audit

### 1. Access Control

#### Admin Levels:
- **Super Admin**: Full access semua fitur
- **Order Manager**: Order management only
- **Finance Admin**: Payment/settlement only
- **Support Agent**: View only + basic actions

### 2. Audit Trail

#### Logged Activities:
- Status changes dengan timestamp
- Payment bypass actions
- Refund processing
- Settlement marking
- Data exports

#### Audit Information:
- User yang melakukan action
- Timestamp detail
- Alasan/notes
- Before/after values
- IP address dan device

### 3. Data Security

#### Sensitive Data Protection:
- Payment info encrypted
- Personal data masking
- Secure API communications
- Regular security audits

---

## Tips dan Best Practices

### 1. **Monitoring Harian**
- Check pending payments setiap pagi
- Review cancelled orders untuk pattern
- Monitor refund requests yang pending
- Verify settlement calculations

### 2. **Customer Service**
- Respond cepat ke order disputes
- Proactive communication untuk delays  
- Clear explanation untuk cancellations
- Follow up refund status

### 3. **Seller Management**
- Monitor seller response times
- Identify problematic sellers early
- Support sellers dengan training
- Regular performance reviews

### 4. **Financial Controls**
- Daily reconciliation dengan accounting
- Weekly settlement validation
- Monthly revenue analysis
- Quarterly fee structure review

### 5. **System Maintenance**
- Regular backup order data
- Monitor system performance
- Update payment gateway configs
- Test emergency procedures

---

## Informasi Teknis

### Database Schema:
```sql
-- Orders Table
Table: orders
- id: UUID PRIMARY KEY
- user_id: BIGINT FOREIGN KEY
- shop_id: UUID FOREIGN KEY  
- invoice: VARCHAR(255) UNIQUE
- status: ENUM(pending,paid,confirmed,processing,shipped,delivered,finished,cancelled,refunded)
- order_details: JSON
- payment_detail: JSON
- cancellation_reason: TEXT
- shipment_ref_id: VARCHAR(255)
- tracking_details: JSON
- has_reviewed: BOOLEAN
- has_settlement: BOOLEAN
- biteship_order: JSON
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
- deleted_at: TIMESTAMP

-- Order Payments Table  
Table: order_payments
- id: BIGINT PRIMARY KEY
- order_id: UUID FOREIGN KEY
- payment_method_id: BIGINT
- channel: VARCHAR(255)
- reference_id: VARCHAR(255)
- status: VARCHAR(50)
- value: DECIMAL(15,2)
- payment_fee: DECIMAL(15,2)
- json_callback: JSON
- expired_at: TIMESTAMP
- paid_at: TIMESTAMP
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
```

### API Endpoints:
```
GET    /admin/orders                    - List orders
GET    /admin/orders/{id}               - Show order detail  
PUT    /admin/orders/{id}               - Update order
POST   /admin/orders/{id}/refund        - Process refund
PUT    /admin/orders/payment/{id}/{status} - Bypass payment
PUT    /admin/orders/payment/bulk-bypass   - Bulk bypass
GET    /admin/orders/analytics/dashboard   - Analytics data
```

### Integration APIs:
- **Xendit API**: Payment processing
- **Midtrans API**: Alternative payment
- **Biteship API**: Shipping integration
- **WhatsApp API**: Notifications

---

## Dukungan dan Bantuan

Untuk bantuan lebih lanjut terkait sistem pesanan:

**Email Support**: support@pasarsantri.com  
**WhatsApp**: +62 812-3456-7890  
**Website**: www.pasarsantri.com  
**Developer**: PT. Sidogiri Fintech Utama

**Jam Operasional Support**:  
Senin - Jumat: 08:00 - 17:00 WIB  
Sabtu: 08:00 - 12:00 WIB

**Emergency Contact** (untuk masalah kritis):  
**Hotline**: +62 811-2233-4455 (24/7)

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: September 2025*
