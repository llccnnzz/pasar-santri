# 📊 Dashboard Seller - Pasar Santri

## 📋 Deskripsi
Dashboard Seller adalah halaman utama yang memberikan gambaran lengkap tentang kinerja toko Anda di marketplace Pasar Santri. Dashboard ini menampilkan berbagai metrik bisnis, statistik penjualan, dan data analitik yang membantu penjual dalam mengambil keputusan bisnis yang tepat.

## 🎯 Tujuan
- Memberikan gambaran real-time kinerja toko
- Memantau statistik penjualan dan revenue secara terpusat
- Menganalisis trend dan pertumbuhan bisnis
- Membantu pengambilan keputusan strategis
- Mengoptimalkan operasional toko berdasarkan data

## 🔐 Akses & Persyaratan
**Role Required:** Seller dengan toko aktif dan KYC approved  
**Permission:** Akses penuh ke dashboard dan analytics  
**URL:** `/seller/dashboard`

## ⭐ Fitur Utama Dashboard

### 1. **Statistik Real-time**
- Statistik penjualan, revenue, produk, dan pesanan yang diperbarui secara otomatis
- Indikator pertumbuhan dengan persentase perbandingan periode sebelumnya

### 2. **Analitik Berdasarkan Waktu**  
- Analisis berdasarkan periode waktu (hari ini, minggu, bulan, tahun)
- Filter data yang fleksibel untuk berbagai kebutuhan analisis

### 3. **Wawasan Kinerja**
- Insight performa toko dengan persentase pertumbuhan dan analisis trend
- Grafik visual untuk memahami pola bisnis

### 4. **Aktivitas Terbaru**
- Pantauan aktivitas terbaru pesanan, produk, dan pelanggan
- Timeline real-time untuk monitoring operasional

### 5. **Visualisasi Data**
- Grafik dan chart untuk memudahkan analisis data
- Dashboard interaktif dengan tampilan yang user-friendly

---

## 📋 Persyaratan Akses Dashboard

### Prasyarat Wajib

1. **Akun Terverifikasi**: Pengguna harus memiliki akun yang sudah terverifikasi
2. **KYC Disetujui**: Status KYC harus `disetujui` untuk mengakses dashboard
3. **Setup Toko Lengkap**: Toko harus sudah diatur dengan informasi lengkap
4. **Role Penjual**: Pengguna harus memiliki role `penjual` yang aktif

### Validasi Sistem

```php
// Cek apakah user memiliki toko
if (!$shop) {
    return redirect()->route('seller.setup')
        ->with('error', 'Please complete your shop setup first.');
}

// Cek status KYC
$approvedKyc = KycApplication::where('user_id', $user->id)
    ->where('status', 'approved')
    ->exists();
```

---

## Komponen Dashboard

### 1. Header Dashboard
- **Breadcrumb Navigation**: Navigasi hierarki halaman
- **Time Range Selector**: Pemilih periode waktu untuk analisis
- **Quick Access Menu**: Menu akses cepat ke fitur utama

### 2. Status Cards Area
Area dengan 4 kartu statistik utama yang menampilkan KPI (Key Performance Indicators) toko.

### 3. Recent Orders Table
Tabel yang menampilkan 10 order terbaru dengan informasi lengkap.

### 4. Analytics Section
Area grafik dan chart untuk visualisasi data penjualan.

### 5. Top Products & Customers
Daftar produk terlaris dan customer dengan pembelian tertinggi.

---

## Statistik Utama

### 1. Total Sales Card
- **Data Displayed**: Jumlah total penjualan yang completed
- **Growth Indicator**: Persentase pertumbuhan dibanding periode sebelumnya
- **Status Colors**: 
  - Hijau untuk pertumbuhan positif
  - Merah untuk penurunan
- **Calculation**: Berdasarkan order dengan status `completed`, `shipped`, `delivered`

```php
$orderStats = DB::table('orders')
    ->selectRaw("
        COUNT(CASE WHEN status IN ('completed', 'shipped', 'delivered') THEN 1 END) as total_sales
    ")
    ->where('shop_id', $shop->id)
    ->whereBetween('created_at', [$startDate, $endDate])
    ->first();
```

### 2. Total Revenue Card
- **Data Displayed**: Total pendapatan dalam Rupiah
- **Additional Info**: Jumlah order yang berkontribusi pada revenue
- **Calculation**: Dari `payment_detail.total_amount` order yang completed
- **Format**: Mata uang Rupiah dengan format Indonesia

```php
COALESCE(SUM(CASE 
    WHEN status IN ('completed', 'shipped', 'delivered') 
    THEN CAST((payment_detail::jsonb)->>'total_amount' AS DECIMAL(15,2))
    ELSE 0 
END), 0) as total_revenue
```

### 3. Total Products Card
- **Data Displayed**: Jumlah total produk di toko
- **Active Products**: Produk dengan status `active`
- **Out of Stock**: Produk dengan stock <= 0
- **Status Badges**: Badge berwarna untuk menunjukkan status produk

### 4. Pending Orders Card
- **Data Displayed**: Order yang membutuhkan perhatian seller
- **Status Included**: `pending`, `confirmed`, `processing`
- **Alert System**: Indikator visual jika ada order yang perlu ditindaklanjuti
- **Action Required**: Badge warning jika ada pending orders

---

## Grafik dan Analitik

### 1. Monthly Sales Chart
Grafik yang menampilkan trend penjualan 12 bulan terakhir.

**Data Source**: 
```php
$monthlyData = DB::table('orders')
    ->selectRaw("
        TO_CHAR(created_at, 'YYYY-MM') as month,
        COALESCE(SUM(revenue), 0) as revenue
    ")
    ->groupBy('month')
    ->orderBy('month')
    ->get();
```

**Features**:
- **12 Months View**: Menampilkan 12 bulan terakhir
- **Revenue Tracking**: Revenue per bulan
- **Trend Analysis**: Identifikasi pola seasonal
- **Interactive Chart**: Hover untuk detail data

### 2. Weekly Revenue Chart
Grafik revenue mingguan untuk bulan berjalan.

**Calculation**:
```php
$weeklyData = DB::table('orders')
    ->selectRaw("
        EXTRACT(WEEK FROM created_at) as week_number,
        COALESCE(SUM(revenue), 0) as revenue
    ")
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->groupBy('week_number')
    ->get();
```

### 3. Growth Percentage Calculation
Perhitungan pertumbuhan dibanding periode sebelumnya.

**Algorithm**:
```php
// Hitung periode sebelumnya
$periodLength = $currentEnd->diffInDays($currentStart);
$previousStart = $currentStart->copy()->subDays($periodLength);
$previousEnd = $currentStart->copy();

// Hitung pertumbuhan
$growth = (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
```

---

## Tabel Data

### 1. Recent Orders Table

**Columns**:
- **Date**: Tanggal order dibuat
- **Invoice**: Nomor invoice dengan format `#INV-XXXXX`
- **Customer**: Nama pembeli
- **Items**: Jumlah item dalam order
- **Total**: Total pembayaran dalam Rupiah
- **Payment**: Metode pembayaran yang digunakan
- **Status**: Status order dengan color coding
- **Actions**: Quick action untuk view detail order

**Status Color Mapping**:
```php
$statusClasses = [
    'pending' => 'bg-warning-transparent text-warning',
    'confirmed' => 'bg-info-transparent text-info',
    'processing' => 'bg-primary-transparent text-primary',
    'shipped' => 'bg-info-transparent text-info',
    'delivered' => 'bg-success-transparent text-success',
    'completed' => 'bg-success-transparent text-success',
    'cancelled' => 'bg-danger-transparent text-danger',
    'refunded' => 'bg-secondary-transparent text-secondary'
];
```

### 2. Top Selling Products Table

**Data Query**:
```php
// Complex PostgreSQL query dengan JSON operations
$productSales = DB::select("
    SELECT 
        p.id, p.name, p.slug, p.price, p.stock, p.status,
        COALESCE(SUM(
            CASE 
                WHEN o.status IN ('completed', 'shipped', 'delivered') 
                THEN (item->>'quantity')::integer
                ELSE 0 
            END
        ), 0) as total_sold
    FROM products p
    LEFT JOIN orders o ON o.shop_id = p.shop_id
    LEFT JOIN LATERAL jsonb_array_elements((o.order_details::jsonb)->'items') AS item 
        ON (item->>'id') = p.id::text
    WHERE p.shop_id = ?
    GROUP BY p.id, p.name, p.slug, p.price, p.stock, p.status
    ORDER BY total_sold DESC, p.stock DESC
");
```

**Features**:
- **Product Image**: Thumbnail produk atau placeholder
- **Product Name**: Nama produk dengan truncate
- **Stock Status**: Badge status stock (In Stock/Out of Stock)
- **Sales Count**: Jumlah terjual dalam periode

### 3. Top Customers Table

**Data Calculation**:
```php
$topCustomers = DB::table('orders')
    ->join('users', 'orders.user_id', '=', 'users.id')
    ->selectRaw("
        users.name, users.email,
        COUNT(orders.id) as order_count,
        COALESCE(SUM(total_amount), 0) as total_spent
    ")
    ->groupBy('users.id', 'users.name', 'users.email')
    ->orderByDesc('total_spent')
    ->get();
```

**Display Elements**:
- **Customer Avatar**: Icon user sebagai placeholder
- **Customer Name**: Nama lengkap customer
- **Order Count**: Jumlah order yang pernah dibuat
- **Total Purchase**: Total pembelian dalam Rupiah

---

## Filter dan Periode Waktu

### Date Range Options

1. **Today**: Data hari ini (00:00 - 23:59)
2. **This Week**: Data minggu berjalan (Senin - Minggu)
3. **This Month**: Data bulan berjalan (tanggal 1 - akhir bulan)
4. **This Year**: Data tahun berjalan (1 Januari - 31 Desember)

### Implementation

```php
private function getStartDate($range)
{
    switch ($range) {
        case 'today':
            return now()->startOfDay();
        case 'week':
            return now()->startOfWeek();
        case 'year':
            return now()->startOfYear();
        default: // month
            return now()->startOfMonth();
    }
}
```

### AJAX Data Refresh

Dashboard menyediakan endpoint AJAX untuk refresh data real-time:

```php
// Route: /seller/dashboard/data
public function dashboardData(Request $request)
{
    $dateRange = $request->get('range', 'month');
    $stats = $this->getOptimizedStats($shop, $startDate, $endDate, $dateRange);
    
    return response()->json([
        'stats' => $stats,
        'ordersByStatus' => $ordersByStatus,
        'dateRange' => $dateRange
    ]);
}
```

---

## Optimisasi Performa

### 1. Caching Strategy

Dashboard menggunakan sistem caching untuk meningkatkan performa:

```php
$cacheKey = "seller_dashboard_{$shop->id}_{$dateRange}_" . $startDate->format('Y-m-d');
$cacheDuration = now()->addMinutes($dateRange === 'today' ? 5 : 30);

$dashboardData = Cache::remember($cacheKey, $cacheDuration, function() {
    return [
        'stats' => $this->getOptimizedStats(...),
        'ordersByStatus' => $this->getOrdersByStatus(...),
        // ... other data
    ];
});
```

**Cache Rules**:
- **Today Range**: Cache 5 menit (data lebih sering berubah)
- **Other Ranges**: Cache 30 menit
- **Real-time Data**: Recent orders tidak di-cache

### 2. Database Optimization

- **Raw SQL Queries**: Menggunakan DB::table() dan raw SQL untuk performa optimal
- **Single Query Operations**: Menggabungkan multiple calculations dalam satu query
- **PostgreSQL JSON Operations**: Optimized JSON queries untuk order_details
- **Proper Indexing**: Index pada shop_id, created_at, status columns

### 3. Data Aggregation

```php
// Optimized stats query
$orderStats = DB::table('orders')
    ->selectRaw("
        COUNT(*) as total_orders,
        COUNT(CASE WHEN status IN ('completed', 'shipped', 'delivered') THEN 1 END) as total_sales,
        COUNT(CASE WHEN status IN ('pending', 'confirmed', 'processing') THEN 1 END) as pending_orders,
        COALESCE(SUM(CASE WHEN status IN ('completed', 'shipped', 'delivered') 
            THEN CAST((payment_detail::jsonb)->>'total_amount' AS DECIMAL(15,2))
            ELSE 0 END), 0) as total_revenue
    ")
    ->where('shop_id', $shop->id)
    ->whereBetween('created_at', [$startDate, $endDate])
    ->first();
```

### 4. Cache Invalidation

Cache otomatis dibersihkan ketika:
- Ada order baru
- Status order berubah
- Produk diupdate
- Setting toko diubah

```php
private function clearDashboardCache($shop)
{
    $ranges = ['today', 'week', 'month', 'year'];
    foreach ($ranges as $range) {
        $cacheKey = "seller_dashboard_{$shop->id}_{$range}_*";
        Cache::forget($cacheKey);
    }
}
```

---

## Panduan Penggunaan

### 1. Mengakses Dashboard

1. **Login** ke akun seller Anda
2. **Pastikan KYC sudah approved** dan shop sudah disetup
3. **Klik Dashboard** pada menu navigasi utama
4. Dashboard akan terbuka dengan data default periode "This Month"

### 2. Membaca Statistik Utama

#### Total Sales
- **Angka besar**: Jumlah penjualan yang sudah completed
- **Badge hijau/merah**: Indikator pertumbuhan vs periode sebelumnya
- **Persentase**: Growth rate dibanding periode sama sebelumnya

#### Total Revenue
- **Format Rupiah**: Total pendapatan dalam mata uang Indonesia
- **Info tambahan**: "From X orders this month" - konteks revenue

#### Total Products
- **Angka utama**: Total produk di toko
- **Badge hijau**: Produk aktif yang sedang dijual
- **Badge kuning**: Produk yang habis stock (perlu restock)

#### Pending Orders
- **Angka merah/kuning**: Order yang butuh tindakan
- **Badge warning**: "Needs attention" jika ada pending
- **Badge success**: "All caught up" jika semua sudah ditangani

### 3. Menggunakan Filter Waktu

1. **Klik dropdown** di pojok kanan atas setiap section
2. **Pilih periode**:
   - **Today**: Untuk monitoring harian
   - **This Week**: Untuk review mingguan
   - **This Month**: Untuk laporan bulanan (default)
   - **This Year**: Untuk analisis tahunan

3. **Data otomatis refresh** setelah memilih periode baru

### 4. Menganalisis Recent Orders

1. **Scan tabel orders** untuk melihat aktivitas terbaru
2. **Perhatikan status** orders:
   - **Kuning (Pending)**: Perlu konfirmasi
   - **Biru (Confirmed/Processing)**: Sedang diproses
   - **Hijau (Shipped/Delivered)**: Berhasil
   - **Merah (Cancelled)**: Dibatalkan

3. **Klik icon mata** untuk melihat detail order
4. **Prioritaskan** order dengan status pending

### 5. Memantau Top Products

1. **Review produk terlaris** untuk:
   - **Identifikasi bestseller**: Produk dengan penjualan tinggi
   - **Monitor stock**: Cegah kehabisan stock produk laris
   - **Optimasi inventory**: Tambah stock produk populer

2. **Perhatikan badge stock**:
   - **Hijau**: Stock aman
   - **Merah**: Segera restock

### 6. Analisis Top Customers

1. **Identifikasi VIP customers** dengan pembelian tertinggi
2. **Customer retention**: Fokus pada pelanggan loyal
3. **Personal approach**: Berikan service khusus untuk top customers
4. **Cross-selling opportunity**: Tawarkan produk related

---

## Troubleshooting

### 1. Dashboard Tidak Muncul

**Problem**: Halaman kosong atau error 403

**Solusi**:
```bash
# Cek status KYC
1. Buka menu KYC Verification
2. Pastikan status "Approved"
3. Jika belum, lengkapi aplikasi KYC

# Cek setup toko
1. Buka Shop Settings
2. Pastikan informasi toko lengkap
3. Upload logo dan banner toko
```

### 2. Data Statistik Tidak Update

**Problem**: Angka statistik tidak berubah meski ada order baru

**Solusi**:
```bash
# Clear cache dashboard
1. Tunggu 5-30 menit (sesuai cache duration)
2. Refresh halaman dengan Ctrl+F5
3. Atau ganti period filter untuk force refresh

# Jika masih bermasalah
1. Logout dan login kembali
2. Clear browser cache
3. Coba browser berbeda
```

### 3. Grafik Tidak Tampil

**Problem**: Area grafik kosong atau loading terus

**Solusi**:
```javascript
// Cek console browser
1. Tekan F12 > Console tab
2. Lihat error JavaScript
3. Refresh halaman

// Cek koneksi internet
1. Pastikan internet stabil
2. Coba reload halaman
3. Disable ad blocker jika ada
```

### 4. Recent Orders Kosong

**Problem**: Tabel recent orders kosong padahal ada order

**Solusi**:
```php
// Cek filter periode
1. Ganti filter ke "This Year" 
2. Jika tetap kosong, cek status order
3. Order harus linked ke shop yang benar

// Cek data order
1. Buka menu Orders
2. Pastikan ada order dengan status valid
3. Cek apakah order sudah ter-assign ke shop
```

### 5. Permission Error

**Problem**: "Access denied" atau "Shop not found"

**Solusi**:
```bash
# Cek role user
1. Pastikan role "seller" aktif
2. Cek di User Profile > Roles

# Cek kepemilikan toko
1. User harus owner toko
2. Cek di Shop Settings
3. Jika tidak ada, setup toko baru
```

### 6. Performance Issues

**Problem**: Dashboard loading lambat

**Solusi**:
```php
// Optimasi query
1. Pilih period lebih kecil (Today/Week)
2. Clear cache browser
3. Tutup tab browser lain

// Server optimization
1. Tunggu saat traffic rendah
2. Hubungi admin jika persisten
3. Cek resource server
```

---

## FAQ

### Q: Berapa sering data dashboard diupdate?
**A**: Data dashboard diupdate secara real-time dengan cache:
- **Data "Today"**: Cache 5 menit
- **Data "Week/Month/Year"**: Cache 30 menit
- **Recent orders**: Selalu real-time (no cache)

### Q: Mengapa total sales berbeda dengan revenue?
**A**: 
- **Total Sales**: Jumlah transaksi/order yang completed
- **Revenue**: Total nilai uang dari sales tersebut
- Contoh: 10 sales bisa menghasilkan revenue Rp 1.000.000

### Q: Apa arti growth percentage negatif?
**A**: Growth percentage negatif menunjukkan penurunan performa dibanding periode sebelumnya:
- **-10%**: Turun 10% dari periode sebelumnya
- **Badge merah**: Indikator penurunan
- **Evaluasi**: Perlu analisis penyebab dan strategi perbaikan

### Q: Bagaimana cara meningkatkan ranking di top products?
**A**: Produk ranking berdasarkan total penjualan:
1. **Optimasi listing**: Foto menarik, deskripsi lengkap
2. **Competitive pricing**: Harga kompetitif
3. **Stock management**: Jaga ketersediaan stock
4. **Marketing**: Promosi dan iklan produk

### Q: Kapan status order berubah otomatis?
**A**: Beberapa status berubah otomatis:
- **Pending → Confirmed**: Setelah pembayaran verified
- **Shipped → Delivered**: Berdasarkan tracking courier (jika terintegrasi)
- **Delivered → Completed**: Setelah periode tertentu atau konfirmasi buyer

### Q: Mengapa ada order yang tidak muncul di dashboard?
**A**: Order mungkin tidak muncul jika:
- **Status draft**: Order belum di-submit customer
- **Payment pending**: Belum ada pembayaran
- **Different shop**: Order untuk toko lain
- **Time filter**: Diluar periode yang dipilih

### Q: Bagaimana cara export data dashboard?
**A**: Saat ini fitur export belum tersedia di dashboard. Alternatif:
1. **Screenshot**: Untuk laporan visual
2. **Manual copy**: Copy data ke spreadsheet
3. **Reports menu**: Gunakan menu Reports untuk export detail

### Q: Apa bedanya customer dengan user?
**A**: 
- **User**: Semua pengguna platform (seller, buyer, admin)
- **Customer**: User yang pernah berbelanja di toko Anda
- **Top Customers**: Customer dengan total pembelian tertinggi

### Q: Mengapa produk out of stock masih muncul di dashboard?
**A**: Dashboard menampilkan semua produk untuk monitoring:
- **Stock monitoring**: Agar seller tahu produk mana yang perlu restock
- **Performance tracking**: Lihat performa produk meski habis stock
- **Inventory management**: Untuk planning stock ulang

### Q: Bagaimana mengatasi cache yang stuck?
**A**: Jika data tidak update meski sudah melewati waktu cache:
1. **Hard refresh**: Ctrl+Shift+R (Chrome/Firefox)
2. **Incognito mode**: Buka dashboard di private browsing
3. **Clear browser data**: Settings > Clear browsing data
4. **Contact support**: Jika masalah persisten

---

## Tips Optimasi Bisnis

### 1. Daily Monitoring
- **Cek dashboard setiap pagi** untuk monitor overnight orders
- **Prioritaskan pending orders** untuk customer satisfaction
- **Monitor stock produk laris** untuk mencegah lost sales

### 2. Weekly Analysis
- **Review growth percentage** untuk evaluasi performa mingguan
- **Analisis top customers** untuk strategi retention
- **Evaluasi top products** untuk inventory planning

### 3. Monthly Planning
- **Review monthly revenue trend** untuk business forecasting
- **Analisis seasonal patterns** dari grafik 12 bulan
- **Update produk strategy** berdasarkan top selling products

### 4. Performance Optimization
- **Respond cepat** pada pending orders untuk meningkatkan conversion
- **Maintain stock** produk top selling untuk maximize revenue
- **Engage top customers** dengan special offers dan personal service

---

*Dokumentasi ini dibuat untuk membantu seller memaksimalkan penggunaan dashboard Pasar Santri Marketplace. Untuk pertanyaan lebih lanjut, silakan hubungi tim support.*
