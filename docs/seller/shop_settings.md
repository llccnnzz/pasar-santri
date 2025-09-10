# Pengaturan Toko Seller - Pasar Santri

## Deskripsi
Pengaturan Toko adalah menu yang memungkinkan penjual untuk mengatur dan mengelola seluruh aspek toko online mereka di **Pasar Santri Marketplace**. Menu ini mencakup informasi dasar toko, kontak, lokasi, media sosial, dan status operasional toko.

## Tujuan
- Mengatur profil lengkap toko untuk menarik pembeli
- Mengelola informasi kontak dan lokasi toko
- Mengoptimalkan branding toko dengan logo dan deskripsi
- Mengintegrasikan media sosial untuk jangkauan lebih luas
- Mengelola status operasional dan jam buka toko

## Akses & Persyaratan
**Role Required:** Seller dengan KYC approved  
**Permission:** Akses penuh ke pengaturan toko  
**URL:** `/seller/shop/settings`

---

## Persyaratan Akses Pengaturan Toko

### 1. **KYC Telah Disetujui**
- Status KYC harus **"Disetujui"**
- Tidak dapat mengakses jika KYC masih dalam proses atau ditolak
- Role penjual sudah otomatis diberikan sistem

### 2. **Toko Sudah Dibuat**
- Toko sudah dibuat melalui proses setup awal
- Memiliki ID toko yang valid dalam sistem
- Terdaftar dan aktif di database

### 3. **Status Toko Aktif**
- Toko tidak dalam status ditangguhkan
- Dapat mengakses semua fitur pengaturan
- Tidak ada pembatasan dari administrator

---

## Komponen Pengaturan Toko

### 1. **Informasi Dasar Toko**

#### A. Logo Toko
```
Persyaratan Logo:
✓ Format File: JPEG, PNG, JPG, WebP
✓ Ukuran File: Maksimal 2 MB
✓ Ukuran Gambar: Disarankan 300x300px (kotak)
✓ Kualitas: Resolusi tinggi, gambar jelas
✓ Latar Belakang: Sebaiknya transparan atau warna solid
```

**Tips Logo yang Menarik:**
- **Profesional**: Menggambarkan merek toko Anda
- **Jelas**: Mudah dibaca dan dikenali pembeli
- **Konsisten**: Selaras dengan identitas toko secara keseluruhan
- **Mudah Diingat**: Berkesan dan tidak mudah dilupakan

#### B. Nama Toko
```
Persyaratan Nama Toko:
✓ Wajib diisi (Required field)
✓ Maksimal 255 karakter
✓ Harus unik (tidak boleh sama dengan toko lain)
✓ Dapat menggunakan huruf, angka, spasi, dan simbol
✓ Akan tampil di semua halaman produk
```

**Contoh Nama Toko yang Baik:**
- "Santri Fashion Store"
- "Gadget Center Jakarta"
- "Ibu Sari - Makanan Khas"
- "Berkah Electronics"

#### C. Shop URL Slug
```
🔗 Slug Requirements:
✓ Wajib diisi (Required field)
✓ Maksimal 255 karakter
✓ Harus unik di seluruh platform
✓ Format: lowercase, number, hyphen only
✓ Tidak boleh spasi atau karakter khusus
✓ Akan menjadi URL public toko
```

**Format URL Toko:**
```
https://pasarsantri.com/shop/[your-slug]
```

**Contoh Slug yang Baik:**
- "santri-fashion-store"
- "gadget-center-jakarta"  
- "ibu-sari-makanan"
- "berkah-electronics"

#### D. Shop Description
```
Description Guidelines:
✓ Opsional tapi highly recommended
✓ Maksimal 1.000 karakter
✓ Jelaskan apa yang dijual
✓ Highlight keunggulan toko
✓ Target audience yang jelas
✓ Call-to-action yang menarik
```

**Template Deskripsi:**
```
"[Nama Toko] adalah [jenis bisnis] yang menyediakan [produk utama] 
berkualitas tinggi dengan [keunggulan unik]. Kami melayani [target market] 
dengan [value proposition]. Pengiriman [cakupan area] dan [garansi/after sales]."
```

### 2. **Informasi Kontak**

#### A. Phone Number
```
Phone Requirements:
✓ Opsional tapi recommended
✓ Format internasional: +62xxx
✓ Maksimal 20 karakter
✓ Nomor yang aktif dan dapat dihubungi
✓ Akan ditampilkan di halaman toko
```

**Tips Nomor Telepon:**
- Gunakan **nomor bisnis** yang dedicated
- **Aktif 24/7** atau sesuai jam operasional
- **WhatsApp-enabled** untuk kemudahan customer
- **Jangan nomor personal** untuk privacy

#### B. Shop Status (Buka/Tutup)
```
Status Control:
✓ Toggle switch: Open/Closed
✓ Default: Open (dapat menerima pesanan)
✓ Closed: Customer tidak bisa checkout
✓ Realtime: Efek langsung setelah save
```

**Kapan Menggunakan Status Closed:**
- **Liburan** atau cuti panjang
- **Stok kosong** sementara
- **Maintenance** sistem internal
- **Force majeure** (bencana, dll)

### 3. **Informasi Lokasi Toko**

#### A. Address Fields (Alamat Lengkap)
```
Required Address Fields:
✓ Province (Provinsi) - Dropdown selection
✓ City (Kota/Kabupaten) - Dropdown selection  
✓ Subdistrict (Kecamatan) - Dropdown selection
✓ Village (Kelurahan/Desa) - Dropdown selection
✓ Postal Code (Kode Pos) - 5 digits
✓ Full Address (Alamat Lengkap) - Street, number, RT/RW
```

**Pentingnya Alamat Akurat:**
- **Kalkulasi Ongkir**: Biteship integration
- **Pickup Location**: Untuk courier pickup
- **Customer Trust**: Transparansi lokasi
- **Local SEO**: Visibility untuk pencarian lokal

#### B. Address Hierarchy
```
Indonesia Address System:
Province → City → Subdistrict → Village
Provinsi → Kota → Kecamatan → Kelurahan

Contoh:
DKI Jakarta → Jakarta Selatan → Kebayoran Baru → Senayan
```

**Tips Pengisian Alamat:**
- **Sesuai KTP**: Konsisten dengan data KYC
- **Detail lengkap**: Include RT/RW, nomor rumah
- **Landmark**: Tambahkan patokan jika perlu
- **Accessible**: Pastikan courier bisa akses

### 4. **Social Media Links**

#### A. Supported Platforms
```
Social Media Integration:
✓ Facebook - facebook.com/yourpage
✓ Instagram - instagram.com/youraccount
✓ Twitter - twitter.com/yourhandle  
✓ Website - yourdomain.com
```

#### B. URL Format Requirements
```
URL Guidelines:
✓ Must be valid URL format (https://)
✓ Publicly accessible
✓ Active social media accounts
✓ Professional content recommended
✓ Consistent branding across platforms
```

**Benefits of Social Media Links:**
- **Brand Credibility**: Show authenticity
- **Customer Engagement**: Multi-channel communication  
- **Social Proof**: Reviews and testimonials
- **Marketing Channel**: Drive traffic both ways

---

## Panduan Step-by-Step Update Settings

### Langkah 1: Akses Shop Settings

1. **Login** ke seller dashboard
2. **Pastikan KYC approved** dan toko sudah dibuat
3. Klik menu **"Shop Settings"** di sidebar
4. Halaman settings akan terbuka dengan form lengkap

### Langkah 2: Update Shop Information

#### Upload Logo Toko:
1. **Lihat logo saat ini** (jika sudah ada)
2. **Klik "Choose File"** di bagian Shop Logo
3. **Select image** dari device (max 2MB)
4. **Preview** akan muncul setelah select
5. **Save** untuk apply perubahan

#### Update Nama Toko:
1. **Edit field "Shop Name"**
2. **Pastikan unik** dan representative
3. **Check availability** (system akan validasi)
4. **Hindari nama yang misleading** atau offensive

#### Update URL Slug:
1. **Edit field "Shop URL Slug"**
2. **Format**: lowercase-with-hyphens
3. **Test availability** (harus unique)
4. **Consider SEO**: include relevant keywords

#### Update Deskripsi:
1. **Write compelling description** (max 1000 chars)
2. **Include keywords** untuk SEO
3. **Highlight unique selling points**
4. **Add call-to-action** jika perlu

### Langkah 3: Update Contact Information

#### Phone Number:
```
Format Examples:
✓ +628123456789 (Indonesian mobile)
✓ +622187654321 (Indonesian landline)
✓ +6281234567890 (with country code)
```

#### Shop Status:
- **Toggle switch** untuk buka/tutup toko
- **Open**: Customer bisa order
- **Closed**: Toko tidak menerima pesanan baru

### Langkah 4: Update Location Details

#### Province Selection:
1. **Click dropdown** Province
2. **Select your province** dari list
3. **System akan load** city options

#### City Selection:
1. **Tunggu province** terpilih dulu
2. **Select city/kabupaten** yang sesuai
3. **System akan load** subdistrict options

#### Subdistrict & Village:
1. **Pilih kecamatan** dari dropdown
2. **Pilih kelurahan/desa** dari dropdown
3. **Input postal code** (5 digits)

#### Full Address:
```
Address Format Example:
"Jl. Sudirman No. 123, RT 01/RW 05, 
Kompleks ABC, Lantai 2"
```

### Langkah 5: Add Social Media Links

#### Facebook:
```
📘 Facebook URL Examples:
✓ https://facebook.com/yourbusinesspage
✓ https://fb.me/yourbusiness
✓ https://m.facebook.com/yourbusiness
```

#### Instagram:
```
Instagram URL Examples:
✓ https://instagram.com/yourbusiness
✓ https://www.instagram.com/yourbusiness
```

#### Website:
```
Website URL Examples:
✓ https://yourdomain.com
✓ https://www.yourbusiness.id
✓ https://yourbusiness.wordpress.com
```

### Langkah 6: Save Changes

1. **Review semua data** yang telah diisi
2. **Check for validation errors** (red text)
3. **Scroll to bottom** dan klik **"Save Settings"**
4. **Wait for confirmation** message
5. **Check updated info** di halaman toko public

---

## Validasi dan Error Handling

### 1. **Required Field Validation**
```
Common Validation Errors:
- Shop name is required
- Shop slug is required  
- Province is required
- City is required
- Subdistrict is required
- Village is required
- Postal code is required
- Full address is required
```

### 2. **Unique Field Validation**
```
Uniqueness Errors:
- "This shop name is already taken"
- "This shop slug is already taken"
```

**Solution**: Try variations:
- Add location: "Toko Sari Jakarta"
- Add specialty: "Toko Sari Fashion" 
- Add year: "Toko Sari 2025"

### 3. **Format Validation**
```
Format Errors:
- Invalid URL format (social media)
- Invalid image format (logo)
- File too large (>2MB)
- Invalid postal code format
```

### 4. **Business Logic Validation**
```
Business Rules:
- Cannot change slug if shop has active orders
- Logo changes may take time to reflect
- Address changes affect shipping calculations
- Social media links are validated for accessibility
```

---

## Impact of Shop Settings Changes

### 1. **SEO Impact**
#### Positive Changes:
- **Better shop name**: Improved search ranking
- **Optimized slug**: Better URL structure  
- **Complete description**: Higher relevance score
- **Location data**: Local search visibility

#### Negative Changes:  
- **Frequent slug changes**: Broken external links
- **Missing description**: Lower search ranking
- **Inconsistent branding**: Confused customers

### 2. **Customer Experience Impact**
#### Improvements:
- **Professional logo**: Increased trust
- **Clear description**: Better understanding
- **Contact info**: Easy communication
- **Social proof**: Brand credibility

#### Issues:
- **Closed status**: Lost sales opportunities
- **Wrong address**: Shipping problems  
- **Broken social links**: Poor impression
- **Unclear descriptions**: Customer confusion

### 3. **Operational Impact**
#### Benefits:
- **Accurate address**: Smooth pickup/delivery
- **Updated contact**: Better customer service
- **Proper status**: Managed expectations
- **Complete info**: Professional appearance

#### Risks:
- **Wrong location**: Shipping cost issues
- **Outdated phone**: Missed communications
- **Inconsistent data**: System conflicts
- **Incomplete setup**: Limited functionality

---

## Best Practices

### 1. **Branding Consistency**
```
Brand Guidelines:
✓ Use same logo across all platforms
✓ Consistent color scheme and fonts
✓ Uniform messaging and tone
✓ Aligned social media presence
✓ Professional imagery throughout
```

### 2. **SEO Optimization**
```
SEO Best Practices:
✓ Include relevant keywords in shop name
✓ Optimize slug for search engines
✓ Write keyword-rich descriptions
✓ Use location-based terms
✓ Update content regularly
```

### 3. **Customer Communication**
```
Communication Tips:
✓ Provide multiple contact channels
✓ Set clear expectations for response times
✓ Use professional language
✓ Include business hours information
✓ Enable notifications for inquiries
```

### 4. **Regular Updates**
```
Maintenance Schedule:
✓ Review shop info monthly
✓ Update seasonal promotions
✓ Refresh social media links
✓ Verify contact information
✓ Check address accuracy quarterly
```

---

## Troubleshooting

### Problem: "Cannot save shop settings"
**Diagnosis**:
- Check all required fields filled
- Verify unique constraints (name, slug)
- Check file format and size for logo
- Validate URL formats for social media

**Solution**:
1. Fill all required fields marked with *
2. Try different name/slug if uniqueness error
3. Compress logo image if too large
4. Use proper URL format (https://)

### Problem: "Shop not appearing in search"
**Diagnosis**:
- Check if shop status is "Open"
- Verify location data is complete
- Check if shop is suspended
- Review description for keywords

**Solution**:
1. Set shop status to "Open"
2. Complete all address fields
3. Contact support if suspended
4. Add relevant keywords to description

### Problem: "Shipping costs incorrect"
**Diagnosis**:
- Check address accuracy
- Verify postal code is correct
- Ensure province/city match
- Check Biteship integration

**Solution**:
1. Update address with exact location
2. Verify postal code on Indonesia Post
3. Ensure address hierarchy is correct
4. Contact support for Biteship issues

### Problem: "Customer cannot contact shop"
**Diagnosis**:
- Check phone number format
- Verify number is active
- Check social media link validity
- Ensure contact info is visible

**Solution**:
1. Use proper phone format (+62xxx)
2. Test number availability
3. Verify all social media links work
4. Enable contact visibility in settings

---

## Security dan Privacy

### 1. **Data Protection**
- **Personal Information**: Only necessary data stored
- **Contact Details**: Protected from spam/abuse
- **Location Data**: Used only for shipping/SEO
- **Social Links**: Validated but not stored credentials

### 2. **Privacy Controls**
- **Public Information**: Name, description, location
- **Private Information**: Phone number (buyer only)  
- **Hidden Data**: Internal shop statistics
- **Seller Control**: Can hide/show contact info

### 3. **Security Measures**
- **Input Validation**: All data sanitized
- **File Upload Security**: Image virus scanning
- **URL Validation**: Social media links verified
- **Access Control**: Only shop owner can edit

---

## Integration dengan Sistem Lain

### 1. **Shipping Integration (Biteship)**
- **Pickup Location**: Uses shop address
- **Cost Calculation**: Based on location data
- **Courier Selection**: Available in shop area
- **Tracking**: Shop location for origin

### 2. **Payment System**
- **Shop Info**: Displayed in checkout
- **Receipt**: Shop details included
- **Settlement**: Linked to shop account
- **Reporting**: Shop-based analytics

### 3. **Search & Discovery**
- **SEO**: Shop name and description indexed
- **Local Search**: Location-based results
- **Category**: Shop classification
- **Filtering**: By location, rating, etc.

### 4. **Social Media**
- **Share Buttons**: Link to shop social accounts
- **Verification**: Cross-platform authenticity
- **Marketing**: Social media integration
- **Customer Service**: Multi-channel support

---

## Dukungan dan Bantuan

Untuk bantuan terkait pengaturan toko:

### **Support Channels:**
```
Email Shop : shop-support@pasarsantri.com
WhatsApp   : +62 812-3456-7890
Live Chat  : Available di seller dashboard
Help Center: help.pasarsantri.com/shop-settings
Developer : PT. Sidogiri Fintech Utama
```

### **Jam Operasional:**
```
Shop Settings Support:
Senin - Jumat  : 08:00 - 17:00 WIB  
Sabtu          : 08:00 - 12:00 WIB
Minggu         : Closed

Technical Support:
24/7 untuk masalah urgent
```

### **Resources:**
```
Shop Setup Guide    : docs.pasarsantri.com/seller/shop
Video Tutorials     : youtube.com/pasarsantri/shop
Best Practices      : help.pasarsantri.com/shop-tips
FAQ                : faq.pasarsantri.com/shop-settings
```

---

## Frequently Asked Questions (FAQ)

### Q: Apakah wajib mengisi semua field di shop settings?
**A**: Field yang wajib diisi adalah yang bertanda asterisk (*) merah, termasuk nama toko, slug, dan alamat lengkap. Field lain optional tapi sangat disarankan untuk kelengkapan profil toko.

### Q: Berapa lama perubahan shop settings terlihat di public?
**A**: Perubahan informasi teks (nama, deskripsi) langsung terlihat setelah save. Logo mungkin butuh 5-10 menit untuk update di semua halaman karena caching system.

### Q: Apakah bisa mengubah slug toko setelah ada produk?  
**A**: Ya bisa, tapi tidak disarankan karena akan mengubah URL toko. Link lama akan broken dan bisa affect SEO ranking. Lebih baik set slug yang tepat dari awal.

### Q: Kenapa toko saya tidak muncul di pencarian?
**A**: Pastikan status toko "Open", lengkapi deskripsi dengan keywords yang relevan, dan isi alamat dengan benar. Toko yang suspended atau closed tidak muncul di search results.

### Q: Bisa punya multiple social media account yang sama?
**A**: Satu toko hanya bisa link ke satu account per platform. Jika punya multiple account, pilih yang paling aktif dan representative untuk bisnis.

### Q: Bagaimana jika alamat toko pindah?
**A**: Update alamat di shop settings sesegera mungkin karena mempengaruhi kalkulasi ongkir dan pickup location. Pastikan semua level alamat (provinsi sampai kelurahan) updated.

### Q: Apakah phone number akan terlihat semua orang?
**A**: Nomor telepon hanya terlihat oleh customer yang sudah order atau sedang dalam proses komunikasi. Tidak ditampilkan public di halaman toko.

### Q: Bisa temporarily tutup toko tanpa suspend?
**A**: Ya, gunakan toggle "Shop is Open" di settings. Set ke "Closed" untuk temporary closure, customer tidak bisa checkout tapi bisa lihat produk. Set ke "Open" lagi kapan saja.

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: September 2025*
