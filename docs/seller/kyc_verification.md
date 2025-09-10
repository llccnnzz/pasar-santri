# 🔐 Verifikasi KYC Seller - Pasar Santri

## 📋 Deskripsi
Sistem **KYC (Know Your Customer)** adalah proses verifikasi identitas yang **WAJIB** dilakukan oleh setiap penjual untuk dapat berjualan di **Pasar Santri Marketplace**. Proses ini memastikan keamanan platform dan melindungi pembeli dari penjual yang tidak terverifikasi.

## 🎯 Tujuan
- Memverifikasi identitas dan kredibilitas calon penjual
- Memastikan kepatuhan terhadap regulasi perdagangan elektronik
- Mencegah penipuan dan aktivitas ilegal di marketplace
- Memberikan kepercayaan kepada pembeli terhadap penjual terverifikasi
- Melindungi semua pihak dalam transaksi jual-beli

## 🔐 Akses & Persyaratan
**Role Required:** User terdaftar (akan upgrade ke Seller setelah KYC approved)  
**Permission:** Akses terbuka untuk semua user terdaftar  
**URL:** `/seller/kyc`

---

## ⭐ Manfaat Verifikasi KYC

### 1. **Keamanan Platform**
- Memastikan hanya penjual terverifikasi yang dapat berjualan
- Mengurangi risiko penipuan dan aktivitas mencurigakan
- Melindungi data dan transaksi pembeli
- Memenuhi regulasi perdagangan elektronik Indonesia

### 2. **Keuntungan Penjual Terverifikasi**
- **Lencana Terverifikasi**: Mendapat lencana "Penjual Terverifikasi"
- **Akses Lengkap**: Dapat menggunakan semua fitur penjualan
- **Kepercayaan Pembeli**: Meningkatkan tingkat pembelian
- **Dukungan Prioritas**: Mendapat bantuan lebih cepat
- **Penarikan Dana**: Dapat menarik hasil penjualan

### 3. **Risiko Tanpa Verifikasi KYC**
- **Tidak bisa berjualan**: Akses toko sangat terbatas
- **Tidak bisa menarik dana**: Saldo tidak dapat dicairkan
- **Fitur terbatas**: Hanya bisa melihat dasbor
- **Toko tersembunyi**: Tidak muncul dalam pencarian

---

## 📋 Persyaratan Verifikasi KYC

### 1. **Informasi Pribadi yang Diperlukan**

#### A. Data Diri Utama
- **Nama Lengkap**: Harus sama persis dengan dokumen identitas
- **Tanggal Lahir**: Format Tanggal/Bulan/Tahun (DD/MM/YYYY)
- **Jenis Kelamin**: Pilih Laki-laki, Perempuan, atau Lainnya
- **Kewarganegaraan**: Warga Negara Indonesia (WNI) atau Warga Negara Asing (WNA)

#### B. Alamat Tempat Tinggal
- **Alamat Lengkap**: Jalan, nomor rumah, RT/RW
- **Provinsi**: Pilih dari daftar yang tersedia
- **Kota/Kabupaten**: Pilih sesuai provinsi
- **Kecamatan**: Pilih sesuai kota/kabupaten
- **Kelurahan/Desa**: Pilih sesuai kecamatan
- **Kode Pos**: 5 angka kode pos area Anda
- **Negara**: Indonesia (sudah otomatis)
- **Nomor Telepon**: Nomor yang aktif dan bisa dihubungi

### 2. **Dokumen yang Wajib Diunggah**

#### Dokumen Identitas (Pilih Salah Satu):
```
🆔 KTP (Kartu Tanda Penduduk)    - Recommended
🛂 Passport (Paspor)             - Untuk WNA  
🚗 SIM (Surat Izin Mengemudi)    - Alternative
```

#### File Requirements:
- **Format**: JPEG, PNG, JPG, WebP
- **Ukuran Maksimal**: 5 MB per file
- **Kualitas**: Jelas, tidak blur, semua text terbaca
- **Pencahayaan**: Cukup terang, tidak gelap/overexposed

### 3. **Foto yang Diperlukan**

#### A. Foto Sisi Depan Dokumen:
- **Seluruh dokumen terlihat**: Semua sudut dan edge
- **Text jelas terbaca**: Nama, nomor, alamat
- **Tidak ada pantulan cahaya**: Flash tidak menutupi text
- **Background kontras**: Letakkan di permukaan gelap/terang

#### B. Foto Selfie dengan Dokumen:
- **Wajah jelas terlihat**: Tidak tertutup masker/kacamata
- **Dokumen di samping wajah**: Pegang dokumen di samping kepala
- **Pencahayaan cukup**: Wajah dan dokumen sama-sama terang
- **Fokus tajam**: Tidak blur atau goyang

#### C. Dokumen Tambahan (Opsional):
- **NPWP**: Untuk seller dengan volume tinggi
- **SIUP/NIB**: Untuk seller berbadan hukum
- **Surat Keterangan**: Dokumen pendukung lainnya
- **Format**: JPEG, PNG, JPG, WebP, PDF
- **Ukuran Maksimal**: 10 MB per file

---

## Status Aplikasi KYC

### 1. 🟡 **Pending** (Menunggu Review)
**Deskripsi**: Aplikasi KYC telah disubmit dan menunggu review admin

**Timeline**: 3-5 hari kerja  
**Yang Bisa Dilakukan**:
- ✅ Melihat status aplikasi
- ✅ Mengakses dashboard seller (terbatas)
- ❌ Tidak bisa berjualan
- ❌ Tidak bisa withdraw saldo

**Informasi Ditampilkan**:
- Tanggal submit aplikasi
- Estimasi waktu review
- Checklist dokumen yang sudah diupload
- Status "Under Review" notification

### 2. 🔵 **Under Review** (Sedang Direview)
**Deskripsi**: Admin sedang memeriksa dokumen yang disubmit

**Timeline**: 1-3 hari kerja  
**Yang Bisa Dilakukan**:
- ✅ Monitoring status real-time
- ✅ Menunggu hasil review
- ❌ Tidak bisa edit aplikasi
- ❌ Masih belum bisa berjualan

**Informasi Ditampilkan**:
- Progress review (30%, 60%, 90%)
- Estimasi completion time
- Contact support jika urgent

### 3. ✅ **Approved** (Disetujui)
**Deskripsi**: KYC berhasil diverifikasi, seller dapat mulai berjualan

**Yang Bisa Dilakukan**:
- ✅ **Full access** semua fitur seller
- ✅ Berjualan dan upload produk
- ✅ Withdraw saldo penjualan
- ✅ Mendapat badge "Verified Seller"
- ✅ Akses ke semua menu dan fitur

**Benefit yang Didapat**:
```
🏪 Setup Toko Complete     ✓
📦 Upload Produk Unlimited ✓  
💰 Withdraw Saldo         ✓
📊 Analytics Advanced     ✓
🎯 Product Ads           ✓
🚚 Shipping Integration  ✓
💬 Customer Chat         ✓
⭐ Review Management     ✓
```

### 4. ❌ **Rejected** (Ditolak)
**Deskripsi**: Dokumen tidak memenuhi syarat dan perlu diperbaiki

**Alasan Umum Penolakan**:
- Dokumen tidak jelas/blur
- Informasi tidak sesuai/tidak lengkap
- Foto selfie tidak sesuai standar
- Dokumen palsu/tidak valid
- Data personal tidak konsisten

**Yang Bisa Dilakukan**:
- ✅ **Reapply KYC** dengan dokumen perbaikan
- ✅ Lihat detail alasan penolakan
- ✅ Upload dokumen baru
- ❌ Masih belum bisa berjualan

---

## Panduan Step-by-Step Verifikasi KYC

### Langkah 1: Akses Menu KYC

1. Login ke dashboard seller
2. Klik menu **"KYC Verification"** di sidebar
3. Jika belum ada aplikasi, akan muncul tombol **"Start KYC Process"**
4. Klik **"Apply for KYC Verification"**

### Langkah 2: Isi Informasi Personal

#### Data Diri:
```
First Name        : [Nama Depan]
Last Name         : [Nama Belakang]  
Date of Birth     : [DD/MM/YYYY]
Gender            : [Male/Female/Other]
Nationality       : [Indonesian/Other]
```

#### Informasi Alamat:
```
Address           : [Jalan, No., RT/RW]
Province          : [Dropdown: Pilih Provinsi]
City              : [Dropdown: Pilih Kota]  
Subdistrict       : [Dropdown: Pilih Kecamatan]
Village           : [Dropdown: Pilih Kelurahan]
Postal Code       : [5 digit kode pos]
Country           : [Indonesia (default)]
Phone Number      : [+62xxxxxxxxxx]
```

**💡 Tips Pengisian:**
- Gunakan data sesuai **KTP/identitas resmi**
- Alamat harus **detail dan akurat**  
- Nomor telepon harus **aktif** (untuk verifikasi)
- Double-check semua data sebelum lanjut

### Langkah 3: Pilih Jenis Dokumen

#### Pilihan Dokumen Identitas:
1. **🆔 KTP (Kartu Tanda Penduduk)** - Recommended
   - Untuk WNI (Warga Negara Indonesia)
   - Paling mudah dan cepat diverifikasi
   - Tidak ada expiry date

2. **🛂 Passport (Paspor)**
   - Untuk WNA (Warga Negara Asing)
   - Harus masih berlaku (belum expired)
   - Memerlukan visa/permit tinggal

3. **🚗 SIM (Surat Izin Mengemudi)**
   - Alternative untuk WNI
   - Harus SIM A/B/C yang masih berlaku
   - Proses review lebih lama

#### Informasi Dokumen:
```
Document Number      : [Nomor sesuai dokumen]
Expiry Date         : [DD/MM/YYYY - jika ada]
Issued Country      : [Negara penerbit]
```

### Langkah 4: Upload Foto Dokumen

#### A. Foto Sisi Depan Dokumen:
```
📋 Checklist Foto Dokumen:
✓ Seluruh dokumen masuk frame
✓ Semua text jelas terbaca  
✓ Tidak ada bayangan/pantulan
✓ Background kontras (gelap/terang)
✓ Resolusi tinggi, tidak pixelated
✓ Format: JPEG/PNG/JPG/WebP
✓ Ukuran: Maksimal 5 MB
```

**🚫 Hindari Kesalahan:**
- Foto terpotong/tidak lengkap
- Flash yang menimbulkan silau
- Foto miring/tidak lurus
- Background pattern yang mengganggu
- Resolusi terlalu rendah

#### B. Foto Selfie dengan Dokumen:
```
📸 Checklist Foto Selfie:
✓ Wajah jelas dan terfokus
✓ Dokumen dipegang di samping wajah
✓ Kedua mata terbuka dan terlihat
✓ Mulut tidak tertutup masker
✓ Pencahayaan cukup (tidak backlight)
✓ Ekspresi natural, tidak menyipitkan mata
✓ Background bersih dan tidak ramai
```

**💡 Tips Foto Selfie:**
- Gunakan **kamera depan** smartphone
- **Pencahayaan alami** (di dekat jendela)
- **Posisi tegak**, pandangan ke kamera
- **Dokumen sejajar** dengan wajah
- **Hindari filter** atau editing

### Langkah 5: Upload Dokumen Tambahan (Opsional)

#### Dokumen yang Dapat Diunggah:
- **NPWP** (Nomor Pokok Wajib Pajak)
- **SIUP** (Surat Izin Usaha Perdagangan)  
- **NIB** (Nomor Induk Berusaha)
- **Surat Keterangan Usaha** dari kelurahan
- **Akta Pendirian** (untuk PT/CV)

#### Manfaat Dokumen Tambahan:
- **Prioritas Review**: Proses lebih cepat
- **Higher Trust Score**: Badge premium
- **Business Features**: Akses fitur B2B
- **Higher Limits**: Batas withdrawal lebih tinggi

### Langkah 6: Persetujuan Terms & Conditions

#### Yang Harus Disetujui:
```
☑️ Terms & Conditions
   - Kebijakan platform Pasar Santri
   - Aturan dan tanggung jawab seller
   - Sanksi pelanggaran
   
☑️ Privacy Policy  
   - Penggunaan data personal
   - Keamanan informasi
   - Hak dan kewajiban user
```

**⚠️ Penting**: Wajib membaca dan memahami sebelum menyetujui

### Langkah 7: Submit Aplikasi

1. **Review semua data** yang telah diisi
2. **Check semua dokumen** sudah terupload
3. **Pastikan centang** terms & privacy policy
4. Klik **"Submit KYC Application"**
5. **Konfirmasi submit** di popup dialog
6. **Tunggu redirect** ke halaman status

#### Setelah Submit:
```
✅ Aplikasi berhasil dikirim
📧 Email konfirmasi dikirim  
⏰ Review 3-5 hari kerja
📱 Notifikasi real-time di dashboard
💬 Bisa contact support jika ada masalah
```

---

## Monitoring Status KYC

### 1. Mengecek Status Aplikasi

#### Dashboard KYC:
- **Status Badge**: Warna sesuai status current
- **Timeline Progress**: Visual progress bar
- **Application Details**: Info lengkap aplikasi
- **Action Buttons**: Tombol sesuai status
- **History**: Riwayat semua aplikasi

#### Status Colors:
```
🟡 Pending      : Yellow/Warning
🔵 Under Review : Blue/Info  
✅ Approved     : Green/Success
❌ Rejected     : Red/Danger
```

### 2. Notifikasi Real-time

#### Email Notifications:
- **Application Submitted**: Konfirmasi submit
- **Under Review**: Mulai direview admin
- **Additional Documents Needed**: Butuh dokumen tambahan  
- **Approved**: KYC berhasil disetujui
- **Rejected**: KYC ditolak dengan alasan

#### In-App Notifications:
- **Bell icon** di header dashboard
- **Status updates** real-time
- **Action required** notifications
- **Deadline reminders**

### 3. Timeline Estimasi

#### Normal Processing:
```
Day 1     : Application Submitted ✓
Day 2-3   : Document Review
Day 4-5   : Final Verification  
Day 5     : Decision & Notification
```

#### Expedited Processing (dengan dokumen lengkap):
```
Day 1     : Application Submitted ✓
Day 2     : Fast Track Review
Day 3     : Approval/Rejection
```

#### Delayed Processing (jika ada masalah):
```
Day 1-3   : Initial Review
Day 4-7   : Additional Verification
Day 8-10  : Final Decision
```

---

## Handling Aplikasi Ditolak (Rejected)

### 1. Mengecek Alasan Penolakan

#### Detail Rejection:
- **Primary Reason**: Alasan utama penolakan
- **Specific Issues**: Detail masalah spesifik
- **Required Actions**: Apa yang harus diperbaiki
- **Reapply Instructions**: Panduan untuk apply ulang

#### Alasan Penolakan Umum:

##### 🖼️ **Masalah Foto/Dokumen:**
```
❌ Document photo unclear/blurry
   → Upload foto dengan kualitas HD
   
❌ Selfie doesn't match document  
   → Pastikan wajah sama dengan foto di dokumen
   
❌ Document partially hidden/cut off
   → Upload foto dokumen lengkap, semua sudut terlihat
   
❌ Poor lighting in photos
   → Gunakan pencahayaan natural yang cukup
   
❌ Glare/reflection on document
   → Hindari flash, gunakan pencahayaan tidak langsung
```

##### 📝 **Masalah Data:**
```
❌ Personal info doesn't match document
   → Pastikan nama, alamat sesuai dengan dokumen
   
❌ Expired document provided
   → Upload dokumen yang masih berlaku
   
❌ Invalid/fake document detected  
   → Gunakan dokumen asli dan resmi
   
❌ Incomplete address information
   → Lengkapi alamat sampai detail RT/RW
   
❌ Phone number not reachable
   → Gunakan nomor yang aktif dan bisa dihubungi
```

### 2. Proses Reapply KYC

#### Langkah Reapply:
1. **Login ke dashboard seller**
2. **Masuk ke menu KYC**
3. **Klik "Reapply"** pada aplikasi yang rejected
4. **Review rejection reason** dengan detail
5. **Perbaiki data/dokumen** sesuai feedback
6. **Upload dokumen baru** yang sudah diperbaiki
7. **Submit reapplication**

#### Yang Bisa Diubah saat Reapply:
```
✅ Personal Information
✅ Address Details  
✅ Document Photos
✅ Selfie Photo
✅ Additional Documents
❌ Document Type (harus sama)
❌ Basic Identity (nama sesuai dokumen)
```

#### Tips Successful Reapply:
- **Baca rejection reason** dengan teliti
- **Perbaiki semua poin** yang disebutkan
- **Gunakan foto berkualitas tinggi**
- **Double-check semua data** sebelum submit
- **Upload dokumen tambahan** untuk memperkuat aplikasi

### 3. Dukungan untuk Rejected Application

#### Contact Support:
```
📧 Email   : kyc-support@pasarsantri.com
📱 WhatsApp: +62 812-3456-7890  
💬 Live Chat: Available di dashboard
⏰ Jam Kerja: Senin-Jumat 08:00-17:00 WIB
```

#### Yang Disediakan Support:
- **Penjelasan detail** rejection reason
- **Guidance** untuk perbaikan dokumen
- **Review preview** sebelum resubmit
- **Expedited processing** untuk urgent case

---

## Tips Sukses Verifikasi KYC

### 1. **Persiapan Dokumen**
```
📋 Checklist Persiapan:
✅ Siapkan dokumen asli (KTP/Passport/SIM)
✅ Pastikan dokumen masih berlaku
✅ Bersihkan dokumen dari debu/kotoran
✅ Siapkan smartphone dengan kamera HD
✅ Cari tempat dengan pencahayaan baik
✅ Siapkan background yang kontras
```

### 2. **Teknik Fotografi**
```
📸 Photography Best Practices:
✅ Gunakan mode HDR jika tersedia
✅ Focus manual pada dokumen
✅ Hindari zoom digital berlebihan  
✅ Ambil beberapa foto, pilih yang terbaik
✅ Check hasil foto sebelum upload
✅ Pastikan file size tidak melebihi limit
```

### 3. **Data Accuracy**
```
📝 Data Entry Tips:
✅ Ketik data dengan teliti, hindari typo
✅ Gunakan format yang konsisten
✅ Pastikan alamat sesuai dengan KTP
✅ Nomor telepon dengan format +62
✅ Double-check semua field sebelum submit
```

### 4. **Timing Strategy**
```
⏰ Optimal Submission Timing:
✅ Submit di hari kerja (Senin-Kamis)
✅ Waktu pagi (09:00-11:00 WIB) untuk review cepat
✅ Hindari submit di Jumat sore atau weekend
✅ Jangan submit menjelang holiday/libur panjang
```

---

## Troubleshooting KYC

### Problem: "Upload foto gagal terus"
**Diagnosis**:
- Check file size (max 5MB untuk identitas, 10MB untuk additional)
- Check format file (JPEG/PNG/JPG/WebP)
- Check koneksi internet

**Solusi**:
1. Compress foto jika terlalu besar
2. Convert format jika perlu
3. Coba upload satu per satu
4. Refresh halaman dan coba lagi
5. Clear browser cache

### Problem: "Data tidak bisa disimpan"  
**Diagnosis**:
- Check semua field yang required sudah diisi
- Check format data (tanggal, nomor telepon)
- Check browser compatibility

**Solusi**:
1. Pastikan semua field wajib terisi
2. Check format tanggal (DD/MM/YYYY)
3. Nomor telepon mulai dengan +62
4. Gunakan browser update (Chrome/Firefox)
5. Disable ad-blocker sementara

### Problem: "Status tidak update setelah submit"
**Diagnosis**:
- Check notifikasi email konfirmasi
- Check apakah submit benar-benar berhasil
- Check browser cache

**Solusi**:
1. Check email untuk konfirmasi submit
2. Refresh halaman dashboard
3. Logout dan login kembali
4. Clear browser cache dan cookies
5. Contact support jika masalah berlanjut

### Problem: "Aplikasi tertunda lebih dari 5 hari"
**Diagnosis**:
- Check apakah ada request additional documents
- Check email untuk komunikasi dari admin  
- Check apakah ada holiday/libur panjang

**Solusi**:
1. Check email termasuk folder spam
2. Login dashboard untuk update terbaru
3. Contact support via WhatsApp untuk urgent
4. Berikan application ID untuk tracking
5. Request status update dan ETA

---

## Kebijakan dan Aturan KYC

### 1. **Kebijakan Umum**
- **Satu akun satu KYC**: Tidak boleh duplikasi identitas
- **Dokumen asli wajib**: Tidak menerima fotokopi/scan
- **Data harus akurat**: Sesuai dengan dokumen resmi
- **Foto berkualitas**: Jelas, terang, tidak blur

### 2. **Batas Waktu**
- **Submission**: Tidak ada batas waktu
- **Review process**: 3-5 hari kerja
- **Reapply cooldown**: 24 jam setelah rejection  
- **Document validity**: Sesuai masa berlaku dokumen

### 3. **Compliance Requirements**
- **Anti-Money Laundering (AML)**: Sesuai regulasi BI
- **Counter Financing of Terrorism (CFT)**: Screening otomatis
- **Data Protection**: Sesuai UU Perlindungan Data Pribadi
- **E-Commerce Regulation**: Sesuai PP No. 80/2019

### 4. **Sanksi Pelanggaran**
```
⚠️ Dokumen Palsu:
- Permanent ban dari platform
- Laporan ke authorities terkait
- Blacklist di sistem industri

⚠️ Identity Fraud:
- Account suspension
- Legal action jika diperlukan  
- Collaboration dengan law enforcement

⚠️ Data Manipulation:
- Application rejection
- Extended review period
- Additional verification required
```

---

## Dukungan dan Bantuan

Untuk bantuan terkait verifikasi KYC seller:

### 📞 **Support Channels:**
```
📧 Email KYC     : kyc-support@pasarsantri.com
📱 WhatsApp      : +62 812-3456-7890
💬 Live Chat     : Available di seller dashboard  
🌐 Help Center   : help.pasarsantri.com/kyc
🏢 Developer     : PT. Sidogiri Fintech Utama
```

### ⏰ **Jam Operasional:**
```
Support KYC:
Senin - Jumat  : 08:00 - 17:00 WIB
Sabtu          : 08:00 - 12:00 WIB  
Minggu         : Closed

Urgent/Emergency: 
WhatsApp 24/7 untuk masalah kritis
```

### 📚 **Resources:**
```
📖 KYC Guidelines    : docs.pasarsantri.com/seller/kyc
📹 Video Tutorial    : youtube.com/pasarsantri/kyc
🎯 Best Practices    : help.pasarsantri.com/kyc-tips
❓ FAQ              : faq.pasarsantri.com/kyc
```

---

## Frequently Asked Questions (FAQ)

### Q: Apakah KYC wajib untuk semua seller?
**A**: Ya, verifikasi KYC adalah **mandatory** untuk semua seller yang ingin berjualan di Pasar Santri Marketplace. Tanpa KYC yang approved, seller tidak dapat mengakses fitur penjualan dan withdrawal.

### Q: Berapa lama proses verifikasi KYC?
**A**: Normal processing time adalah **3-5 hari kerja**. Untuk aplikasi dengan dokumen lengkap dan berkualitas, bisa dipercepat menjadi 2-3 hari. Jika ada masalah dengan dokumen, bisa memakan waktu hingga 7-10 hari.

### Q: Apakah bisa menggunakan SIM sebagai dokumen identitas?
**A**: Ya, SIM A/B/C yang masih berlaku dapat digunakan sebagai alternative dokumen identitas. Namun KTP lebih direkomendasikan karena proses review lebih cepat.

### Q: Bagaimana jika dokumen saya expired?  
**A**: Dokumen yang expired tidak dapat diterima. Anda harus memperpanjang dokumen terlebih dahulu atau menggunakan dokumen alternatif yang masih berlaku.

### Q: Apakah data KYC saya aman?
**A**: Ya, semua data KYC dilindungi dengan enkripsi tingkat bank dan disimpan sesuai standar keamanan internasional. Data hanya diakses oleh admin yang berwenang untuk proses verifikasi.

### Q: Bisa ubah data KYC setelah approved?  
**A**: Data KYC yang sudah approved tidak bisa diubah secara mandiri. Jika ada perubahan data penting (alamat, nomor telepon), hubungi customer support dengan dokumen pendukung.

### Q: Kenapa aplikasi KYC saya ditolak?
**A**: Rejection bisa karena dokumen tidak jelas, data tidak sesuai, foto selfie tidak memenuhi standar, atau dokumen tidak valid. Check detail rejection reason di dashboard dan perbaiki sesuai feedback.

### Q: Apakah bisa reapply jika ditolak?
**A**: Ya, Anda bisa reapply unlimited dengan perbaikan dokumen. Tunggu 24 jam setelah rejection untuk cooldown period, kemudian submit aplikasi baru dengan dokumen yang sudah diperbaiki.

---

*Dokumentasi ini berlaku untuk Pasar Santri Marketplace versi 11.6.1*  
*Terakhir diperbarui: September 2025*
