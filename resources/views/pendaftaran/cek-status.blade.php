<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status - SI-PPDB SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">SI-PPDB SD</h1>
            <a href="{{ route('home') }}" class="hover:text-blue-200 text-sm">← Beranda</a>
        </div>
    </nav>

    <div class="container mx-auto max-w-lg my-12 px-4">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Cek Status Pendaftaran</h2>

        <form method="GET" action="{{ route('pendaftaran.cek') }}"
              class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6 flex gap-3">
            <input type="text" name="no_seri" placeholder="Masukkan nomor seri (REG-2026-XXXX)"
                   value="{{ request('no_seri') }}"
                   class="flex-1 border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition text-sm">
                Cek
            </button>
        </form>

        @if(request('no_seri'))
            @if($pendaftaran)
                @php
                    $statusColor = match($pendaftaran->status_pendaftaran) {
                        'Diterima' => 'text-green-600',
                        'Revisi'   => 'text-red-600',
                        default    => 'text-yellow-600',
                    };
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-3 text-sm">
                    <div class="text-center mb-2">
                        <p class="text-slate-500 text-xs">Nomor Seri</p>
                        <p class="text-xl font-bold text-blue-700">{{ $pendaftaran->no_seri_pendaftaran }}</p>
                    </div>
                    <hr>
                    <div class="grid grid-cols-2 gap-2">
                        <span class="text-slate-500">Nama</span>
                        <span class="font-medium">{{ $pendaftaran->peserta->nama_lengkap }}</span>

                        <span class="text-slate-500">Tanggal Daftar</span>
                        <span class="font-medium">{{ $pendaftaran->created_at->format('d M Y') }}</span>

                        <span class="text-slate-500">Status</span>
                        <span class="font-semibold {{ $statusColor }}">{{ $pendaftaran->status_pendaftaran }}</span>
                    </div>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 text-red-600 rounded-lg p-4 text-center text-sm">
                    Nomor seri tidak ditemukan. Pastikan nomor yang Anda masukkan benar.
                </div>
            @endif
        @endif
    </div>

</body>
</html>
