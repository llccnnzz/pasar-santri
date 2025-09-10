#  Service Fee Management - Admin Pasar Santri

## Deskripsi
Service Fee Management adalah modul untuk mengatur biaya layanan/fee yang dikenakan pada setiap transaksi pembayaran di Pasar Santri Marketplace. Admin dapat mengonfigurasi berbagai jenis fee dan parameter perhitungan fee secara fleksibel.

## Tujuan
- Mengatur biaya layanan yang dikenakan kepada seller atau buyer
- Menentukan metode perhitungan fee (persentase atau tetap)
- Mengonfigurasi batas minimum dan maksimum fee
- Mengelola struktur biaya marketplace secara terpusat

## Akses & Permission
**Role Required:** Administrator  
**Permission:** `admin-dashboard|index service fee`, `admin-dashboard|update service fee`  
**URL:** `/admin/service-fees`

## Jenis Konfigurasi Service Fee

### 1. **Payment Fee Type** (Jenis Fee Pembayaran)
Menentukan metode perhitungan fee pembayaran.

**Opsi yang tersedia:**
- **Percent** - Fee dihitung berdasarkan persentase dari total transaksi
- **Fixed** - Fee dihitung dengan jumlah tetap

### 2. **Payment Fee Percent** (Persentase Fee)
Persentase yang dikenakan jika menggunakan jenis "Percent".

**Konfigurasi:**
- **Range:** 0% - 100%
- **Step:** 0.01%
- **Default:** 2%
- **Contoh:** Jika diset 2.5%, maka transaksi IDR 100.000 akan dikenakan fee IDR 2.500

### 3. **Payment Fee Percent Min Value** (Minimum Fee)
Jumlah minimum fee yang dikenakan ketika menggunakan perhitungan persentase.

**Konfigurasi:**
- **Mata Uang:** IDR
- **Minimum:** 0
- **Step:** 100
- **Default:** IDR 2.000
- **Contoh:** Jika fee 2% dari IDR 50.000 = IDR 1.000, tapi minimum IDR 2.000, maka yang dikenakan adalah IDR 2.000

### 4. **Payment Fee Percent Max Value** (Maksimum Fee)
Jumlah maksimum fee yang dikenakan ketika menggunakan perhitungan persentase.

**Konfigurasi:**
- **Mata Uang:** IDR
- **Minimum:** 0
- **Step:** 100
- **Default:** Tidak terbatas (kosong)
- **Optional:** Ya, boleh dikosongkan untuk tidak ada batas maksimum
- **Contoh:** Jika fee 2% dari IDR 10.000.000 = IDR 200.000, tapi maksimum IDR 100.000, maka yang dikenakan adalah IDR 100.000

### 5. **Payment Fee Fixed** (Fee Tetap)
Jumlah fee tetap yang dikenakan jika menggunakan jenis "Fixed".

**Konfigurasi:**
- **Mata Uang:** IDR
- **Minimum:** 0
- **Step:** 100
- **Default:** IDR 2.500
- **Contoh:** Setiap transaksi akan dikenakan fee IDR 2.500 terlepas dari nominal transaksi

## Cara Menggunakan

### **Akses Halaman Service Fee**
1. Login sebagai Administrator
2. Buka menu **Admin Dashboard**
3. Navigasi ke **Service Fees Management**
4. Atau akses langsung: `/admin/service-fees`

### **Melihat Konfigurasi Saat Ini**
Halaman akan menampilkan:
- **Current Fee Type:** Jenis fee yang sedang aktif
- **Percentage Rate:** Persentase yang berlaku
- **Fixed Amount:** Jumlah tetap yang berlaku
- **Detail Configuration:** Form untuk mengubah setiap parameter

### **Mengubah Konfigurasi Fee**

#### **Metode 1: Mengubah Jenis Fee**
1. Cari field **"Fee Type"**
2. Pilih antara:
   - **Percentage** - Untuk menggunakan perhitungan persentase
   - **Fixed Amount** - Untuk menggunakan jumlah tetap
3. Klik **Update** untuk menyimpan

#### **Metode 2: Mengatur Fee Persentase**
1. Pastikan Fee Type sudah diset ke **"Percentage"**
2. Atur **"Fee Percentage"** (contoh: 2.5 untuk 2.5%)
3. Atur **"Minimum Fee Amount"** (contoh: 2000 untuk IDR 2.000)
4. Atur **"Maximum Fee Amount"** (opsional, kosongkan jika tidak ada batas)
5. Klik **Update** untuk setiap field yang diubah

#### **Metode 3: Mengatur Fee Tetap**
1. Pastikan Fee Type sudah diset ke **"Fixed Amount"**
2. Atur **"Fixed Fee Amount"** (contoh: 2500 untuk IDR 2.500)
3. Klik **Update** untuk menyimpan

## Contoh Skenario Perhitungan

### **Skenario 1: Fee Persentase dengan Min/Max**
**Konfigurasi:**
- Fee Type: Percent
- Fee Percentage: 2%
- Min Value: IDR 2.000
- Max Value: IDR 50.000

**Perhitungan:**
- Transaksi IDR 50.000 → Fee 2% = IDR 1.000 → Minimum IDR 2.000 → **Fee Final: IDR 2.000**
- Transaksi IDR 1.000.000 → Fee 2% = IDR 20.000 → **Fee Final: IDR 20.000**
- Transaksi IDR 5.000.000 → Fee 2% = IDR 100.000 → Maksimum IDR 50.000 → **Fee Final: IDR 50.000**

### **Skenario 2: Fee Tetap**
**Konfigurasi:**
- Fee Type: Fixed
- Fixed Amount: IDR 2.500

**Perhitungan:**
- Transaksi IDR 50.000 → **Fee Final: IDR 2.500**
- Transaksi IDR 1.000.000 → **Fee Final: IDR 2.500**
- Transaksi IDR 5.000.000 → **Fee Final: IDR 2.500**

## Hal Penting yang Perlu Diperhatikan

### **Best Practices:**
1. **Testing:** Selalu test konfigurasi fee dengan transaksi kecil terlebih dahulu
2. **Communication:** Informasikan perubahan fee kepada sellers sebelum implementasi
3. **Monitoring:** Monitor impact terhadap volume transaksi setelah perubahan fee
4. **Backup:** Catat konfigurasi lama sebelum melakukan perubahan

### **Batasan Sistem:**
- Fee hanya berlaku untuk transaksi baru setelah konfigurasi disimpan
- Transaksi yang sudah selesai tidak akan terpengaruh perubahan fee
- Maximum value boleh dikosongkan untuk unlimited
- Semua nilai fee harus dalam format mata uang IDR

### **Validasi Input:**
- Fee Percentage: 0-100%
- Minimum Value: ≥ 0
- Maximum Value: ≥ 0 (atau kosong)
- Fixed Amount: ≥ 0

## Troubleshooting

### **Problem: Fee tidak terapply pada transaksi**
**Solution:**
1. Pastikan konfigurasi sudah disimpan dengan benar
2. Cek apakah transaksi dibuat setelah konfigurasi diubah
3. Verify bahwa tidak ada cache yang mengganggu

### **Problem: Error saat update konfigurasi**
**Solution:**
1. Pastikan nilai yang dimasukkan sesuai format (angka)
2. Cek koneksi database
3. Verify bahwa user memiliki permission yang sesuai

### **Problem: Fee terlalu tinggi/rendah**
**Solution:**
1. Review kembali formula perhitungan
2. Adjust minimum dan maximum values
3. Consider impact terhadap competitiveness marketplace

## Monitoring & Analytics

### **Metrics yang Perlu Dipantau:**
- Total revenue dari service fees
- Average fee per transaction
- Impact terhadap conversion rate
- Seller satisfaction terkait fee structure

### **Reporting:**
- Monthly fee collection report
- Fee percentage analysis
- Transaction volume vs fee changes correlation

---

## Support & Bantuan

Jika mengalami kesulitan dalam menggunakan Service Fee Management:

1. **Technical Issues:** Hubungi tim development PT. Sidogiri Fintech Utama
2. **Business Logic:** Konsultasi dengan finance team
3. **User Training:** Tersedia training session untuk admin baru
4. **General Support:** Kontak support Pasar Santri Marketplace

**Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**Last Updated:** September 2025  
**Version:** 1.0
