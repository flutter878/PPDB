<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - SI-PPDB SD</title>
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

    <div class="container mx-auto max-w-2xl my-10 px-4">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">Formulir Pendaftaran</h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 rounded-lg p-4 mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-4">
            @csrf

            <h3 class="font-semibold text-slate-600 border-b pb-2">Data Calon Siswa</h3>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('alamat') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">No. HP / WhatsApp Orang Tua</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <h3 class="font-semibold text-slate-600 border-b pb-2 pt-2">Upload Dokumen</h3>

            <div>
                <label class="block text-sm font-medium mb-1">Kartu Keluarga (KK)</label>
                <input type="file" name="file_kk" accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, atau PDF. Maks 2MB.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Akta Kelahiran</label>
                <input type="file" name="file_akta" accept=".jpg,.jpeg,.png,.pdf"
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, atau PDF. Maks 2MB.</p>
            </div>

            <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition duration-300 mt-2">
                Kirim Pendaftaran
            </button>
        </form>
    </div>

</body>
</html>
