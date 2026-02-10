@extends('layouts.asesor')

@section('content')
<h4>Detail Penilaian Asesi</h4>

<p><b>Nama Asesi:</b> {{ $pengajuan->user->nama }}</p>
<p><b>Skema:</b> {{ $pengajuan->program->nama }}</p>

<hr>

<div class="mt-3">
    <a href="{{ route('asesor.pengajuan.penilaian', $pengajuan->id) }}" class="btn btn-primary">Mulai Penilaian</a>
</div>
@endsection
