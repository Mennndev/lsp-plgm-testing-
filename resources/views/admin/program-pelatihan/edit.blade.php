@extends('layouts.admin')

@section('title', 'Edit Program Pelatihan')
@section('page_title', 'Edit Program Pelatihan')

@section('content')
<div class="admin-table">
    <h5 class="mb-3">Edit Program: {{ $program->nama }}</h5>

    <form action="{{ route('admin.program-pelatihan.update', $program->id) }}"
          method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.program-pelatihan._form', ['program' => $program])
    </form>
</div>
@push('scripts')
<script>
    // ========== UNIT KOMPETENSI ==========
    const unitWrapper = document.getElementById('unit-wrapper');
    const addUnitBtn   = document.getElementById('add-unit');

    if (addUnitBtn) {
        addUnitBtn.addEventListener('click', function () {
            let unitCount = unitWrapper.querySelectorAll('.unit-card').length;
            let unitIndex = unitCount;

            let unitCard = `
                <div class="unit-card card mb-3">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <strong>Unit ${unitCount + 1}</strong>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="unit_kode[]" class="form-control form-control-sm"
                                       placeholder="Kode Unit" required>
                            </div>
                            <div class="col">
                                <input type="text" name="unit_judul[]" class="form-control form-control-sm"
                                       placeholder="Judul Unit" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger btn-sm remove-unit">
                                    <i class="bi bi-trash"></i> Hapus Unit
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-2">Elemen Kompetensi</h6>
                        <div class="elemen-wrapper">
                            <div class="card mb-3 elemen-card">
                                <div class="card-body py-2">
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto">
                                            <strong class="text-muted">1.</strong>
                                        </div>
                                        <div class="col">
                                            <input type="text" name="elemen_nama[${unitIndex}][]"
                                                   class="form-control form-control-sm"
                                                   placeholder="Nama Elemen Kompetensi" required>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger btn-sm remove-elemen">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="ms-4">
                                        <p class="mb-2 text-muted small">
                                            <i class="bi bi-list-check"></i> Kriteria Unjuk Kerja (KUK)
                                        </p>
                                        <div class="kuk-wrapper">
                                            <div class="input-group input-group-sm mb-2 kuk-row">
                                                <span class="input-group-text">1.</span>
                                                <input type="text" name="kuk_deskripsi[${unitIndex}][0][]"
                                                       class="form-control" 
                                                       placeholder="Deskripsi Kriteria Unjuk Kerja" required>
                                                <button type="button" class="btn btn-outline-danger remove-kuk">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm add-kuk">
                                            <i class="bi bi-plus"></i> Tambah KUK
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm add-elemen">
                            <i class="bi bi-plus-circle"></i> Tambah Elemen
                        </button>
                    </div>
                </div>`;
            unitWrapper.insertAdjacentHTML('beforeend', unitCard);
            updateUnitNumbers();
        });
    }

    // Hapus baris unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-unit')) {
            const card = e.target.closest('.unit-card');
            if (card && unitWrapper.querySelectorAll('.unit-card').length > 1) {
                card.remove();
                updateUnitNumbers();
            } else {
                alert('Minimal harus ada 1 unit kompetensi');
            }
        }
    });

    // Update unit numbers and elemen name attributes
    function updateUnitNumbers() {
        const unitCards = unitWrapper.querySelectorAll('.unit-card');
        unitCards.forEach((card, unitIndex) => {
            // Update unit label
            const unitLabel = card.querySelector('.card-header strong');
            if (unitLabel) {
                unitLabel.textContent = `Unit ${unitIndex + 1}`;
            }

            // Update elemen name attributes and KUK name attributes
            const elemenCards = card.querySelectorAll('.elemen-card');
            elemenCards.forEach((elemenCard, elemenIndex) => {
                // Update elemen input name
                const elemenInput = elemenCard.querySelector('input[name^="elemen_nama"]');
                if (elemenInput) {
                    elemenInput.setAttribute('name', `elemen_nama[${unitIndex}][]`);
                }

                // Update KUK input names
                const kukInputs = elemenCard.querySelectorAll('input[name^="kuk_deskripsi"]');
                kukInputs.forEach(kukInput => {
                    kukInput.setAttribute('name', `kuk_deskripsi[${unitIndex}][${elemenIndex}][]`);
                });
            });

            // Update elemen row numbers
            updateElemenNumbers(card);
        });
    }

    // ========== ELEMEN KOMPETENSI ==========
    // Add elemen to a unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.add-elemen')) {
            const button = e.target.closest('.add-elemen');
            const card = button.closest('.unit-card');
            const elemenWrapper = card.querySelector('.elemen-wrapper');
            const unitCards = Array.from(unitWrapper.querySelectorAll('.unit-card'));
            const unitIndex = unitCards.indexOf(card);
            const elemenCount = elemenWrapper.querySelectorAll('.elemen-card').length;

            const elemenCard = `
                <div class="card mb-3 elemen-card">
                    <div class="card-body py-2">
                        <div class="row align-items-center mb-2">
                            <div class="col-auto">
                                <strong class="text-muted">${elemenCount + 1}.</strong>
                            </div>
                            <div class="col">
                                <input type="text" name="elemen_nama[${unitIndex}][]"
                                       class="form-control form-control-sm"
                                       placeholder="Nama Elemen Kompetensi" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger btn-sm remove-elemen">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="ms-4">
                            <p class="mb-2 text-muted small">
                                <i class="bi bi-list-check"></i> Kriteria Unjuk Kerja (KUK)
                            </p>
                            <div class="kuk-wrapper">
                                <div class="input-group input-group-sm mb-2 kuk-row">
                                    <span class="input-group-text">1.</span>
                                    <input type="text" name="kuk_deskripsi[${unitIndex}][${elemenCount}][]"
                                           class="form-control" 
                                           placeholder="Deskripsi Kriteria Unjuk Kerja" required>
                                    <button type="button" class="btn btn-outline-danger remove-kuk">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm add-kuk">
                                <i class="bi bi-plus"></i> Tambah KUK
                            </button>
                        </div>
                    </div>
                </div>`;
            elemenWrapper.insertAdjacentHTML('beforeend', elemenCard);
            updateElemenNumbers(card);
        }
    });

    // Remove elemen from a unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-elemen')) {
            const button = e.target.closest('.remove-elemen');
            const elemenCard = button.closest('.elemen-card');
            const elemenWrapper = elemenCard.closest('.elemen-wrapper');

            if (elemenWrapper.querySelectorAll('.elemen-card').length > 1) {
                elemenCard.remove();
                updateElemenNumbers(elemenCard.closest('.unit-card'));
                updateUnitNumbers(); // Update KUK indices
            } else {
                alert('Minimal harus ada 1 elemen kompetensi per unit');
            }
        }
    });

    // Update elemen row numbers
    function updateElemenNumbers(card) {
        const elemenCards = card.querySelectorAll('.elemen-card');
        elemenCards.forEach((elemenCard, index) => {
            const numberLabel = elemenCard.querySelector('.row .col-auto strong');
            if (numberLabel) {
                numberLabel.textContent = `${index + 1}.`;
            }
        });
    }

    // ========== KRITERIA UNJUK KERJA (KUK) ==========
    // Add KUK
    document.addEventListener('click', function (e) {
        if (e.target.closest('.add-kuk')) {
            const button = e.target.closest('.add-kuk');
            const elemenCard = button.closest('.elemen-card');
            const kukWrapper = elemenCard.querySelector('.kuk-wrapper');
            const kukCount = kukWrapper.querySelectorAll('.kuk-row').length;
            
            const unitCard = elemenCard.closest('.unit-card');
            const unitIndex = Array.from(unitWrapper.querySelectorAll('.unit-card')).indexOf(unitCard);
            const elemenIndex = Array.from(unitCard.querySelectorAll('.elemen-card')).indexOf(elemenCard);
            
            const kukRow = `
                <div class="input-group input-group-sm mb-2 kuk-row">
                    <span class="input-group-text">${kukCount + 1}.</span>
                    <input type="text" name="kuk_deskripsi[${unitIndex}][${elemenIndex}][]"
                           class="form-control" 
                           placeholder="Deskripsi Kriteria Unjuk Kerja" required>
                    <button type="button" class="btn btn-outline-danger remove-kuk">
                        <i class="bi bi-x"></i>
                    </button>
                </div>`;
            kukWrapper.insertAdjacentHTML('beforeend', kukRow);
        }
    });

    // Remove KUK
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-kuk')) {
            const button = e.target.closest('.remove-kuk');
            const kukRow = button.closest('.kuk-row');
            const kukWrapper = kukRow.closest('.kuk-wrapper');
            
            if (kukWrapper.querySelectorAll('.kuk-row').length > 1) {
                kukRow.remove();
                // Update numbering
                const kukRows = kukWrapper.querySelectorAll('.kuk-row');
                kukRows.forEach((row, index) => {
                    const numberSpan = row.querySelector('.input-group-text');
                    if (numberSpan) {
                        numberSpan.textContent = `${index + 1}.`;
                    }
                });
            } else {
                alert('Minimal harus ada 1 Kriteria Unjuk Kerja per elemen');
            }
        }
    });


  
</script>
@endpush


@endsection
