@extends('layouts.asesor')

@section('content')
<h4>Penilaian Skema: {{ $pengajuan->program->nama }}</h4>
<p>Asesi: {{ $pengajuan->user->nama }}</p>

<form method="POST" action="{{ route('asesor.pengajuan.store', $pengajuan->id) }}">
@csrf

@forelse($pengajuan->program->units as $unit)
    <h5>{{ $unit->judul_unit }}</h5>

    @foreach($unit->elemenKompetensis as $elemen)
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
    @endforeach
@empty
    <div class="alert alert-warning">Unit kompetensi untuk skema ini belum tersedia.</div>
@endforelse

<button class="btn btn-success">Simpan Penilaian</button>

</form>
@endsection
