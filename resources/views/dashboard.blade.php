@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

<style>
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

    .filter-container {
        margin-bottom: 20px;
        padding: 20px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .search-container {
        margin-bottom: 15px;
    }

    .search-input {
        width: 100%;
        box-sizing: border-box;
        padding: 13px 16px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        outline: none;
    }

    .search-input:focus {
        border-color: #087cf0;
    }

    .filter-row {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-select,
    .filter-date {
        padding: 12px 14px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        background-color: white;
        outline: none;
    }

    .filter-select:focus,
    .filter-date:focus {
        border-color: #087cf0;
    }

    .filter-button {
        padding: 12px 20px;
        border: none;
        border-radius: 7px;
        background-color: #087cf0;
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-button:hover {
        opacity: 0.9;
    }

    .reset-button {
        padding: 12px 20px;
        border: 1px solid #ccc;
        border-radius: 7px;
        background-color: white;
        color: #444;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
    }

    .reset-button:hover {
        background-color: #f5f5f5;
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
        border-bottom: 1px solid white;
        font-size: 15px;
    }

    .attendance-table th {
        font-weight: 600;
        color: #555;
        background-color: #eeeeee;
    }

    .attendance-table tbody tr:last-child td {
        border-bottom: none;
    }

    .empty-data {
        padding: 30px;
        text-align: center;
        color: #777;
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-hadir {
        background-color: #e7f7ed;
        color: #218838;
    }

    .status-terlambat {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-sakit,
    .status-izin{
        background-color: #f8d7da;
        color: #721c24;
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

    <div class="filter-container">
        <form method="GET" action="{{ route('dashboard') }}">

            @if(auth()->user()->role === 'admin')

                <div class="search-container">

                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari nama pegawai..."
                        value="{{ request('search') }}">
                </div>
            @endif

            <div class="filter-row">
                <select name="status" class="filter-select">

                    <option value="">Semua Status</option>

                    <option value="hadir"
                        {{ request('status') === 'hadir' ? 'selected' : '' }}>
                        Hadir
                    </option>

                    <option value="terlambat"
                        {{ request('status') === 'terlambat' ? 'selected' : '' }}>
                        Terlambat
                    </option>

                    <option value="sakit"
                        {{ request('status') === 'sakit' ? 'selected' : '' }}>
                        Sakit
                    </option>

                    <option value="izin"
                        {{ request('status') === 'izin' ? 'selected' : '' }}>
                        Izin
                    </option>
                </select>

                <input
                    type="date"
                    name="date"
                    class="filter-date"
                    value="{{ request('date') }}">

                <button type="submit" class="filter-button">
                    Cari
                </button>
                <a
                    href="{{ route('dashboard') }}"
                    class="reset-button">
                    Reset
                </a>
            </div>
        </form>
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
                            <td>
                                {{ $presensi->user->name }}
                            </td>
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
                            @if($presensi->status)
                                <span class="status status-{{ $presensi->status }}">
                                    {{ ucfirst($presensi->status) }}
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            {{ $presensi->note ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="{{ auth()->user()->role === 'admin' ? 6 : 5 }}"
                            class="empty-data">
                            Tidak ada data presensi ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection