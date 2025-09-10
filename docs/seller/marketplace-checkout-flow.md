# 🛒 Marketplace Checkout Flow - Pasar Santri

## 📋 Deskripsi
Marketplace Checkout Flow adalah sistem lengkap untuk proses pembelian produk di Pasar Santri, mulai dari menambahkan produk ke keranjang belanja, mengelola item, menggunakan kode promo, hingga menyelesaikan pembayaran melalui integrasi Emaal. Sistem ini dirancang untuk memberikan pengalaman berbelanja yang aman, mudah, dan efisien bagi pelanggan terdaftar.

## 🎯 Tujuan
- Menyediakan keranjang belanja yang fleksibel dan mudah dikelola
- Memfasilitasi proses checkout yang streamlined dan user-friendly
- Mengintegrasikan sistem pembayaran Emaal untuk transaksi yang aman
- Memberikan opsi kode promo dan diskon untuk pengalaman berbelanja yang menguntungkan
- Memastikan keamanan data pembayaran dan informasi pribadi pelanggan

## 🔐 Akses & Persyaratan
**Role Required:** Buyer/Customer yang sudah login  
**Permission:** Akses ke keranjang belanja dan sistem pembayaran  
**URL:** `/cart`, `/checkout`, `/payment`

## ⭐ Fitur Utama Checkout Flow

### 1. **Shopping Cart Management**
- Menambah, mengurangi, dan menghapus produk dari keranjang
- Kalkulasi otomatis subtotal, ongkos kirim, dan total pembayaran
- Simpan keranjang untuk session berikutnya

### 2. **Checkout Integration dengan Emaal**  
- Integrasi seamless dengan payment gateway Emaal
- Multiple pilihan metode pembayaran (bank transfer, e-wallet, kartu kredit)
- Sistem keamanan berlapis untuk proteksi transaksi

### 3. **Promo Code System**
- Input dan validasi kode promo untuk diskon
- Kombinasi berbagai jenis promo (persentase, nominal, free shipping)
- Tracking penggunaan kode promo dan eligibilitas

### 4. **Payment Handling**
- Pemrosesan pembayaran real-time melalui Emaal
- Konfirmasi pembayaran dan invoice otomatis
- Status tracking pembayaran dan notifikasi

### 5. **Order Confirmation**
- Konfirmasi pesanan dengan detail lengkap
- Email confirmation dan SMS notification
- Invoice dan receipt digital

---

## 📋 Persyaratan Akses Checkout Flow

### Prasyarat Wajib

1. **Akun Terdaftar**: Pengguna harus memiliki akun yang sudah login
2. **Alamat Pengiriman**: Minimal satu alamat tersimpan di address book
3. **Produk di Keranjang**: Minimal satu produk valid di shopping cart
4. **Metode Pembayaran**: Pilihan payment method yang tersedia melalui Emaal

### Prasyarat Opsional

1. **Nomor Telepon Terverifikasi**: Untuk notifikasi SMS dan keamanan tambahan
2. **Email Terverifikasi**: Untuk konfirmasi pesanan dan invoice
3. **Kode Promo**: Jika ingin menggunakan diskon atau promo khusus

---

## 🛒 Shopping Cart Management

### Tentang Shopping Cart

**Fungsi Utama Cart:**
- Temporary storage untuk produk yang ingin dibeli
- Kalkulasi otomatis harga dan ongkos kirim
- Session persistence - keranjang tersimpan meskipun logout
- Cross-device synchronization untuk pengguna yang login
- Batch operations untuk efficiency

**Keunggulan Cart System:**
- Real-time stock validation untuk memastikan ketersediaan produk
- Auto-save changes untuk mencegah kehilangan data
- Smart recommendations berdasarkan items di cart
- Bulk actions untuk mengelola multiple items sekaligus

### Mengelola Items di Cart

#### 1. Menambahkan Produk ke Cart
**Dari Halaman Produk:**
- Pilih variasi produk (ukuran, warna, dll) jika tersedia
- Tentukan jumlah quantity yang diinginkan
- Klik tombol "Add to Cart" atau "Masukkan Keranjang"
- Produk akan otomatis tersimpan di shopping cart

**Dari Halaman Kategori/Search:**
- Klik tombol cart pada thumbnail produk
- Untuk produk dengan variasi, akan diarahkan ke halaman detail terlebih dahulu
- Quick add untuk produk tanpa variasi

**Validasi Saat Menambah:**
- Cek stock availability secara real-time
- Validasi maximum quantity per customer
- Pengecekan minimum order requirement
- Konfirmasi harga dan promo yang berlaku

#### 2. Mengubah Quantity Produk
**Adjust Quantity:**
- Gunakan tombol (+) dan (-) untuk mengubah jumlah
- Input manual quantity di field input
- Sistem akan validasi dengan stock yang tersedia
- Auto-update subtotal dan total cart secara real-time

**Batch Update:**
- Select multiple items untuk bulk quantity change
- Apply percentage increase/decrease untuk semua selected items
- Mass update dengan CSV import untuk large orders

**Smart Suggestions:**
- Rekomendasi quantity berdasarkan bulk pricing
- Notifikasi jika quantity mendekati maximum stock
- Saran untuk mencapai minimum order untuk free shipping

#### 3. Menghapus Item dari Cart
**Single Item Removal:**
- Klik tombol "X" atau "Remove" pada item yang ingin dihapus
- Konfirmasi penghapusan untuk mencegah accident removal
- Item akan dipindahkan ke "Recently Removed" untuk recovery

**Bulk Removal:**
- Select multiple items dengan checkbox
- Klik "Remove Selected" untuk bulk deletion
- Option untuk clear entire cart sekaligus

**Save for Later:**
- Pindahkan item ke wishlist instead of deleting
- Temporary removal dengan opsi restore
- Archive items untuk future purchase

### Cart Calculations dan Pricing

#### 1. Subtotal dan Pricing
**Komponen Harga:**
- **Product Price**: Harga dasar produk per unit
- **Quantity Discount**: Diskon berdasarkan jumlah pembelian
- **Member Discount**: Diskon khusus member atau loyalty program
- **Subtotal**: Total harga sebelum ongkos kirim dan pajak

**Dynamic Pricing:**
- Real-time price update jika ada perubahan harga produk
- Flash sale pricing dengan countdown timer
- Bulk pricing tiers untuk quantity purchases
- Member exclusive pricing untuk registered customers

#### 2. Shipping Calculation
**Ongkos Kirim Otomatis:**
- Kalkulasi berdasarkan alamat pengiriman yang dipilih
- Multiple shipping options (reguler, express, same day)
- Weight-based dan volume-based shipping rates
- Free shipping threshold notification

**Shipping Options:**
- **Reguler (2-3 hari)**: Opsi standar dengan biaya terendah
- **Express (1-2 hari)**: Pengiriman cepat dengan biaya tambahan  
- **Same Day**: Pengiriman di hari yang sama untuk area tertentu
- **Pickup**: Option untuk pickup di store/warehouse

#### 3. Tax dan Fees
**Komponen Tambahan:**
- **PPN (11%)**: Pajak pertambahan nilai sesuai regulasi
- **Service Fee**: Biaya layanan platform (jika ada)
- **Insurance**: Asuransi pengiriman (optional)
- **Handling Fee**: Biaya penanganan untuk produk khusus

---

## 🎫 Promo Code System

### Tentang Sistem Promo Code

**Jenis Promo Code:**
- **Percentage Discount**: Diskon berdasarkan persentase (contoh: 10% off)
- **Fixed Amount**: Diskon nominal tetap (contoh: Rp 50.000 off)
- **Free Shipping**: Gratis ongkos kirim untuk pembelian tertentu
- **Buy One Get One**: Promo pembelian dengan bonus produk
- **Bundle Discount**: Diskon untuk pembelian paket produk

**Sumber Promo Code:**
- Newsletter subscription rewards
- Social media campaigns dan giveaways
- Loyalty program benefits
- Special event promotions (Ramadan, Christmas, etc.)
- First-time buyer incentives

### Cara Menggunakan Promo Code

#### 1. Memasukkan Kode Promo
**Langkah Penggunaan:**
- Di halaman cart, cari section "Promo Code" atau "Kode Voucher"
- Input kode promo di field yang tersedia
- Klik tombol "Apply" atau "Gunakan Kode"
- Sistem akan validasi kode dan menampilkan hasil

**Validasi Kode Promo:**
- Cek expiry date dan periode berlaku promo
- Validasi minimum purchase requirement
- Pengecekan user eligibility (first-time, member level, dll)
- Verifikasi product/category eligibility

#### 2. Multiple Promo Stacking
**Kombinasi Promo:**
- Beberapa marketplace mengizinkan stacking multiple promo codes
- Priority system untuk promo dengan benefit terbesar
- Automatic application of the best available discount
- Clear indication of which promos are active

**Promo Conflicts:**
- Sistem akan memberitahu jika ada conflict antar promo codes
- Rekomendasi kombinasi promo terbaik untuk maximum savings
- Override options untuk memilih specific promo combination

#### 3. Promo Code Management
**Tracking Active Promos:**
- List semua promo yang sedang aktif di account
- Expiry date notifications untuk promo codes yang akan expire
- Usage history dan remaining quota untuk limited-use promos
- Sharing options untuk referral-based promos

**Promo Discovery:**
- In-app notifications untuk available promos
- Personalized promo recommendations
- Category-based promo suggestions
- Seasonal dan event-based promo alerts

---

## 💳 Checkout Integration (Emaal)

### Tentang Integrasi Emaal

**Emaal Payment Gateway:**
Emaal adalah payment gateway yang terintegrasi dengan marketplace untuk memfasilitasi berbagai metode pembayaran yang aman dan terpercaya. Sistem ini mendukung multiple payment channels dan memberikan pengalaman checkout yang seamless.

**Keunggulan Emaal Integration:**
- **Multi-channel Payment**: Support untuk bank transfer, e-wallet, credit card
- **Real-time Processing**: Verifikasi pembayaran instan
- **Security Standards**: Compliance dengan PCI DSS dan security standards
- **Mobile Optimization**: Optimized untuk pembayaran mobile
- **Local Payment Methods**: Support untuk payment methods populer di Indonesia

### Proses Checkout dengan Emaal

#### 1. Initiate Checkout Process
**Langkah Awal Checkout:**
- Dari cart, klik tombol "Checkout" atau "Bayar Sekarang"
- Sistem akan redirect ke halaman checkout summary
- Validasi cart contents dan stock availability
- Load payment options yang tersedia melalui Emaal

**Pre-checkout Validation:**
- Verifikasi user authentication status
- Cek alamat pengiriman yang valid
- Konfirmasi cart contents dan pricing
- Validate promo codes yang digunakan

#### 2. Checkout Information Review
**Review Order Summary:**
- **Items Review**: Daftar produk, quantity, dan harga per item
- **Shipping Details**: Alamat pengiriman dan metode pengiriman
- **Payment Summary**: Subtotal, shipping, tax, discount, dan grand total
- **Estimated Delivery**: Perkiraan waktu sampai berdasarkan shipping method

**Editable Information:**
- Change shipping address dari address book
- Modify shipping method (reguler, express, same day)
- Adjust quantity items (redirect back to cart)
- Add atau remove promo codes

#### 3. Payment Method Selection
**Available Payment Channels via Emaal:**

**Bank Transfer:**
- Transfer manual ke virtual account
- Auto-verification untuk bank partner
- QR Code untuk mobile banking
- Internet banking redirect

**E-Wallet:**
- GoPay, OVO, DANA, LinkAja integration
- One-click payment untuk registered wallets
- QR Code scanning untuk mobile app
- Balance check dan top-up options

**Credit/Debit Card:**
- Visa, MasterCard, JCB support
- Secure 3D authentication
- Save card for future payments (tokenization)
- Installment options untuk credit cards

**Alternative Methods:**
- QRIS untuk universal QR payments
- Convenience store payments (Indomaret, Alfamart)
- Post-payment methods (COD jika tersedia)

### Emaal Payment Process

#### 1. Payment Gateway Redirect
**Seamless Integration:**
- User diarahkan ke secure Emaal payment page
- Maintain session dan order information
- Encrypted data transmission untuk security
- Mobile-responsive payment interface

**Payment Page Features:**
- Clear order summary dan payment amount
- Multiple payment method tabs
- Real-time payment status updates
- Cancel payment dan return to cart options

#### 2. Payment Execution
**Real-time Processing:**
- Instant payment verification untuk e-wallet dan cards
- Pending status untuk bank transfer dengan confirmation timeline
- SMS dan email notifications untuk payment status
- Automatic order processing setelah payment confirmed

**Payment Security:**
- End-to-end encryption untuk payment data
- PCI DSS compliance untuk card payments
- Fraud detection dan prevention systems
- Secure token storage untuk saved payment methods

#### 3. Payment Confirmation
**Successful Payment:**
- Immediate redirect ke order confirmation page
- Email receipt dengan payment details
- SMS notification dengan order number
- Invoice generation dan download option

**Failed Payment:**
- Error message dengan specific failure reason
- Retry payment dengan same atau different method
- Cart preservation untuk payment retry
- Customer service contact untuk payment issues

---

## 💰 Payment Handling

### Payment Processing Workflow

#### 1. Payment Verification
**Automatic Verification:**
- Real-time payment status check melalui Emaal API
- Webhook notifications untuk payment updates
- Automatic order status update setelah payment confirmed
- Invoice generation dan email dispatch

**Manual Verification:**
- Admin review untuk suspicious transactions
- Customer service verification untuk large amounts
- Document verification untuk certain payment methods
- Fraud prevention checks

#### 2. Payment Status Management
**Status Types:**
- **Pending**: Payment initiated, menunggu konfirmasi
- **Processing**: Payment sedang diverifikasi oleh system
- **Completed**: Payment berhasil dan confirmed
- **Failed**: Payment gagal atau rejected
- **Cancelled**: Payment dibatalkan oleh user atau system
- **Refunded**: Payment yang sudah dikembalikan

**Status Notifications:**
- Real-time status update di user dashboard
- Email notifications untuk setiap status change
- SMS alerts untuk critical payment events
- Push notifications untuk mobile app users

#### 3. Post-Payment Processing
**Order Activation:**
- Automatic order creation setelah successful payment
- Inventory adjustment dan stock deduction
- Seller notification untuk order fulfillment
- Shipping label generation dan logistics coordination

**Customer Communication:**
- Order confirmation email dengan tracking details
- SMS notification dengan estimated delivery time
- WhatsApp integration untuk order updates (optional)
- Customer portal access untuk order tracking

### Payment Security dan Compliance

#### 1. Security Measures
**Data Protection:**
- PCI DSS Level 1 compliance
- SSL/TLS encryption untuk all payment communications
- Tokenization untuk stored payment information
- Regular security audits dan penetration testing

**Fraud Prevention:**
- Real-time fraud scoring untuk transactions
- Machine learning untuk suspicious pattern detection
- Velocity checking untuk multiple payment attempts
- Device fingerprinting untuk user verification

#### 2. Compliance Standards
**Regulatory Compliance:**
- Bank Indonesia regulations compliance
- Anti-money laundering (AML) procedures
- Know Your Customer (KYC) requirements untuk large transactions
- Tax reporting dan invoice generation sesuai regulasi

**Privacy Protection:**
- GDPR-compliant data handling
- User consent management untuk data processing
- Right to data deletion dan portability
- Transparent privacy policy dan terms of service

---

## 📊 Order Management Post-Payment

### Order Creation dan Tracking

#### 1. Order Generation
**Automatic Order Creation:**
- Unique order ID generation setelah successful payment
- Complete order details dengan itemization
- Customer information dan shipping details
- Payment method dan transaction reference

**Order Documentation:**
- Digital invoice dengan tax calculations
- Receipt dengan payment breakdown
- Shipping manifest untuk logistics
- Order history record di customer account

#### 2. Order Tracking Integration
**Real-time Tracking:**
- Integration dengan logistics providers untuk tracking
- Automated status updates dari warehouse ke delivery
- GPS tracking untuk supported shipping methods
- Estimated delivery time dengan real-time adjustments

**Customer Visibility:**
- Order tracking page dengan live updates
- Email notifications untuk status changes
- SMS alerts untuk key milestones
- Mobile app push notifications

#### 3. Post-Purchase Customer Service
**Support Channels:**
- Live chat integration untuk immediate assistance
- Email support untuk detailed queries
- Phone support untuk urgent issues
- WhatsApp customer service untuk mobile users

**Issue Resolution:**
- Return dan refund process integration
- Exchange requests untuk defective items
- Delivery issue resolution protocols
- Escalation procedures untuk complex problems

---

## ⚠️ Troubleshooting & FAQ

### Common Checkout Issues

#### Masalah 1: Cart Items Unavailable
**Gejala**: Produk di cart shows "out of stock" saat checkout
**Solusi**:
- Remove out of stock items dari cart
- Check alternative products atau variations
- Set stock alert untuk restock notifications
- Contact seller untuk expected restock timeline
- Save items ke wishlist untuk future purchase

#### Masalah 2: Promo Code Not Working
**Gejala**: Kode promo tidak bisa diapply atau shows error
**Solusi**:
- Verify promo code spelling dan format
- Check expiry date dan validity period
- Ensure minimum purchase requirement terpenuhi
- Verify product/category eligibility untuk promo
- Contact customer service jika kode valid tapi tidak bekerja

#### Masalah 3: Payment Gateway Error
**Gejala**: Payment fails atau error saat redirect ke Emaal
**Solusi**:
- Check internet connection stability
- Try different payment method
- Clear browser cache dan cookies
- Disable browser ad-blockers
- Use different browser atau device
- Contact Emaal support untuk technical issues

#### Masalah 4: Address Validation Error
**Gejala**: Shipping address tidak bisa validated atau shows error
**Solusi**:
- Verify alamat lengkap dengan kode pos correct
- Use standard format untuk address input
- Add landmark atau patokan untuk clarity
- Contact customer service untuk address verification
- Use alternative address dari address book

#### Masalah 5: Order Confirmation Not Received
**Gejala**: Payment successful tapi tidak ada order confirmation
**Solusi**:
- Check spam/junk folder untuk email confirmation
- Verify email address di profile settings
- Check order history di user dashboard
- Wait up to 30 minutes untuk system processing
- Contact customer service dengan payment reference number

### FAQ Checkout Flow

#### T: Berapa lama cart items akan tersimpan?
**J**: Items di cart akan tersimpan selama 7 hari untuk logged-in users. Untuk guest users, items akan hilang saat browser session berakhir.

#### T: Apakah bisa menggunakan multiple promo codes sekaligus?
**J**: Tergantung terms dari masing-masing promo. Beberapa promo bisa dikombinasi, tapi system akan automatically apply combination dengan benefit terbesar.

#### T: Bagaimana jika payment gagal setelah beberapa kali mencoba?
**J**: Setelah 3 kali gagal, account akan di-temporary block untuk payment selama 30 menit. Setelah itu bisa mencoba lagi atau contact customer service.

#### T: Apakah ada biaya tambahan untuk menggunakan payment gateway Emaal?
**J**: Tidak ada biaya tambahan untuk customer. Semua processing fees ditanggung oleh marketplace.

#### T: Bisa cancel order setelah payment berhasil?
**J**: Order bisa dicancel selama status masih "Processing" dan belum dikirim oleh seller. Refund akan diproses dalam 3-7 hari kerja.

#### T: Bagaimana cara mendapatkan invoice untuk keperluan bisnis?
**J**: Invoice otomatis dikirim via email setelah payment confirmed. Untuk invoice dengan kop perusahaan, bisa request ke customer service dengan melampirkan NPWP.

#### T: Apakah data kartu kredit aman disimpan?
**J**: Marketplace tidak menyimpan data kartu kredit. Semua payment processing dilakukan oleh Emaal yang PCI DSS certified untuk keamanan maksimal.

#### T: Bisa ubah alamat pengiriman setelah checkout?
**J**: Alamat bisa diubah selama status order masih "Processing" dan belum dikirim. Contact customer service atau update via order management page.

---

## 💡 Tips & Best Practices

### Optimasi Checkout Experience

**Preparation Tips:**
- Pastikan alamat pengiriman lengkap dan accurate sebelum checkout
- Verify payment method balance atau limit sebelum transaction
- Check promo code validity dan requirements sebelum apply
- Review order summary carefully sebelum confirm payment
- Save frequently used addresses dan payment methods untuk convenience

**Security Best Practices:**
- Selalu logout dari shared atau public devices setelah checkout
- Verify website URL (https) sebelum enter payment information
- Don't save payment information di public atau shared computers
- Monitor bank/e-wallet statements untuk unauthorized transactions
- Report suspicious activity immediately ke customer service

**Mobile Checkout Optimization:**
- Use mobile app untuk faster checkout experience
- Enable push notifications untuk real-time order updates
- Save payment methods untuk quick mobile payments
- Use mobile banking apps untuk faster bank transfer
- Enable biometric authentication untuk security

### Cost Saving Strategies

**Smart Shopping:**
- Plan purchases untuk maximize free shipping threshold
- Stack applicable promo codes untuk maximum savings
- Subscribe newsletter untuk exclusive promo codes
- Follow social media untuk flash sale notifications
- Use wishlist price tracking untuk buy at optimal price

**Payment Method Selection:**
- Choose payment methods dengan lowest processing fees
- Use e-wallet promotions untuk additional discounts
- Consider installment options untuk large purchases
- Use credit card points atau cashback benefits
- Check bank-specific promotions untuk additional savings

### Error Prevention

**Common Mistakes to Avoid:**
- Tidak verify stock availability sebelum proceed ke checkout
- Menggunakan expired atau invalid promo codes
- Salah input alamat pengiriman atau contact information
- Tidak check total amount sebelum confirm payment
- Menggunakan payment method dengan insufficient balance

**Quality Assurance:**
- Double-check quantity dan variations sebelum checkout
- Verify seller reputation dan product reviews
- Read return policy dan warranty information
- Understand shipping terms dan delivery timeline
- Keep payment confirmation screenshots untuk reference

---

**Tips untuk Pengalaman Checkout Optimal:**
- Gunakan saved addresses dan payment methods untuk checkout cepat
- Manfaatkan promo codes dan seasonal discounts untuk savings
- Review order details carefully sebelum payment confirmation
- Keep order confirmation dan payment receipts untuk records

**Mobile Experience**: Download mobile app untuk checkout experience yang lebih smooth, push notifications real-time, dan access ke exclusive mobile-only promotions.

**Customer Support**: Jika mengalami kesulitan dengan checkout process, customer service tersedia 24/7 melalui live chat, email, atau phone untuk bantuan immediate dan detailed guidance.
