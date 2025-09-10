#  Manajemen Saldo Toko

> **DOKUMENTASI TIDAK TERKONFIRMASI**
> 
> Fitur ini telah dikembangkan secara teknis dan siap untuk digunakan, namun saat ini tidak tersedia untuk pengguna karena kebijakan perusahaan yang tidak mengizinkan sistem untuk menyimpan dana pengguna.

## Tentang Fitur Saldo Toko

Fitur manajemen saldo toko memungkinkan Anda untuk memantau dan mengelola dana hasil penjualan di marketplace. Dengan fitur ini Anda dapat melihat berapa pendapatan yang sudah masuk, melakukan penarikan dana, dan memantau riwayat transaksi keuangan.

**Fitur utama yang tersedia:**
- Melihat saldo yang tersedia dan yang sedang diproses
- Melakukan penarikan dana ke rekening bank
- Memantau riwayat semua transaksi keuangan
- Melihat laporan pendapatan dari penjualan
- Analisis aliran dana masuk dan keluar

**Jenis saldo:**
- **Saldo Tersedia**: Dana yang sudah bisa ditarik ke rekening bank
- **Saldo Pending**: Dana yang masih dalam proses settlement (belum bisa ditarik)

## Cara Mengakses Menu Saldo Toko

Untuk melihat dan mengelola saldo toko Anda:

1. Login ke dashboard seller
2. Pilih menu "Wallet Management" 
3. Klik "Balance Overview"

Di halaman ini Anda akan melihat informasi lengkap tentang saldo dan dapat melakukan penarikan dana.

## Memahami Jenis Saldo

**Saldo Tersedia**
- Dana dari penjualan yang sudah dapat ditarik
- Berasal dari pesanan yang sudah selesai dan melewati masa garansi
- Dapat langsung ditransfer ke rekening bank Anda

**Saldo Pending** 
- Dana yang masih dalam proses settlement
- Berasal dari pesanan yang baru selesai tetapi masih dalam periode konfirmasi
- Biasanya akan berubah menjadi saldo tersedia dalam 1-7 hari kerja

**Total Saldo**
- Gabungan dari saldo tersedia dan saldo pending
- Menunjukkan total pendapatan kotor dari semua penjualan

**Pembaruan saldo otomatis:**
- Saldo akan bertambah otomatis ketika ada pesanan selesai
- Pengurangan otomatis terjadi saat ada refund atau penarikan dana
- Sistem memproses pembaruan saldo setiap hari pada pukul 01.00 WIB

## Cara Melakukan Penarikan Dana

**Syarat penarikan dana:**
- Minimal penarikan Rp 50.000
- Harus memiliki rekening bank yang terdaftar
- Saldo tersedia mencukupi untuk jumlah yang ingin ditarik

**Langkah-langkah penarikan:**

1. **Buka halaman penarikan**
   - Di dashboard saldo, klik tombol "Withdraw" atau "Tarik Dana"

2. **Isi formulir penarikan**
   - Masukkan jumlah yang ingin ditarik (minimal Rp 50.000)
   - Pilih rekening bank tujuan (jika punya lebih dari satu)
   - Periksa kembali informasi yang sudah diisi

3. **Submit permintaan penarikan**
   - Klik "Request Withdrawal" untuk mengajukan penarikan
   - Anda akan menerima notifikasi konfirmasi

**Status penarikan:**
- **Pending**: Permintaan baru diajukan, menunggu verifikasi
- **Processing**: Sedang diproses oleh tim keuangan  
- **Completed**: Dana sudah ditransfer ke rekening Anda
- **Failed**: Penarikan gagal, saldo dikembalikan

**Waktu pemrosesan:**
- Penarikan biasanya diproses dalam 1-3 hari kerja
- Dana akan masuk ke rekening bank yang Anda pilih
- Anda akan mendapat notifikasi email ketika transfer selesai

## Melihat Riwayat Transaksi

**Jenis transaksi yang tercatat:**

**Transaksi Masuk:**
- Pembayaran dari pesanan yang sudah selesai
- Pengembalian dana dari refund yang dibatalkan
- Penyesuaian saldo oleh admin (jika ada)

**Transaksi Keluar:**
- Penarikan dana ke rekening bank
- Pengembalian dana untuk refund pesanan
- Penyesuaian saldo oleh admin (jika ada)

**Cara melihat riwayat transaksi:**

1. **Akses halaman transaksi**
   - Dari dashboard saldo, klik "View Transactions" atau "Lihat Riwayat"

2. **Gunakan filter untuk mempermudah pencarian**
   - Filter berdasarkan jenis: Masuk, Keluar, atau Semua
   - Filter berdasarkan status: Pending, Selesai, Gagal
   - Filter berdasarkan tanggal: Hari ini, Minggu ini, Bulan ini, atau custom
   - Cari berdasarkan nomor referensi

3. **Informasi yang ditampilkan**
   - Tanggal dan waktu transaksi
   - Jenis transaksi dan jumlah dana
   - Status transaksi (selesai, pending, atau gagal)
   - Nomor referensi untuk tracking
   - Detail tambahan seperti nomor pesanan atau rekening tujuan

## Dashboard Keuangan

**Informasi yang ditampilkan di dashboard saldo:**

**Kartu Saldo Utama:**
- **Saldo Tersedia**: Jumlah dana yang bisa ditarik (contoh: Rp 2.580.000)  
- **Saldo Pending**: Dana yang sedang diproses (contoh: Rp 750.000)
- **Total Saldo**: Gabungan keseluruhan saldo (contoh: Rp 3.330.000)

**Widget Transaksi Terbaru:**
- Menampilkan 5 transaksi terakhir
- Status setiap transaksi dengan kode warna (hijau=selesai, kuning=pending, merah=gagal)
- Jumlah dana dalam format Rupiah yang mudah dibaca
- Link cepat untuk melihat detail atau melakukan aksi

**Fitur Analisis:**
- Ringkasan pendapatan per bulan
- Riwayat penarikan dana dengan status lengkap  
- Grafik aliran dana masuk dan keluar
- Pelacakan otomatis settlement dari pesanan

## Alur Kerja Saldo Toko

**Bagaimana saldo terbentuk dari penjualan:**

1. **Pesanan selesai**
   - Pembeli mengonfirmasi pesanan diterima dengan baik
   - Atau sistem otomatis konfirmasi setelah batas waktu

2. **Proses settlement**
   - Dana masuk ke saldo pending terlebih dahulu
   - Sistem memotong biaya layanan marketplace
   - Menunggu periode konfirmasi (biasanya 1-7 hari)

3. **Saldo tersedia**
   - Setelah periode konfirmasi selesai, dana pindah ke saldo tersedia
   - Anda bisa langsung melakukan penarikan

4. **Proses penarikan**
   - Pilih jumlah dan rekening tujuan
   - Dana dipindah dari saldo tersedia ke pending withdrawal
   - Tim keuangan memproses transfer (1-3 hari kerja)
   - Setelah berhasil, dana masuk ke rekening bank Anda

## Tampilan Dashboard Saldo

**Layout halaman utama saldo:**

- **Area overview saldo** di bagian atas dengan 3 kartu:
  - Kartu saldo tersedia (warna hijau)
  - Kartu saldo pending (warna kuning) 
  - Kartu total saldo (warna biru)

- **Form penarikan cepat** di bagian tengah:
  - Input jumlah penarikan dengan minimum Rp 50.000
  - Dropdown pilihan rekening bank tujuan
  - Tombol "Request Withdrawal" untuk mengajukan penarikan

- **Daftar transaksi terbaru** di bagian bawah:
  - Menampilkan 5 transaksi terakhir
  - Info lengkap: tanggal, jenis, jumlah, dan status
  - Link "View All" untuk melihat riwayat lengkap

**Formulir penarikan dana:**

- **Input jumlah penarikan**
  - Kolom angka dengan minimum Rp 50.000
  - Maksimum sesuai saldo tersedia
  - Info saldo tersedia ditampilkan di bawah kolom

- **Pilihan rekening bank**
  - Dropdown berisi semua rekening yang sudah terdaftar
  - Rekening utama dipilih secara otomatis
  - Format: Nama Bank - ****1234 (nomor disamarkan)

- **Informasi tambahan**
  - Estimasi waktu pemrosesan: 1-3 hari kerja  
  - Konfirmasi bahwa dana akan ditransfer ke rekening yang dipilih
  - Tombol "Request Withdrawal" untuk submit

## Mengatasi Masalah Umum

**Masalah: "Saldo tidak mencukupi untuk penarikan"**
- Periksa saldo tersedia, pastikan cukup untuk jumlah yang ingin ditarik
- Tunggu saldo pending berubah menjadi tersedia
- Kurangi jumlah penarikan sesuai saldo yang ada

**Masalah: "Rekening bank diperlukan untuk penarikan"**
- Anda harus menambahkan rekening bank terlebih dahulu
- Masuk ke menu Bank Accounts dan tambahkan minimal satu rekening
- Pastikan rekening yang didaftarkan masih aktif

**Masalah: Penarikan lama sekali statusnya pending**
- Hubungi customer service untuk menanyakan status penarikan
- Pastikan rekening bank tujuan masih aktif dan benar
- Periksa apakah ada masalah teknis dengan bank tujuan

**Masalah: Saldo tidak bertambah padahal pesanan sudah selesai**
- Refresh halaman untuk memastikan data terbaru
- Cek status pesanan, pastikan benar-benar sudah selesai (completed)
- Settlement biasanya diproses dalam 1-24 jam, tunggu hingga proses selesai

**Masalah: Transaksi tidak muncul dalam riwayat**
- Coba perluas rentang tanggal pencarian  
- Periksa filter jenis transaksi dan status
- Reset semua filter dan coba cari lagi

## Pertanyaan yang Sering Diajukan

**Berapa minimal penarikan dana?**
Minimum penarikan adalah Rp 50.000 untuk mengurangi biaya administrasi.

**Berapa lama proses penarikan dana?**
Penarikan biasanya diproses dalam 1-3 hari kerja, tergantung bank tujuan dan hari libur.

**Apakah ada biaya penarikan?**
Saat ini tidak ada biaya penarikan, tetapi kebijakan dapat berubah sewaktu-waktu.

**Bisakah membatalkan penarikan yang sudah diajukan?**
Penarikan yang masih berstatus "pending" bisa dibatalkan. Hubungi customer service untuk bantuan.

**Kapan saldo dari pesanan masuk ke akun?**
Saldo masuk otomatis setelah pesanan selesai dan melewati periode konfirmasi (biasanya 7 hari).

**Ada batasan maksimal penarikan per hari?**
Tidak ada batasan khusus, tetapi penarikan dalam jumlah besar mungkin perlu verifikasi tambahan.

**Apa itu saldo pending?**
Saldo pending adalah dana yang sedang dalam proses settlement atau penarikan yang belum selesai.

**Bisakah menarik dana ke rekening orang lain?**
Tidak, penarikan hanya bisa ke rekening bank yang terdaftar atas nama seller sesuai KYC.

**Bagaimana jika penarikan gagal?**
Jika gagal, saldo akan dikembalikan otomatis dan Anda bisa mengajukan penarikan ulang.

**Apakah ada notifikasi untuk transaksi?**
Ya, Anda akan mendapat notifikasi email untuk setiap transaksi penting seperti settlement dan penarikan selesai.

**Tips mengelola saldo:**
- Pantau saldo secara rutin untuk mengetahui cash flow
- Atur jadwal penarikan reguler sesuai kebutuhan
- Sisakan saldo untuk kebutuhan operasional
- Gunakan filter riwayat transaksi untuk analisis keuangan

Jika membutuhkan bantuan terkait saldo dan penarikan, hubungi tim customer service melalui live chat atau email.

**Catatan:** Fitur ini mengikuti kebijakan perusahaan dan regulasi keuangan yang berlaku. Kebijakan dapat berubah sewaktu-waktu sesuai peraturan.
