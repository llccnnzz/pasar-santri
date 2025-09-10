# 🚚 Pengaturan Metode Pengiriman - Pasar Santri

## 📋 Deskripsi
Pengaturan Metode Pengiriman adalah sistem yang memungkinkan penjual untuk mengaktifkan dan mengelola layanan kurir yang akan tersedia untuk pembeli saat proses checkout. Sistem ini terintegrasi dengan **Biteship API** untuk mendapatkan data kurir dan perhitungan ongkos kirim secara otomatis.

## 🎯 Tujuan
- Menyediakan pilihan kurir yang sesuai untuk toko
- Mengintegrasikan perhitungan ongkos kirim otomatis
- Memberikan fleksibilitas pengiriman kepada pembeli
- Mengoptimalkan biaya dan waktu pengiriman
- Mengelola layanan pengiriman per toko

## 🔐 Akses & Persyaratan
**Role Required:** Seller dengan toko aktif  
**Permission:** Akses penuh ke pengaturan pengiriman  
**URL:** `/seller/shipping`

---

## 📋 Persyaratan Akses Metode Pengiriman

### 1. **KYC Disetujui & Toko Aktif**
- Status KYC harus **"Disetujui"**
- Toko sudah dibuat dan berstatus aktif
- Role penjual sudah otomatis diberikan
- Alamat toko sudah lengkap untuk lokasi penjemputan

### 2. **Sistem Admin Siap**
- Administrator sudah mengaktifkan metode pengiriman global
- Integrasi Biteship API sudah dikonfigurasi
- Daftar metode pengiriman sudah tersinkronisasi dari Biteship

### 3. **Status Toko Normal**
- Toko tidak dalam status ditangguhkan
- Dapat mengakses semua fitur pengelolaan pengiriman
- Tidak ada pembatasan dari administrator

---

## 🏗️ Struktur Sistem Pengiriman

### 1. **Pengelolaan Bertingkat**
```
🏢 Level Administrator (Global):
├── Sinkronisasi dari Biteship API
├── Mengaktifkan/menonaktifkan kurir secara global
├── Memperbarui database metode pengiriman
└── Mengelola logo kurir dan data

👤 Level Penjual (Per Toko):
├── Memilih dari kurir yang sudah diaktifkan admin
├── Mengaktifkan/menonaktifkan per layanan
├── Mengatur semua kurir sekaligus
└── Mengelola opsi pengiriman khusus toko
```

### 2. **Alur Data**
```
Biteship API → Sinkronisasi Admin → Metode Pengiriman Global → Pilihan Penjual → Checkout Pembeli
```

### 3. **Integration Points**
- **Biteship API**: Real-time courier data dan rate calculation
- **Checkout System**: Shipping method selection
- **Order Management**: Shipment creation dan tracking
- **Rate Calculation**: Dynamic ongkir calculation

---

## Komponen Shipping Methods

### 1. **Statistics Overview**

#### A. Available Methods
```
📊 Total Methods Available:
- Semua shipping methods yang bisa digunakan shop
- Gabungan dari: Active + Inactive + Not Used
- Update otomatis saat admin sync dari Biteship
```

#### B. Active Methods  
```
✅ Active Shipping Methods:
- Methods yang sudah diaktifkan seller
- Akan muncul di checkout customer
- Bisa dikalkulasi ongkirnya via Biteship
- Customer bisa pilih saat order
```

#### C. Inactive Methods
```
⏸️ Inactive Shipping Methods:  
- Methods yang pernah ditambah tapi di-disable
- Masih tersimpan di database (shop_shipping_methods)
- Tidak muncul di checkout customer
- Bisa diaktifkan kembali kapan saja
```

#### D. Not Used Methods
```
➕ Not Used Methods:
- Methods yang belum pernah ditambah seller
- Available di global tapi belum diselect
- Bisa ditambahkan sebagai option baru
- Otomatis bertambah saat admin sync methods baru
```

### 2. **Courier Cards Display**

#### A. Courier Information
```
🚚 Courier Card Components:
✓ Courier Logo (jika ada)
✓ Courier Name (JNE, POS, TIKI, dll)
✓ Courier Code (uppercase, ex: JNE)  
✓ Master Toggle Switch (enable/disable all services)
✓ Service Statistics (Total, Enabled, Disabled, Not Used)
```

#### B. Service Statistics per Courier
```
📈 Per-Courier Statistics:
- Total Services: Semua layanan courier tersebut
- Enabled: Services yang aktif untuk shop
- Disabled: Services yang non-aktif tapi pernah ditambah  
- Not Used: Services yang belum pernah dipilih
```

#### C. Visual Indicators
```
🎨 Card Visual States:
- White Background: Ada services yang enabled
- Red Background (#ffcaca): Semua services disabled
- Hover Effect: Transform dan shadow
- Click Area: Seluruh card untuk buka detail modal
```

### 3. **Courier Methods Detail Modal**

#### A. Individual Service Management
```
⚙️ Per-Service Controls:
✓ Service Name (REG, YES, OKE, dll)
✓ Service Code (uppercase badge)
✓ Description (jika tersedia dari Biteship)
✓ Status Badge (Active/Disabled/Not Added)
✓ Toggle Switch atau Add/Remove Button
```

#### B. Service States
```
🏷️ Service Status Types:

1. NOT ADDED (Not Used):
   - Badge: Secondary/Gray "Not Added"
   - Action: "Add" button
   - Database: Tidak ada record di shop_shipping_methods

2. ACTIVE (Enabled): 
   - Badge: Success/Green "Active"
   - Action: Toggle switch (checked)
   - Database: enabled = true

3. DISABLED (Inactive):
   - Badge: Warning/Orange "Disabled"  
   - Action: Toggle switch (unchecked)
   - Database: enabled = false
```

---

## Panduan Step-by-Step Mengelola Shipping Methods

### Langkah 1: Akses Shipping Methods

1. **Login** ke seller dashboard
2. **Pastikan KYC approved** dan shop sudah dibuat  
3. Klik menu **"Shipping Methods"** di sidebar
4. Halaman shipping management akan terbuka dengan courier cards

### Langkah 2: Memahami Statistics Dashboard

#### Review Available Methods:
```
📊 Check Statistics Cards:
1. Available Methods: Total semua methods yang bisa dipakai
2. Active: Methods yang sudah aktif dan bisa dipilih customer
3. Inactive: Methods yang di-disable temporary
4. Not Used: Methods baru yang belum pernah digunakan
```

#### Evaluasi Current Status:
- **Jika Active = 0**: Customer tidak bisa checkout (no shipping options)
- **Jika Available tinggi, Active rendah**: Masih banyak options yang bisa diaktifkan
- **Jika Not Used tinggi**: Ada methods baru dari admin sync yang belum dievaluasi

### Langkah 3: Mengelola Courier (Bulk Management)

#### Aktifkan Semua Services Courier:
1. **Lihat courier card** yang ingin diaktifkan
2. **Toggle master switch** di kanan atas card ke "ON"
3. **Konfirmasi action** - semua services courier akan diaktifkan
4. **Wait for success message** dan page refresh

#### Nonaktifkan Semua Services Courier:  
1. **Toggle master switch** di courier card ke "OFF"
2. **Konfirmasi action** - semua services akan di-disable
3. **Services tetap tersimpan** di database (bisa diaktifkan lagi)

### Langkah 4: Mengelola Individual Services

#### Akses Service Detail:
1. **Klik courier card** (bukan toggle switch)
2. **Modal akan terbuka** dengan list semua services
3. **Review service list** dengan status masing-masing

#### Tambah Service Baru (Not Added → Active):
1. **Find service** dengan status "Not Added"
2. **Klik "Add" button** 
3. **Service otomatis active** dan toggle switch muncul
4. **Success message** dan button berubah ke toggle switch

#### Aktifkan Service (Disabled → Active):
1. **Find service** dengan toggle switch unchecked
2. **Click toggle switch** ke position "ON"  
3. **Service status** berubah ke "Active"
4. **Badge berubah** dari orange ke green

#### Nonaktifkan Service (Active → Disabled):
1. **Find service** dengan toggle switch checked
2. **Click toggle switch** ke position "OFF"
3. **Service status** berubah ke "Disabled"  
4. **Badge berubah** dari green ke orange
5. **Record tetap ada** di database (enabled = false)

### Langkah 5: Best Practices untuk Selection

#### Pilih Courier Populer:
```
🏆 Courier Recommendations:
1. JNE: Coverage luas, reliable, populer
2. POS Indonesia: Jaringan nasional, affordable
3. TIKI: Good service, competitive rates  
4. J&T: Fast growing, good pricing
5. Anteraja: Competitive rates, decent coverage
```

#### Balance Coverage vs Cost:
```
⚖️ Selection Strategy:
✓ Enable 3-5 courier minimum (customer choice)
✓ Mix premium (JNE YES) dan ekonomi (POS Reguler)  
✓ Consider coverage area shop location
✓ Test popular routes untuk verify rates
✓ Monitor customer preferences via orders
```

#### Services per Courier:
```
📦 Service Type Recommendations:
- Regular/Standard: Untuk economical shipping
- Express/Next Day: Untuk urgent orders  
- Cargo/Heavy: Untuk large items jika applicable
- Cash on Delivery (COD): Jika supported dan needed
```

---

## Technical Implementation

### 1. **Database Structure**

#### ShippingMethod (Global Methods)
```sql
-- Table: shipping_methods
id               UUID PRIMARY KEY
courier_code     VARCHAR (jne, pos, tiki, dll)
courier_name     VARCHAR (JNE, POS Indonesia, dll)
service_code     VARCHAR (reg, yes, oke, dll)  
service_name     VARCHAR (Reguler, YES, OKE, dll)
description      TEXT (optional)
logo_url         VARCHAR (logo courier)
active           BOOLEAN (controlled by admin)
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

#### ShopShippingMethod (Shop Selections)
```sql
-- Table: shop_shipping_methods  
id                  UUID PRIMARY KEY
shop_id            UUID FOREIGN KEY (shops.id)
shipping_method_id UUID FOREIGN KEY (shipping_methods.id)
enabled            BOOLEAN (controlled by seller)
created_at         TIMESTAMP
updated_at         TIMESTAMP

-- Unique constraint: (shop_id, shipping_method_id)
```

### 2. **API Integration Flow**

#### Biteship Integration Points:
```
🔄 API Integration Flow:

1. Admin Sync:
   GET /api/biteship/couriers → Update shipping_methods table

2. Rate Calculation:  
   POST /api/biteship/rates → Get real-time shipping costs

3. Order Creation:
   POST /api/biteship/orders → Create shipment tracking

4. Order Tracking:
   GET /api/biteship/tracking/{id} → Get delivery status
```

### 3. **Frontend JavaScript Functions**

#### Key Functions:
```javascript
// Toggle individual service
function toggleMethodStatus(methodId, methodName, isEnabled, toggleElement)

// Add new service to shop
function addMethod(methodId, methodName, buttonElement)  

// Remove service from shop
function removeMethod(methodId)

// Toggle all services for courier
function toggleAllCourier(courierCode, enabled)

// Show courier methods in modal
function showCourierMethods(courierCode, courierName)

// Toast notifications
function showToast(message, type)
```

---

## Validation dan Error Handling

### 1. **Input Validation**

#### ShippingToggleRequest Validation:
```php
Rules:
- shipping_method_id: required|exists:shipping_methods,id
- enabled: required|boolean

Messages:
- Shipping method ID is required
- Selected shipping method does not exist  
- Enabled flag is required
- Enabled must be true or false
```

### 2. **Business Logic Validation**

#### Common Validation Scenarios:
```
❌ Validation Errors:

1. Method Not Found:
   - Shipping method sudah dihapus admin
   - ID tidak valid atau tidak exists

2. Shop Access Denied:
   - User bukan pemilik shop
   - Shop dalam status suspended
   - KYC belum approved

3. Method Not Available:
   - Admin sudah disable method globally  
   - Method tidak aktif di sistem
```

### 3. **Error Response Handling**

#### Frontend Error Management:
```javascript
// Success response
{
  "success": true,
  "message": "Shipping method enabled",
  "updated_count": 5,
  "created_count": 2
}

// Error response  
{
  "success": false,
  "message": "Selected shipping method does not exist",
  "errors": {...}
}
```

---

## Integration dengan Sistem Lain

### 1. **Checkout Process Integration**

#### Customer Checkout Flow:
```
🛒 Checkout Integration:

1. Get Available Methods:
   - Filter by shop_shipping_methods.enabled = true
   - AND shipping_methods.active = true
   - Group by courier untuk display

2. Rate Calculation:
   - Call Biteship API with destination address
   - Get real-time shipping costs
   - Cache rates untuk performance

3. Method Selection:
   - Customer pilih shipping method
   - Calculate total order cost  
   - Validate method masih available
```

### 2. **Order Management Integration**

#### Order Processing Flow:
```
📦 Order Processing:

1. Order Creation:
   - Validate shipping method still enabled
   - Store shipping details in order
   - Calculate final shipping cost

2. Order Fulfillment:
   - Create Biteship shipment
   - Get tracking information
   - Update order dengan shipment data

3. Order Tracking:  
   - Integrate dengan Biteship tracking API
   - Real-time status updates
   - Customer notification
```

### 3. **Analytics dan Reporting**

#### Shipping Analytics:
```
📊 Analytics Integration:

1. Popular Shipping Methods:
   - Track usage frequency per method
   - Identify customer preferences
   - Optimize method selection

2. Shipping Cost Analysis:
   - Average shipping cost per order
   - Cost comparison antar courier
   - Route optimization insights

3. Performance Metrics:
   - Delivery success rates per courier
   - Customer satisfaction per method  
   - Return/complaint rates
```

---

## Performance dan Optimization

### 1. **Caching Strategy**

#### Rate Caching:
```
🚀 Performance Optimization:

1. Rate Cache:
   - Cache Biteship rate responses
   - TTL: 15-30 minutes (rates change frequently)
   - Key: origin_postal + destination_postal + items_hash

2. Method Cache:
   - Cache enabled methods per shop  
   - Invalidate saat method di-toggle
   - Reduce database queries di checkout

3. Courier Logo Cache:
   - CDN untuk courier logos
   - Static assets dengan long cache headers
```

### 2. **Database Optimization**

#### Query Optimization:
```sql
-- Optimized queries dengan proper indexing

-- Index untuk shop shipping methods lookup
CREATE INDEX idx_shop_shipping_methods_shop_enabled 
ON shop_shipping_methods(shop_id, enabled);

-- Index untuk shipping methods lookup
CREATE INDEX idx_shipping_methods_active_courier 
ON shipping_methods(active, courier_code);

-- Composite index untuk checkout queries
CREATE INDEX idx_shipping_checkout 
ON shipping_methods(active, courier_code, service_code);
```

### 3. **API Rate Limiting**

#### Biteship API Management:
```
🔄 API Rate Management:

1. Request Throttling:
   - Implement exponential backoff
   - Retry logic untuk failed requests
   - Circuit breaker pattern

2. Batch Operations:
   - Bulk enable/disable operations
   - Minimize individual API calls
   - Batch rate calculations

3. Error Handling:
   - Graceful degradation saat API down
   - Fallback ke cached rates
   - User-friendly error messages
```

---

## Troubleshooting

### Problem: "No shipping methods available"
**Diagnosis**:
- Check admin sudah sync methods dari Biteship
- Verify shop sudah enable minimal 1 method
- Check shipping_methods.active = true globally
- Verify shop_shipping_methods.enabled = true

**Solution**:
1. Admin: Run `php artisan biteship:sync-shipping`
2. Seller: Enable beberapa shipping methods
3. Check shop address sudah lengkap
4. Verify Biteship API credentials

### Problem: "Shipping cost calculation failed"  
**Diagnosis**:
- Check shop postal code valid
- Verify customer address complete
- Check Biteship API connectivity
- Review method masih available di Biteship

**Solution**:
1. Update shop address dengan postal code valid
2. Test Biteship API connection
3. Re-enable shipping method yang bermasalah
4. Check Biteship service status

### Problem: "Courier toggle not working"
**Diagnosis**:
- Check JavaScript console untuk errors
- Verify CSRF token valid  
- Check user permissions (shop owner)
- Review network connectivity

**Solution**:
1. Refresh page untuk reset CSRF token
2. Check browser developer tools
3. Verify user logged in sebagai shop owner
4. Clear browser cache/cookies

### Problem: "New methods not showing"
**Diagnosis**:
- Check admin sudah sync dari Biteship
- Verify methods active di admin panel
- Check cache invalidation
- Review database constraints

**Solution**:
1. Admin sync shipping methods
2. Clear application cache
3. Verify shipping_methods table updated
4. Check method tidak di-block admin

---

## Security dan Permissions

### 1. **Access Control**
- **Authentication**: User must be logged in
- **Authorization**: User must own the shop
- **KYC Requirement**: Shop must have approved KYC  
- **Shop Status**: Shop must not be suspended

### 2. **Data Validation**
- **Input Sanitization**: All inputs validated dan sanitized
- **Method Existence**: Verify shipping method exists dan active
- **Shop Ownership**: Ensure user can only modify own shop methods
- **Rate Limiting**: Prevent abuse of toggle operations

### 3. **API Security**
- **Biteship API Key**: Securely stored di environment
- **Request Signing**: Proper authorization headers
- **Error Handling**: No sensitive data leakage
- **Audit Trail**: Log important shipping method changes

---

## Monitoring dan Maintenance

### 1. **Health Checks**
```
🩺 System Health Monitoring:

1. Biteship API Status:
   - Monitor API response times
   - Track success/failure rates
   - Alert untuk extended downtime

2. Method Sync Status:  
   - Automated sync schedule
   - Verification sync berhasil
   - Notification untuk sync failures

3. Rate Calculation Performance:
   - Monitor calculation response times
   - Track cache hit/miss rates
   - Alert untuk degraded performance
```

### 2. **Maintenance Tasks**
```
🔧 Regular Maintenance:

1. Daily:
   - Monitor Biteship API health
   - Check error rates dan response times
   - Review customer shipping complaints

2. Weekly:
   - Analyze shipping method usage stats
   - Review popular/unpopular methods
   - Update courier logos jika diperlukan

3. Monthly:
   - Sync new methods dari Biteship  
   - Clean up unused shipping methods
   - Performance optimization review
```

---

## Best Practices untuk Seller

### 1. **Method Selection Strategy**
```
🎯 Selection Best Practices:

1. Customer Coverage:
   ✓ Enable 4-6 courier options minimum
   ✓ Mix premium dan economical options
   ✓ Consider target customer preferences
   ✓ Enable popular couriers (JNE, POS, J&T)

2. Service Types:
   ✓ Regular services untuk standard shipping
   ✓ Express services untuk urgent orders
   ✓ Cargo services untuk heavy items
   ✓ COD services jika customer prefer

3. Geographic Considerations:  
   ✓ Enable couriers dengan coverage baik di area
   ✓ Test shipping ke target customer locations
   ✓ Consider outer area coverage needs
   ✓ Balance cost vs delivery speed
```

### 2. **Regular Review Process**
```
📊 Method Performance Review:

1. Weekly Analysis:
   - Review order data untuk popular methods
   - Check customer complaints terkait shipping
   - Monitor delivery success rates
   - Evaluate cost competitiveness

2. Monthly Optimization:
   - Add/remove methods based pada usage
   - Test new couriers yang available
   - Adjust method selection untuk seasonal needs
   - Update berdasarkan customer feedback

3. Quarterly Strategic Review:
   - Comprehensive shipping cost analysis
   - Customer satisfaction survey results
   - Competitive analysis dengan sellers lain
   - Strategic planning untuk improvement
```

### 3. **Customer Communication**
```
💬 Shipping Communication Tips:

1. Clear Expectations:
   ✓ Inform estimated delivery times
   ✓ Explain shipping cost calculations  
   ✓ Set proper pickup schedule expectations
   ✓ Provide tracking information promptly

2. Proactive Updates:
   ✓ Notify customers tentang shipping delays
   ✓ Update saat ada changes di courier availability
   ✓ Share tracking information actively
   ✓ Follow up pada delivery completion

3. Issue Resolution:
   ✓ Quick response untuk shipping complaints
   ✓ Work dengan courier untuk resolve issues
   ✓ Provide alternative solutions
   ✓ Learn dari problems untuk prevent recurrence
```

---

## Dukungan dan Bantuan

Untuk bantuan terkait shipping methods management:

### 📞 **Support Channels:**
```
📧 Email Shipping: shipping-support@pasarsantri.com
📱 WhatsApp     : +62 812-3456-7890 (Shipping Issues)
💬 Live Chat    : Available di seller dashboard
🌐 Help Center  : help.pasarsantri.com/shipping
🏢 Developer    : PT. Sidogiri Fintech Utama
```

### ⏰ **Jam Operasional:**
```
Shipping Support:
Senin - Jumat  : 08:00 - 17:00 WIB  
Sabtu          : 08:00 - 12:00 WIB
Minggu         : Closed

Biteship Issues:
24/7 untuk critical shipping problems
```

### 📚 **Resources:**
```
📖 Shipping Guide     : docs.pasarsantri.com/seller/shipping  
📹 Video Tutorials    : youtube.com/pasarsantri/shipping
🎯 Best Practices     : help.pasarsantri.com/shipping-tips
❓ FAQ                : faq.pasarsantri.com/shipping
🔧 Troubleshooting    : support.pasarsantri.com/shipping-issues
```

---

## Frequently Asked Questions (FAQ)

### Q: Berapa minimum shipping methods yang harus diaktifkan?
**A**: Minimal 1 method harus aktif agar customer bisa checkout. Namun direkomendasikan 3-5 methods untuk memberikan pilihan yang cukup kepada customer.

### Q: Kenapa shipping method yang sudah diaktifkan tidak muncul di checkout?
**A**: Pastikan: 1) Method masih active di admin panel, 2) Shop address lengkap dengan postal code valid, 3) Biteship API bisa calculate rate untuk destination customer, 4) Method tidak di-disable temporary.

### Q: Bisakah mengaktifkan semua courier sekaligus?
**A**: Ya, bisa menggunakan master toggle di courier card atau enable manual satu per satu. Namun pertimbangkan management complexity dan customer confusion jika terlalu banyak options.

### Q: Bagaimana jika Biteship API down saat customer checkout?
**A**: System akan show error message ke customer dan suggest untuk try again later. Customer bisa contact seller langsung untuk alternative arrangement.

### Q: Apakah bisa custom shipping rate atau hanya dari Biteship?
**A**: Saat ini sistem menggunakan real-time rates dari Biteship. Custom rates tidak supported untuk ensure accuracy dan prevent disputes.

### Q: Bagaimana handle shipping ke luar negeri?
**A**: Biteship fokus ke domestic Indonesia shipping. Untuk international shipping, perlu koordinasi langsung dengan courier atau gunakan shipping partner yang support international.

### Q: Bisakah disable shipping method sementara tanpa hapus permanent?  
**A**: Ya, gunakan toggle switch untuk disable method temporarily. Data tetap tersimpan dan bisa diaktifkan kembali kapan saja tanpa perlu setup ulang.

### Q: Bagaimana monitor performance shipping methods?
**A**: Check seller dashboard analytics untuk data usage per method, customer feedback, dan delivery success rates. Data ini help optimize method selection.

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: September 2025*
