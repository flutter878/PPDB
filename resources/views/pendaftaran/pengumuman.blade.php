<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Hasil PPDB - SI-PPDB SD</title>
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

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-blue-700">Pengumuman Hasil Seleksi</h2>
            <p class="text-slate-500 text-sm mt-1">Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027</p>
        </div>

        {{-- Form cek --}}
        <form method="GET" action="{{ route('pengumuman') }}"
              class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 mb-6">
            <label class="block text-sm font-medium text-slate-600 mb-2">Masukkan Nomor Seri Pendaftaran</label>
            <div class="flex gap-2">
                <input type="text" name="no_seri" placeholder="Contoh: REG-2026-0001"
                       value="{{ request('no_seri') }}"
                       class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition text-sm">
                    Lihat Hasil
                </button>
            </div>
        </form>

        {{-- Hasil --}}
        @if(request('no_seri'))
            @if(!$pendaftaran)
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                    <div class="text-4xl mb-3">❌</div>
                    <p class="font-semibold text-red-700">Nomor seri tidak ditemukan</p>
                    <p class="text-red-500 text-sm mt-1">Pastikan nomor yang Anda masukkan benar.</p>
                </div>

            @elseif($pendaftaran->status_pendaftaran === 'Diterima')
                <div class="bg-green-50 border-2 border-green-400 rounded-xl p-6 text-center">
                    <div class="text-5xl mb-3">🎉</div>
                    <h3 class="text-xl font-bold text-green-700 mb-1">SELAMAT! ANDA DITERIMA</h3>
                    <p class="text-green-600 text-sm mb-5">Calon peserta didik berikut dinyatakan <strong>DITERIMA</strong> di sekolah kami.</p>

                    <div class="bg-white rounded-lg border border-green-200 p-4 text-left text-sm space-y-2 mb-5">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama</span>
                            <span class="font-semibold">{{ $pendaftaran->peserta->nama_lengkap }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor Seri</span>
                            <span class="font-mono text-blue-700">{{ $pendaftaran->no_seri_pendaftaran }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Jenis Kelamin</span>
                            <span>{{ $pendaftaran->peserta->jenis_kelamin }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tanggal Lahir</span>
                            <span>{{ \Carbon\Carbon::parse($pendaftaran->peserta->tanggal_lahir)->format('d M Y') }}</span>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('pendaftaran.bukti', $pendaftaran->no_seri_pendaftaran) }}" target="_blank"
                           class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                            🖨 Unduh Bukti Penerimaan
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-lg transition text-sm">
                            Login untuk Unduh Bukti
                        </a>
                    @endauth
                </div>

            @elseif($pendaftaran->status_pendaftaran === 'Revisi')
                <div class="bg-red-50 border-2 border-red-300 rounded-xl p-6 text-center">
                    <div class="text-5xl mb-3">📋</div>
                    <h3 class="text-xl font-bold text-red-700 mb-1">BERKAS PERLU DIREVISI</h3>
                    <p class="text-red-600 text-sm mb-5">Berkas pendaftaran Anda memerlukan perbaikan. Silakan hubungi pihak sekolah untuk informasi lebih lanjut.</p>

                    <div class="bg-white rounded-lg border border-red-200 p-4 text-left text-sm space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama</span>
                            <span class="font-semibold">{{ $pendaftaran->peserta->nama_lengkap }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor Seri</span>
                            <span class="font-mono text-blue-700">{{ $pendaftaran->no_seri_pendaftaran }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">No. HP</span>
                            <span>{{ $pendaftaran->peserta->no_hp }}</span>
                        </div>
                    </div>
                </div>

            @else {{-- Menunggu --}}
                <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-6 text-center">
                    <div class="text-5xl mb-3">⏳</div>
                    <h3 class="text-xl font-bold text-yellow-700 mb-1">SEDANG DIPROSES</h3>
                    <p class="text-yellow-600 text-sm mb-5">Berkas pendaftaran Anda sedang dalam tahap verifikasi oleh panitia. Mohon tunggu.</p>

                    <div class="bg-white rounded-lg border border-yellow-200 p-4 text-left text-sm space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama</span>
                            <span class="font-semibold">{{ $pendaftaran->peserta->nama_lengkap }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor Seri</span>
                            <span class="font-mono text-blue-700">{{ $pendaftaran->no_seri_pendaftaran }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Tanggal Daftar</span>
                            <span>{{ $pendaftaran->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>

</body>
</html>
