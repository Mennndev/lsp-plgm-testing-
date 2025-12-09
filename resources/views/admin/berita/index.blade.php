@extends('layouts.admin') {{-- sesuaikan layout admin mu --}}

@section('title', 'Kelola Berita')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Kelola Berita</h4>

    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Berita
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($beritas->isEmpty())
            <p class="text-muted mb-0">Belum ada berita yang dibuat.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Judul</th>
                        <th width="160">Tanggal Terbit</th>
                        <th width="120">Status</th>
                        <th width="160">Dibuat</th>
                        <th width="170">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($beritas as $index => $berita)
                        <tr>
                            <td>{{ $beritas->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $berita->judul }}</strong>
                                @if($berita->slug)
                                    <div class="small text-muted">slug: {{ $berita->slug }}</div>
                                @endif
                            </td>
                            <td>
                                @if($berita->tanggal_terbit)
                                    {{ \Carbon\Carbon::parse($berita->tanggal_terbit)->format('d-m-Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($berita->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $berita->created_at?->format('d-m-Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       target="_blank" title="Lihat di publik">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>

                                    <a href="{{ route('admin.berita.edit', $berita->id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $beritas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
