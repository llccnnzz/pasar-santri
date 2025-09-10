# 👥 Seller Management - Admin Pasar Santri

## Deskripsi
Seller Management adalah modul untuk mengelola semua penjual (seller) yang terdaftar di Pasar Santri Marketplace. Sistem ini memberikan kontrol penuh kepada admin untuk memantau, mengelola, dan mengsupervisi aktivitas seller serta toko mereka.

## Tujuan
- Mengelola database seller yang terverifikasi KYC
- Memantau performa dan aktivitas seller
- Mengatur status aktif/non-aktif seller
- Mengelola suspensi dan unsuspensi toko
- Memastikan compliance seller terhadap kebijakan marketplace
- Memberikan dukungan dan bantuan kepada seller

## Akses & Permission
**Role Required:** Administrator  
**Permission:** 
- `admin-dashboard|index seller` - Melihat daftar seller
- `admin-dashboard|show seller` - Melihat detail seller
- `admin-dashboard|update seller` - Edit informasi seller dan status

**URL:** `/admin/sellers`

## Seller Lifecycle Management

### **Seller Journey dalam Sistem:**
```
┌─────────────────────────────────────────────────────────────┐
│ SELLER LIFECYCLE IN PASAR SANTRI                            │
├─────────────────────────────────────────────────────────────┤
│ 1. USER REGISTRATION                                        │
│    ├─ Basic user account (Role: Buyer)                      │
│    └─ Email verification                                    │
├─────────────────────────────────────────────────────────────┤
│ 2. KYC APPLICATION                                          │
│    ├─ Submit KYC documents                                  │
│    ├─ Admin review & approval                               │
│    └─ Auto-assigned "Seller" role                           │
├─────────────────────────────────────────────────────────────┤
│ 3. SHOP SETUP                                               │
│    ├─ Create shop profile                                   │
│    ├─ Bank account setup                                    │
│    └─ Shipping configuration                                │
├─────────────────────────────────────────────────────────────┤
│ 4. ACTIVE SELLER                                            │
│    ├─ List products & manage inventory                      │
│    ├─ Process orders & handle customers                     │
│    ├─ Manage finances & withdrawals                         │
│    └─ Admin monitoring & support                            │
├─────────────────────────────────────────────────────────────┤
│ 5. POTENTIAL ACTIONS                                        │
│    ├─ Deactivation (temporary)                              │
│    ├─ Shop suspension (policy violation)                    │
│    ├─ Account termination (severe cases)                    │
│    └─ Reactivation & rehabilitation                         │
└─────────────────────────────────────────────────────────────┘
```

## Status & Classification Seller

### **1. User Status (Account Level):**
- **Active** - Account aktif, bisa login dan beroperasi
- **Inactive** - Account dinonaktifkan, tidak bisa login

### **2. Shop Status (Business Level):**
- **Active** - Toko beroperasi normal
- **Suspended** - Toko disuspend sementara
- **No Shop** - Seller belum setup toko

### **3. Seller Categories:**
- **New Sellers** - Baru bergabung < 30 hari
- **Active Sellers** - Punya toko dan aktif jualan
- **Dormant Sellers** - Punya akun tapi tidak aktif
- **Suspended Sellers** - Toko atau akun disuspend

## Cara Menggunakan Seller Management

### **Akses Halaman Seller Management**
1. Login sebagai Administrator
2. Buka menu **Admin Dashboard**
3. Navigasi ke **Seller Management**
4. Atau akses langsung: `/admin/sellers`

### **Dashboard Overview**
Halaman menampilkan statistik:
- **Total Sellers:** Jumlah semua seller terdaftar
- **Active Sellers:** Seller dengan akun aktif
- **Suspended:** Seller dengan toko yang disuspend
- **With Shops:** Seller yang sudah setup toko

### **Filter & Pencarian Seller**

#### **Filter berdasarkan Status:**
- **All:** Tampilkan semua seller
- **Active:** Hanya seller aktif dengan toko normal
- **Inactive:** Seller dengan akun nonaktif
- **Suspended:** Seller dengan toko yang disuspend
- **No Shop:** Seller yang belum setup toko

#### **Search Function:**
Pencarian berdasarkan:
- **Nama seller** (user name)
- **Email address** seller
- **Nama toko** (shop name)
- **Slug toko** (shop URL)

#### **Sorting Options:**
- **Created Date:** Urutkan berdasarkan tanggal daftar
- **Name:** Urutkan berdasarkan nama seller
- **Shop Name:** Urutkan berdasarkan nama toko
- **Last Activity:** Urutkan berdasarkan aktivitas terakhir

### **Melihat Detail Seller**

#### **Akses Detail Seller:**
1. Klik nama seller atau tombol "View Details"
2. Halaman detail menampilkan informasi lengkap seller

#### **Informasi yang Ditampilkan:**

**Basic Information:**
- Nama lengkap seller
- Email address
- Status akun (active/inactive)
- Tanggal registrasi
- Role permissions

**Shop Information:**
- Nama toko dan slug
- Status toko (active/suspended)
- Alamat toko lengkap
- Bank account information
- Setup completion status

**KYC Status:**
- Status verifikasi KYC
- Dokumen yang sudah disubmit
- Admin yang mereview
- Tanggal approval/rejection

**Business Statistics:**
- **Total Products:** Jumlah produk yang dimiliki
- **Active Products:** Produk yang sedang aktif dijual
- **Total Orders:** Total pesanan yang diterima
- **Completed Orders:** Pesanan yang selesai
- **Total Revenue:** Total pendapatan seller

**Recent Activity:**
- 5 produk terakhir yang ditambahkan
- 5 pesanan terakhir yang diterima
- Activity log dan history

## Mengelola Seller

### **Edit Informasi Seller**

#### **Data yang Bisa Diedit:**
1. **Nama Lengkap** - Update nama display seller
2. **Email Address** - Ubah email (dengan validasi unique)
3. **Account Status** - Toggle active/inactive

#### **Cara Edit:**
1. Buka detail seller
2. Klik tombol **"Edit Seller Information"**
3. Update data yang diperlukan
4. Klik **"Save Changes"**

### **Toggle Status Seller (Active/Inactive)**

#### **Deactivate Seller:**
- **Effect:** Seller tidak bisa login ke sistem
- **Shop Impact:** Toko tetap bisa dilihat tapi tidak bisa dikelola
- **Order Impact:** Pesanan existing tetap berjalan
- **Use Case:** Temporary suspension, investigation, dll

#### **Activate Seller:**
- **Effect:** Seller bisa login kembali
- **Shop Impact:** Bisa mengelola toko normal
- **Order Impact:** Bisa memproses pesanan baru
- **Use Case:** Rehabilitation setelah penyelesaian masalah

#### **Cara Toggle Status:**
1. Buka detail seller
2. Klik toggle switch **"Account Status"**
3. Konfirmasi action
4. Status berubah secara real-time

## Mengelola Shop Seller

### **Akses Shop Management**
1. Dari detail seller, klik **"View Shop"**
2. Atau akses langsung ke shop management
3. Halaman khusus untuk mengelola toko

### **Shop Suspension Management**

#### **Suspend Shop (Temporary Closure):**
**Kapan Digunakan:**
- Policy violation (pelanggaran aturan)
- Quality issues (masalah kualitas produk)
- Customer complaints (banyak komplain)
- Investigation period (sedang investigasi)
- Fraud suspicion (dugaan penipuan)

**Yang Terjadi Saat Suspend:**
- Toko tidak muncul di search results
- Produk tidak bisa dibeli buyer
- Seller tidak bisa update produk
- Pesanan existing tetap berjalan
- Seller masih bisa komunikasi dengan buyer
- Withdrawal dana tetap bisa dilakukan

#### **Cara Suspend Shop:**
1. Buka shop management page
2. Klik **"Suspend Shop"**
3. **Wajib:** Isi alasan suspension yang detail
4. Konfirmasi suspension
5. Sistem otomatis:
   - Update status shop menjadi suspended
   - Record admin yang suspend dan timestamp
   - Send notification ke seller
   - Log activity untuk audit trail

#### **Unsuspend Shop (Reactivation):**
**Requirements:**
- Masalah yang menyebabkan suspend sudah resolved
- Seller sudah comply dengan requirements
- Admin sudah verify perbaikan

#### **Cara Unsuspend Shop:**
1. Buka shop management page (shop yang suspended)
2. Klik **"Unsuspend Shop"**  
3. Konfirmasi unsuspension
4. Sistem otomatis:
   - Update status shop menjadi active
   - Clear suspension records
   - Send notification ke seller
   - Log activity untuk audit trail

### **Shop Information Management**
**Data yang Bisa Dilihat/Dikelola:**
- Shop profile dan branding
- Product catalog dan inventory
- Order history dan performance
- Bank account dan payment settings
- Shipping configuration
- Customer reviews dan ratings

## Analytics & Monitoring

### **Individual Seller Analytics:**
**Performance Metrics:**
- **Sales Volume:** Total penjualan per periode
- **Revenue Growth:** Trend pertumbuhan pendapatan
- **Order Completion Rate:** Persentase pesanan selesai
- **Customer Satisfaction:** Rating dan review average
- **Response Time:** Waktu respon ke customer
- **Product Quality Score:** Score kualitas produk

**Business Health Indicators:**
- **Active Product Ratio:** Persentase produk aktif vs total
- **Inventory Management:** Stock availability dan turnover
- **Financial Health:** Cash flow dan withdrawal patterns
- **Compliance Score:** Adherence terhadap marketplace policies

### **System-wide Seller Analytics:**
**Marketplace Overview:**
- **Total Active Sellers:** Jumlah seller aktif
- **New Seller Acquisition:** Rate pertambahan seller baru
- **Seller Retention Rate:** Persentase seller yang bertahan
- **Average Seller Performance:** Benchmark metrics

**Quality Metrics:**
- **Suspension Rate:** Persentase seller yang disuspend
- **Reactivation Success:** Success rate unsuspension
- **Policy Compliance:** Overall compliance rate
- **Customer Satisfaction:** Average satisfaction terhadap seller

## Policy Enforcement

### **Common Violations:**
1. **Product Policy Violations:**
   - Listing prohibited items
   - Misleading product descriptions
   - Copyright infringement
   - Poor product quality

2. **Service Policy Violations:**
   - Poor customer service
   - Late shipping or delivery
   - Not responding to customer inquiries
   - Fake reviews or manipulation

3. **Financial Policy Violations:**
   - Price manipulation
   - Hidden fees
   - Fraudulent transactions
   - Money laundering suspicion

### **Enforcement Actions:**

#### **Warning System:**
- **1st Warning:** Education dan guidance
- **2nd Warning:** Temporary restrictions
- **3rd Warning:** Shop suspension review

#### **Progressive Discipline:**
1. **Verbal Warning** - Education dan coaching
2. **Written Warning** - Official documentation
3. **Temporary Restriction** - Limited features
4. **Shop Suspension** - Temporary closure
5. **Account Termination** - Permanent ban

### **Appeals Process:**
1. **Seller Submission:** Seller submit appeal dengan evidence
2. **Admin Review:** Thorough review of case
3. **Decision Communication:** Clear communication of decision
4. **Resolution:** Implementation of decision
5. **Follow-up:** Monitoring post-resolution

## Troubleshooting

### **Problem: Seller tidak bisa login**
**Possible Causes:**
- Account status inactive
- Password reset needed
- Email verification pending
- Technical issues

**Solutions:**
1. Check account status di admin panel
2. Verify email verification status
3. Reset password jika diperlukan
4. Check untuk technical issues

### **Problem: Shop tidak muncul di marketplace**
**Possible Causes:**
- Shop suspended
- Shop setup belum complete
- Products tidak aktif
- Search indexing issues

**Solutions:**
1. Check shop suspension status
2. Verify shop setup completion
3. Check product active status
4. Re-index shop dalam search

### **Problem: Seller tidak bisa withdraw dana**
**Possible Causes:**
- Bank account belum setup
- Insufficient balance
- Withdrawal limits
- System maintenance

**Solutions:**
1. Verify bank account setup
2. Check balance dan minimum withdrawal
3. Review withdrawal policies
4. Check system status

### **Problem: Suspend/unsuspend tidak berfungsi**
**Possible Causes:**
- Permission issues
- Database constraints
- Concurrent modifications
- System errors

**Solutions:**
1. Verify admin permissions
2. Check database integrity
3. Refresh dan retry
4. Check system logs for errors

## Best Practices

### **Seller Onboarding:**
1. **Welcome Communication:** Proper introduction dan guidance
2. **Setup Assistance:** Help dengan shop setup
3. **Training Materials:** Provide comprehensive guides
4. **Regular Check-ins:** Monitor progress awal seller

### **Ongoing Management:**
1. **Regular Reviews:** Periodic seller performance review
2. **Proactive Communication:** Early intervention untuk issues
3. **Policy Updates:** Keep sellers informed tentang changes
4. **Performance Feedback:** Regular feedback dan improvement suggestions

### **Conflict Resolution:**
1. **Listen First:** Understand seller perspective
2. **Fair Investigation:** Thorough dan unbiased investigation
3. **Clear Communication:** Transparent communication process
4. **Documentation:** Proper record keeping untuk semua actions

### **Growth Support:**
1. **Performance Analytics:** Provide seller dengan insights
2. **Marketing Support:** Help dengan promotional activities
3. **Technical Support:** Assist dengan platform usage
4. **Business Guidance:** Provide business development advice

## Legal & Compliance

### **Data Protection:**
- **GDPR Compliance:** Protect seller personal data
- **Access Control:** Limited access to sensitive information
- **Audit Trail:** Complete logging of admin actions
- **Data Retention:** Appropriate retention policies

### **Business Compliance:**
- **Tax Obligations:** Ensure seller tax compliance
- **Business Licenses:** Verify business registration
- **Product Regulations:** Ensure product safety compliance
- **Consumer Protection:** Enforce consumer protection laws

### **Platform Policies:**
- **Terms of Service:** Enforce platform ToS
- **Seller Agreement:** Monitor seller agreement compliance
- **Quality Standards:** Maintain marketplace quality standards
- **Fair Trading:** Ensure fair trading practices

---

## Support & Bantuan

Jika mengalami kesulitan dalam menggunakan Seller Management:

1. **Technical Issues:** Hubungi tim development PT. Sidogiri Fintech Utama
2. **Policy Questions:** Konsultasi dengan legal & compliance team  
3. **Seller Relations:** Hubungi seller success team
4. **Escalation Needed:** Contact senior management
5. **General Support:** Kontak support Pasar Santri Marketplace

### **Emergency Contacts:**
- **Fraud Alert:** Immediate escalation ke security team
- **Legal Issues:** Escalate ke legal department  
- **System Critical:** Contact tech support hotline
- **Business Critical:** Notify business stakeholders

### **Seller Support Resources:**
- **Help Center:** Comprehensive seller guides
- **Training Programs:** Regular seller education sessions
- **Support Tickets:** Seller support ticket system
- **Community Forum:** Seller community dan peer support

**Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**Focus:** Seller Success & Marketplace Quality  
**Last Updated:** September 2025  
**Version:** 1.0
