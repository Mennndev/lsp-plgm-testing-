@extends('layouts.admin')

@section('title', 'Tambah Program Pelatihan')
@section('page_title', 'Tambah Program Pelatihan')

@section('content')
<div class="admin-table">
    <h5 class="mb-3">Tambah Program Pelatihan</h5>

    <form action="{{ route('admin.program-pelatihan.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.program-pelatihan._form', ['program' => null])
    </form>
</div>
@push('scripts')
<script>
    // ========== UNIT KOMPETENSI ==========
    const unitWrapper = document.getElementById('unit-wrapper');
    const addUnitBtn   = document.getElementById('add-unit');

    if (addUnitBtn) {
        addUnitBtn.addEventListener('click', function () {
            let rowCount = unitWrapper.rows.length + 1;

            let row = `
                <tr>
                    <td class="text-center">${rowCount}</td>
                    <td>
                        <input type="text" name="unit_kode[]" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" name="unit_judul[]" class="form-control" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-unit">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            unitWrapper.insertAdjacentHTML('beforeend', row);
        });
    }

    // Hapus baris unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-unit')) {
            e.target.closest('tr').remove();
        }
    });


    // ========== PROFESI TERKAIT ==========
    const profesiWrapper = document.getElementById('profesi-wrapper');
    const addProfesiBtn  = document.getElementById('add-profesi');

    if (addProfesiBtn) {
        addProfesiBtn.addEventListener('click', function () {
            let rowCount = profesiWrapper.rows.length + 1;

            let row = `
                <tr>
                    <td class="text-center">${rowCount}</td>
                    <td>
                        <input type="text" name="profesi_nama[]" class="form-control" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-profesi">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            profesiWrapper.insertAdjacentHTML('beforeend', row);
        });
    }

    // Hapus baris profesi
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-profesi')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush
@endsection
