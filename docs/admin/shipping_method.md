# 🚚 Shipping Method Management - Admin Pasar Santri

## 📋 Deskripsi
Shipping Method Management adalah modul untuk mengelola semua metode pengiriman yang tersedia di Pasar Santri Marketplace. Sistem ini terintegrasi dengan Biteship API untuk menyediakan berbagai pilihan kurir dan layanan pengiriman dengan kalkulasi ongkir real-time.

## 🎯 Tujuan
- Mengelola daftar kurir dan layanan pengiriman yang tersedia
- Mengintegrasikan kalkulasi ongkir real-time melalui Biteship API
- Mengatur status aktif/non-aktif untuk setiap metode pengiriman
- Memberikan fleksibilitas kepada seller dalam memilih metode pengiriman
- Memastikan pengalaman checkout yang smooth untuk buyer

## 🔐 Akses & Permission
**Role Required:** Administrator  
**Permission:** 
- `admin-dashboard|index shipping method` - Melihat daftar
- `admin-dashboard|show shipping method` - Melihat detail
- `admin-dashboard|update shipping method` - Mengubah status
- `admin-dashboard|create shipping method` - Sync dari API

**URL:** `/admin/shipping-methods`

## 🏗️ Arsitektur System

### **Integrasi Biteship API:**
```
┌─────────────────────────────────────────────────────────────┐
│ PASAR SANTRI MARKETPLACE                                    │
├─────────────────────────────────────────────────────────────┤
│ Admin: Manage Shipping Methods                              │
│ ├─ Sync from Biteship API                                   │
│ ├─ Enable/Disable Couriers                                  │
│ └─ Enable/Disable Services                                  │
├─────────────────────────────────────────────────────────────┤
│ Seller: Select Available Methods                            │
│ ├─ Choose which couriers to support                         │
│ └─ Configure shipping from their location                   │
├─────────────────────────────────────────────────────────────┤
│ Buyer: Real-time Shipping Calculator                        │
│ ├─ Select delivery address                                  │
│ ├─ Get real-time shipping rates                             │
│ └─ Choose preferred shipping option                         │
└─────────────────────────────────────────────────────────────┘
                            ↕ API Integration
┌─────────────────────────────────────────────────────────────┐
│ BITESHIP API SERVICE                                        │
│ ├─ Courier List & Services                                  │
│ ├─ Real-time Rate Calculation                               │
│ ├─ Tracking Integration                                     │
│ └─ Shipping Label Generation                                │
└─────────────────────────────────────────────────────────────┘
```

## 📦 Kurir yang Didukung

Sistem mendukung 19+ kurir utama Indonesia melalui Biteship API:

### **Kurir Nasional:**
1. **JNE** (Jalur Nugraha Ekakurir) - `jne`
2. **J&T Express** - `jnt`  
3. **SiCepat** - `sicepat`
4. **TIKI** (Titipan Kilat) - `tiki`
5. **Pos Indonesia** - `pos`
6. **Wahana** - `wahana`
7. **AnterAja** - `anteraja`
8. **RPX (Raf Perdana Xpress)** - `rpx`
9. **Lion Parcel** - `lion`
10. **ID Express** - `idexpress`

### **Kurir Same-Day/Instant:**
11. **Gojek (GoSend)** - `gojek`
12. **Grab (GrabExpress)** - `grab`
13. **Lalamove** - `lalamove`
14. **Borzo** - `borzo`
15. **Paxel** - `paxel`
16. **Deliveree** - `deliveree`

### **Kurir Kargo:**
17. **SAP Express** - `sap`
18. **Sentral Cargo** - `sentralcargo`
19. **Ninja Express** - `ninja`

## 🛠️ Cara Menggunakan Shipping Method Management

### **Akses Halaman Shipping Methods**
1. Login sebagai Administrator
2. Buka menu **Admin Dashboard**
3. Navigasi ke **Shipping Methods Management**
4. Atau akses langsung: `/admin/shipping-methods`

### **Dashboard Overview**
Halaman menampilkan statistik:
- **Total Methods:** Jumlah semua layanan shipping
- **Active:** Layanan yang sedang aktif
- **Inactive:** Layanan yang dinonaktifkan
- **Total Couriers:** Jumlah kurir yang tersedia

### **Sync dari Biteship API**

#### **Cara Sync Shipping Methods:**
1. Klik tombol **"Sync from API"** di bagian atas halaman
2. Sistem akan mengambil data terbaru dari Biteship
3. Proses sync akan:
   - ✅ **Menambah** kurir/layanan baru yang belum ada
   - ✅ **Update** informasi kurir/layanan yang sudah ada
   - ✅ **Mempertahankan** status aktif/nonaktif yang sudah diset
   - ✅ **Menambahkan** logo kurir secara otomatis

#### **Yang Terjadi Saat Sync:**
- **New Services:** Layanan baru akan ditambahkan dengan status aktif
- **Existing Services:** Info akan diupdate, status tetap sesuai setting
- **Logo Assignment:** Logo kurir ditambahkan otomatis
- **Service Details:** Deskripsi dan nama layanan diperbarui

### **Mengelola Status Kurir**

#### **Toggle Status per Kurir (Bulk):**
1. Temukan kurir yang ingin diubah statusnya
2. Klik switch toggle di samping nama kurir
3. Konfirmasi perubahan
4. **Semua layanan** dari kurir tersebut akan berubah status sekaligus

#### **Toggle Status per Layanan (Individual):**
1. Expand detail kurir dengan klik nama kurir
2. Lihat daftar semua layanan dari kurir tersebut
3. Toggle status untuk layanan spesifik
4. **Hanya layanan tersebut** yang akan berubah status

### **Filter dan Pencarian**

#### **Filter berdasarkan Status:**
- **All:** Tampilkan semua kurir dan layanan
- **Active Only:** Hanya kurir/layanan yang aktif
- **Inactive Only:** Hanya kurir/layanan yang nonaktif

#### **Pencarian:**
- Cari berdasarkan **nama kurir** (contoh: "JNE")
- Cari berdasarkan **kode kurir** (contoh: "jne")
- Cari berdasarkan **nama layanan** (contoh: "REG")
- Cari berdasarkan **kode layanan** (contoh: "reg")

## ⚙️ Detail Teknis

### **Database Structure:**
```sql
shipping_methods table:
- id (UUID, Primary Key)
- courier_code (String) - Kode kurir dari Biteship
- courier_name (String) - Nama kurir
- service_code (String) - Kode layanan
- service_name (String) - Nama layanan  
- description (Text) - Deskripsi layanan
- logo_url (String) - Path ke logo kurir
- active (Boolean) - Status aktif/nonaktif
- created_at, updated_at (Timestamps)
```

### **API Integration:**
- **Endpoint Biteship:** `/couriers` untuk mendapat daftar kurir
- **Authentication:** Menggunakan API key Biteship
- **Response Handling:** Parsing JSON response ke database
- **Error Handling:** Rollback transaction jika ada error

### **Logo Management:**
Sistem otomatis assign logo untuk setiap kurir:
```php
$logos = [
    "jne" => "/assets/imgs/courier-logo/jne.png",
    "jnt" => "/assets/imgs/courier-logo/jnt.png",
    "sicepat" => "/assets/imgs/courier-logo/sicepat.png",
    // ... dan seterusnya
];
```

## 📊 Impact pada System

### **Untuk Seller:**
- Seller bisa memilih kurir mana yang ingin mereka support
- Konfigurasi shipping dari lokasi toko mereka
- Fleksibilitas dalam menentukan metode pengiriman

### **Untuk Buyer:**
- Pilihan kurir yang beragam saat checkout
- Kalkulasi ongkir real-time dan akurat
- Estimasi waktu pengiriman yang tepat
- Tracking integration untuk monitoring paket

### **Untuk Admin:**
- Control penuh atas kurir yang tersedia di marketplace
- Monitoring penggunaan setiap kurir
- Kemudahan sync dengan provider eksternal

## 🎛️ Best Practices

### **Kurir Management:**
1. **Popular Couriers First:** Aktifkan kurir populer seperti JNE, J&T, SiCepat
2. **Regional Coverage:** Pastikan ada kurir untuk semua area Indonesia
3. **Service Mix:** Sediakan mix antara ekonomis, reguler, dan express
4. **Same-day Options:** Aktifkan Gojek/Grab untuk area urban

### **Performance Optimization:**
1. **Regular Sync:** Lakukan sync berkala untuk update layanan terbaru
2. **Monitor Usage:** Track kurir mana yang paling banyak digunakan
3. **Inactive Cleanup:** Nonaktifkan kurir yang jarang digunakan
4. **API Rate Limiting:** Jangan terlalu sering sync untuk menghindari API limit

### **Business Strategy:**
1. **Cost Analysis:** Monitor ongkir vs conversion rate
2. **Customer Preference:** Aktifkan kurir sesuai preferensi customer
3. **Seller Feedback:** Dengar feedback seller tentang performa kurir
4. **Competitive Advantage:** Sediakan opsi shipping yang kompetitif

## ⚠️ Hal Penting yang Perlu Diperhatikan

### **API Dependencies:**
- **Biteship Account:** Pastikan akun Biteship aktif dan memiliki kredit
- **API Key:** Jaga keamanan API key, jangan expose di frontend
- **Rate Limiting:** Biteship memiliki limit API call per hari
- **Downtime:** Jika Biteship down, kalkulasi ongkir akan terganggu

### **Data Consistency:**
- **Sync Frequency:** Jangan terlalu sering sync (max 1x per hari)
- **Status Preservation:** Status aktif/nonaktif akan dipertahankan saat sync
- **Logo Management:** Logo disimpan lokal, tidak depend pada API
- **Service Changes:** Biteship bisa menambah/hapus layanan sewaktu-waktu

### **Performance Impact:**
- **Database Size:** Banyak shipping methods bisa memperlambat query
- **Checkout Speed:** Terlalu banyak opsi bisa memperlambat checkout
- **API Calls:** Rate calculation membutuhkan API call ke Biteship
- **Caching:** Implement caching untuk rate calculation yang sering digunakan

## 🔍 Troubleshooting

### **Problem: Sync from API gagal**
**Possible Causes:**
- API key Biteship tidak valid atau expired
- Koneksi internet bermasalah
- Biteship API sedang maintenance
- Rate limit API tercapai

**Solutions:**
1. Cek API key di konfigurasi sistem
2. Test koneksi ke Biteship manual
3. Coba sync lagi setelah beberapa saat
4. Hubungi support Biteship jika masih error

### **Problem: Ongkir tidak muncul saat checkout**
**Possible Causes:**
- Semua kurir dinonaktifkan
- Seller belum konfigurasi shipping methods
- Address buyer tidak valid atau tidak ter-cover
- API Biteship bermasalah

**Solutions:**
1. Pastikan ada kurir yang aktif
2. Minta seller setup shipping methods
3. Validasi format address buyer
4. Check status Biteship API

### **Problem: Logo kurir tidak muncul**
**Possible Causes:**
- File logo tidak ada di direktori assets
- Path logo salah di database
- File permission bermasalah

**Solutions:**
1. Upload logo ke `/assets/imgs/courier-logo/`
2. Update path logo di array `getCourierLogos()`
3. Check file permission di server
4. Re-sync dari API untuk update logo

### **Problem: Status toggle tidak berfungsi**
**Possible Causes:**
- Permission user tidak cukup
- JavaScript error di frontend
- Database lock atau constraint issue

**Solutions:**
1. Verify permission user di admin panel
2. Check browser console untuk JS error
3. Refresh halaman dan coba lagi
4. Check database connection dan constraints

## 📈 Monitoring & Analytics

### **Key Metrics yang Perlu Dipantau:**
1. **Usage Statistics:** Kurir mana yang paling banyak digunakan
2. **Conversion Impact:** Pengaruh variasi kurir terhadap checkout completion
3. **Cost Analysis:** Average shipping cost vs order value
4. **Performance:** Response time untuk rate calculation
5. **Error Rate:** Berapa sering API call gagal

### **Business Intelligence:**
- **Popular Routes:** Rute pengiriman yang paling sering digunakan
- **Seasonal Trends:** Penggunaan kurir berbeda di musim tertentu
- **Regional Preference:** Preferensi kurir per wilayah
- **Seller Adoption:** Seberapa banyak seller menggunakan kurir tertentu

## 🚀 Future Enhancements

### **Potential Features:**
1. **Auto-disable:** Otomatis nonaktifkan kurir dengan performance buruk
2. **Cost Optimization:** Saran kurir termurah untuk setiap rute
3. **SLA Monitoring:** Track delivery time vs promised time
4. **Bulk Operations:** Activate/deactivate multiple couriers sekaligus
5. **Regional Settings:** Different courier availability per region

### **Integration Possibilities:**
- **Multiple Providers:** Integrasi dengan provider lain selain Biteship
- **Direct API:** Integrasi langsung dengan kurir besar
- **Warehouse Management:** Integrasi dengan sistem gudang
- **Analytics Platform:** Export data ke Google Analytics atau lainnya

---

## 📞 Support & Bantuan

Jika mengalami kesulitan dalam menggunakan Shipping Method Management:

1. **Technical Issues:** Hubungi tim development PT. Sidogiri Fintech Utama
2. **Biteship API Issues:** Hubungi support Biteship langsung
3. **Business Logic:** Konsultasi dengan operations team
4. **Seller Training:** Provide training untuk seller setup shipping
5. **General Support:** Kontak support Pasar Santri Marketplace

### **Emergency Contacts:**
- **System Down:** Immediate escalation ke tech lead
- **API Issues:** Backup plan dengan manual rate calculation
- **Business Impact:** Inform business stakeholders

**Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**API Partner:** Biteship Indonesia  
**Last Updated:** September 2025  
**Version:** 1.0
