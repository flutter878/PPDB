<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peserta;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:150',
            'alamat'        => 'required|string',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'file_kk'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_akta'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $peserta = Peserta::create($request->only([
            'nama_lengkap', 'alamat', 'tempat_lahir',
            'tanggal_lahir', 'no_hp', 'jenis_kelamin',
        ]));

        $noSeri = 'REG-' . date('Y') . '-' . str_pad($peserta->id_peserta, 4, '0', STR_PAD_LEFT);

        $pathKK   = $request->file('file_kk')->storeAs('uploads', $noSeri . '_KK.' . $request->file('file_kk')->extension(), 'public');
        $pathAkta = $request->file('file_akta')->storeAs('uploads', $noSeri . '_AKTA.' . $request->file('file_akta')->extension(), 'public');

        Pendaftaran::create([
            'no_seri_pendaftaran' => $noSeri,
            'id_peserta'          => $peserta->id_peserta,
            'file_kk'             => $pathKK,
            'file_akta'           => $pathAkta,
        ]);

        return redirect()->route('pendaftaran.sukses', $noSeri);
    }

    public function sukses($no_seri)
    {
        $pendaftaran = Pendaftaran::with('peserta')->where('no_seri_pendaftaran', $no_seri)->firstOrFail();
        return view('pendaftaran.sukses', compact('pendaftaran'));
    }

    public function bukti($no_seri)
    {
        $pendaftaran = Pendaftaran::with('peserta')->where('no_seri_pendaftaran', $no_seri)->firstOrFail();
        return view('pendaftaran.bukti', compact('pendaftaran'));
    }

    public function cekStatus(Request $request)
    {
        $pendaftaran = null;
        if ($request->filled('no_seri')) {
            $pendaftaran = Pendaftaran::with('peserta')
                ->where('no_seri_pendaftaran', $request->no_seri)
                ->first();
        }
        return view('pendaftaran.cek-status', compact('pendaftaran'));
    }

    public function pengumuman(Request $request)
    {
        $pendaftaran = null;
        if ($request->filled('no_seri')) {
            $pendaftaran = Pendaftaran::with('peserta')
                ->where('no_seri_pendaftaran', $request->no_seri)
                ->first();
        }
        return view('pendaftaran.pengumuman', compact('pendaftaran'));
    }
}
