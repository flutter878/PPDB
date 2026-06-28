<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran {{ $pendaftaran->no_seri_pendaftaran }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', serif; font-size: 12pt; color: #000; background: #fff; }

        .page { width: 210mm; min-height: 297mm; margin: 0 auto; padding: 20mm 25mm; }

        /* Header */
        .header { display: flex; align-items: center; gap: 16px; border-bottom: 3px double #000; padding-bottom: 12px; margin-bottom: 16px; }
        .header-logo { font-size: 40px; }
        .header-text h1 { font-size: 16pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .header-text p  { font-size: 10pt; color: #333; margin-top: 2px; }

        /* Judul */
        .judul { text-align: center; margin: 20px 0 24px; }
        .judul h2 { font-size: 14pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; letter-spacing: 1px; }
        .judul .no-seri { font-size: 13pt; font-weight: bold; letter-spacing: 3px; color: #1a56db; margin-top: 6px; }

        /* Data */
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data td { padding: 6px 8px; font-size: 11pt; vertical-align: top; }
        table.data td:first-child { width: 38%; font-weight: 500; }
        table.data td:nth-child(2) { width: 4%; text-align: center; }

        /* Status */
        .status-box { border: 2px solid #000; border-radius: 4px; padding: 10px 20px; display: inline-block; margin: 10px 0; }
        .status-menunggu { border-color: #b45309; color: #b45309; }
        .status-diterima { border-color: #166534; color: #166534; }
        .status-revisi   { border-color: #991b1b; color: #991b1b; }

        /* TTD */
        .ttd { margin-top: 40px; display: flex; justify-content: flex-end; }
        .ttd-box { text-align: center; width: 200px; }
        .ttd-box .ttd-space { height: 70px; border-bottom: 1px solid #000; margin-bottom: 4px; }
        .ttd-box p { font-size: 10pt; }

        /* Footer */
        .footer { margin-top: 30px; border-top: 1px solid #aaa; padding-top: 8px; font-size: 9pt; color: #555; text-align: center; }

        /* Print controls — sembunyikan saat cetak */
        .no-print { position: fixed; bottom: 24px; right: 24px; display: flex; gap: 10px; z-index: 999; }
        .no-print button, .no-print a {
            padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
            cursor: pointer; border: none; text-decoration: none; display: inline-block;
        }
        .btn-print { background: #1d4ed8; color: #fff; }
        .btn-back  { background: #e2e8f0; color: #334155; }

        @media print {
            .no-print { display: none !important; }
            .page { padding: 15mm 20mm; }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>
<div class="page">

    {{-- Kop --}}
    <div class="header">
        <div class="header-logo">🏫</div>
        <div class="header-text">
            <h1>Sistem Informasi PPDB</h1>
            <p>Penerimaan Peserta Didik Baru Tingkat Sekolah Dasar</p>
            <p>Tahun Ajaran 2026/2027</p>
        </div>
    </div>

    {{-- Judul --}}
    <div class="judul">
        <h2>Tanda Bukti Pendaftaran</h2>
        <div class="no-seri">{{ $pendaftaran->no_seri_pendaftaran }}</div>
    </div>

    {{-- Data Peserta --}}
    <p style="font-weight:bold; margin-bottom:8px; font-size:11pt;">I. Data Calon Peserta Didik</p>
    <table class="data">
        <tr>
            <td>Nama Lengkap</td><td>:</td>
            <td><strong>{{ $pendaftaran->peserta->nama_lengkap }}</strong></td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td><td>:</td>
            <td>{{ $pendaftaran->peserta->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->peserta->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td><td>:</td>
            <td>{{ $pendaftaran->peserta->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>Alamat</td><td>:</td>
            <td>{{ $pendaftaran->peserta->alamat }}</td>
        </tr>
        <tr>
            <td>No. HP Orang Tua</td><td>:</td>
            <td>{{ $pendaftaran->peserta->no_hp }}</td>
        </tr>
    </table>

    {{-- Data Pendaftaran --}}
    <p style="font-weight:bold; margin-bottom:8px; font-size:11pt;">II. Data Pendaftaran</p>
    <table class="data">
        <tr>
            <td>Nomor Seri</td><td>:</td>
            <td><strong>{{ $pendaftaran->no_seri_pendaftaran }}</strong></td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td><td>:</td>
            <td>{{ $pendaftaran->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td>Status Berkas</td><td>:</td>
            <td>
                @php $sc = strtolower($pendaftaran->status_pendaftaran); @endphp
                <span class="status-box status-{{ $sc }}">
                    <strong>{{ $pendaftaran->status_pendaftaran }}</strong>
                </span>
            </td>
        </tr>
    </table>

    <p style="font-size:10pt; color:#555; margin-top:8px;">
        * Simpan dokumen ini sebagai bukti pendaftaran yang sah. Tunjukkan nomor seri kepada panitia jika diperlukan.
    </p>

    {{-- TTD --}}
    <div class="ttd">
        <div class="ttd-box">
            <p>{{ now()->translatedFormat('d F Y') }}</p>
            <p>Panitia PPDB</p>
            <div class="ttd-space"></div>
            <p style="font-weight:bold;">( ________________________ )</p>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh Sistem Informasi PPDB SD &bull; {{ now()->format('Y') }}
    </div>

</div>

{{-- Tombol aksi (tidak ikut tercetak) --}}
<div class="no-print">
    <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
    <button onclick="window.print()" class="btn-print">🖨 Cetak / Simpan PDF</button>
</div>

</body>
</html>
