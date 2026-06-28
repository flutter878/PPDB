@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Total Pendaftar</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-yellow-500">{{ $stats['menunggu'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Menunggu</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-green-500">{{ $stats['diterima'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Diterima</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-100 text-center">
            <p class="text-3xl font-bold text-red-500">{{ $stats['revisi'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Revisi</p>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <h3 class="font-semibold text-slate-700 mb-4">Pendaftar 7 Hari Terakhir</h3>
        <canvas id="grafikChart" height="80"></canvas>
    </div>

    @push('head')@endpush
@endsection

@push('head')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('grafikChart'), {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: @json($data),
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderRadius: 6,
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush
