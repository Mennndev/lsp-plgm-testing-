@extends('layouts.asesor')

@section('content')
<h4>Penilaian Skema: {{ $pengajuan->program->nama }}</h4>
<p>Asesi: {{ $pengajuan->user->nama }}</p>

<form method="POST" action="{{ route('asesor.pengajuan.store', $pengajuan->id) }}">
@csrf

@forelse($pengajuan->program->units as $unit)
    <h5>{{ $unit->judul_unit }}</h5>

    @forelse($unit->elemenKompetensis as $elemen)
        <b>{{ $elemen->nama_elemen }}</b>

        <ul>
        @foreach($elemen->kriteriaUnjukKerja as $kuk)
            <li>
                {{ $kuk->deskripsi }}

                <select name="nilai[{{ $kuk->id }}]" required>
                    <option value="">-- Pilih --</option>
                    <option value="kompeten">Kompeten</option>
                    <option value="belum_kompeten">Belum Kompeten</option>
                </select>

                <br>
                <textarea name="catatan[{{ $kuk->id }}]" placeholder="Catatan..."></textarea>
            </li>
        @endforeach
        </ul>
    @empty
        <p class="text-muted">Belum ada elemen kompetensi untuk unit ini.</p>
    @endforelse
@empty
    <p class="text-muted">Belum ada unit kompetensi pada program ini.</p>
@endforelse

<button class="btn btn-success">Simpan Penilaian</button>

</form>
@endsection
