# Marketplace User Profile - Pasar Santri

## Deskripsi
Marketplace User Profile adalah halaman khusus untuk pengguna terdaftar yang menyediakan akses ke fitur-fitur akun pribadi, manajemen alamat, dan pengelolaan wishlist. Halaman ini memerlukan autentikasi dan memberikan pengalaman personal yang lebih baik untuk aktivitas belanja di marketplace Pasar Santri.

## Tujuan
- Memberikan kontrol penuh atas informasi akun pribadi
- Memudahkan pengelolaan alamat pengiriman untuk proses checkout yang lebih cepat
- Menyediakan fitur wishlist untuk menyimpan dan mengelola produk favorit
- Meningkatkan pengalaman berbelanja yang personal dan efisien
- Mempertahankan riwayat preferensi dan aktivitas pengguna

## Akses & Persyaratan
**Role Required:** Buyer/Customer yang sudah terdaftar dan login  
**Permission:** Akses ke profil pribadi dan fitur wishlist  
**URL:** `/user/profile`, `/user/address-book`, `/user/wishlist`

## Fitur Utama User Profile

### 1. **Manajemen Akun Pribadi**
- Update informasi profil seperti nama, email, dan nomor telepon
- Pengaturan password dan keamanan akun
- Foto profil dan informasi personal

### 2. **Address Book (Buku Alamat)**  
- Menyimpan multiple alamat pengiriman untuk kemudahan checkout
- Set alamat utama/default untuk pengiriman
- Edit, hapus, dan kelola alamat yang tersimpan

### 3. **Wishlist Management**
- Simpan produk favorit untuk dibeli kemudian
- Organisasi wishlist dengan kategori atau folder
- Notifikasi perubahan harga atau stok produk di wishlist

### 4. **Preferensi & Pengaturan**
- Pengaturan notifikasi email dan SMS
- Preferensi bahasa dan tampilan
- Riwayat aktivitas dan login

### 5. **Quick Access Features**
- Shortcut ke riwayat pesanan dan tracking
- Akses cepat ke customer service dan bantuan
- Link ke halaman pembayaran dan invoice

---

## Persyaratan Akses User Profile

### Prasyarat Wajib

1. **Akun Terdaftar**: Pengguna harus memiliki akun yang sudah terdaftar di marketplace
2. **Status Login**: Harus dalam kondisi logged in untuk mengakses fitur
3. **Email Terverifikasi**: Email akun harus sudah terverifikasi untuk keamanan
4. **Role Customer**: Pengguna harus memiliki role `customer/buyer` yang aktif

### Prasyarat Opsional

1. **Nomor Telepon**: Disarankan untuk verifikasi tambahan dan notifikasi
2. **Foto Profil**: Untuk personalisasi pengalaman
3. **Alamat Lengkap**: Untuk kemudahan proses checkout

---

## User Account & Address Book

### Informasi Akun Dasar

**Data Profil Utama:**
- **Nama Lengkap**: Nama yang akan muncul di profil dan pesanan
- **Email**: Alamat email utama untuk komunikasi dan login
- **Nomor Telepon**: Kontak untuk notifikasi dan verifikasi
- **Tanggal Lahir**: Untuk keperluan promo khusus dan validasi
- **Gender**: Pilihan opsional untuk personalisasi konten

**Keamanan Akun:**
- **Password**: Pengaturan dan perubahan password akun
- **Two-Factor Authentication**: Keamanan tambahan dengan SMS/email
- **Login History**: Riwayat aktivitas login untuk monitoring keamanan
- **Device Management**: Kelola perangkat yang terdaftar

### Manajemen Address Book

**Fitur Utama Address Book:**

#### 1. Tambah Alamat Baru
**Langkah-langkah:**
- Klik tombol "Tambah Alamat Baru" di halaman Address Book
- Isi informasi lengkap alamat:
  - Nama penerima (bisa berbeda dengan nama akun)
  - Nomor telepon penerima
  - Alamat lengkap (jalan, nomor, RT/RW)
  - Kelurahan/Desa, Kecamatan, Kota/Kabupaten
  - Provinsi dan kode pos
  - Catatan khusus untuk kurir (opsional)
- Pilih apakah alamat ini akan dijadikan alamat utama
- Klik "Simpan Alamat" untuk menyimpan

**Tips Pengisian Alamat:**
- Pastikan nomor telepon aktif dan bisa dihubungi
- Tulis alamat sejelas mungkin dengan patokan yang mudah ditemukan
- Sertakan nomor rumah/gedung dan kode pos yang benar
- Tambahkan catatan khusus jika lokasi sulit ditemukan

#### 2. Kelola Alamat Tersimpan
**Fungsi yang Tersedia:**
- **Edit Alamat**: Ubah informasi alamat yang sudah tersimpan
- **Hapus Alamat**: Menghapus alamat yang tidak diperlukan lagi
- **Set Alamat Utama**: Jadikan alamat tertentu sebagai default
- **Duplikat Alamat**: Salin alamat untuk membuat variasi baru
- **Validasi Alamat**: Sistem akan memverifikasi kelengkapan data

**Label Alamat:**
- **Rumah**: Alamat tempat tinggal utama
- **Kantor**: Alamat tempat kerja untuk pengiriman
- **Kos/Apartemen**: Alamat sementara atau hunian
- **Keluarga**: Alamat saudara atau keluarga
- **Lainnya**: Kategori custom sesuai kebutuhan

#### 3. Penggunaan Alamat Saat Checkout
**Proses Seleksi Alamat:**
- Saat checkout, semua alamat tersimpan akan muncul
- Pilih alamat pengiriman yang sesuai untuk pesanan
- Bisa edit alamat langsung dari halaman checkout jika diperlukan
- Sistem akan mengkalkulasi ongkos kirim berdasarkan alamat terpilih

**Alamat Default:**
- Alamat yang ditandai sebagai "Utama" akan otomatis terpilih
- Menghemat waktu checkout untuk pembelian rutin
- Bisa diubah kapan saja sesuai kebutuhan

---

## Wishlist Management

### Tentang Fitur Wishlist

**Fungsi Utama Wishlist:**
- Menyimpan produk yang menarik untuk dibeli kemudian
- Tracking perubahan harga produk favorit
- Organisasi produk berdasarkan kategori atau prioritas
- Sharing wishlist dengan teman atau keluarga
- Reminder untuk produk yang hampir habis stok

**Keuntungan Menggunakan Wishlist:**
- Tidak kehilangan track produk yang diminati
- Bisa menunggu promo atau diskon untuk produk tertentu
- Memudahkan perencanaan budget belanja
- Perbandingan produk serupa dalam satu tempat

### Cara Menggunakan Wishlist

#### 1. Menambahkan Produk ke Wishlist
**Dari Halaman Produk:**
- Buka halaman detail produk yang diminati
- Klik icon "♡" (heart) di sebelah tombol "Add to Cart"
- Produk otomatis tersimpan di wishlist Anda
- Icon akan berubah menjadi "♥" (filled heart) menandakan sudah disimpan

**Dari Halaman Kategori/Search:**
- Hover mouse ke gambar produk
- Klik icon wishlist yang muncul di corner gambar
- Produk langsung tersimpan tanpa perlu membuka detail

**Indikator Produk di Wishlist:**
- Icon heart akan berwarna merah jika produk sudah di wishlist
- Jumlah item wishlist tertera di header website
- Notifikasi konfirmasi saat berhasil menambah/menghapus

#### 2. Mengelola Wishlist
**Fitur Organisasi:**
- **Kategori Wishlist**: Buat folder seperti "Elektronik", "Fashion", "Hadiah"
- **Priority Level**: Tandai produk dengan tingkat prioritas (High, Medium, Low)
- **Notes**: Tambahkan catatan personal untuk setiap produk
- **Date Added**: Lihat kapan produk ditambahkan ke wishlist

**Aksi yang Tersedia:**
- **View Product**: Lihat detail lengkap produk
- **Add to Cart**: Pindahkan langsung dari wishlist ke keranjang
- **Remove**: Hapus produk dari wishlist
- **Share**: Bagikan produk via WhatsApp, email, atau sosial media
- **Compare**: Bandingkan dengan produk serupa

#### 3. Notifikasi dan Alert
**Jenis Notifikasi Wishlist:**
- **Price Drop**: Pemberitahuan saat harga produk turun
- **Stock Alert**: Info saat produk hampir habis atau kembali ready stock
- **Promo Alert**: Notifikasi saat ada diskon khusus untuk produk di wishlist
- **Similar Product**: Rekomendasi produk serupa dengan harga lebih baik

**Pengaturan Notifikasi:**
- Pilih jenis notifikasi yang diinginkan (email, SMS, push notification)
- Set frekuensi notifikasi (instant, daily summary, weekly summary)
- Atur threshold harga untuk price drop alert
- On/off notifikasi untuk kategori produk tertentu

### Tips Maksimalkan Penggunaan Wishlist

**Strategi Belanja Efektif:**
1. **Monitoring Harga**: Pantau fluktuasi harga produk secara berkala
2. **Timing Pembelian**: Manfaatkan moment sale atau promo besar
3. **Budget Planning**: Hitung total wishlist untuk perencanaan budget
4. **Comparison Shopping**: Bandingkan produk serupa sebelum membeli
5. **Seasonal Shopping**: Simpan produk musiman untuk dibeli di waktu yang tepat

**Organisasi yang Efisien:**
- Buat kategori berdasarkan kebutuhan (urgent, nice-to-have, gifts)
- Regular cleanup - hapus produk yang sudah tidak relevan
- Prioritaskan berdasarkan budget dan kebutuhan
- Gunakan notes untuk reminder spesifik

---

## Pengaturan dan Personalisasi

### Preferensi Akun

**Pengaturan Tampilan:**
- **Bahasa**: Pilih bahasa Indonesia atau English
- **Currency**: Mata uang default (IDR)
- **Timezone**: Set zona waktu sesuai lokasi
- **Layout Preference**: Grid view atau list view untuk produk

**Notifikasi Settings:**
- **Email Notifications**: Kontrol email untuk order, promo, newsletter
- **SMS Alerts**: Pengaturan SMS untuk order status dan security
- **Push Notifications**: Notifikasi browser dan mobile app
- **Marketing Communications**: Opt-in/out untuk materi promosi

### Privacy dan Keamanan

**Kontrol Privasi:**
- **Profile Visibility**: Atur siapa yang bisa melihat profil
- **Wishlist Privacy**: Set wishlist sebagai public atau private
- **Purchase History**: Kontrol visibilitas riwayat pembelian
- **Recommendation Settings**: Atur personalisasi rekomendasi produk

**Security Features:**
- **Login Alerts**: Notifikasi saat ada login dari device baru
- **Session Management**: Kelola sesi aktif di berbagai perangkat
- **Data Download**: Request data pribadi untuk keperluan backup
- **Account Deactivation**: Opsi untuk menonaktifkan akun sementara

---

## Aktivitas dan Riwayat

### Dashboard Aktivitas Pengguna

**Ringkasan Aktivitas:**
- Jumlah total pesanan dalam berbagai periode
- Total pengeluaran dan average order value
- Produk yang paling sering dibeli
- Toko favorit berdasarkan frekuensi pembelian
- Statistik penggunaan wishlist dan saved items

**Recent Activities:**
- History browsing produk terbaru
- Pesanan dalam proses dan yang baru selesai
- Perubahan pada wishlist dan address book
- Interaksi dengan customer service atau review

### Integration Features

**Social Media Integration:**
- Login dengan Google, Facebook, atau Apple ID
- Share wishlist dan produk favorit ke sosial media
- Import contacts untuk gift recommendations
- Social proof dari pembelian teman

**Third-party Services:**
- Integrasi dengan e-wallet untuk pembayaran cepat
- Sync dengan calendar untuk delivery scheduling  
- Connection dengan loyalty program external
- API access untuk aplikasi personal finance

---

## Troubleshooting & FAQ

### Masalah Umum User Profile

#### Masalah 1: Tidak Bisa Update Profile
**Gejala**: Form profile tidak tersimpan atau muncul error
**Solusi**:
- Pastikan semua field yang wajib sudah diisi
- Cek format email dan nomor telepon sudah benar
- Clear browser cache dan cookies
- Coba login ulang jika session expired
- Hubungi customer service jika masalah berlanjut

#### Masalah 2: Address Book Error
**Gejala**: Alamat tidak tersimpan atau tidak muncul saat checkout
**Solusi**:
- Verifikasi semua field alamat sudah lengkap
- Pastikan kode pos benar dan sesuai wilayah
- Cek koneksi internet saat menyimpan
- Refresh halaman dan coba tambah alamat lagi
- Pastikan tidak melebihi limit maksimal alamat (biasanya 10)

#### Masalah 3: Wishlist Tidak Sinkron
**Gejala**: Produk wishlist hilang atau tidak update
**Solusi**:
- Login ulang untuk refresh data wishlist
- Cek apakah produk masih tersedia di toko
- Clear browser data dan login kembali
- Pastikan tidak menggunakan multiple account
- Sync manual dengan refresh halaman wishlist

#### Masalah 4: Notifikasi Tidak Diterima
**Gejala**: Email atau SMS notifikasi tidak masuk
**Solusi**:
- Cek folder spam/junk untuk email notifications
- Verifikasi nomor telepon sudah benar dan aktif
- Update pengaturan notifikasi di profile settings
- Pastikan tidak memblokir email dari domain marketplace
- Test dengan request OTP atau password reset

### FAQ User Profile

#### T: Apakah data pribadi aman disimpan di marketplace?
**J**: Ya, marketplace menggunakan enkripsi SSL dan mengikuti standar keamanan data internasional. Data pribadi tidak akan dibagikan ke pihak ketiga tanpa persetujuan.

#### T: Berapa banyak alamat yang bisa disimpan di address book?
**J**: Anda dapat menyimpan hingga 10 alamat berbeda di address book. Jika sudah mencapai limit, hapus alamat yang tidak digunakan untuk menambah yang baru.

#### T: Apakah wishlist ada batas maksimal produk?
**J**: Tidak ada batas maksimal untuk jumlah produk di wishlist. Namun untuk performa optimal, disarankan mengelola dan membersihkan wishlist secara berkala.

#### T: Bisakah mengubah email yang terdaftar?
**J**: Ya, email bisa diubah melalui pengaturan profile. Anda akan menerima konfirmasi di email lama dan baru untuk verifikasi perubahan.

#### T: Bagaimana cara menghapus akun permanent?
**J**: Untuk penghapusan akun permanent, hubungi customer service. Proses ini memerlukan verifikasi identitas dan tidak dapat dibatalkan.

#### T: Apakah bisa login dengan media sosial?
**J**: Ya, marketplace mendukung login dengan Google, Facebook, dan Apple ID untuk kemudahan akses.

#### T: Wishlist bisa dilihat orang lain?
**J**: Secara default wishlist bersifat private. Anda bisa mengatur untuk membagikan wishlist tertentu atau membuat wishlist public melalui pengaturan privacy.

#### T: Notifikasi price drop seberapa sering dikirim?
**J**: Notifikasi price drop dikirim real-time saat ada perubahan harga. Anda bisa mengatur untuk menerima summary harian atau mingguan melalui pengaturan notifikasi.

---

## Tips & Best Practices

### Optimasi Penggunaan User Profile

**Keamanan Akun:**
- Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol
- Aktifkan two-factor authentication untuk keamanan tambahan
- Jangan sharing informasi login dengan orang lain
- Logout dari device publik atau sharing setelah penggunaan
- Monitor riwayat login secara berkala untuk deteksi aktivitas mencurigakan

**Efisiensi Address Book:**
- Selalu update alamat yang berubah untuk menghindari kesalahan pengiriman
- Buat label yang jelas untuk setiap alamat (Rumah, Kantor, Kos, dll)
- Set alamat yang paling sering digunakan sebagai default
- Sertakan landmark atau patokan yang mudah ditemukan kurir
- Simpan nomor telepon alternatif jika memungkinkan

**Maksimalkan Wishlist:**
- Kategorikan produk berdasarkan prioritas atau jenis
- Set alert untuk produk yang benar-benar ingin dibeli
- Review wishlist secara berkala dan hapus yang tidak relevan
- Manfaatkan comparison feature untuk produk sejenis
- Share wishlist saat ada event khusus untuk gift ideas

### Mobile Experience

**Optimasi Mobile:**
- Download aplikasi mobile untuk akses yang lebih cepat
- Enable push notifications untuk update real-time
- Gunakan fingerprint atau face unlock untuk kemudahan login
- Sync data antara web dan mobile untuk konsistensi
- Manfaatkan fitur quick checkout di mobile

**Offline Functionality:**
- Wishlist tersimpan locally untuk akses saat offline
- Draft profile changes disimpan sementara saat koneksi terbatas
- Cache alamat favorit untuk checkout cepat
- Sync otomatis saat koneksi kembali normal

---

**Tips untuk Pengalaman Optimal:**
- Update profile secara berkala untuk mendapatkan rekomendasi yang lebih akurat
- Manfaatkan semua fitur notifikasi untuk tidak melewatkan promo
- Backup data penting seperti alamat dan wishlist secara manual
- Berikan feedback untuk membantu peningkatan fitur

**Customer Support**: Jika mengalami kesulitan dengan fitur User Profile, hubungi customer service melalui live chat, email, atau telepon yang tersedia 24/7 untuk bantuan teknis dan panduan penggunaan.
