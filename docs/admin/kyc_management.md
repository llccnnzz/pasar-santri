# KYC Management - Admin Pasar Santri

## Deskripsi
KYC (Know Your Customer) Management adalah modul untuk mengelola proses verifikasi identitas calon seller di Pasar Santri Marketplace. Sistem ini memastikan bahwa semua penjual telah terverifikasi secara sah sesuai dengan regulasi keuangan dan hukum yang berlaku di Indonesia.

## Tujuan
- Memverifikasi identitas dan kelayakan calon seller
- Memastikan compliance terhadap regulasi KYC Indonesia
- Mencegah fraud dan aktivitas ilegal di marketplace
- Memberikan kepercayaan kepada buyer terhadap seller yang terverifikasi
- Mengelola proses onboarding seller secara sistematis

## Akses & Permission
**Role Required:** Administrator  
**Permission:** 
- `admin-dashboard|index kyc` - Melihat daftar aplikasi KYC
- `admin-dashboard|show kyc` - Melihat detail aplikasi KYC
- `admin-dashboard|update kyc` - Approve/reject aplikasi KYC

**URL:** `/admin/kyc`

## Alur KYC Process

### **User Journey:**
```
┌─────────────────────────────────────────────────────────────┐
│ USER REGISTRATION & KYC FLOW                                │
├─────────────────────────────────────────────────────────────┤
│ 1. User Register → Role: Buyer (Default)                    │
│ 2. User Submit KYC Application                              │
│    ├─ Personal Information                                  │
│    ├─ Address Information                                   │
│    ├─ Document Upload (ID Card, Selfie)                     │
│    └─ Terms & Privacy Agreement                             │
├─────────────────────────────────────────────────────────────┤
│ 3. Admin Review Process                                     │
│    ├─ Document Verification                                 │
│    ├─ Data Validation                                       │
│    ├─ Risk Assessment                                       │
│    └─ Decision Making                                       │
├─────────────────────────────────────────────────────────────┤
│ 4. APPROVED → User gets "Seller" Role                       │
│    ├─ Can create shop                                       │
│    ├─ Can list products                                     │
│    └─ Can receive payments                                  │
├─────────────────────────────────────────────────────────────┤
│ 5. REJECTED → User remains "Buyer" only                     │
│    ├─ Notification with rejection reason                    │
│    ├─ Option to reapply with corrections                    │
│    └─ Cannot access seller features                         │
└─────────────────────────────────────────────────────────────┘
```

## Status KYC Applications

### **1. Pending** 
- **Deskripsi:** Aplikasi baru yang belum direview
- **Action Required:** Admin perlu review dan buat keputusan
- **Priority:** Tertinggi (ditampilkan paling atas)
- **User Impact:** User tidak bisa menjadi seller

### **2. Approved** 
- **Deskripsi:** Aplikasi yang telah disetujui
- **Automatic Action:** User mendapat role "seller"
- **User Access:** Bisa membuat toko dan jualan
- **Admin Notes:** Bisa ditambahkan untuk referensi

### **3. Rejected** 
- **Deskripsi:** Aplikasi yang ditolak
- **Required Field:** Rejection reason wajib diisi
- **Automatic Action:** Role "seller" dicabut (jika ada)
- **User Option:** Bisa mengajukan ulang dengan perbaikan

## Cara Menggunakan KYC Management

### **Akses Halaman KYC Management**
1. Login sebagai Administrator
2. Buka menu **Admin Dashboard**
3. Navigasi ke **KYC Management**
4. Atau akses langsung: `/admin/kyc`

### **Dashboard Overview**
Halaman menampilkan statistik:
- **Total:** Jumlah semua aplikasi KYC
- **Pending:** Aplikasi yang menunggu review (prioritas utama)
- **Approved:** Aplikasi yang sudah disetujui
- **Rejected:** Aplikasi yang ditolak

### **Filter & Pencarian Aplikasi**

#### **Filter berdasarkan Status:**
- **All:** Tampilkan semua aplikasi
- **Pending:** Hanya aplikasi pending (yang perlu action)
- **Approved:** Hanya aplikasi yang approved
- **Rejected:** Hanya aplikasi yang rejected

#### **Search Function:**
Pencarian berdasarkan:
- **Nama depan & belakang** aplikant
- **Nomor dokumen** (KTP/Paspor)
- **Nama user** di sistem
- **Email address** user

### **Review Individual KYC Application**

#### **Akses Detail Aplikasi:**
1. Klik nama aplikant atau tombol "View" di daftar
2. Halaman detail akan menampilkan semua informasi KYC

#### **Informasi yang Ditampilkan:**
**Personal Information:**
- Nama lengkap (First Name + Last Name)
- Tanggal lahir
- Gender
- Nationality
- Nomor telepon

**Address Information:**
- Alamat lengkap
- Provinsi, Kota, Kecamatan, Kelurahan
- Kode pos
- Negara

**Document Information:**
- Jenis dokumen (KTP/Paspor)
- Nomor dokumen
- Tanggal expired
- Negara penerbit dokumen
- **Foto dokumen** (tampil sebagai preview image)
- **Foto selfie** (tampil sebagai preview image)

**Application Metadata:**
- Status saat ini
- Tanggal submit
- IP address saat submit
- User agent (browser/device info)
- Persetujuan terms & privacy

### **Approve KYC Application**

#### **Langkah Approval:**
1. Buka detail aplikasi KYC
2. Review semua dokumen dan data
3. Klik tombol **"Approve Application"**
4. **Opsional:** Tambahkan admin notes
5. Konfirmasi approval

#### **Yang Terjadi Saat Approve:**
- Status berubah menjadi "approved"
- User otomatis mendapat role "seller"
- User bisa mengakses seller dashboard
- User bisa setup toko dan jualan
- Timestamp reviewed_at dicatat
- Admin yang approve tercatat

### **Reject KYC Application**

#### **Langkah Rejection:**
1. Buka detail aplikasi KYC
2. Klik tombol **"Reject Application"**
3. **Wajib:** Isi alasan penolakan yang jelas
4. **Opsional:** Tambahkan admin notes
5. Konfirmasi rejection

#### **Yang Terjadi Saat Reject:**
- Status berubah menjadi "rejected"
- Role "seller" dicabut dari user (jika ada)
- User tidak bisa akses seller features
- User mendapat notifikasi dengan alasan penolakan
- User bisa reapply dengan perbaikan dokumen
- Admin notes dan rejection reason tersimpan

### **Bulk Actions (Multiple KYC)**

#### **Fitur Bulk Actions:**
1. Klik tombol **"Bulk Actions"** di halaman index
2. Pilih multiple KYC applications menggunakan checkbox
3. Pilih action yang diinginkan:
   - **Bulk Approve:** Approve multiple applications sekaligus
   - **Bulk Reject:** Reject multiple applications dengan alasan sama
   - **Bulk Delete:** Hapus applications yang sudah final (approved/rejected)

#### **Bulk Approve:**
- Semua selected pending applications akan di-approve
- Users akan mendapat role "seller" otomatis
- Admin notes sama untuk semua (opsional)

#### **Bulk Reject:**
- Semua selected pending applications akan di-reject
- **Wajib:** Isi rejection reason yang akan berlaku untuk semua
- Admin notes sama untuk semua (opsional)

#### **Bulk Delete:**
- Hanya bisa delete applications yang statusnya approved/rejected
- Pending applications tidak bisa dihapus
- Permanent delete dari database

## Document Verification Guidelines

### **KTP (Kartu Tanda Penduduk) Verification:**
**Yang Harus Dicek:**
- **Foto jelas** dan tidak blur
- **Semua teks terbaca** dengan jelas
- **Tidak expired** (tanggal berlaku masih valid)
- **Format KTP** sesuai standar Indonesia
- **Data konsisten** dengan form yang diisi
- **Tidak ada tanda editing** atau manipulasi foto

**Red Flags:**
- Foto blur atau gelap
- Ada bagian yang tertutup atau terpotong
- Tanggal expired sudah lewat
- Data tidak sesuai dengan form
- Tanda-tanda photo editing
- Format KTP tidak standar

### **Selfie Verification:**
**Yang Harus Dicek:**
- **Wajah jelas** dan terlihat dengan baik
- **Sesuai dengan foto KTP** (face matching)
- **Tidak ada masker** atau penutup wajah
- **Pencahayaan cukup** untuk identifikasi
- **Background natural** (bukan foto dari foto)

**Red Flags:**
- Wajah tidak sesuai dengan KTP
- Menggunakan masker atau sunglasses
- Foto terlalu gelap atau blur
- Terlihat seperti foto dari layar/foto lain
- Background mencurigakan

## KYC Compliance Guidelines

### **Legal Requirements (Indonesia):**
1. **POJK No. 12/2017** - Penerapan Program APU-PPT
2. **UU No. 8/2010** - Pencegahan Pencucian Uang
3. **Peraturan Bank Indonesia** terkait KYC
4. **GDPR Compliance** untuk data protection

### **Data Protection:**
- **Encrypted Storage:** Semua dokumen disimpan terenkripsi
- **Access Control:** Hanya admin yang berwenang bisa akses
- **Audit Trail:** Semua action tercatat dengan timestamp
- **Data Retention:** Sesuai dengan regulasi yang berlaku

### **Risk Assessment Criteria:**
**Low Risk:** 
- Dokumen lengkap dan valid
- Data konsisten
- Warga Negara Indonesia
- Alamat jelas dan valid

**Medium Risk:** 
- Dokumen valid tapi kualitas kurang baik
- Minor inconsistency dalam data
- Alamat di daerah remote

**High Risk:** 
- Dokumen tidak jelas atau mencurigakan
- Data tidak konsisten
- Alamat tidak valid
- Indikasi fraud atau manipulation

## Fraud Prevention

### **Common Fraud Patterns:**
1. **Fake Documents:** KTP palsu atau manipulasi digital
2. **Identity Theft:** Menggunakan identitas orang lain
3. **Multiple Applications:** Satu orang submit multiple KYC
4. **Fake Selfies:** Menggunakan foto orang lain
5. **Address Fraud:** Alamat palsu atau tidak valid

### **Detection Methods:**
- **Visual Inspection:** Manual review dokumen
- **Data Cross-check:** Validasi data antar field
- **Duplicate Detection:** Check untuk aplikasi duplikat
- **IP Analysis:** Monitor IP address patterns
- **Device Fingerprinting:** Track device characteristics

### **Action untuk Suspicious Cases:**
1. **Reject** dengan alasan yang jelas
2. **Flag user** untuk monitoring lebih lanjut
3. **Report** ke authorities jika diperlukan
4. **Block IP/Device** jika ada pattern abuse

## Troubleshooting

### **Problem: KYC aplikasi tidak muncul**
**Possible Causes:**
- Database connection issue
- Permission problem
- Filter yang terlalu restrictive

**Solutions:**
1. Check database connection
2. Verify user permissions
3. Reset filter dan search
4. Refresh halaman

### **Problem: Tidak bisa approve/reject**
**Possible Causes:**
- User tidak punya permission update
- KYC sudah di-review oleh admin lain
- Database lock atau constraint issue

**Solutions:**
1. Verify permission user
2. Check apakah KYC masih pending
3. Refresh dan coba lagi
4. Check database constraints

### **Problem: Bulk action gagal**
**Possible Causes:**
- Some selected KYC bukan status pending
- Required field tidak diisi (rejection reason)
- Database transaction timeout

**Solutions:**
1. Pastikan hanya select pending KYC untuk approve/reject
2. Isi semua required fields
3. Reduce jumlah selected items
4. Coba action satu per satu

### **Problem: Foto dokumen tidak tampil**
**Possible Causes:**
- File tidak ter-upload dengan benar
- Storage path bermasalah
- File permission issue

**Solutions:**
1. Check file existence di storage
2. Verify storage configuration
3. Check file permissions
4. Ask user untuk re-upload dokumen

## KYC Analytics & Reporting

### **Key Metrics to Monitor:**
1. **Application Volume:** Berapa aplikasi KYC per hari/minggu/bulan
2. **Approval Rate:** Persentase aplikasi yang di-approve
3. **Processing Time:** Rata-rata waktu dari submit ke decision
4. **Rejection Reasons:** Pattern alasan penolakan yang sering muncul
5. **Fraud Rate:** Berapa persen aplikasi yang terindikasi fraud

### **Business Intelligence:**
- **Peak Times:** Jam/hari dengan aplikasi terbanyak
- **Geographic Patterns:** Dari mana saja aplikan berasal
- **Success Factors:** Karakteristik aplikasi yang sukses
- **Bottlenecks:** Di mana proses sering tertunda

### **Quality Assurance:**
- **Second Review:** Sample review untuk quality control
- **Consistency Check:** Pastikan standard review konsisten
- **Feedback Loop:** Input dari seller untuk improve process
- **Regular Training:** Update guidelines sesuai perkembangan

## SLA (Service Level Agreement)

### **Response Time Standards:**
- **Pending Applications:** Maximum 2x24 jam untuk review
- **Peak Season:** Maximum 3x24 jam (Ramadan, Lebaran, dll)
- **Reapplication:** Maximum 1x24 jam untuk review ulang
- **Bulk Processing:** Diselesaikan dalam 1 hari kerja

### **Quality Standards:**
- **Accuracy Rate:** Minimum 95% accuracy dalam decision making
- **False Positive:** Maximum 5% dari total approvals
- **Customer Satisfaction:** Minimum 4.0/5.0 rating dari users
- **Compliance Rate:** 100% sesuai dengan legal requirements

## Training & Best Practices

### **Admin Training Requirements:**
1. **KYC Fundamentals:** Understanding legal requirements
2. **Document Analysis:** How to spot fake documents
3. **Risk Assessment:** Identifying high-risk applications
4. **System Navigation:** Efficient use of admin interface
5. **Compliance Updates:** Regular updates on regulation changes

### **Best Practices for Reviewers:**
1. **Consistent Standards:** Apply same criteria untuk semua aplikasi
2. **Clear Documentation:** Selalu catat reasoning untuk decisions
3. **Time Management:** Prioritize pending applications
4. **Quality Focus:** Better to be thorough than fast
5. **Escalation Protocol:** Know when to escalate to supervisor

---

## Support & Bantuan

Jika mengalami kesulitan dalam menggunakan KYC Management:

1. **Technical Issues:** Hubungi tim development PT. Sidogiri Fintech Utama
2. **Legal Compliance:** Konsultasi dengan legal & compliance team
3. **Document Verification:** Training available dari security team
4. **Process Questions:** Hubungi KYC supervisor atau manager
5. **General Support:** Kontak support Pasar Santri Marketplace

### **Emergency Escalation:**
- **Fraud Suspected:** Immediate escalation ke security team
- **Legal Issues:** Escalate ke legal department
- **System Down:** Contact tech support hotline
- **Compliance Violation:** Report ke compliance officer

**Sistem:** Pasar Santri Marketplace  
**Developer:** PT. Sidogiri Fintech Utama  
**Compliance:** Sesuai dengan regulasi KYC Indonesia  
**Last Updated:** September 2025  
**Version:** 1.0
