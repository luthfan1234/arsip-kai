<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📁 Archive Management System

Sistem pengelolaan arsip dokumen digital untuk perusahaan yang dibangun dengan Laravel, Vue.js, dan Inertia.js.

## 🚀 Fitur Utama

### 👤 Manajemen User & Role
- **Admin**: CRUD semua dokumen, kelola divisi & kategori
- **User**: Lihat dan download dokumen

### 📋 Manajemen Dokumen
- Upload dokumen (PDF, DOC, DOCX, XLS, XLSX)
- Auto-generate nomor dokumen
- Versioning dokumen
- Preview dan download file
- Soft delete untuk data integrity

### 🔍 Pencarian & Filter
- Pencarian berdasarkan judul, nomor dokumen, deskripsi
- Filter berdasarkan divisi dan kategori
- Pagination untuk performa optimal

### 🎨 User Interface
- Design modern dengan TailwindCSS
- Responsive design
- Dark/Light mode support
- Toast notifications
- Loading states

## 🛠️ Teknologi

- **Backend**: Laravel 11 + PHP 8.2
- **Frontend**: Vue.js 3 + Inertia.js 2
- **Styling**: TailwindCSS + HeadlessUI
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission
- **File Storage**: Laravel Storage (Local/S3)
- **PDF Generation**: DomPDF

## 📦 Instalasi

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/SQLite

### Setup

1. **Clone repository**
```bash
git clone <repository-url>
cd archive-system
```

2. **Install dependencies**
```bash

```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
```bash
# Edit .env untuk konfigurasi database
php artisan migrate
php artisan db:seed
```

5. **Storage setup**
```bash
php artisan storage:link
```

6. **Build assets**
```bash
npm run build
# atau untuk development
npm run dev
```

7. **Start server**
```bash
php artisan serve
```

## 📚 Penggunaan

### Default Users (Setelah Seeding)
- **Admin**: admin@admin.com / password
- **User**: user@user.com / password

### Upload Dokumen
1. Login sebagai admin
2. Navigate ke "Documents" -> "Add New"
3. Isi form dan upload file
4. Sistem akan auto-generate nomor dokumen

### Pencarian Dokumen
- Gunakan search bar untuk mencari berdasarkan judul/nomor
- Gunakan filter dropdown untuk divisi/kategori
- Kombinasikan pencarian dan filter

## 🗂️ Struktur Database

### Documents Table
- `document_number`: Auto-generated (DOC/YYYY/MM/XXXX)
- `title`: Judul dokumen
- `description`: Deskripsi (optional)
- `division_id`: Foreign key ke divisions
- `category_id`: Foreign key ke categories
- `version`: Versi dokumen (default: 1.0)
- `file_path`: Path file di storage
- `uploaded_by`: Foreign key ke users
- `upload_date`: Timestamp upload

### Divisions Table
- `name`: Nama divisi
- `description`: Deskripsi divisi
- `is_active`: Status aktif

### Categories Table
- `name`: Nama kategori
- `description`: Deskripsi kategori
- `is_active`: Status aktif

## 🔒 Security Features

- CSRF Protection
- XSS Protection
- File upload validation
- Role-based access control
- Input sanitization
- Secure file storage

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=DocumentTest
```

## 📈 Performance

- Database indexing pada kolom pencarian
- Eager loading untuk relasi
- File compression untuk storage
- Cache untuk data statis
- Pagination untuk large datasets

## 🚀 Deployment

### Production Setup
1. Set `APP_ENV=production` di .env
2. Set `APP_DEBUG=false`
3. Configure database production
4. Set up proper file permissions
5. Configure web server (Apache/Nginx)
6. Set up SSL certificate
7. Configure backup strategy

### Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## 🤝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

MIT License - see [LICENSE.md](LICENSE.md)

## 📞 Support

Untuk pertanyaan atau issue, silakan buat issue di repository ini.
