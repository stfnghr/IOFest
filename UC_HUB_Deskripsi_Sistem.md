# UC HUB
## Platform Magang & Karir Terintegrasi
### Dokumen Deskripsi Sistem & Desain UX

**Mahasiswa | Perusahaan | Admin Universitas | Super Admin**

Lomba Web Development — I/O Festival 2026
BEM FTI Universitas Tarumanagara
Subtema: Human Capital & Future Skills Inclusivity
Versi Final — Penggabungan Spesifikasi Teknis & UX

---

## Daftar Isi

1. Mahasiswa
   - Fase 1: Auth & Onboarding
   - Fase 2: Dashboard & Discovery
   - Fase 3: Profile & CV Builder
   - Fase 4: The Action & Monitoring
   - Database Schema
2. Perusahaan / Company
   - Alur Registrasi & Verifikasi
   - Job Management
   - Candidate Pipeline & Interview
   - Internship Monitoring & Sertifikat
   - Database Schema
3. Admin Universitas
   - Account Provisioning
   - Dashboard & Accreditation Analytics
   - Partner Management (Gatekeeper)
   - Student & Academic Management
   - Internship Monitoring & Anti-Ghosting
   - Report Center & System Config
4. Super Admin (Platform Owner)
   - Sistem Pengelolaan Akun & Akses
   - Dashboard Analitik Global
   - Manajemen Keamanan & Integritas
   - Infrastruktur & Billing
   - Master Data & Konfigurasi Global

---

## 1. Mahasiswa
### Sebagai seorang UX Thinker: 4 Fase Utama dalam Perjalanan Karir

Alur mahasiswa dirancang mengikuti perjalanan karir yang alami — dari onboarding pertama kali hingga monitoring magang aktif. Setiap fase memiliki UI yang berfokus pada kemudahan dan motivasi.

---

### Fase 1 | Auth & Onboarding — Gerbang Masuk

#### Halaman A: Landing & Login (SSO Gateway)

- **Hero Section:** Ilustrasi modern mahasiswa terhubung dengan gedung perkantoran.
- **Central Box:** Tombol "Login with University ID" menggunakan Laravel Socialite.

**Logic Detail:**
- Sistem mengecek email domain (contoh: @student.itb.ac.id). Jika domain tidak terdaftar, akses ditolak.
- Data yang ditarik dari SSO: Nama, NIM, Foto, Fakultas, Prodi, Semester, IPK (read-only).

**SSO Fallback — Jika Sistem SSO Kampus Down:**
- Tersedia Form Registrasi Manual sebagai jalur alternatif.
- Mahasiswa wajib mengunggah foto KTM sebagai bukti identitas.
- Admin Universitas memvalidasi akun dalam maksimal 48 jam kerja sebelum akun aktif. Jika melewati 48 jam tanpa respons, mahasiswa mendapat temporary access (browse-only).

#### Halaman B: Initial Career Interest (Matching Setup)

- **Interactive Chips:** Mahasiswa memilih minimal 3 kategori minat (contoh: "Frontend", "Copywriting", "HR").
- **Work Preference Toggle:** Pilihan "Remote Only" atau "On-site/Hybrid".
- **Output:** Data disimpan ke tabel user_preferences untuk mentenagai algoritma matching di dashboard.

---

### Fase 2 | Dashboard & Discovery — Pencarian

#### Halaman C: Main Dashboard (The Career Assistant)

**Stat Cards (3 Kolom):**
- **Lamaran Aktif:** Angka besar + sub-teks "Cek status terbaru".
- **Undangan Interview:** Berwarna kuning menyala (Urgent).
- **Match Score:** Rata-rata kesesuaian profil dengan pasar.

**Notification Center:**
- Bell Icon di pojok kanan atas.
- Daftar notifikasi: undangan interview, perubahan status lamaran, dan pengingat jurnal harian.

**Skill Radar Chart:**
- Grafik laba-laba yang memetakan keahlian mahasiswa secara visual.

**Recommended Feed:**
- Daftar kartu lowongan dengan badge persentase kesesuaian.
- Lowongan diurutkan berdasarkan Match Score tertinggi.

**Algoritma Match Score (Revisi Matematis):**

```
Score Final = MIN(Base Score + Bonus Lokasi + Bonus Kategori, 100)
```

Detail Perhitungan: Base Score didapat dari (Skill Overlap / Total Required Skill) x 100. Kemudian ditambahkan +5 poin bonus preferensi lokasi dan +5 poin bonus kategori. Fungsi MIN digunakan untuk memastikan secara algoritma skor maksimal tetap terkunci di 100%.

#### Halaman D: Job Board (The Exploration Page)

- **Sticky Search & Filter:** Input teks, dropdown kategori, range gaji (jika ada).

**Job Card Component:**
- Logo Perusahaan di sisi kiri.
- Badge Tipe Kerja: [Remote] [Paid] [On-site].
- Lingkaran progres hijau dengan angka persentase Match Score.
- Tombol "Quick View" — membuka side-panel/modal tanpa berpindah halaman.

#### Halaman E: Job Detail Page (The Deep Dive)

- **Header Section:** Foto banner kantor + tombol "Apply Now".

**Matching Analysis Box (2 Kolom):**
- Kiri: Skill yang dimiliki mahasiswa (centang hijau).
- Kanan: Skill yang belum dimiliki (tanda seru kuning — gap indication).

- **Company Verified Badge:** Konfirmasi bahwa perusahaan telah diverifikasi oleh Admin Universitas.
- **Job Description:** Typography Inter/Roboto untuk kenyamanan baca.

---

### Fase 3 | Profile & Auto-CV — Personal Branding

#### Halaman F: Digital Profile & CV Builder

**Input Form (Kolom Kiri):**
- Formulir bertahap: Bio, Pengalaman, Organisasi, Sertifikat, Portofolio.
- Skill Input menggunakan Tag Input (Select2 / TomSelect).

**Portfolio Upload Strategy:**
- **Storage:** AWS S3 / Cloud Storage untuk skalabilitas.
- Maksimal 5MB per file, format PDF.
- Alternatif: Link URL eksternal (GitHub, Behance, dll).

**Live Resume Preview (Kolom Kanan):**
- Tampilan kertas A4 virtual yang ter-update secara real-time saat mahasiswa mengetik.

**Generate ATS-PDF:**
- Tombol "Generate ATS-PDF" memproses data menjadi file PDF siap download.
- Library: Browsershot (Puppeteer) untuk akurasi layout A4.
- Demo fallback: dompdf untuk lingkungan tanpa Node.js.

---

### Fase 4 | The Action & Monitoring — Anti-Ghosting

#### Halaman G: Application Flow (Submission Modal)

Alur yang terjadi saat mahasiswa klik "Apply Now":

1. **Checklist Validation**
   Sistem mengecek kelengkapan profil. Jika kelengkapan < 80%, muncul peringatan: "Profilmu belum siap, lengkapi sekarang!" dengan visual progress bar.

2. **Cover Letter Input**
   Kotak teks opsional: "Kenapa kamu kandidat yang tepat?" Mahasiswa dapat melewati langkah ini.

3. **Submission Confirmation**
   Tombol konfirmasi dengan ringkasan singkat data lamaran yang akan dikirim.

4. **SLA Activation**
   Detik saat klik "Kirim", sistem mencatat applied_at dan memulai hitung mundur 7 hari (Ghosting Guard).

**SLA Escalation Logic (Anti-Ghosting Berjenjang):**
- **Hari ke-7 (Warning):** Status lamaran tidak berubah otomatis agar valid, namun SLA merah menyala. Tombol "Request Campus Intervention" aktif untuk mahasiswa.
- **Hari ke-14 (Eskalasi Level 2):** Jika tidak ada respons 7 hari paska intervensi kampus, Admin Univ mendapat notifikasi eskalasi. Perusahaan mendapat flag pelanggaran.
- **Hari ke-21+ (Review MoU):** Jika pelanggaran berulang melampaui batas semester, sistem memberikan rekomendasi otomatis ke Admin untuk meninjau ulang/suspend MoU perusahaan tersebut.

#### Halaman H: Application Tracker (The Status Hub)

- **Kanban Board:** Kolom "Applied" → "Under Review" → "Interview" → "Decision".

**Application Card (detail setiap kartu):**
- Nama posisi & nama perusahaan.
- **SLA Timer Bar:** Progress bar hijau → merah jika HRD tidak merespons dalam 7 hari.
- **Status Badge:** Berubah otomatis sesuai aksi HRD (Under Review, Interview Scheduled, Accepted, Rejected).

#### Halaman I: Daily Journal & Logbook (Post-Accepted)

Halaman ini hanya muncul jika status lamaran = Accepted.

- **Calendar View:** Memilih tanggal entri jurnal.
- **Daily Form:** Input teks "Apa yang kamu kerjakan hari ini?"
- **Approval Status:** Menampilkan apakah jurnal sudah divalidasi oleh HRD perusahaan.
- **Output:** Rekapitulasi jurnal dalam format PDF untuk diserahkan ke Dosen Pembimbing sebagai bukti magang selesai.

> ★ **Inovasi: Direct Follow-up Button**
>
> Jika lamaran sudah 7 hari tidak direspons (SLA Merah), tombol "Request Campus Intervention" muncul. Satu klik mengirimkan notifikasi resmi ke Admin Universitas untuk membantu menanyakan status ke HRD. Ini adalah bukti nyata bahwa platform membela mahasiswa.

---

### Database Schema — Mahasiswa

| Tabel | Kolom Utama | Keterangan |
|---|---|---|
| users | id, name, nim, email, faculty, major, semester, gpa (read-only dari SSO) | — |
| user_preferences | user_id (FK), interest_categories (JSON), work_preference (enum) | Preferensi karir awal |
| skills | id, name, category | Master data keahlian |
| user_skills | user_id (FK), skill_id (FK), proficiency_level | Keahlian mahasiswa |
| experiences | id, user_id (FK), title, company, start_date, end_date, description | Riwayat pengalaman |
| educations | id, user_id (FK), degree, institution, year | Riwayat pendidikan |
| portfolios | id, user_id (FK), title, file_path (S3), url, type | Portofolio mahasiswa |
| applications | id, user_id (FK), job_id (FK), status (enum), applied_at, cover_letter | Data lamaran |
| application_status_logs | id, application_id (FK), status, changed_at, changed_by | Log perubahan status |
| internship_journals | id, application_id (FK), date, content, approved_by, approved_at | Jurnal harian magang |

---

## 2. Perusahaan / Company
### Sistem Multi-Universitas dengan Gatekeeper & Mini-ATS

#### Alur Registrasi — Step by Step

**Step 1 Sign Up (Basic Account)**
- **Input:** Nama Perusahaan, Email Kantor (wajib domain perusahaan, contoh: recruitment@gojek.com), Password.
- **Logic:** Laravel mengirim email verifikasi. Akun dibuat dengan status "Unverified".

**Step 2 Company Profile & Branding**
- **Input:** Slogan, Deskripsi Perusahaan, Website, Media Sosial, Alamat Kantor Pusat.
- **Upload:** Logo PNG transparan dan Banner Profile.
- **Output:** Halaman profil perusahaan yang estetik (belum terlihat oleh mahasiswa).

**Step 3 Business Legalization — The Trust Layer**
- **Input:** Nomor Induk Berusaha (NIB) atau NPWP.
- **Upload:** Dokumen PDF NIB/legalitas resmi.
- **Fungsi:** Data ini menjadi "KTP Digital" perusahaan di dalam sistem.
- **Status akun:** "Pending Verification" — menunggu persetujuan Admin Universitas target.

#### University Marketplace — Cara Masuk ke Universitas

Setelah registrasi selesai, perusahaan tidak otomatis bisa posting lowongan ke semua universitas. Mereka harus mengajukan kerja sama secara individual ke setiap universitas target.

**Partnership Flow:**
1. Perusahaan mencari universitas target di halaman University Marketplace.
2. Klik tombol "Ajukan Kerja Sama" → status menjadi "Pending Approval" di sisi kampus.
3. Admin Universitas menerima notifikasi di Verification Queue, mengecek NIB/NPWP perusahaan.
4. Jika disetujui (Approve) → seluruh lowongan yang ditargetkan ke kampus tersebut otomatis terlihat oleh mahasiswanya.
5. Jika ditolak (Reject) → perusahaan menerima email dengan alasan penolakan.

**Manage Partnership — Status Kerja Sama:**

| | |
|---|---|
| Universitas A | Verified (Active) — Lowongan dapat terlihat oleh mahasiswa. |
| Universitas B | Pending Approval — Menunggu keputusan Admin Universitas B. |
| Universitas C | Rejected — Lowongan tidak dapat dipublish ke kampus ini. |

---

### Menu Dashboard Perusahaan

#### A. Dashboard Utama (Unified Analytics)

**Global University Switcher (Header):**
- Dropdown "All Partner Universities" di header dashboard.
- Pilih "All" → tampilkan total agregat data dari semua kampus mitra.
- Pilih "Universitas Surabaya" → seluruh grafik dan daftar pelamar difilter ke data kampus tersebut.

**Stat Cards (4 Kolom):**

| | |
|---|---|
| Total Applicants | Semua kampus mitra |
| Average Match Rate | Kualitas pelamar saat ini |
| SLA Warning | Lamaran menggantung > 5 hari |
| Hired Interns | Mahasiswa aktif magang |

- **University-Source Chart:** Pie/bar chart asal kampus pelamar. Contoh: Univ A (45%), Univ B (30%).
- **Skill-Demand Heatmap:** Skill yang paling banyak diminta vs ketersediaan skill di platform.

#### B. Menu: Job Management (Post & Edit)

**Multi-Targeting Job Post — 4 Langkah:**
- **Step 1 — Job Details:** Judul posisi, deskripsi, kategori, durasi magang.
- **Step 2 — Requirement & Skill Mapping:** HRD memilih tag skill dari Master Data Sistem (dikelola Super Admin).
- **Step 3 — Target Campuses (Inovasi Utama):** Sistem menampilkan daftar universitas partner aktif. HRD mencentang universitas yang menjadi target publikasi. Lowongan hanya muncul di dashboard mahasiswa dari kampus yang dicentang.
- **Step 4 — Custom Questions (Opsional):** Tambah pertanyaan khusus per lowongan, contoh: "Lampirkan link portfolio GitHub Anda."

**Job Edit & Delete:**
- Halaman khusus untuk mengelola lowongan aktif (edit deskripsi, skill requirement, status).
- Saat menutup lowongan, sistem konfirmasi: "Tolak semua pelamar yang tersisa?" untuk mencegah ghosting massal.

**MoU Expiry Handling:**
- Jika masa berlaku kerja sama (MoU) dengan sebuah universitas berakhir, semua lowongan aktif yang menarget universitas tersebut otomatis berstatus Hidden.
- HRD menerima notifikasi untuk memperbarui MoU melalui menu Partner Universities.

#### C. Menu: Candidate Pipeline (Intelligent Screening)

- **Candidate List View:** Nama Mahasiswa | Badge Logo & Nama Universitas | Match Score (%) | Status saat ini.

**Smart Filter Sidebar:**
- Filter by University — tampilkan pelamar dari kampus tertentu.
- Filter by Minimum Match Rate — hanya tampilkan kandidat dengan skor di atas threshold (contoh: > 70%).
- Filter by Major (Jurusan) — untuk posisi yang mensyaratkan jurusan tertentu.

**Detail Candidate Modal (The Decision Page):**
- **CV Preview:** Format standar kampus yang rapi.
- **Skill-Gap Analysis:** Grafik perbandingan skill mahasiswa vs requirement lowongan.
- **Decision Buttons:**
  - **Reject:** Kirim notifikasi penolakan dengan alasan otomatis ke mahasiswa.
  - **Interview:** Date & Time Picker terintegrasi dengan kalender internal. Undangan terkirim otomatis via email dan push notification ke dashboard mahasiswa.
  - **Hire:** Konfirmasi penerimaan. Status mahasiswa berubah menjadi "Accepted" dan fitur Logbook aktif.

#### D. Menu: Internship Monitoring & Certificate

**Logbook Approval View:**
- HRD melihat Daily Journal mahasiswa dari berbagai universitas.
- Filter by University untuk evaluasi per kampus.
- One-Click Approve: Menyetujui laporan harian dengan satu klik.

**Final Evaluation & Certificate Generation:**
- Input nilai akhir: Kompetensi, Kedisiplinan, Komunikasi, dan Inisiatif.
- **Generate Certificate:** Sistem membuat PDF sertifikat secara otomatis menggunakan Blade Template dengan data binding dinamis.
- **Data binding:** Nama Mahasiswa, Nama Perusahaan, Logo Universitas (dari profil kampus), Nilai Evaluasi.

---

### Database Schema — Perusahaan

| Tabel | Kolom Utama | Keterangan |
|---|---|---|
| companies | id, name, email, nib, npwp, logo_path, banner_path, status (enum) | Profil perusahaan |
| company_users | id, company_id (FK), user_id (FK), role (master/hr) | Tim HR internal |
| company_university | company_id (FK), university_id (FK), status (enum), mou_file, mou_expires_at | Status kerjasama + expiry |
| jobs | id, company_id (FK), title, description, category, duration, status | Data lowongan |
| job_university | job_id (FK), university_id (FK) | Target kampus per lowongan |
| job_skills | job_id (FK), skill_id (FK) | Skill yang dibutuhkan |
| job_custom_questions | id, job_id (FK), question, is_required | Pertanyaan kustom |

---

## 3. Admin Universitas
### Konsep "Control & Insight" — Data untuk Akreditasi & Perlindungan Mahasiswa

#### Account Provisioning — Cara Mendapatkan Akun

Admin Universitas tidak mendaftar secara mandiri melalui tombol publik demi menjaga keamanan sistem. Tersedia tiga opsi provisioning:

**Opsi A — Super Admin Creation (Developer Level)**
Saat universitas pertama kali menjalin kontrak, Super Admin membuatkan satu akun Master Admin melalui backend atau database seeder (php artisan db:seed).

**Opsi B — Invitation System (Internal)**
Master Admin masuk ke menu Staf Management dan mengundang staf kampus lainnya (CDC/Pusat Karir) dengan menginput email institusi. Sistem mengirimkan link aktivasi ke email staf tersebut.

**Opsi C — SSO Whitelist**
Jika kampus menggunakan SSO (Google/Microsoft), Super Admin mendaftarkan domain @univ.ac.id ke daftar putih (whitelist). Siapapun dari tim manajemen yang login dengan email tersebut otomatis diarahkan ke Dashboard Admin.

---

### Menu 1: Executive Dashboard (Accreditation Analytics)

Ini adalah menu yang paling disukai Rektor dan Dekan karena datanya dapat langsung digunakan untuk borang akreditasi BAN-PT dan pelaporan IKU (Indikator Kinerja Utama) ke Kemendikbud.

**Top Metric Cards:**
- **Student Success Rate:** Persentase mahasiswa yang berhasil mendapat magang tahun ini.
- **Active Partners:** Jumlah perusahaan yang aktif bekerja sama.
- **Average Hiring Time:** Rata-rata waktu yang dibutuhkan mahasiswa untuk mendapat magang.

**Charts & Visualisasi:**
- **Major Distribution:** Grafik batang jumlah mahasiswa magang per program studi.
- **Skill-Gap Heatmap:** Perbandingan skill yang diajarkan (profil mahasiswa) vs skill yang diminta pasar (data lowongan). Output: Rekomendasi perbaikan kurikulum untuk Kaprodi.
- **Industry Preference:** Industri yang paling banyak menyerap mahasiswa (contoh: 60% IT, 20% Finance, 20% lainnya).

---

### Menu 2: Partner Management (Gatekeeper)

Admin berperan sebagai "Satpam" yang memastikan perusahaan yang masuk bukan perusahaan bodong atau tidak memenuhi kriteria.

**Sub-menu: Verification Queue:**
- Daftar perusahaan baru yang menunggu verifikasi dokumen legalitas.
- **Detail Viewer:** Admin melihat NIB, Surat Legalitas, dan Profil Perusahaan langsung di browser tanpa perlu mengunduh.
- **Action Buttons:** Approve (perusahaan aktif) atau Reject dengan alasan yang dikirim ke email perusahaan.

**Sub-menu: MoU Tracker:**
- Daftar perusahaan yang sudah bekerja sama beserta status dan tanggal berakhirnya MoU (mou_expires_at).
- Admin dapat mengunggah dokumen digital MoU di sini sebagai arsip kampus.
- Sistem mengirimkan reminder otomatis 30 hari sebelum MoU berakhir.

---

### Menu 3: Student & Academic Management

**Sub-menu: Student List:**
- Daftar seluruh mahasiswa pengguna platform. Admin dapat mencari berdasarkan NIM.
- **Transcript Verification:** Jika data IPK tidak otomatis dari SSO, Admin memverifikasi transkrip yang diunggah mahasiswa agar muncul badge "Verified" di profil.
- Admin melihat status magang aktif setiap mahasiswa secara real-time.

**Sub-menu: Violation / Report:**
- Menampilkan laporan dari perusahaan terkait mahasiswa yang bermasalah selama magang.
- Admin dapat memberikan sanksi: banned sementara dari fitur "Apply" di platform.
- **Violation Appeal Flow:** Mahasiswa yang terkena banned dapat mengajukan banding (appeal) melalui form khusus dengan melampirkan bukti klarifikasi, yang ditinjau ulang oleh Admin.

---

### Menu 4: Internship Monitoring (Anti-Ghosting Shield)

- **SLA Monitor:** Daftar lamaran mahasiswa yang sudah > 7 hari tidak diproses perusahaan.
- **Follow-up Button:** Satu klik mengirimkan email teguran resmi atas nama Universitas ke HRD perusahaan. Ini memberikan tekanan institusional yang lebih efektif daripada teguran individu.
- **Logbook Overview:** Admin dapat mengecek jurnal harian mahasiswa (secara acak atau menyeluruh) untuk memastikan program magang berjalan sesuai koridor pendidikan.

---

### Menu 5: Report Center (The 1-Second Report)

Senjata utama untuk menghemat waktu berminggu-minggu pekerjaan administratif.

- Custom Report Generator dengan filter: Fakultas, Semester, atau Perusahaan.
- **Output:** File Excel/PDF yang formatnya sesuai Borang BAN-PT dan Laporan IKU.
- **Data yang disertakan:** NIM, Nama, Nama Perusahaan, Nama Mentor, Posisi, Durasi Magang, Nilai Akhir.

---

### Menu 6: System Configuration (White-labeling)

- **Branding:** Unggah logo universitas dan atur warna tema aplikasi agar sesuai dengan identitas kampus.
- **Internship Rules:** Mengatur syarat minimum IPK atau SKS untuk mahasiswa dapat menggunakan fitur "Apply" (contoh: minimal 80 SKS).

> ★ **Inovasi: Alumni Tracker Integration**
>
> Sistem tidak berhenti setelah mahasiswa selesai magang. Saat mahasiswa lulus, platform mengirimkan notifikasi pengingat untuk melaporkan status kerja pertama mereka (self-report via form singkat). Data ini dicatat otomatis dan berkontribusi pada Tracer Study kampus — poin paling sulit dalam akreditasi BAN-PT. Admin Universitas mendapatkan data pelacakan alumni tanpa proses survei manual yang memakan waktu.

---

### Contoh Alur Kerja Nyata Admin Universitas:

- **Verifikasi Perusahaan:** Admin mengecek NIB Perusahaan X → Approve → Perusahaan X dapat menarget mahasiswa kampus.
- **Pantau Skill-Gap:** Admin melihat heatmap: mahasiswa Informatika banyak ditolak karena kurang skill "Docker" → Saran ke Kaprodi untuk adakan workshop Docker.
- **Lindungi Mahasiswa:** Admin melihat 10 mahasiswa "digantung" oleh Perusahaan Y selama 10 hari → Klik Follow-up → Perusahaan Y langsung merespons.
- **Pelaporan Instan:** Akhir semester: Admin klik "Generate IKU Report" → Selesai dalam hitungan detik → Laporan siap dikirim ke Kemendikbud/BAN-PT.

---

## 4. Super Admin (Platform Owner)
### Role Ke-4 — Otoritas Tertinggi Platform UC HUB

Super Admin adalah pengelola platform secara keseluruhan. Role ini bertugas untuk mengelola onboarding universitas baru, memantau stabilitas sistem, dan memastikan integritas platform dari level paling atas.

---

### 1. Sistem Pengelolaan Akun & Akses

**University Onboarding:**
- Membuat profil universitas baru di sistem.
- Generate akun Master Admin pertama untuk universitas yang baru bergabung.
- Menetapkan batas mahasiswa aktif dan fitur yang tersedia sesuai paket langganan.

**Global Domain Whitelisting:**
- Mendaftarkan domain email institusi universitas (contoh: @univ.ac.id) agar fitur SSO mahasiswa dan Admin Kampus aktif.
- Mengelola domain SSO untuk memastikan tidak ada domain tidak sah yang terdaftar.

**Internal Staff Management:**
- Mengelola tim internal platform (developer, customer support, tim operasional).
- Menetapkan hak akses bagi masing-masing staf internal.

---

### 2. Dashboard Analitik Global

**Global Metrics:**
- **Total Mahasiswa Aktif:** Jumlah mahasiswa yang terdaftar di seluruh universitas platform.
- **Total Perusahaan Mitra:** Perusahaan yang memiliki akun aktif dan terverifikasi.
- **Total Lowongan Tersedia:** Lowongan aktif yang dipublish di seluruh platform.
- **Platform Uptime:** Persentase stabilitas server dalam periode tertentu.
- **University Performance Ranking:** Melihat universitas dengan tingkat penyerapan magang tertinggi.
- **Platform Traffic Monitor:** Jumlah pengguna harian untuk memastikan kesiapan skalabilitas server.

---

### 3. Manajemen Keamanan & Integritas Global

**Global Company Suspend:**
- Jika sebuah perusahaan terbukti melakukan penipuan massal di beberapa kampus, Super Admin memiliki wewenang untuk menutup akun perusahaan tersebut secara global dari seluruh platform.
- Tindakan ini tidak dapat dilakukan oleh Admin Universitas individual (yang hanya dapat menolak di level kampus masing-masing).

**System Audit Log:**
- Mencatat semua aktivitas Admin Universitas dan Perusahaan secara lengkap.
- Log mencakup: siapa yang memverifikasi perusahaan apa, kapan, dan hasilnya.
- Digunakan untuk keperluan audit keamanan dan investigasi jika terjadi sengketa.

**Violation Appeals (Final Level):**
- Meninjau banding tingkat akhir dari perusahaan yang merasa akunnya ditutup secara tidak adil oleh Admin Kampus tertentu.
- Keputusan Super Admin bersifat final dan tidak dapat diganggu gugat.

---

### 4. Manajemen Infrastruktur & Billing

**Server Monitoring:**
- Memantau stabilitas sistem dan performa API integrasi SSO kampus.
- Dashboard menampilkan response time, error rate, dan queue panjang (untuk Reverb/Pusher).

**Subscription & Billing (SaaS Model):**
- Mengelola status langganan universitas: paket Starter, Growth, atau Enterprise per semester.
- Mengelola penagihan biaya lisensi penggunaan platform.
- Notifikasi otomatis ke Admin Universitas jika langganan akan berakhir dalam 30 hari.

**System Update & Configuration:**
- Mengatur jadwal deployment pembaruan fitur (maintenance window) agar tidak mengganggu operasional universitas.
- Mengelola feature flags — fitur baru dapat diaktifkan secara bertahap per universitas.

---

### 5. Master Data & Konfigurasi Global

**Master Skill Database:**
- Mengelola daftar induk keahlian yang digunakan sebagai referensi oleh semua pengguna.
- Memastikan konsistensi penamaan skill di seluruh platform (contoh: "React.js" bukan "ReactJS" atau "React").
- Admin Perusahaan dan Mahasiswa hanya bisa memilih skill dari master list ini — tidak bisa input bebas.

**Standard Report Templates:**
- Menentukan format standar laporan IKU dan BAN-PT yang akan digunakan oleh semua Admin Universitas.
- Pembaruan template dilakukan terpusat — satu kali update berlaku untuk semua kampus.

---

## Ringkasan Teknis Laravel — Multi-Tenancy & Roles

### Role System:

| Role | Kemampuan Utama | Batasan |
|---|---|---|
| super_admin | can_manage_universities, can_global_suspend, can_manage_billing | Tidak ada (akses penuh) |
| university_admin | can_verify_company, can_export_report, can_manage_students | Terbatas pada data universitas sendiri |
| company_admin | can_post_job, can_review_candidate, can_manage_hr_team | Hanya pelamar dari kampus yang aktif MoU |
| student | can_apply_job, can_build_cv, can_write_journal | Hanya lowongan dari kampus sendiri |

### Multi-Tenancy Scope (Laravel Global Scope):

- Setiap query mahasiswa di dashboard perusahaan harus memiliki where clause yang memverifikasi perusahaan memiliki akses MoU ke universitas mahasiswa tersebut.
- Admin Universitas A tidak dapat melihat data mahasiswa atau internal Universitas B (terisolasi per universitas_id).

### Real-time Notification (Laravel Reverb / Pusher):

- Mahasiswa melamar → Admin Perusahaan menerima notifikasi real-time.
- HRD klik "Interview" → Mahasiswa menerima notifikasi instan di dashboard dan email.
- Demo fallback: Gunakan Pusher free tier jika Reverb belum siap di environment demo.

> ★ **Inovasi Sistem Keamanan Berlapis**
>
> Platform UC HUB menggunakan sistem keamanan 3 lapis: (1) Super Admin mengontrol universitas dan perusahaan di level global, (2) Admin Universitas mengontrol akses perusahaan ke mahasiswanya, (3) Mahasiswa hanya melihat lowongan dari perusahaan yang sudah diverifikasi oleh kampusnya sendiri. Tidak ada satu pun perusahaan yang bisa bypass verifikasi kampus untuk mendekati mahasiswa.

---

## Ringkasan Arsitektur Platform

| Komponen | Teknologi | Keterangan |
|---|---|---|
| Backend Framework | Laravel 11 | API & Business Logic |
| SSO Authentication | Laravel Socialite | Integrasi SSO Google/Microsoft Kampus |
| Real-time Events | Laravel Reverb / Pusher | Notifikasi instan antar role |
| PDF Generation | Browsershot (Puppeteer) | CV & Sertifikat, presisi A4 |
| File Storage | AWS S3 | Portfolio, dokumen legalitas, foto |
| Scheduled Jobs | Laravel Scheduler | SLA timer, reminder MoU, Alumni Tracker |
| Excel Export | Maatwebsite/Excel | Laporan BAN-PT & IKU |
| Multi-tenancy | Laravel Global Scope | Isolasi data per universitas |
| Database | MySQL / PostgreSQL | Relational DB dengan pivot tables |

---

*UC HUB — Platform Magang & Karir Terintegrasi*

*Dokumen ini memuat deskripsi lengkap sistem untuk Lomba Web Development I/O Festival 2026.*

*Subtema: Human Capital & Future Skills Inclusivity*
