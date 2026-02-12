<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir {{ str_replace('_', '.', $jenis) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #233C7E;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #233C7E;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .header h2 {
            color: #D69F3A;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11px;
            color: #666;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            background: #233C7E;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
            background: #f8f9fa;
        }
        .content-box {
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 12px;
            background: #fff;
        }
        .content-label {
            font-weight: bold;
            color: #233C7E;
            margin-bottom: 5px;
            display: block;
        }
        .content-value {
            padding: 8px;
            background: #f8f9fa;
            border-left: 3px solid #D69F3A;
            min-height: 40px;
        }
        .footer {
            margin-top: 40px;
            border-top: 2px solid #ddd;
            padding-top: 15px;
        }
        .signature {
            display: inline-block;
            width: 45%;
            text-align: center;
            vertical-align: top;
        }
        .signature-space {
            height: 60px;
            margin: 20px 0;
        }
        .signature-name {
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>LSP PLGM</h1>
        <h2>Lembaga Sertifikasi Profesi Pariwisata dan Perhotelan</h2>
        <p>Formulir Asesmen BNSP - {{ str_replace('_', '.', $jenis) }}</p>
    </div>

    <!-- INFORMASI ASESI -->
    <div class="section">
        <div class="section-title">INFORMASI ASESI</div>
        <table class="info-table">
            <tr>
                <td>Nama Asesi</td>
                <td>{{ $pengajuan->user->nama }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $pengajuan->user->email }}</td>
            </tr>
            <tr>
                <td>Skema Sertifikasi</td>
                <td>{{ $pengajuan->program->nama }}</td>
            </tr>
            <tr>
                <td>Nama Asesor</td>
                <td>{{ $formulir->asesor->nama }}</td>
            </tr>
            <tr>
                <td>Tanggal Dicetak</td>
                <td>{{ now()->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    <!-- ISIAN FORMULIR -->
    <div class="section">
        <div class="section-title">ISIAN FORMULIR</div>
        
        @php
            $data = $formulir->data;
        @endphp

        @if($jenis === 'FR_IA_01')
            <!-- FR.IA.01: Ceklis Observasi Aktivitas di Tempat Kerja -->
            <div class="content-box">
                <span class="content-label">Lokasi Observasi:</span>
                <div class="content-value">{{ $data['lokasi'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Tanggal Observasi:</span>
                <div class="content-value">{{ $data['tanggal'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Aktivitas yang Diobservasi:</span>
                <div class="content-value">{{ $data['aktivitas'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Hasil Observasi:</span>
                <div class="content-value">{{ $data['hasil'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Catatan:</span>
                <div class="content-value">{{ $data['catatan'] ?? '-' }}</div>
            </div>

        @elseif($jenis === 'FR_IA_02')
            <!-- FR.IA.02: Tugas Praktik Demonstrasi -->
            <div class="content-box">
                <span class="content-label">Tugas yang Diberikan:</span>
                <div class="content-value">{{ $data['tugas'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Tanggal Pelaksanaan:</span>
                <div class="content-value">{{ $data['tanggal'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Hasil Demonstrasi:</span>
                <div class="content-value">{{ $data['hasil'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Penilaian:</span>
                <div class="content-value">{{ ucfirst(str_replace('_', ' ', $data['penilaian'] ?? '-')) }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Catatan:</span>
                <div class="content-value">{{ $data['catatan'] ?? '-' }}</div>
            </div>

        @elseif($jenis === 'FR_IA_05')
            <!-- FR.IA.05: Pertanyaan Tertulis Esai -->
            <div class="content-box">
                <span class="content-label">Pertanyaan 1:</span>
                <div class="content-value">{{ $data['pertanyaan_1'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Jawaban Asesi 1:</span>
                <div class="content-value">{{ $data['jawaban_1'] ?? '-' }}</div>
            </div>
            @if(isset($data['pertanyaan_2']))
            <div class="content-box">
                <span class="content-label">Pertanyaan 2:</span>
                <div class="content-value">{{ $data['pertanyaan_2'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Jawaban Asesi 2:</span>
                <div class="content-value">{{ $data['jawaban_2'] ?? '-' }}</div>
            </div>
            @endif
            <div class="content-box">
                <span class="content-label">Evaluasi:</span>
                <div class="content-value">{{ $data['evaluasi'] ?? '-' }}</div>
            </div>

        @elseif($jenis === 'FR_IA_07')
            <!-- FR.IA.07: Pertanyaan Lisan -->
            <div class="content-box">
                <span class="content-label">Tanggal Wawancara:</span>
                <div class="content-value">{{ $data['tanggal'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Pertanyaan 1:</span>
                <div class="content-value">{{ $data['pertanyaan_1'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Jawaban Asesi 1:</span>
                <div class="content-value">{{ $data['jawaban_1'] ?? '-' }}</div>
            </div>
            @if(isset($data['pertanyaan_2']))
            <div class="content-box">
                <span class="content-label">Pertanyaan 2:</span>
                <div class="content-value">{{ $data['pertanyaan_2'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Jawaban Asesi 2:</span>
                <div class="content-value">{{ $data['jawaban_2'] ?? '-' }}</div>
            </div>
            @endif
            <div class="content-box">
                <span class="content-label">Kesimpulan:</span>
                <div class="content-value">{{ $data['kesimpulan'] ?? '-' }}</div>
            </div>

        @elseif($jenis === 'FR_IA_11')
            <!-- FR.IA.11: Ceklis Meninjau Portofolio -->
            <div class="content-box">
                <span class="content-label">Dokumen Portofolio:</span>
                <div class="content-value">{{ $data['dokumen'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Relevansi dengan Kompetensi:</span>
                <div class="content-value">{{ $data['relevansi'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Penilaian Kelengkapan:</span>
                <div class="content-value">{{ ucfirst(str_replace('_', ' ', $data['kelengkapan'] ?? '-')) }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Catatan:</span>
                <div class="content-value">{{ $data['catatan'] ?? '-' }}</div>
            </div>

        @elseif($jenis === 'FR_AK_01')
            <!-- FR.AK.01: Persetujuan Asesmen dan Kerahasiaan -->
            <div class="content-box">
                <span class="content-label">Tanggal Persetujuan:</span>
                <div class="content-value">{{ $data['tanggal'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Metode Asesmen yang Disetujui:</span>
                <div class="content-value">{{ $data['metode'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Jadwal Asesmen:</span>
                <div class="content-value">{{ $data['jadwal'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Persetujuan Asesi:</span>
                <div class="content-value">{{ isset($data['persetujuan_asesi']) ? 'Sudah Menyetujui' : 'Belum Menyetujui' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Catatan:</span>
                <div class="content-value">{{ $data['catatan'] ?? '-' }}</div>
            </div>

        @elseif($jenis === 'FR_AK_05')
            <!-- FR.AK.05: Laporan Hasil Asesmen -->
            <div class="content-box">
                <span class="content-label">Tanggal Asesmen:</span>
                <div class="content-value">{{ $data['tanggal'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Metode Asesmen yang Digunakan:</span>
                <div class="content-value">{{ $data['metode'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Ringkasan Hasil Asesmen:</span>
                <div class="content-value">{{ $data['ringkasan'] ?? '-' }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Rekomendasi:</span>
                <div class="content-value">{{ ucfirst(str_replace('_', ' ', $data['rekomendasi'] ?? '-')) }}</div>
            </div>
            <div class="content-box">
                <span class="content-label">Catatan dan Saran:</span>
                <div class="content-value">{{ $data['catatan'] ?? '-' }}</div>
            </div>
        @endif
    </div>

    <!-- FOOTER & SIGNATURE -->
    <div class="footer">
        <div class="signature" style="float: left;">
            <p>Asesi,</p>
            <div class="signature-space"></div>
            <p class="signature-name">{{ $pengajuan->user->nama }}</p>
        </div>
        
        <div class="signature" style="float: right;">
            <p>Asesor,</p>
            <div class="signature-space"></div>
            <p class="signature-name">{{ $formulir->asesor->nama }}</p>
        </div>
        
        <div style="clear: both;"></div>
    </div>
</body>
</html>
