# Formulir Asesmen BNSP - Feature Documentation

## Overview
This feature implements a comprehensive forms management system for assessors (asesor) to fill and print BNSP standard assessment forms digitally. The forms are required in the competency certification process.

## Implementation Details

### 1. Database Schema

**Table: `formulir_asesmen`**
- `id` - Primary key
- `pengajuan_skema_id` - Foreign key to pengajuan_skema table
- `asesor_id` - Foreign key to users table (assessor)
- `jenis_formulir` - Form type (FR_IA_01, FR_IA_02, FR_IA_05, FR_IA_07, FR_IA_11, FR_AK_01, FR_AK_05)
- `data` - JSON field storing form data
- `status` - Enum: 'draft' or 'selesai' (completed)
- `timestamps` - Created at / Updated at
- Unique constraint on (pengajuan_skema_id, asesor_id, jenis_formulir)

### 2. Routes

All routes are under the `asesor` middleware group with `auth` and `role:asesor` protection:

- `GET /asesor/pengajuan/{id}/formulir` → Lists all available forms
- `GET /asesor/pengajuan/{id}/formulir/{jenis}` → Show form input interface
- `POST /asesor/pengajuan/{id}/formulir/{jenis}` → Save form data
- `GET /asesor/pengajuan/{id}/formulir/{jenis}/cetak` → Generate and download PDF

### 3. Form Types Supported

1. **FR.IA.01** - Ceklis Observasi Aktivitas di Tempat Kerja
   - Location, date, activities observed, results, notes

2. **FR.IA.02** - Tugas Praktik Demonstrasi
   - Task description, date, demonstration results, assessment (competent/not competent), notes

3. **FR.IA.05** - Pertanyaan Tertulis Esai
   - Multiple questions and answers, evaluation

4. **FR.IA.07** - Pertanyaan Lisan
   - Interview date, questions and oral responses, conclusion

5. **FR.IA.11** - Ceklis Meninjau Portofolio
   - Portfolio documents, relevance to competency, completeness assessment, notes

6. **FR.AK.01** - Persetujuan Asesmen dan Kerahasiaan
   - Approval date, agreed assessment methods, schedule, consent checkbox, notes

7. **FR.AK.05** - Laporan Hasil Asesmen
   - Assessment date, methods used, summary of results, recommendation (competent/not competent), notes

### 4. Key Features

- **Status Management**: Forms can be saved as drafts or marked as completed
- **Authorization**: Only assigned assessors can access forms for their pengajuan
- **PDF Generation**: Professional PDF output with LSP PLGM branding
- **Data Persistence**: Form data is stored as JSON for flexibility
- **User-Friendly Interface**: Bootstrap-styled forms with validation

### 5. Files Created/Modified

**New Files:**
- `app/Models/FormulirAsesmen.php` - Model with relationships
- `app/Http/Controllers/Asesor/FormulirController.php` - Controller with CRUD operations
- `database/migrations/2026_02_12_131638_create_formulir_asesmen_table.php` - Database migration
- `resources/views/asesor/formulir/index.blade.php` - Forms listing page
- `resources/views/asesor/formulir/show.blade.php` - Form input page
- `resources/views/asesor/formulir/cetak.blade.php` - PDF template

**Modified Files:**
- `routes/web.php` - Added formulir routes
- `app/Models/PengajuanSkema.php` - Added formulirAsesmen relationship
- `resources/views/asesor/pengajuan/show.blade.php` - Added "Formulir Asesmen" button

### 6. Dependencies

- **barryvdh/laravel-dompdf** (^3.1) - For PDF generation

### 7. Usage Flow

1. Assessor navigates to pengajuan detail page
2. Clicks "Formulir Asesmen" button
3. Views list of 7 available form types with status indicators
4. Clicks "Isi Formulir" or "Edit" for a specific form type
5. Fills in the form fields
6. Can save as draft or mark as completed
7. Once completed, can print/download PDF

### 8. Security

- All routes protected by `auth` and `role:asesor` middleware
- Assessors can only access forms for pengajuan they are assigned to
- Authorization checks in every controller method

### 9. Testing

To test the feature:

1. Run migration: `php artisan migrate`
2. Login as an assessor user
3. Navigate to an assigned pengajuan
4. Click "Formulir Asesmen" button
5. Fill out a form and save
6. Verify data is saved correctly
7. Test PDF generation

### 10. Future Enhancements

Potential improvements:
- Form validation rules per form type
- File attachments for evidence
- Digital signatures
- Email notifications when forms are completed
- Export to Excel functionality
- Form templates customization
