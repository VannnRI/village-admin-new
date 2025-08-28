# Platform Administrasi Desa

Sistem administrasi desa yang memungkinkan pengelolaan data warga, surat-menyurat, dengan berbagai level akses pengguna.

## Fitur Utama

- **Super Admin**: Manajemen pengguna dan desa secara global
- **Admin Desa**: Pengelolaan data warga, surat
- **Perangkat Desa**: Validasi dan persetujuan surat warga
- **Masyarakat**: Pengajuan surat dan monitoring status

## Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- Database (MySQL/MariaDB/SQLite)
- Web server (Apache/Nginx) atau Laravel built-in server

## Instalasi dan Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd village-admin-new
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=village_admin
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

## Cara Menjalankan Sistem

### Development Mode
```bash
# Terminal 1: Jalankan Laravel server
php artisan serve

# Terminal 2: Jalankan Vite untuk hot reload
npm run dev
```

### Production Mode
```bash
# Build assets untuk production
npm run build

# Jalankan server
php artisan serve --host=0.0.0.0 --port=8000
```

### Menggunakan Composer Script
```bash
composer run dev
```

## Tutorial Penggunaan Sistem

### 1. Login ke Sistem

#### Super Admin (Default)
- **URL**: `http://localhost:8000/login`
- **Username**: `admin`
- **Password**: `admin`

#### Membuat User Baru
Setelah login sebagai Super Admin, Anda dapat membuat user untuk role lain:

1. **Buat Admin Desa**:
   - Buka menu "Users" → "Create User"
   - Isi form dengan data:
     - Name: `Admin Desa Warungering`
     - Username: `admin_desa`
     - Email: `admin@warungering.desa.id`
     - Password: `password123`
     - Role: `admin_desa`
     - Village: `Warungering`

2. **Buat Perangkat Desa**:
   - Buka menu "Users" → "Create User"
   - Isi form dengan data:
     - Name: `Perangkat Desa`
     - Username: `perangkat`
     - Email: `perangkat@warungering.desa.id`
     - Password: `password123`
     - Role: `perangkat_desa`
     - Village: `Warungering`

3. **Buat Masyarakat**:
   - Buka menu "Users" → "Create User"
   - Isi form dengan data:
     - Name: `John Doe`
     - Username: `1234567890123456` (NIK)
     - Email: `john.doe@mail.com`
     - Password: `1990-01-01` (Tanggal lahir)
     - Role: `masyarakat`
     - Village: `Warungering`

### 2. Tutorial Super Admin

#### Dashboard
- Melihat overview sistem secara global
- Statistik jumlah desa, user, dan surat

#### Manajemen Desa
1. **Tambah Desa Baru**:
   - Menu: `Villages` → `Create Village`
   - Isi data desa:
     - Name: `Nama Desa`
     - District: `Kecamatan`
     - Regency: `Kabupaten`
     - Code: `KODE001`
     - Address: `Alamat lengkap`
     - Phone: `Nomor telepon`
     - Email: `email@desa.id`

2. **Edit Desa**:
   - Menu: `Villages` → Klik tombol edit
   - Update informasi yang diperlukan

#### Manajemen User
1. **Buat User Baru**:
   - Menu: `Users` → `Create User`
   - Pilih role dan desa sesuai kebutuhan

2. **Reset Password User**:
   - Menu: `Users` → Klik tombol reset password
   - Password default: `password123`

### 3. Tutorial Admin Desa

#### Dashboard
- Melihat statistik desa
- Quick actions untuk fitur utama

#### Pengelolaan Data Warga
1. **Tambah Warga Baru**:
   - Menu: `Citizens` → `Create Citizen`
   - Isi data lengkap warga:
     - NIK, Nama, Tempat/Tanggal Lahir
     - Alamat, Telepon, Gender
     - Agama, Status Perkawinan, Pendidikan, Pekerjaan

2. **Import Data Warga**:
   - Menu: `Citizens` → `Import`
   - Download template Excel
   - Upload file yang sudah diisi

3. **Export Data Warga**:
   - Menu: `Citizens` → `Export`
   - Pilih format (Excel/PDF)

#### Manajemen Template Surat
1. **Buat Template Baru**:
   - Menu: `Letter Templates` → `Create`
   - Isi nama dan deskripsi surat
   - Gunakan CKEditor untuk template HTML
   - Tambahkan field yang diperlukan

2. **Preview Template**:
   - Klik tombol preview untuk melihat hasil


#### Arsip Dokumen
1. **Arsip Umum**:
   - Menu: `Archives` → `General`
   - Upload dan kategorikan dokumen

2. **Arsip Kependudukan**:
   - Menu: `Archives` → `Population`
   - Kelola dokumen kependudukan

3. **Arsip Surat**:
   - Menu: `Archives` → `Letters`
   - Arsip surat yang sudah diproses

### 4. Tutorial Perangkat Desa

#### Dashboard
- Melihat surat yang perlu divalidasi
- Statistik pengajuan surat

#### Validasi Surat
1. **Review Pengajuan**:
   - Menu: `Letter Requests`
   - Klik surat yang perlu divalidasi

2. **Proses Surat**:
   - Baca pengajuan dan dokumen pendukung
   - Setujui atau tolak dengan alasan
   - Generate surat jika disetujui

3. **Download Surat**:
   - Surat yang sudah disetujui dapat didownload
   - Format PDF siap cetak

### 5. Tutorial Masyarakat

#### Dashboard
- Melihat status pengajuan surat
- Riwayat surat yang sudah diajukan

#### Ajukan Surat
1. **Pilih Jenis Surat**:
   - Menu: `Letter Form`
   - Pilih kategori surat yang diperlukan

2. **Isi Form Pengajuan**:
   - Lengkapi data yang diminta
   - Upload dokumen pendukung
   - Submit pengajuan

#### Monitoring Status
1. **Cek Status Surat**:
   - Menu: `Letters Status`
   - Lihat progress pengajuan

2. **Download Surat**:
   - Surat yang sudah disetujui dapat didownload
   - Format PDF siap cetak

## Fitur Tambahan

### Export Data
- Export data warga ke Excel
- Export arsip dokumen
- Export laporan surat

### Template Surat
- Editor WYSIWYG dengan CKEditor
- Field dinamis sesuai jenis surat
- Preview sebelum generate

### Arsip Digital
- Kategorisasi dokumen
- Search dan filter
- Backup otomatis

## Support

Untuk bantuan teknis atau pertanyaan, silakan hubungi tim development atau buat issue di repository.