<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - SI-PPDB SD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold">SI-PPDB SD</h1>
        </div>
    </nav>

    <div class="container mx-auto max-w-lg my-16 px-4 text-center">
        <div class="text-6xl mb-4">✅</div>
        <h2 class="text-3xl font-bold text-green-600 mb-2">Pendaftaran Berhasil!</h2>
        <p class="text-slate-500 mb-8">Simpan nomor seri berikut untuk mengecek status pendaftaran Anda.</p>

        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 mb-6 text-left space-y-3">
            <div class="text-center">
                <p class="text-sm text-slate-500">Nomor Seri Pendaftaran</p>
                <p class="text-2xl font-bold text-blue-700 tracking-widest">{{ $pendaftaran->no_seri_pendaftaran }}</p>
            </div>
            <hr>
            <div class="grid grid-cols-2 gap-2 text-sm">
                <span class="text-slate-500">Nama</span>
                <span class="font-medium">{{ $pendaftaran->peserta->nama_lengkap }}</span>

                <span class="text-slate-500">Tanggal Lahir</span>
                <span class="font-medium">{{ \Carbon\Carbon::parse($pendaftaran->peserta->tanggal_lahir)->format('d M Y') }}</span>

                <span class="text-slate-500">Status</span>
                <span class="font-medium text-yellow-600">{{ $pendaftaran->status_pendaftaran }}</span>

                <span class="text-slate-500">Tanggal Daftar</span>
                <span class="font-medium">{{ $pendaftaran->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('pendaftaran.bukti', $pendaftaran->no_seri_pendaftaran) }}" target="_blank"
               class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                🖨 Cetak Bukti PDF
            </a>
            <a href="{{ route('pendaftaran.cek') }}?no_seri={{ $pendaftaran->no_seri_pendaftaran }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                Cek Status
            </a>
            <a href="{{ route('home') }}"
               class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-2 px-6 rounded-lg transition">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
