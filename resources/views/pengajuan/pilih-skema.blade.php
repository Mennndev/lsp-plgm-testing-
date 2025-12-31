<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pilih Skema Sertifikasi | LSP PLGM</title>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        .pilih-skema-wrapper {
            min-height: 100vh;
            background: #f5f7fa;
            padding: 40px 0;
        }

        .pilih-skema-header {
            background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
        }

        .pilih-skema-header h1 {
            margin:  0;
            font-size: 28px;
            font-weight:  700;
        }

        .pilih-skema-header p {
            margin:  8px 0 0;
            opacity: 0.9;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box input {
            border-radius: 8px;
            padding: 12px 20px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .table-skema {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        .table-skema table {
            margin:  0;
        }

        .table-skema thead {
            background: #f8f9fa;
        }

        .table-skema thead th {
            border:  none;
            padding: 15px 20px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .table-skema tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            border-top: 1px solid #f0f0f0;
        }

        .table-skema tbody tr:hover {
            background:  #f8f9fa;
        }

        .expand-icon {
            cursor: pointer;
            color: #0d47a1;
            font-weight: bold;
            font-size: 18px;
            user-select: none;
        }

        .skema-name {
            font-weight: 600;
            color: #333;
        }

        .kode-skema {
            color: #666;
            font-size: 13px;
        }

        .btn-ajukan {
            padding: 8px 24px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-approved {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="pilih-skema-wrapper">
        <!-- Header -->
        <div class="pilih-skema-header">
            <div class="container">
                <a href="{{ route('home') }}" class="btn btn-sm btn-light mb-3">
                    <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <h1>Daftar Skema Sertifikasi</h1>
                <p>Pilih skema sertifikasi yang ingin Anda ajukan</p>
            </div>
        </div>

        <!-- Content -->
        <div class="container">
            <!-- Search Box -->
            <div class="search-box">
                <input type="text"
                       id="searchSkema"
                       class="form-control"
                       placeholder="Cari Skema Sertifikasi... ">
            </div>

            <!-- Table -->
            <div class="table-skema">
                <table class="table table-hover mb-0" id="tableSkema">
                    <thead>
                        <tr>
                            <th width="40"></th>
                            <th width="45%">Skema Sertifikasi</th>
                            <th width="30%">Kode Skema</th>
                            <th width="25%" class="text-center">Ajukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td class="text-center">
                                <span class="expand-icon">+</span>
                            </td>
                            <td>
                                <div class="skema-name">{{ $program->nama }}</div>
                            </td>
                            <td>
                                <span class="kode-skema">{{ $program->kode_skema }}</span>
                            </td>
                            <td class="text-center">
                                @if(in_array($program->id, $pengajuanUser))
                                    <span class="badge badge-status badge-pending">Sudah Diajukan</span>
                                @else
                                    <a href="{{ route('pengajuan.create', $program->id) }}"
                                       class="btn btn-primary btn-ajukan">
                                        Ajukan
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada skema sertifikasi yang tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Info -->
            <div class="mt-3 text-muted">
                <small>Total: {{ $programs->count() }} skema sertifikasi</small>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script>
        // Search functionality
        document.getElementById('searchSkema').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#tableSkema tbody tr');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
