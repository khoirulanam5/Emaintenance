# 🚗 Sistem Maintenance Kendaraan  
### *Manajemen Perawatan Kendaraan – Role Admin, Sopir, dan Teknisi*

Aplikasi ini adalah sistem manajemen maintenance kendaraan yang dibangun menggunakan **CodeIgniter 3**, **MySQL**, dan frontend **HTML, CSS, JavaScript, Bootstrap**. Sistem ini membantu perusahaan memantau kondisi kendaraan, jadwal maintenance, dan riwayat perbaikan secara lebih efisien dengan dukungan multi-role.

---

## 📌 Fitur Utama

### 🧑‍💼 Admin
- Mengelola data kendaraan (tambah, edit, hapus)  
- Mengelola data sopir dan teknisi  
- Mengatur jadwal maintenance kendaraan  
- Menyetujui/menolak permintaan perbaikan  
- Melihat laporan riwayat maintenance  
- Dashboard monitoring kondisi kendaraan  

### 🚚 Sopir
- Mengajukan permintaan perbaikan kendaraan  
- Melaporkan kerusakan atau kendala kendaraan  
- Melihat status maintenance kendaraan  
- Mengisi checklist harian kendaraan (opsional)  

### 🔧 Teknisi
- Melihat daftar permintaan perbaikan  
- Mengupdate status pengerjaan (proses, selesai, pending)  
- Mengisi detail hasil perbaikan  
- Mengupload laporan teknis jika diperlukan  

---

## 🛠️ Teknologi yang Digunakan

| Bagian         | Teknologi                       |
|----------------|----------------------------------|
| Backend        | CodeIgniter 3                    |
| Frontend       | HTML, CSS, JavaScript, Bootstrap |
| Database       | MySQL                            |
| Grafik         | Chart.js (opsional)              |

---

## 📂 Struktur Direktori (Ringkas)

```
/application
    /controllers
    /models
    /views
/assets
    /css
    /js
    /images
/database
    maintenance.sql
/uploads
    /kendaraan
    /laporan
```

---

## 📥 Instalasi & Setup

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/maintenance-kendaraan.git
```

### 2️⃣ Pindahkan ke Folder Server Local
Taruh di:
```
htdocs/ (XAMPP) atau public_html (hosting)
```

### 3️⃣ Import Database
- Buka **phpMyAdmin**
- Buat database baru
- Import file:
```
database/maintenance.sql
```

### 4️⃣ Konfigurasi Database

**application/config/database.php**
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'maintenance',
    'dbdriver' => 'mysqli'
);
```

### 5️⃣ Setting Base URL

**application/config/config.php**
```php
$config['base_url'] = 'http://localhost/maintenance-kendaraan/';
```

---

## 🔧 Modul Utama di Dalam Sistem

- **Manajemen kendaraan** (no. polisi, jenis, merk, km awal, kondisi)  
- **Permintaan perbaikan oleh sopir**  
- **Penugasan teknisi**  
- **Jadwal maintenance berkala**  
- **Monitoring pekerjaan teknisi**  
- **Riwayat maintenance kendaraan** lengkap  
- **Laporan PDF** (jika tersedia)  

---

## 🔐 Akun Login Default

| Role      | Username | Password |
|-----------|----------|----------|
| Admin     | admin    | admin    |
| Sopir     | sopir    | sopir    |
| Teknisi   | teknisi  | teknisi  |

> Sangat disarankan untuk mengganti password setelah login.

---

## 🖼️ Screenshot (Opsional)

Bisa menambahkan screenshot seperti:
- Dashboard  
- Daftar kendaraan  
- Form pengajuan perbaikan  
- Halaman teknisi  
- Laporan maintenance  

---

## 📝 Lisensi

Proyek ini dapat digunakan, dimodifikasi, dan dikembangkan sesuai kebutuhan internal.

---

## 💡 Kontribusi

Pull request sangat diterima.  
Laporkan bug atau ide fitur melalui *Issues*.

---

### ⭐ Jika aplikasi ini bermanfaat, jangan lupa beri **Star** pada repository!
