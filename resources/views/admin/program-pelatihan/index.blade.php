@extends('layouts.admin')

@section('title', 'Program Pelatihan – Admin')
@section('page_title', 'Program Pelatihan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Daftar Program Pelatihan</h5>
    <a href="{{ route('admin.program-pelatihan.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Program Baru
    </a>
</div>

<div class="admin-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Kode</th>
                    <th>Nama Program</th>
                    <th>Kategori</th>
                    <th style="width: 90px;">Unit</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($programs as $program)
                <tr>
                    <td>{{ $program->kode_skema }}</td>
                    <td>{{ $program->nama }}</td>
                    <td>{{ $program->kategori }}</td>
                    <td>{{ $program->jumlah_unit }}</td>
                    <td>
                        @if($program->is_published)
                            <span class="badge bg-success">Publish</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('skema/'.$program->slug) }}" target="_blank"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('admin.program-pelatihan.edit', $program->id) }}"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.program-pelatihan.destroy', $program->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada data program pelatihan.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $programs->links() }}
    </div>
</div>

@endsection
