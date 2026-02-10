@extends('layouts.asesor')

@section('page-title', 'Penilaian Asesi')

@section('content')
<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h4 class="mb-1">Penilaian Skema: {{ $pengajuan->program->nama }}</h4>
            <p class="text-muted mb-0">Asesi: {{ $pengajuan->user->nama }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('asesor.pengajuan.store', $pengajuan->id) }}" class="vstack gap-4">
        @csrf

        @forelse($pengajuan->program->units as $unit)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">{{ $unit->judul_unit }}</h5>
                </div>
                <div class="card-body">
                    @forelse($unit->elemenKompetensis as $elemen)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">{{ $elemen->nama_elemen }}</h6>

                            <div class="vstack gap-3">
                                @foreach($elemen->kriteriaUnjukKerja as $kuk)
                                    <div class="border rounded p-3 bg-light-subtle">
                                        <label class="form-label fw-semibold d-block mb-2" for="nilai_{{ $kuk->id }}">
                                            {{ $kuk->deskripsi }}
                                        </label>

                                        <div class="row g-3">
                                            <div class="col-lg-4 col-md-5">
                                                <select id="nilai_{{ $kuk->id }}" name="nilai[{{ $kuk->id }}]" class="form-select" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="kompeten" {{ old('nilai.' . $kuk->id) === 'kompeten' ? 'selected' : '' }}>Kompeten</option>
                                                    <option value="belum_kompeten" {{ old('nilai.' . $kuk->id) === 'belum_kompeten' ? 'selected' : '' }}>Belum Kompeten</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-8 col-md-7">
                                                <textarea name="catatan[{{ $kuk->id }}]" class="form-control" rows="2" placeholder="Catatan untuk kriteria ini (opsional)">{{ old('catatan.' . $kuk->id) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada elemen kompetensi untuk unit ini.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="alert alert-secondary mb-0">Belum ada unit kompetensi pada program ini.</div>
        @endforelse

        <div>
            <button type="submit" class="btn btn-success px-4">Simpan Penilaian</button>
        </div>
    </form>
</div>
@endsection
