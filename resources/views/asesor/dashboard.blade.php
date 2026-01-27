@extends('layouts.asesor')

@section('content')
<h4>Dashboard Asesor</h4>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Asesi</th>
                    <th>Skema</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuanList as $row)
                <tr>
                  <td>{{ $row->pengajuan->user->nama }}</td>
                <td>{{ $row->pengajuan->program->nama }}</td>
                <td>
                    <span class="badge bg-info">
                        {{ $row->pengajuan->status }}
                    </span>
                </td>
                <td>
                   <a href="{{ route('asesor.pengajuan.show', $row->pengajuan->id) }}" class="btn btn-primary">
                Mulai Penilaian
                </a>

                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
