<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    private function getData(Request $request)
    {
        return Pendaftaran::with('peserta')
            ->when($request->status, fn($q) => $q->where('status_pendaftaran', $request->status))
            ->latest()
            ->get();
    }

    public function csv(Request $request)
    {
        $rows = $this->getData($request);

        $filename = 'pendaftar_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['No. Seri', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'No. HP', 'Status', 'Tanggal Daftar']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->no_seri_pendaftaran,
                    $r->peserta->nama_lengkap,
                    $r->peserta->jenis_kelamin,
                    $r->peserta->tempat_lahir,
                    $r->peserta->tanggal_lahir,
                    $r->peserta->alamat,
                    $r->peserta->no_hp,
                    $r->status_pendaftaran,
                    $r->created_at->format('Y-m-d'),
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function excel(Request $request)
    {
        $rows = $this->getData($request);
        $filename = 'pendaftar_' . now()->format('Ymd_His') . '.xlsx';

        // Gunakan format SpreadsheetML (XML) yang bisa dibuka Excel
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"';
        $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
        $xml .= '<Worksheet ss:Name="Pendaftar"><Table>' . "\n";

        $headers = ['No. Seri', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Alamat', 'No. HP', 'Status', 'Tanggal Daftar'];
        $xml .= '<Row>' . implode('', array_map(fn($h) => '<Cell><Data ss:Type="String">' . htmlspecialchars($h) . '</Data></Cell>', $headers)) . '</Row>' . "\n";

        foreach ($rows as $r) {
            $cols = [
                $r->no_seri_pendaftaran,
                $r->peserta->nama_lengkap,
                $r->peserta->jenis_kelamin,
                $r->peserta->tempat_lahir,
                $r->peserta->tanggal_lahir,
                $r->peserta->alamat,
                $r->peserta->no_hp,
                $r->status_pendaftaran,
                $r->created_at->format('Y-m-d'),
            ];
            $xml .= '<Row>' . implode('', array_map(fn($v) => '<Cell><Data ss:Type="String">' . htmlspecialchars($v) . '</Data></Cell>', $cols)) . '</Row>' . "\n";
        }

        $xml .= '</Table></Worksheet></Workbook>';

        return response($xml, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
