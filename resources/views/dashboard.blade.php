@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

<style>
    .summary-container {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .summary-card {
        width: 220px;
        min-height: 130px;
        padding: 24px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .summary-card h3 {
        margin: 0 0 12px;
        font-size: 17px;
        font-weight: 500;
        color: #666;
    }

    .summary-card p {
        margin: 0;
        font-size: 32px;
        font-weight: 600;
    }

    .dashboard-title {
        margin: 0 0 8px;
        font-size: 36px;
        font-weight: 600;
    }

    .welcome-text {
        margin: 0 0 35px;
        font-size: 17px;
        color: #666;
    }

    .attendance-section {
        margin-top: 50px;
    }

    .section-header {
        margin-bottom: 20px;
    }

    .section-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .attendance-table-container {
        width: 100%;
        overflow-x: auto;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 16px 18px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 15px;
    }

    .attendance-table th {
        font-weight: 600;
        color: #555;
        background-color: #f8f8f8;
    }

    .attendance-table tbody tr:last-child td {
        border-bottom: none;
    }
</style>

    <h1 class="dashboard-title">
        Dashboard
    </h1>

    <p class="welcome-text">
        Selamat Datang, {{ Auth::user()->name }}
    </p>
    <div class="summary-container">

    <div class="summary-card">
        <h3>Hadir</h3>
        <p>{{ $summary['hadir'] ?? 0 }}</p>
    </div>

    <div class="summary-card">
        <h3>Terlambat</h3>
        <p>{{ $summary['terlambat'] ?? 0 }}</p>
    </div>

    <div class="summary-card">
        <h3>Sakit</h3>
        <p>{{ $summary['sakit'] ?? 0 }}</p>
    </div>

    <div class="summary-card">
        <h3>Izin</h3>
        <p>{{ $summary['izin'] ?? 0 }}</p>
    </div>
</div>

<div class="attendance-section">

    <div class="section-header">
        <h2>
            @if(auth()->user()->role === 'admin')
                Data Presensi Pegawai
            @else
                Riwayat Presensi
            @endif
        </h2>
    </div>

    <div class="attendance-table-container">
        <table class="attendance-table">

            <thead>
                <tr>
                    @if(auth()->user()->role === 'admin')
                        <th>Nama</th>
                    @endif

                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($presensis as $presensi)
                    <tr>
                        @if(auth()->user()->role === 'admin')
                            <td>{{ $presensi->user->name }}</td>
                        @endif

                        <td>
                            {{ $presensi->date->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $presensi->check_in ?? '-' }}
                        </td>

                        <td>
                            {{ $presensi->check_out ?? '-' }}
                        </td>

                        <td>
                            {{ ucfirst($presensi->status ?? '-') }}
                        </td>

                        <td>
                            {{ $presensi->note ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            Belum ada data presensi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection