@csrf

<div class="mb-3">
    <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
    <input type="text" name="judul"
           class="form-control @error('judul') is-invalid @enderror"
           value="{{ old('judul', $berita->judul ?? '') }}" required>
    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Terbit</label>
    <input type="date" name="tanggal_terbit"
           class="form-control @error('tanggal_terbit') is-invalid @enderror"
           value="{{ old('tanggal_terbit', isset($berita->tanggal_terbit) ? \Carbon\Carbon::parse($berita->tanggal_terbit)->format('Y-m-d') : '') }}">
    @error('tanggal_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan Singkat</label>
    <textarea name="ringkasan" rows="3"
              class="form-control @error('ringkasan') is-invalid @enderror">{{ old('ringkasan', $berita->ringkasan ?? '') }}</textarea>
    <div class="form-text">Opsional, ditampilkan sebagai cuplikan di halaman daftar berita.</div>
    @error('ringkasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Konten Berita <span class="text-danger">*</span></label>
    <textarea name="konten" rows="8"
              class="form-control @error('konten') is-invalid @enderror">{{ old('konten', $berita->konten ?? '') }}</textarea>
    @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar Utama</label>
   @if(!empty($berita->gambar) && $berita->gambar !== '0')
  <img src="{{ Storage::url($berita->gambar) }}" style="max-height:150px;">
@endif
    <input type="file" name="gambar"
           class="form-control @error('gambar') is-invalid @enderror">
    <div class="form-text">Format: JPG/PNG, maks 2 MB.</div>
    @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="1" id="is_published"
           name="is_published"
           {{ old('is_published', $berita->is_published ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_published">
        Publish berita ini
    </label>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
        Batal
    </a>
</div>
