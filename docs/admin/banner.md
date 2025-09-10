# Pengelolaan Banner - Admin Marketplace

## Tentang Pengelolaan Banner
Pengelolaan Banner adalah fitur untuk mengatur semua banner promosi yang ditampilkan di berbagai area marketplace. Sebagai admin, Anda dapat mengunggah, mengubah, dan mengatur banner untuk meningkatkan daya tarik visual dan promosi produk.

## Tujuan Fitur
- Mengelola banner promosi di seluruh area marketplace
- Mengoptimalkan tampilan visual beranda dan halaman lainnya  
- Meningkatkan engagement pengunjung melalui banner yang menarik
- Mengelola kampanye promosi visual secara terpusat

## Akses Fitur
Fitur ini hanya dapat diakses oleh Administrator yang telah login ke sistem admin.

## Struktur Banner di Marketplace

### Tata Letak Banner di Beranda:
Marketplace memiliki beberapa area banner yang dapat dikelola:

**Area Utama Beranda:**
- **Banner Utama**: Area carousel yang menampilkan beberapa gambar berganti-ganti secara otomatis
- **Banner Samping**: Banner tetap yang ditampilkan di sebelah carousel utama
- **Banner Bawah**: Tiga banner kecil yang ditampilkan dalam satu baris

**Area Lainnya:**
- **Banner Best Seller**: Banner khusus untuk bagian produk terlaris
- **Banner Footer**: Banner informasi di bagian bawah halaman
- **Banner Login**: Banner yang tampil di halaman login dan registrasi
```
┌─────────────────────────────────────────────────────────────┐
│ HEADER & NAVIGATION                                         │
├─────────────────────────────────────┬───────────────────────┤
│ PRIMARY BANNERS (Carousel)          │ SECONDARY BANNER      │
│ - Multiple images                   │ - Single image        │
│ - Auto-rotating carousel            │ - Static display      │
├─────────────────────────────────────┼───────────────────────┤
│ CHILD BANNER 1   │ CHILD BANNER 2   │ CHILD BANNER 3        │
│ - Single image   │ - Single image   │ - Single image        │
├─────────────────────────────────────────────────────────────┤
│ DAILY BEST SELLER BANNER                                    │
│ - Single image for best seller section                      │
├─────────────────────────────────────────────────────────────┤
│ FOOTER BANNER                                               │
│ - Single image in footer area                               │
└─────────────────────────────────────────────────────────────┘

Login Page:
┌─────────────────────────────────────────────────────────────┐
│ LOGIN BANNER                                                │
│ - Displayed on login/register pages                         │
└─────────────────────────────────────────────────────────────┘
```

## Jenis Banner yang Tersedia

### 1. **Primary Banner (Headline Primary)**
**Lokasi:** Homepage - Area utama (carousel)  
**Jenis:** Multiple images (array)  
**Maksimal:** 10 gambar  
**Fungsi:** Banner utama yang berganti secara otomatis  
**Rekomendasi Ukuran:** 1920x600px

### 2. **Secondary Banner (Headline Secondary)**
**Lokasi:** Homepage - Samping carousel utama  
**Jenis:** Single image  
**Fungsi:** Banner pendamping yang static  
**Rekomendasi Ukuran:** 600x600px

### 3. **Child Banner 1, 2, 3 (Headline Child)**
**Lokasi:** Homepage - Baris bawah area headline  
**Jenis:** Single image (masing-masing)  
**Fungsi:** Banner promosi kategori atau produk spesifik  
**Rekomendasi Ukuran:** 400x250px

### 4. **Daily Best Seller Banner**
**Lokasi:** Homepage - Section best seller  
**Jenis:** Single image  
**Fungsi:** Banner untuk mempromosikan produk terlaris  
**Rekomendasi Ukuran:** 1200x300px

### 5. **Footer Banner**
**Lokasi:** Homepage - Area footer  
**Jenis:** Single image  
**Fungsi:** Banner informasi atau promosi di bagian bawah  
**Rekomendasi Ukuran:** 1200x200px

### 6. **Login Page Banner**
**Lokasi:** Halaman login dan register  
**Jenis:** Single image  
**Fungsi:** Banner branding atau promosi untuk user baru  
**Rekomendasi Ukuran:** 800x400px

## Cara Menggunakan Banner Management

### **Akses Halaman Banner Management**
1. Login sebagai Administrator
2. Buka menu **Admin Dashboard**
3. Navigasi ke **Banner Management**
4. Atau akses langsung: `/admin/banners`

### Tampilan Dashboard Banner
Halaman pengelolaan banner menampilkan:
- **Statistik Banner**: Jumlah banner yang aktif per kategori
- **Area Upload**: Formulir untuk mengunggah setiap jenis banner
- **Preview Saat Ini**: Tampilan banner yang sedang aktif

### Cara Mengunggah atau Mengubah Banner

#### Banner Utama (Multiple Gambar):
1. Cari bagian "Banner Utama (Carousel)"
2. Klik "Pilih Multiple File" atau seret dan letakkan gambar
3. Pilih 1-10 gambar sekaligus
4. Format yang didukung: JPEG, PNG, JPG, GIF, WebP
5. Ukuran maksimal: 2MB per file
6. Klik "Unggah Gambar"
7. Banner akan langsung aktif setelah berhasil diunggah

#### Banner Tunggal (Secondary, Child, dll):
1. Cari bagian banner yang ingin diubah
2. Klik "Pilih File" atau seret dan letakkan gambar
3. Pilih 1 file gambar
4. Format yang didukung: JPEG, PNG, JPG, GIF, WebP
5. Ukuran maksimal: 2MB
6. Klik "Unggah Gambar"
7. Banner akan langsung menggantikan yang lama

## Spesifikasi Banner

### Format File yang Didukung:
- **JPEG** (.jpg, .jpeg)
- **PNG** (.png) - Disarankan untuk gambar dengan transparansi
- **GIF** (.gif) - Mendukung animasi
- **WebP** (.webp) - Format modern untuk optimasi

### Batasan Upload:
- **Ukuran maksimal file:** 2MB per gambar
- **Banner Utama:** Maksimal 10 gambar
- **Banner Tunggal:** 1 gambar per slot
- **Penyimpanan:** Tidak terbatas (dikelola sistem)

## Panduan Desain Banner

### Rekomendasi Ukuran (dalam pixel):
- **Banner Utama:** 1920 x 600px (Rasio 16:5)
- **Secondary Banner:** 600 x 600px (Square 1:1)
- **Child Banner 1-3:** 400 x 250px (Ratio 8:5)
- **Daily Best Seller:** 1200 x 300px (Ratio 4:1)
- **Footer Banner:** 1200 x 200px (Ratio 6:1)
- **Login Banner:** 800 x 400px (Ratio 2:1)

### Praktik Desain Terbaik:
1. **Desain Responsif:** Banner harus terlihat baik di semua perangkat
2. **Keterbacaan Teks:** Gunakan kontras yang cukup untuk teks
3. **Ukuran File:** Optimalkan gambar untuk kecepatan loading
4. **Konsistensi Brand:** Gunakan palet warna yang konsisten
5. **Call-to-Action:** Tambahkan ajakan bertindak yang jelas jika diperlukan

### Panduan Konten:
- Gunakan bahasa Indonesia yang mudah dipahami
- Hindari teks yang terlalu panjang
- Pastikan konten sesuai dengan target audience
- Gunakan gambar yang relevan dengan produk/layanan
- Perhatikan aspek yang sesuai dengan nilai-nilai marketplace

## Pemantauan Banner

### Pelacakan Performa Banner:
- **Jumlah Tayangan:** Berapa kali banner dilihat pengunjung
- **Tingkat Klik:** Seberapa sering banner diklik
- **Konversi:** Transaksi yang berasal dari klik banner
- **Kecepatan Loading:** Dampak terhadap kecepatan halaman

### Pengujian Banner:
1. Unggah alternatif banner yang berbeda
2. Pantau metrik performa
3. Bandingkan tingkat engagement
4. Pilih banner dengan performa terbaik

## Hal Penting yang Perlu Diperhatikan

### Kebijakan Konten:
1. **Konten yang Pantas:** Semua banner harus sesuai dengan nilai-nilai marketplace
2. **Tidak Menyesatkan:** Hindari klaim yang berlebihan atau menyesatkan
3. **Gambar Appropriate:** Gunakan gambar yang pantas dan sopan
4. **Hak Cipta:** Pastikan memiliki hak untuk menggunakan gambar tersebut

### Keterbatasan Teknis:
- Banner lama akan tergantikan saat mengunggah banner baru
- Sistem tidak menyimpan riwayat banner sebelumnya
- Penyimpanan file terbatas di server
- Cache browser mungkin perlu dihapus untuk melihat perubahan

### Praktik Terbaik:
1. **Backup:** Simpan salinan banner di komputer sebelum mengunggah
2. **Pengujian:** Uji banner di berbagai ukuran layar
3. **Penjadwalan:** Rencanakan pergantian banner untuk kampanye
4. **Pemantauan:** Pantau kecepatan loading setelah mengunggah banner baru

## Pemecahan Masalah Umum

### Masalah: Upload gagal atau file tidak terunggah
**Solusi:**
1. Periksa ukuran file (maksimal 2MB)
2. Pastikan format file didukung
3. Periksa koneksi internet Anda
4. Muat ulang browser dan coba lagi

### Masalah: Banner tidak muncul setelah upload
**Solusi:**
1. Hapus cache browser (Ctrl+F5)
2. Tunggu beberapa menit untuk pemrosesan sistem
3. Periksa apakah file berhasil terunggah
4. Pastikan file tidak corrupt atau rusak

### Masalah: Gambar blur atau pecah
**Solusi:**
1. Unggah gambar dengan resolusi yang disarankan
2. Gunakan format PNG untuk gambar dengan detail tinggi
3. Kompres gambar dengan tool yang tepat sebelum upload
4. Gunakan format yang lebih kompatibel (JPEG/PNG)

### Masalah: Error saat mengakses halaman
**Solusi:**
1. Pastikan mengakses melalui menu yang benar
2. Muat ulang halaman dan coba lagi
3. Pastikan Anda memiliki akses admin
4. Hubungi tim teknis jika masih bermasalah

## Tips Optimasi

### Optimasi Performa:
1. **Kompres Gambar:** Gunakan tool seperti TinyPNG sebelum upload
2. **Format Modern:** Gunakan WebP untuk kompatibilitas dan ukuran file kecil
3. **Loading Cepat:** Banner akan dimuat sesuai kebutuhan
4. **Kecepatan Akses:** Sistem mendukung loading yang cepat

### Manfaat SEO:
- Banner dengan deskripsi yang baik untuk mesin pencari
- Nama file yang optimal
- Ukuran gambar yang tepat untuk kecepatan halaman
- Desain responsif yang mobile-friendly

### Strategi Marketing:
1. **Kampanye Musiman:** Ganti banner sesuai momen khusus
2. **Promosi Produk:** Sorot produk atau kategori tertentu
3. **Brand Awareness:** Konsisten dengan branding marketplace
4. **User Journey:** Banner yang mengarahkan ke konversi

---

## Bantuan dan Dukungan

Jika mengalami kesulitan dalam menggunakan fitur pengelolaan banner, Anda dapat menghubungi tim support untuk bantuan lebih lanjut.

**Tips Umum:**
- Selalu backup banner lama sebelum mengunggah yang baru
- Test banner di berbagai perangkat sebelum dipublikasikan
- Pantau performa banner secara berkala
- Koordinasi dengan tim marketing untuk strategi banner yang efektif

## Optimization Tips

### **Performance Optimization:**
1. **Compress Images:** Gunakan tool seperti TinyPNG
2. **WebP Format:** Gunakan WebP untuk compatibility dan size
3. **Lazy Loading:** Banner akan load sesuai kebutuhan
4. **CDN Ready:** Sistem mendukung CDN untuk faster loading

### **SEO Benefits:**
- Banner dengan alt text yang baik
- Optimized file names
- Proper image sizing untuk page speed
- Mobile-friendly responsive design

### **Marketing Strategy:**
1. **Seasonal Campaigns:** Ganti banner sesuai momen (Ramadan, Lebaran, dll)
2. **Product Promotion:** Highlight produk atau kategori tertentu
3. **Brand Awareness:** Konsisten dengan branding Pasar Santri
4. **User Journey:** Banner yang mengarahkan ke conversion

---

## Support & Bantuan

Jika mengalami kesulitan dalam menggunakan Banner Management:

1. **Technical Issues:** Hubungi tim development PT. Sidogiri Fintech Utama
2. **Design Guidelines:** Konsultasi dengan marketing team
3. **Content Policy:** Hubungi content moderation team
4. **General Support:** Kontak support Pasar Santri Marketplace

**Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**Last Updated:** September 2025  
**Version:** 1.0
