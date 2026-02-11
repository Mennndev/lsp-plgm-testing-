@extends('layouts.asesor')

@section('title', 'Profil Saya - Asesor')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('asesor.dashboard') }}" style="color: #233C7E;">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
        </ol>
    </nav>

    <h4 class="mb-4" style="color: #233C7E; font-weight: 600;">Profil Saya</h4>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Terdapat kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm" style="border-top: 3px solid #233C7E;">
                <div class="card-body text-center">
                    <div class="mb-3" id="photo-container">
                        @if($asesorProfile && $asesorProfile->foto_profile)
                            <img src="{{ asset('storage/' . $asesorProfile->foto_profile) }}" 
                                 alt="Foto Profil" 
                                 class="rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #233C7E;"
                                 id="preview-foto">
                        @else
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" 
                                 style="width: 150px; height: 150px; border: 4px solid #233C7E;">
                                <i class="bi bi-person-circle" style="font-size: 100px; color: #233C7E;"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1" style="color: #233C7E; font-weight: 600;">{{ $user->nama }}</h5>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <span class="badge px-3 py-2 mt-2" style="background: #D69F3A; color: #111; font-size: 0.9rem;">
                        <i class="bi bi-shield-check me-1"></i>Asesor
                    </span>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm" style="border-top: 3px solid #233C7E;">
                <div class="card-header" style="background: #f8f9fa; border-bottom: 2px solid #233C7E;">
                    <h5 class="mb-0" style="color: #233C7E; font-weight: 600;">
                        <i class="bi bi-person-gear me-2"></i>Edit Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('asesor.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold" style="color: #233C7E;">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $user->nama) }}" 
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold" style="color: #233C7E;">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="mb-3">
                            <label for="no_hp" class="form-label fw-semibold" style="color: #233C7E;">
                                No. HP / WhatsApp
                            </label>
                            <input type="text" 
                                   class="form-control @error('no_hp') is-invalid @enderror" 
                                   id="no_hp" 
                                   name="no_hp" 
                                   value="{{ old('no_hp', $user->no_hp) }}"
                                   placeholder="Contoh: 081234567890">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold" style="color: #233C7E;">
                                Alamat
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" 
                                      name="alamat" 
                                      rows="3"
                                      placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bidang Keahlian -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #233C7E;">
                                Bidang Keahlian / Kompetensi
                            </label>
                            <div id="bidang-keahlian-container">
                                @foreach($bidangKeahlian as $index => $bidang)
                                <div class="input-group mb-2 bidang-keahlian-item">
                                    <input type="text" 
                                           class="form-control" 
                                           name="bidang_keahlian[]" 
                                           value="{{ $bidang }}"
                                           placeholder="Contoh: Teknologi Informasi">
                                    <button type="button" class="btn btn-outline-danger remove-bidang" onclick="removeBidang(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addBidang()">
                                <i class="bi bi-plus-circle me-1"></i>Tambah Bidang Keahlian
                            </button>
                        </div>

                        <!-- Foto Profil -->
                        <div class="mb-3">
                            <label for="foto_profile" class="form-label fw-semibold" style="color: #233C7E;">
                                Foto Profil
                            </label>
                            <input type="file" 
                                   class="form-control @error('foto_profile') is-invalid @enderror" 
                                   id="foto_profile" 
                                   name="foto_profile" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewImage(event)">
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                            @error('foto_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg" style="background: #233C7E; color: #fff; border: none;">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('preview-foto');
            if (preview) {
                preview.src = reader.result;
            } else {
                // Create new img element if it doesn't exist
                const photoContainer = document.getElementById('photo-container');
                if (photoContainer) {
                    photoContainer.innerHTML = `<img src="${reader.result}" alt="Foto Profil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #233C7E;" id="preview-foto">`;
                }
            }
        }
        
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Add bidang keahlian field
    function addBidang() {
        const container = document.getElementById('bidang-keahlian-container');
        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 bidang-keahlian-item';
        newItem.innerHTML = `
            <input type="text" 
                   class="form-control" 
                   name="bidang_keahlian[]" 
                   placeholder="Contoh: Teknologi Informasi">
            <button type="button" class="btn btn-outline-danger remove-bidang" onclick="removeBidang(this)">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newItem);
    }

    // Remove bidang keahlian field
    function removeBidang(button) {
        const container = document.getElementById('bidang-keahlian-container');
        const items = container.querySelectorAll('.bidang-keahlian-item');
        
        // Keep at least one field
        if (items.length > 1) {
            button.closest('.bidang-keahlian-item').remove();
        } else {
            // Clear the last field instead of removing it
            button.closest('.bidang-keahlian-item').querySelector('input').value = '';
        }
    }
</script>
@endpush
@endsection
