@extends('layouts.asesor')

@section('content')
<h4>Detail Penilaian Asesi</h4>

<p><b>Nama Asesi:</b> {{ $pengajuan->user->nama }}</p>
<p><b>Skema:</b> {{ $pengajuan->program->nama }}</p>

<hr>

<p>Halaman penilaian akan kita isi di step berikutnya.</p>
@endsection
