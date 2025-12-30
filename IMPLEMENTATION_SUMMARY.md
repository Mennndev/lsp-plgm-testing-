# Certification Schema Submission System - Implementation Summary

## Overview
This update transforms the certification schema submission system from a simple 4-step wizard to a comprehensive 6-tab structure similar to TIK Global, with dynamic per-schema requirements management.

## Key Changes

### 1. Database Structure

#### New Tables Created:
- `persyaratan_dasar` - Basic requirements per schema
- `bukti_administratif` - Administrative evidence requirements
- `bukti_portofolio_template` - Portfolio document templates
- `kriteria_unjuk_kerja` - Competency criteria (KUK) per elemen
- `pengajuan_persyaratan_dasar` - User submissions for basic requirements
- `pengajuan_bukti_administratif` - User submissions for administrative evidence
- `pengajuan_bukti_portofolio` - User submissions for portfolio documents
- `pengajuan_bukti_kompetensi` - User submissions for competency evidence

#### New Models Created:
- `PersyaratanDasar`
- `BuktiAdministratif`
- `BuktiPortofolioTemplate`
- `KriteriaUnjukKerja`
- `PengajuanPersyaratanDasar`
- `PengajuanBuktiAdministratif`
- `PengajuanBuktiPortofolio`
- `PengajuanBuktiKompetensi`

#### Updated Models:
- `ProgramPelatihan` - Added relationships for requirements
- `ElemenKompetensi` - Added relationship for kriteria unjuk kerja
- `PengajuanSkema` - Added relationships for all new submission types

### 2. Admin Interface

#### New Features:
- Admin can manage Persyaratan Dasar (Basic Requirements) per schema
- Admin can manage Bukti Administratif (Administrative Evidence) per schema
- Admin can manage Bukti Portofolio Template (Portfolio Templates) per schema
- Each requirement can be marked as mandatory or optional
- Requirements can be ordered
- Three types of input: file_upload, text, checkbox

#### Files Modified/Created:
- `app/Http/Controllers/admin/ProgramPelatihanController.php` - Added persyaratan management logic
- `resources/views/admin/program-pelatihan/_persyaratan_section.blade.php` - New section for managing requirements
- `resources/views/admin/program-pelatihan/_form.blade.php` - Included persyaratan section

### 3. User Submission Form (6-Tab System)

#### New Submission Flow:
1. **Tab 1: Data Pribadi** - Personal information (APL-01)
2. **Tab 2: Persyaratan Dasar** - Dynamic list of basic requirements with file upload
3. **Tab 3: Bukti Administratif** - Administrative documents (KTP, Pas Foto, etc.)
4. **Tab 4: Bukti Portofolio** - Portfolio documents (Work Certificates, Training Certificates, etc.)
5. **Tab 5: Bukti Kompetensi** - Self-assessment + Evidence upload per KUK
6. **Tab 6: Persyaratan Pendaftaran** - Review, Agreement, Digital Signature

#### Files Created:
- `resources/views/pengajuan/create-6tab.blade.php` - New 6-tab submission form
- `public/css/pengajuan-6tab.css` - Modern tab-based styling
- `public/js/pengajuan-6tab.js` - Tab navigation and signature functionality

#### Files Modified:
- `app/Http/Controllers/PengajuanSkemaController.php` - Updated to support 6-tab system with file uploads

### 4. Features

#### File Upload Management:
- Support for PDF, JPG, PNG, DOC, DOCX formats
- Maximum file size: 2MB per file
- Automatic validation
- Organized storage per requirement type

#### Digital Signature:
- Canvas-based signature drawing
- Upload signature image option
- Preview before submission
- Saved with submission data

#### Responsive Design:
- Mobile-friendly tab navigation
- Responsive tables and forms
- Touch-friendly signature pad
- Optimized for all screen sizes

#### Backward Compatibility:
- Old submission form still exists (`create.blade.php`)
- Existing data structure preserved
- New tables don't affect existing submissions

## Migration Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

This will create all 8 new tables:
- persyaratan_dasar
- bukti_administratif
- bukti_portofolio_template
- kriteria_unjuk_kerja
- pengajuan_persyaratan_dasar
- pengajuan_bukti_administratif
- pengajuan_bukti_portofolio
- pengajuan_bukti_kompetensi

### 2. Update Existing Programs
Admins need to:
1. Edit each program pelatihan
2. Add Persyaratan Dasar (basic requirements)
3. Add Bukti Administratif (administrative documents)
4. Add Bukti Portofolio Template (portfolio documents)
5. Save the program

### 3. Testing Checklist
- [ ] Verify migrations run successfully
- [ ] Test admin can add/edit/delete requirements
- [ ] Test user can view and submit 6-tab form
- [ ] Test file uploads for each requirement type
- [ ] Test validation works correctly
- [ ] Test digital signature functionality
- [ ] Test responsive design on mobile devices
- [ ] Verify backward compatibility with existing data

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── PengajuanSkemaController.php (updated)
│       └── admin/
│           └── ProgramPelatihanController.php (updated)
└── Models/
    ├── BuktiAdministratif.php (new)
    ├── BuktiPortofolioTemplate.php (new)
    ├── ElemenKompetensi.php (updated)
    ├── KriteriaUnjukKerja.php (new)
    ├── PengajuanBuktiAdministratif.php (new)
    ├── PengajuanBuktiKompetensi.php (new)
    ├── PengajuanBuktiPortofolio.php (new)
    ├── PengajuanPersyaratanDasar.php (new)
    ├── PengajuanSkema.php (updated)
    ├── PersyaratanDasar.php (new)
    └── ProgramPelatihan.php (updated)

database/
└── migrations/
    ├── 2025_12_30_050000_create_persyaratan_dasar_table.php (new)
    ├── 2025_12_30_050100_create_bukti_administratif_table.php (new)
    ├── 2025_12_30_050200_create_bukti_portofolio_template_table.php (new)
    ├── 2025_12_30_050300_create_kriteria_unjuk_kerja_table.php (new)
    ├── 2025_12_30_050400_create_pengajuan_persyaratan_dasar_table.php (new)
    ├── 2025_12_30_050500_create_pengajuan_bukti_administratif_table.php (new)
    ├── 2025_12_30_050600_create_pengajuan_bukti_portofolio_table.php (new)
    └── 2025_12_30_050700_create_pengajuan_bukti_kompetensi_table.php (new)

public/
├── css/
│   └── pengajuan-6tab.css (new)
└── js/
    └── pengajuan-6tab.js (new)

resources/
└── views/
    ├── admin/
    │   └── program-pelatihan/
    │       ├── _form.blade.php (updated)
    │       └── _persyaratan_section.blade.php (new)
    └── pengajuan/
        ├── create.blade.php (existing - unchanged)
        └── create-6tab.blade.php (new)
```

## API/Endpoints

No new routes are required. The existing routes are used:
- `GET /pengajuan/create/{programId}` - Now loads 6-tab form
- `POST /pengajuan/store` - Handles 6-tab submission
- Admin routes remain the same

## Configuration

No additional configuration required. File upload limits are handled in controller validation.

## Notes

1. **KUK Management**: Kriteria Unjuk Kerja should be managed when editing Elemen Kompetensi. This can be added as a future enhancement in the elemen kompetensi form section.

2. **File Storage**: All uploaded files are stored in `storage/app/public/` with subdirectories:
   - `pengajuan_persyaratan_dasar/`
   - `pengajuan_bukti_administratif/`
   - `pengajuan_bukti_portofolio/`
   - `pengajuan_bukti_kompetensi/`

3. **Validation**: File validation is performed at 2MB max size with allowed extensions: PDF, JPG, PNG, DOC, DOCX

4. **UI/UX**: The design follows modern Bootstrap 5 patterns with custom CSS for enhanced user experience.

## Future Enhancements

1. Add KUK management UI in Elemen Kompetensi section
2. Add AJAX file upload with progress bars
3. Add file preview functionality
4. Add bulk file upload option
5. Add email notifications for submission status
6. Add admin dashboard for tracking submissions
7. Export submission data to PDF/Excel
8. Add submission history and version tracking

## Support

For issues or questions, please refer to the repository issues page or contact the development team.
