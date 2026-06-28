<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-PPDB Sekolah Dasar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-overlay {
            background: linear-gradient(135deg, rgba(29, 78, 216, 0.82) 0%, rgba(14, 116, 144, 0.75) 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    {{-- Navbar --}}
    <nav class="bg-blue-700 text-white px-6 py-4 shadow-md sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🏫</span>
                <h1 class="text-xl font-bold tracking-wide">SI-PPDB SD</h1>
            </div>
            <div class="flex items-center gap-5 text-sm">
                <a href="{{ route('pengumuman') }}" class="hover:text-yellow-300 font-medium transition">📢 Pengumuman</a>
                <a href="{{ route('pendaftaran.cek') }}" class="hover:text-blue-200 transition">Cek Status</a>
                @auth
                    <span class="text-blue-200 hidden sm:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hover:text-blue-200 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-200 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-700 font-semibold px-4 py-1.5 rounded-full hover:bg-blue-50 transition">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative min-h-[520px] flex items-center justify-center text-white overflow-hidden">
        {{-- Background image --}}
        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1600&q=80"
             alt="Gedung Sekolah"
             class="absolute inset-0 w-full h-full object-cover object-center">
        {{-- Overlay --}}
        <div class="hero-overlay absolute inset-0"></div>

        {{-- Konten --}}
        <div class="relative z-10 text-center px-6 max-w-3xl mx-auto py-20">
            <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-5 tracking-widest uppercase">
                Tahun Ajaran 2026 / 2027
            </span>
            <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-4 drop-shadow-md">
                Penerimaan Peserta<br>Didik Baru
            </h2>
            <p class="text-blue-100 text-lg mb-8 max-w-xl mx-auto">
                Daftarkan putra-putri Anda secara online. Siapkan Kartu Keluarga dan Akta Kelahiran sebelum memulai.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('pendaftaran.create') }}"
                   class="bg-green-400 hover:bg-green-500 text-white font-bold py-3 px-8 rounded-full text-lg shadow-lg transition">
                    Daftar Sekarang
                </a>
                <a href="{{ route('pengumuman') }}"
                   class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold py-3 px-8 rounded-full text-lg border border-white/40 transition">
                    Lihat Pengumuman
                </a>
            </div>
        </div>
    </section>

    {{-- Alur Pendaftaran --}}
    <section class="container mx-auto px-6 py-16">
        <h3 class="text-center text-2xl font-bold text-slate-700 mb-10">Cara Mendaftar</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 text-center hover:shadow-md transition">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">📝</div>
                <h4 class="text-lg font-semibold mb-2">1. Isi Formulir</h4>
                <p class="text-slate-500 text-sm">Lengkapi biodata calon siswa dan nomor HP orang tua dengan data yang valid.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 text-center hover:shadow-md transition">
                <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">📂</div>
                <h4 class="text-lg font-semibold mb-2">2. Upload Berkas</h4>
                <p class="text-slate-500 text-sm">Unggah foto atau scan Kartu Keluarga (KK) dan Akta Kelahiran anak.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 text-center hover:shadow-md transition">
                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">✅</div>
                <h4 class="text-lg font-semibold mb-2">3. Pantau Status</h4>
                <p class="text-slate-500 text-sm">Unduh bukti pendaftaran dan cek hasil pengumuman secara online kapan saja.</p>
            </div>
        </div>
    </section>

    {{-- Info Persyaratan --}}
    <section class="bg-blue-700 text-white py-12 px-6">
        <div class="container mx-auto max-w-3xl text-center">
            <h3 class="text-xl font-bold mb-6">Persyaratan Dokumen</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-left">
                <div class="bg-white/10 rounded-xl p-4 flex gap-3 items-start">
                    <span class="text-2xl">📄</span>
                    <div>
                        <p class="font-semibold">Kartu Keluarga (KK)</p>
                        <p class="text-blue-200 text-xs mt-0.5">Format JPG, PNG, atau PDF. Maksimal 2MB.</p>
                    </div>
                </div>
                <div class="bg-white/10 rounded-xl p-4 flex gap-3 items-start">
                    <span class="text-2xl">📜</span>
                    <div>
                        <p class="font-semibold">Akta Kelahiran</p>
                        <p class="text-blue-200 text-xs mt-0.5">Format JPG, PNG, atau PDF. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="text-center py-6 text-slate-400 text-xs border-t border-slate-200">
        &copy; {{ date('Y') }} SI-PPDB Sekolah Dasar &bull; Sistem Informasi Penerimaan Peserta Didik Baru
    </footer>

</body>
</html>
