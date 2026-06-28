@extends('admin.layouts.app')
@section('title', 'Edit Peserta')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.peserta.show', $pendaftaran->no_seri_pendaftaran) }}"
           class="text-slate-400 hover:text-slate-600">← Kembali</a>
        <h2 class="text-2xl font-bold">Edit Data Peserta</h2>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 max-w-2xl">
        <p class="text-xs text-slate-400 font-mono mb-6">{{ $pendaftaran->no_seri_pendaftaran }}</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg p-3 mb-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.peserta.update', $pendaftaran->no_seri_pendaftaran) }}"
              class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap"
                       value="{{ old('nama_lengkap', $pendaftaran->peserta->nama_lengkap) }}" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir"
                           value="{{ old('tempat_lahir', $pendaftaran->peserta->tempat_lahir) }}" required
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                           value="{{ old('tanggal_lahir', $pendaftaran->peserta->tanggal_lahir) }}" required
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="Laki-laki" {{ old('jenis_kelamin', $pendaftaran->peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $pendaftaran->peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Alamat</label>
                <textarea name="alamat" rows="3" required
                          class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('alamat', $pendaftaran->peserta->alamat) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp"
                       value="{{ old('no_hp', $pendaftaran->peserta->no_hp) }}" required
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.peserta.show', $pendaftaran->no_seri_pendaftaran) }}"
                   class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-6 py-2 rounded-lg transition text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
