<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with('peserta')
            ->when($request->search, fn($q) =>
                $q->where('no_seri_pendaftaran', 'like', "%{$request->search}%")
                  ->orWhereHas('peserta', fn($q2) =>
                      $q2->where('nama_lengkap', 'like', "%{$request->search}%")
                  )
            )
            ->when($request->status, fn($q) =>
                $q->where('status_pendaftaran', $request->status)
            )
            ->latest();

        $pendaftarans = $query->paginate(15)->withQueryString();

        return view('admin.peserta.index', compact('pendaftarans'));
    }

    public function show(string $no_seri)
    {
        $pendaftaran = Pendaftaran::with('peserta')->findOrFail($no_seri);
        return view('admin.peserta.show', compact('pendaftaran'));
    }

    public function edit(string $no_seri)
    {
        $pendaftaran = Pendaftaran::with('peserta')->findOrFail($no_seri);
        return view('admin.peserta.edit', compact('pendaftaran'));
    }

    public function update(Request $request, string $no_seri)
    {
        $pendaftaran = Pendaftaran::with('peserta')->findOrFail($no_seri);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:150',
            'alamat'        => 'required|string',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        $pendaftaran->peserta->update($request->only([
            'nama_lengkap', 'alamat', 'tempat_lahir',
            'tanggal_lahir', 'no_hp', 'jenis_kelamin',
        ]));

        return redirect()->route('admin.peserta.show', $no_seri)
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(string $no_seri)
    {
        Pendaftaran::findOrFail($no_seri)->delete(); // cascade ke peserta
        return redirect()->route('admin.peserta.index')
            ->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, string $no_seri)
    {
        $request->validate([
            'status_pendaftaran' => 'required|in:Menunggu,Diterima,Revisi',
        ]);

        Pendaftaran::findOrFail($no_seri)->update([
            'status_pendaftaran' => $request->status_pendaftaran,
        ]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
