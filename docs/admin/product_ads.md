# 🎯 Product Ads Management - Admin Pasar Santri

## 📋 Deskripsi
Product Ads Management adalah modul untuk mengelola iklan produk yang ditampilkan di berbagai section khusus dalam Pasar Santri Marketplace. Sistem ini memungkinkan admin untuk mempromosikan produk-produk pilihan dengan berbagai kategori promosi seperti Flash Sale, Hot Promo, Big Discount, dan lainnya.

## 🎯 Tujuan
- Meningkatkan visibilitas produk-produk tertentu di marketplace
- Mengelola berbagai jenis promosi dan kampanye marketing
- Mengoptimalkan conversion rate melalui penempatan strategis
- Memberikan exposure lebih kepada produk berkualitas
- Mengelola flash sale dan promosi terbatas waktu

## 🔐 Akses & Permission
**Role Required:** Administrator  
**Permission:** 
- `admin-dashboard|index ads` - Melihat daftar product ads
- `admin-dashboard|show ads` - Melihat detail product ads  
- `admin-dashboard|create ads` - Membuat product ads baru
- `admin-dashboard|update ads` - Edit dan bulk actions

**URL:** `/admin/ads`

## 🏗️ Struktur Product Ads System

### **Layout Product Ads di Homepage:**
```
┌─────────────────────────────────────────────────────────────┐
│ PASAR SANTRI HOMEPAGE                                       │
├─────────────────────────────────────────────────────────────┤
│ 🔥 FLASH SALE SECTION (Time-limited)                        │
│ ├─ Valid Until: Countdown timer                             │
│ ├─ Special pricing & urgency                                │
│ └─ Maximum visibility placement                             │
├─────────────────────────────────────────────────────────────┤
│ 🔥 HOT PROMO SECTION (Featured promotions)                  │
│ ├─ Sort Order: Custom positioning                           │
│ ├─ Premium placement for trending items                     │
│ └─ High conversion focus                                    │
├─────────────────────────────────────────────────────────────┤
│ 💰 BIG DISCOUNT SECTION (High discount items)               │
│ ├─ Auto-suggest: >40% discount products                     │
│ ├─ Price comparison display                                 │
│ └─ Value proposition highlighting                           │
├─────────────────────────────────────────────────────────────┤
│ ✨ NEW PRODUCT SECTION (Recently added items)               │
│ ├─ Auto-suggest: <7 days old products                       │
│ ├─ Fresh inventory showcase                                 │
│ └─ Innovation & trends focus                                │
├─────────────────────────────────────────────────────────────┤
│ 💸 LESS THAN 10K SECTION (Budget-friendly)                  │
│ ├─ Auto-suggest: <Rp50,000 products                         │
│ ├─ Accessibility & affordability                            │
│ └─ Volume sales strategy                                    │
└─────────────────────────────────────────────────────────────┘
```

## 📂 Kategori Product Ads

### 1. **Flash Sale** ⚡
**Karakteristik:**
- **Time-Limited:** Wajib ada tanggal expired (`valid_until`)  
- **Urgency Factor:** Countdown timer untuk menciptakan urgency
- **Premium Placement:** Posisi paling atas dan mencolok
- **High Impact:** Focus pada conversion tinggi

**Use Cases:**
- Limited time offers (24 jam, 3 hari, weekend, dll)
- Clearance sale untuk inventory lama
- Special event promotions (Ramadan, Lebaran, dll)
- Product launch dengan early bird pricing

**Requirements:**
- ✅ Valid until date wajib diisi
- ✅ Produk harus aktif dan tersedia
- ✅ Harga khusus biasanya diperlukan

### 2. **Hot Promo** 🔥  
**Karakteristik:**
- **Custom Positioning:** Menggunakan `sort_order` untuk mengatur urutan
- **Strategic Placement:** Posisi dapat disesuaikan berdasarkan prioritas
- **Flexible Duration:** Tidak wajib ada expired date
- **High Visibility:** Section dengan traffic tinggi

**Use Cases:**
- Trending products yang sedang populer
- Seasonal promotions (back to school, holiday, dll)
- Brand partnership campaigns
- Cross-selling strategic products

**Requirements:**
- ✅ Sort order untuk mengatur prioritas tampil
- ✅ Produk berkualitas dengan rating tinggi
- ✅ Stock availability yang cukup

### 3. **Big Discount** 💰
**Karakteristik:**
- **Auto-Suggest Feature:** Sistem otomatis suggest produk dengan diskon >40%
- **Value Proposition:** Focus pada penghematan maksimal
- **Price Comparison:** Tampilkan harga asli vs harga diskon
- **Deal Hunter Target:** Menarik pembeli yang mencari value terbaik

**Auto-Suggest Criteria:**
- Diskon minimal 40% dari harga asli
- Produk aktif dan tersedia
- Belum ada di kategori Big Discount lainnya

**Use Cases:**
- End of season clearance
- Overstocked inventory liquidation
- Competitive pricing campaigns
- Customer acquisition dengan value proposition

### 4. **New Product** ✨
**Karakteristik:**
- **Auto-Suggest Feature:** Produk yang dibuat <7 hari yang lalu
- **Innovation Focus:** Highlight produk dan trend terbaru
- **Discovery Platform:** Help customer menemukan item baru
- **Seller Support:** Bantu seller baru mendapat exposure

**Auto-Suggest Criteria:**
- Produk dibuat dalam 7 hari terakhir
- Status aktif dan ready to sell
- Belum ada di kategori New Product

**Use Cases:**
- Product launch campaigns  
- New seller onboarding support
- Trend showcasing
- Innovation highlighting

### 5. **Less Than 10K** 💸
**Karakteristik:**
- **Auto-Suggest Feature:** Produk dengan harga <Rp50,000
- **Accessibility Focus:** Produk terjangkau untuk semua kalangan
- **Volume Strategy:** Focus pada quantity over margin
- **Budget-Friendly:** Menarik customer dengan budget terbatas

**Auto-Suggest Criteria:**
- Final price kurang dari Rp50,000
- Produk aktif dan tersedia
- Belum ada di kategori Less Than 10K

**Use Cases:**
- Student-friendly products
- Bulk purchase items
- Daily necessities
- Gift items dengan budget rendah

## 🛠️ Cara Menggunakan Product Ads Management

### **Akses Halaman Product Ads**
1. Login sebagai Administrator
2. Buka menu **Admin Dashboard**
3. Navigasi ke **Product Ads Management**
4. Atau akses langsung: `/admin/ads`

### **Dashboard Overview dengan Tabs**
Dashboard menggunakan tab system untuk setiap kategori:
- **Flash Sale Tab:** Menampilkan semua flash sale ads
- **Hot Promo Tab:** Menampilkan hot promo ads
- **Big Discount Tab:** Menampilkan big discount ads + auto-suggestions
- **New Product Tab:** Menampilkan new product ads + auto-suggestions  
- **Less Than 10K Tab:** Menampilkan budget-friendly ads + auto-suggestions

**Statistics per Tab:**
- **Total:** Jumlah ads dalam kategori tersebut
- **Active:** Ads yang sedang aktif dan ditampilkan

### **Filter & Pencarian**

#### **Status Filter:**
- **All:** Tampilkan semua ads (active + inactive)
- **Active:** Hanya ads yang aktif
- **Inactive:** Hanya ads yang dinonaktifkan

#### **Search Function:**
- **Product Name:** Cari berdasarkan nama produk
- **SKU:** Cari berdasarkan SKU produk
- **Real-time Search:** Results update saat mengetik

### **Membuat Product Ads Baru**

#### **Manual Selection:**
1. Klik **"Add New Product Ad"**
2. Pilih **kategori** ads yang diinginkan
3. Pilih **produk** dari dropdown/search
4. Isi **detail konfigurasi:**
   - **Sort Order** (untuk Hot Promo)
   - **Valid Until** (wajib untuk Flash Sale)
   - **Admin Notes** (optional)
5. Set status **Active/Inactive**
6. Pilih **Submission Type:** Manual
7. Klik **"Create Product Ad"**

#### **Auto-Suggest Selection (Big Discount, New Product, Less Than 10K):**
1. Pilih kategori yang memiliki auto-suggest
2. Lihat daftar **"Suggested Products"**
3. Sistem menampilkan produk yang memenuhi criteria
4. Pilih produk dari suggestions
5. Atur konfigurasi dan simpan
6. Submission Type otomatis: Auto Suggest

### **Edit Product Ads**

#### **Individual Edit:**
1. Klik **"Edit"** pada product ad yang diinginkan
2. Update informasi:
   - **Ganti produk** (jika diperlukan)
   - **Update sort order**
   - **Extend/modify valid until**
   - **Edit admin notes**
3. Toggle **active/inactive status**
4. Simpan perubahan

#### **Quick Actions:**
- **Toggle Status:** Klik switch untuk active/inactive
- **Delete:** Klik tombol delete dengan konfirmasi
- **View Details:** Lihat informasi lengkap produk

### **Bulk Actions**

#### **Multi-Select Operations:**
1. Centang **checkbox** pada ads yang ingin dikelola
2. Klik **"Bulk Actions"**
3. Pilih action:
   - **Activate:** Aktifkan semua selected ads
   - **Deactivate:** Nonaktifkan semua selected ads
   - **Delete:** Hapus semua selected ads
4. Tambahkan **admin notes** (optional)
5. Konfirmasi bulk action

#### **Bulk Action Use Cases:**
- **Seasonal Campaign End:** Deactivate semua flash sale yang expired
- **Category Refresh:** Delete old ads untuk refresh content
- **Emergency Response:** Quick deactivate jika ada masalah produk
- **Campaign Launch:** Activate multiple ads untuk campaign besar

## ⚙️ Detail Konfigurasi

### **Sort Order (Hot Promo):**
- **Purpose:** Mengatur urutan tampil dalam section
- **Range:** 0-999 (angka kecil tampil lebih dulu)
- **Strategy:** 
  - 1-10: Premium/priority products
  - 11-50: Regular featured products  
  - 51-100: Supporting products
  - 100+: Filler products

### **Valid Until (Flash Sale):**
- **Format:** Date and time picker
- **Requirement:** Must be future date/time
- **Impact:** Auto-deactivate setelah expired
- **Display:** Countdown timer di frontend
- **Strategy:**
  - Short: 1-6 jam (high urgency)
  - Medium: 1-3 hari (weekend deals)
  - Long: 1 minggu (seasonal campaigns)

### **Submission Type:**
- **Manual:** Admin manually pilih produk
- **Auto Suggest:** Dipilih dari system suggestions
- **Tracking:** Untuk analytics dan performance review
- **Strategy:** Balance antara manual curation dan auto-optimization

### **Admin Notes:**
- **Purpose:** Internal documentation dan reasoning
- **Max Length:** 1000 characters
- **Use Cases:**
  - Campaign details dan objectives  
  - Special instructions untuk team
  - Performance notes dan observations
  - Vendor/seller coordination notes

## 📊 Auto-Suggest Intelligence

### **Big Discount Algorithm:**
```sql
SELECT products WHERE:
- status = 'active'
- ((price - final_price) / price * 100) > 40
- final_price > 0
- NOT IN current big_discount ads
ORDER BY discount_percentage DESC
```

### **New Product Algorithm:**
```sql
SELECT products WHERE:
- status = 'active'  
- created_at > (NOW() - INTERVAL '7 days')
- NOT IN current new_product ads
ORDER BY created_at DESC
```

### **Less Than 10K Algorithm:**
```sql  
SELECT products WHERE:
- status = 'active'
- final_price > 0
- final_price < 50000
- NOT IN current less_than_10k ads
ORDER BY final_price ASC
```

### **Smart Exclusion:**
- Products sudah ada di kategori yang sama tidak muncul di suggestions
- Inactive products otomatis diexclude
- Out of stock products tidak dimasukkan
- Duplicate prevention across categories

## 📈 Performance Analytics

### **Key Metrics per Category:**
1. **Click-Through Rate (CTR):** Berapa banyak yang klik dari impression
2. **Conversion Rate:** Berapa yang beli dari yang klik
3. **Revenue Attribution:** Total sales dari each category
4. **Product Performance:** Which products perform best in each slot
5. **Time-based Analysis:** Peak performance hours/days

### **A/B Testing Opportunities:**
- **Position Testing:** Compare performance based on sort_order
- **Duration Testing:** Optimal flash sale duration
- **Category Mix:** Best combination of categories
- **Auto vs Manual:** Performance comparison submission types

### **ROI Analysis:**
- **Admin Time Investment:** Manual curation vs auto-suggest efficiency
- **Sales Lift:** Revenue increase from featured placement  
- **Customer Engagement:** Repeat visits dan brand awareness
- **Seller Satisfaction:** Impact pada seller performance

## ⚠️ Best Practices & Guidelines

### **Content Quality Standards:**
1. **Product Selection:**
   - Pilih produk berkualitas dengan rating tinggi
   - Pastikan stock availability yang cukup
   - Avoid controversial atau problematic products
   - Balance antara price points dan categories

2. **Visual Appeal:**
   - Produk harus punya foto berkualitas tinggi
   - Consistent branding dan presentation
   - Clear product information dan descriptions
   - Attractive pricing displays

3. **Strategic Timing:**
   - **Flash Sale:** Launch during peak hours
   - **New Products:** Promote during discovery times
   - **Big Discounts:** Weekend dan payday periods
   - **Budget Items:** End of month targeting

### **Category Balance:**
- **Premium vs Budget:** Balance high-end dan affordable items  
- **Variety:** Diverse product categories dan brands
- **Seasonal Relevance:** Adjust based on calendar events
- **Trend Alignment:** Include trending dan popular items

### **Performance Optimization:**
- **Regular Refresh:** Update content weekly/bi-weekly
- **Data-Driven Decisions:** Use analytics untuk selection
- **Customer Feedback:** Monitor reviews dan complaints
- **Seller Collaboration:** Work dengan top performing sellers

## 🔍 Troubleshooting

### **Problem: Auto-suggestions tidak muncul**
**Possible Causes:**
- Tidak ada produk yang memenuhi criteria
- Semua eligible products sudah ada di ads
- Database query issues
- Category criteria terlalu strict

**Solutions:**
1. Review dan adjust criteria thresholds
2. Clear existing ads untuk free up products
3. Check database dan query performance  
4. Expand criteria range (e.g., 30% instead of 40%)

### **Problem: Flash sale tidak expired otomatis**
**Possible Causes:**
- Cron job tidak running
- Timezone configuration issues
- Database timestamp problems
- Cache issues

**Solutions:**
1. Check server cron job configuration
2. Verify timezone settings
3. Manual cleanup expired ads
4. Clear application cache

### **Problem: Bulk actions gagal**
**Possible Causes:**
- Too many selected items
- Database timeout  
- Permission issues
- Concurrent modifications

**Solutions:**
1. Reduce jumlah selected items per batch
2. Increase database timeout settings
3. Verify admin permissions
4. Retry dengan smaller batches

### **Problem: Product tidak muncul di homepage**
**Possible Causes:**
- Ad status inactive
- Flash sale expired
- Product status changed to inactive
- Cache tidak updated

**Solutions:**
1. Verify ad status active
2. Check flash sale validity
3. Confirm product still active
4. Clear frontend cache

## 🚀 Advanced Features & Tips

### **Strategic Campaign Management:**
1. **Cross-Category Coordination:** Plan campaigns across multiple categories
2. **Seasonal Campaigns:** Prepare content untuk major events
3. **Vendor Partnerships:** Collaborate dengan sellers untuk exclusive deals
4. **Competitive Analysis:** Monitor competitor promotions dan adjust accordingly

### **Performance Optimization:**
1. **Load Testing:** Monitor homepage performance dengan many ads
2. **Image Optimization:** Ensure fast loading product images
3. **Mobile Optimization:** Test appearance pada mobile devices
4. **SEO Benefits:** Leverage featured products untuk search ranking

### **Future Enhancements:**
1. **Personalization:** Show different ads based on user behavior
2. **Geographic Targeting:** Location-based ad customization
3. **Time-based Rules:** Auto-scheduling untuk campaigns
4. **AI Recommendations:** Machine learning untuk product selection

---

## 📞 Support & Bantuan

Jika mengalami kesulitan dalam menggunakan Product Ads Management:

1. **Technical Issues:** Hubungi tim development PT. Sidogiri Fintech Utama
2. **Marketing Strategy:** Konsultasi dengan marketing team
3. **Performance Questions:** Hubungi analytics team
4. **Seller Coordination:** Work dengan seller success team
5. **General Support:** Kontak support Pasar Santri Marketplace

### **Best Contact untuk Specific Issues:**
- **Algorithm Questions:** Data science team
- **UI/UX Issues:** Frontend development team
- **Database Performance:** Backend development team
- **Business Strategy:** Marketing dan business development team

**Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**Focus:** Product Promotion & Marketing Excellence  
**Last Updated:** September 2025  
**Version:** 1.0
