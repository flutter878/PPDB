@extends('admin.layouts.app')
@section('title', 'Detail Peserta')

@section('content')
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.peserta.index') }}" class="text-slate-400 hover:text-slate-600">← Kembali</a>
        <h2 class="text-2xl font-bold">Detail Peserta</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Data Peserta --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-lg">{{ $pendaftaran->peserta->nama_lengkap }}</h3>
                        <p class="text-slate-400 font-mono text-sm">{{ $pendaftaran->no_seri_pendaftaran }}</p>
                    </div>
                    @php
                        $badge = match($pendaftaran->status_pendaftaran) {
                            'Diterima' => 'bg-green-100 text-green-700',
                            'Revisi'   => 'bg-red-100 text-red-700',
                            default    => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                        {{ $pendaftaran->status_pendaftaran }}
                    </span>
                </div>

                <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div>
                        <dt class="text-slate-500">Tempat, Tanggal Lahir</dt>
                        <dd class="font-medium">{{ $pendaftaran->peserta->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftaran->peserta->tanggal_lahir)->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Jenis Kelamin</dt>
                        <dd class="font-medium">{{ $pendaftaran->peserta->jenis_kelamin }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-slate-500">Alamat</dt>
                        <dd class="font-medium">{{ $pendaftaran->peserta->alamat }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">No. HP</dt>
                        <dd class="font-medium">{{ $pendaftaran->peserta->no_hp }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Tanggal Daftar</dt>
                        <dd class="font-medium">{{ $pendaftaran->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('admin.peserta.edit', $pendaftaran->no_seri_pendaftaran) }}"
                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                        Edit Data
                    </a>
                    <form method="POST" action="{{ route('admin.peserta.destroy', $pendaftaran->no_seri_pendaftaran) }}"
                          onsubmit="return confirm('Hapus data pendaftaran ini secara permanen?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-lg transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Preview Berkas --}}
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold mb-4">Preview Berkas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">Kartu Keluarga (KK)</p>
                        @php $extKK = pathinfo($pendaftaran->file_kk, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($extKK), ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/' . $pendaftaran->file_kk) }}"
                                 class="w-full rounded-lg border border-slate-200 object-cover max-h-60" alt="KK">
                        @else
                            <a href="{{ asset('storage/' . $pendaftaran->file_kk) }}" target="_blank"
                               class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg p-4 hover:bg-slate-100 transition text-sm text-blue-600 font-medium">
                                📄 Buka PDF Kartu Keluarga
                            </a>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">Akta Kelahiran</p>
                        @php $extAkta = pathinfo($pendaftaran->file_akta, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($extAkta), ['jpg','jpeg','png']))
                            <img src="{{ asset('storage/' . $pendaftaran->file_akta) }}"
                                 class="w-full rounded-lg border border-slate-200 object-cover max-h-60" alt="Akta">
                        @else
                            <a href="{{ asset('storage/' . $pendaftaran->file_akta) }}" target="_blank"
                               class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg p-4 hover:bg-slate-100 transition text-sm text-blue-600 font-medium">
                                📄 Buka PDF Akta Kelahiran
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel Verifikasi --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="font-semibold mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.peserta.status', $pendaftaran->no_seri_pendaftaran) }}"
                      class="space-y-3">
                    @csrf @method('PATCH')
                    <div class="space-y-2">
                        @foreach(['Menunggu', 'Diterima', 'Revisi'] as $status)
                            @php
                                $colors = ['Menunggu' => 'yellow', 'Diterima' => 'green', 'Revisi' => 'red'];
                                $c = $colors[$status];
                            @endphp
                            <label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-slate-50
                                {{ $pendaftaran->status_pendaftaran === $status ? "border-{$c}-400 bg-{$c}-50" : 'border-slate-200' }}">
                                <input type="radio" name="status_pendaftaran" value="{{ $status }}"
                                       {{ $pendaftaran->status_pendaftaran === $status ? 'checked' : '' }}>
                                <span class="text-sm font-medium">{{ $status }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition text-sm">
                        Simpan Status
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
