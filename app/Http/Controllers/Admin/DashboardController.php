<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'     => Pendaftaran::count(),
            'menunggu'  => Pendaftaran::where('status_pendaftaran', 'Menunggu')->count(),
            'diterima'  => Pendaftaran::where('status_pendaftaran', 'Diterima')->count(),
            'revisi'    => Pendaftaran::where('status_pendaftaran', 'Revisi')->count(),
        ];

        // Data grafik 7 hari terakhir
        $grafik = Pendaftaran::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        // Isi hari yang kosong dengan 0
        $labels = [];
        $data   = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl      = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            $data[]   = $grafik[$tgl] ?? 0;
        }

        return view('admin.dashboard', compact('stats', 'labels', 'data'));
    }
}
