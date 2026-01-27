@extends('layouts.asesor')

@section('content')
<h4>Penilaian Skema: {{ $pengajuan->program->nama }}</h4>
<p>Asesi: {{ $pengajuan->user->nama }}</p>

<form method="POST" action="{{ route('asesor.pengajuan.store', $pengajuan->id) }}">
@csrf

@foreach($pengajuan->program->unitKompetensi as $unit)
    <h5>{{ $unit->nama }}</h5>

    @foreach($unit->elemen as $elemen)
        <b>{{ $elemen->nama }}</b>

        <ul>
        @foreach($elemen->kriteriaUnjukKerja as $kuk)
            <li>
                {{ $kuk->pertanyaan }}

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
@endforeach

<button class="btn btn-success">Simpan Penilaian</button>

</form>
@endsection
