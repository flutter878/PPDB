@extends('admin.layouts.app')
@section('title', 'Daftar Peserta')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Daftar Peserta</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.ekspor.csv', request()->only('status')) }}"
               class="bg-slate-600 hover:bg-slate-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                ⬇ Ekspor CSV
            </a>
            <a href="{{ route('admin.ekspor.excel', request()->only('status')) }}"
               class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                ⬇ Ekspor Excel
            </a>
        </div>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.peserta.index') }}"
          class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-medium text-slate-500 mb-1">Cari Nama / No. Seri</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau REG-..."
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
            <select name="status" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Semua</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option value="Revisi"   {{ request('status') == 'Revisi'   ? 'selected' : '' }}>Revisi</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Filter
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.peserta.index') }}" class="text-sm text-slate-500 hover:text-slate-700 py-2">Reset</a>
        @endif
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">No. Seri</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Nama Peserta</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Jenis Kelamin</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Tanggal Daftar</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Status</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pendaftarans as $p)
                    @php
                        $badge = match($p->status_pendaftaran) {
                            'Diterima' => 'bg-green-100 text-green-700',
                            'Revisi'   => 'bg-red-100 text-red-700',
                            default    => 'bg-yellow-100 text-yellow-700',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $p->no_seri_pendaftaran }}</td>
                        <td class="px-4 py-3 font-medium">{{ $p->peserta->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $p->peserta->jenis_kelamin }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $p->status_pendaftaran }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.peserta.show', $p->no_seri_pendaftaran) }}"
                                   class="text-blue-600 hover:underline text-xs font-medium">Detail</a>
                                <a href="{{ route('admin.peserta.edit', $p->no_seri_pendaftaran) }}"
                                   class="text-slate-500 hover:underline text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.peserta.destroy', $p->no_seri_pendaftaran) }}"
                                      onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs font-medium">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center px-4 py-10 text-slate-400">Tidak ada data pendaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($pendaftarans->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $pendaftarans->links() }}
            </div>
        @endif
    </div>
@endsection
