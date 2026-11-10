@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 35px;
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

    .summary-container {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .summary-card {
        width: 283px;
        min-height: 150px;
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

    .notification-button {
        position: relative;
        width: 45px;
        height: 45px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: white;
        color: #555;
        font-size: 18px;
        cursor: pointer;
    }

    .notification-button:hover {
        background-color: #f5f5f5;
    }

    .notification-dot {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background-color: #dc3545;
        border: 2px solid white;
    }

    .notification-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        inset: 0;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.45);
    }

    .notification-modal.active {
        display: flex;
    }

    .notification-modal-content,
    .pengajuan-detail-content {
        width: 780px;
        max-width: calc(100% - 60px);
        min-height: 440px;
        display: flex;
        flex-direction: column;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .notification-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 28px 32px;
        border-bottom: 1px solid #eee;
    }

    .notification-modal-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .notification-modal-header p {
        margin: 5px 0 0;
        color: #777;
        font-size: 15px;
    }

    .notification-close {
        border: none;
        background: none;
        color: #777;
        font-size: 24px;
        cursor: pointer;
    }

    .notification-close:hover {
        color: #333;
    }

    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .notification-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 32px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .notification-item:hover {
        background-color: #f8f9fc;
    }

    .notification-item-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .notification-item-info strong {
        font-size: 15px;
    }

    .notification-item-info span {
        color: #777;
        font-size: 15px;
    }

    .notification-item > i {
        color: #aaa;
        font-size: 15px;
    }

    .notification-empty {
        padding: 45px 20px;
        text-align: center;
        color: #777;
    }

    .notification-empty i {
        margin-bottom: 10px;
        color: #35a66f;
        font-size: 25px;
    }

    .notification-empty p {
        margin: 0;
        font-size: 15px;
    }

    .notification-modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: auto;
        padding: 20px 32px;
        border-top: 1px solid #eee;
    }

    .view-all-button,
    .back-button {
        padding: 12px 20px;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
    }

    .view-all-button {
        border: none;
        background-color: #2563eb;
        color: white;
    }

    .view-all-button:hover {
        background-color: #1d4ed8;
    }

    .back-button {
        border: 1px solid #ccc;
        background-color: white;
        color: #444;
    }

    .back-button:hover {
        background-color: #f5f5f5;
    }

    .pengajuan-detail {
        flex: 1;
        padding: 28px 32px;
        overflow-y: auto;
    }

    .detail-row {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 22px;
    }

    .detail-row span {
        color: #777;
        font-size: 15px;
    }

    .detail-row strong {
        color: #222;
        font-size: 15px;
    }

    .detail-proof {
        margin-top: 5px;
    }

    .detail-proof-image {
        display: block;
        max-width: 100%;
        max-height: 260px;
        border: 1px solid #ddd;
        border-radius: 7px;
        object-fit: contain;
    }

    .detail-proof-link {
        display: inline-block;
        margin-top: 8px;
        color: #2563eb;
        font-size: 15px;
        text-decoration: none;
    }

    .detail-proof-link:hover {
        text-decoration: underline;
    }

    .no-proof {
        color: #777;
        font-size: 15px;
    }

    @media (max-width: 700px) {
        .notification-modal-content,
        .pengajuan-detail-content {
            width: calc(100% - 30px);
            max-width: none;
            min-height: 400px;
        }

        .notification-modal-header,
        .notification-item,
        .notification-modal-footer,
        .pengajuan-detail {
            padding-left: 20px;
            padding-right: 20px;
        }
    }


    /* Toolbar filter dua baris */
    .filter-export-row {
        position: relative;
        display: block;
        width: 100%;
        box-sizing: border-box;
    }

    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100%;
        min-width: 0;
    }

    .search-toolbar,
    .filter-toolbar {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .search-toolbar .search-container {
        flex: 1;
        min-width: 0;
        margin-bottom: 0;
    }

    .search-toolbar .search-input {
        width: 100%;
    }

    .search-toolbar .filter-button,
    .search-toolbar .reset-button,
    .filter-modal-button,
    .sort-select {
        min-height: 48px;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .filter-modal-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 7px;
        background-color: #087cf0;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-modal-button:hover {
        background-color: #066bd0;
    }

    .sort-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sort-control label {
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
    }

    .sort-select {
        min-width: 220px;
    }

    .export-buttons {
        position: static;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin: 0 0 0 auto;
        flex-shrink: 0;
    }

    .export-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 7px;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
    }

    .export-pdf {
        background-color: #dc3545;
        color: #fff;
    }

    .export-pdf:hover {
        background-color: #c82333;
        color: #fff;
    }

    .export-excel {
        background-color: #198754;
    }

    .export-excel:hover {
        background-color: #157347;
        color: #fff;
    }

    /* Modal filter */
    .attendance-filter-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, 0.45);
    }

    .attendance-filter-modal.active {
        display: flex;
    }

    .attendance-filter-content {
        width: 520px;
        max-width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
    }

    .attendance-filter-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 22px 24px;
        border-bottom: 1px solid #eee;
    }

    .attendance-filter-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .attendance-filter-header p {
        margin: 5px 0 0;
        color: #777;
        font-size: 13px;
    }

    .attendance-filter-body {
        display: flex;
        flex-direction: column;
        gap: 18px;
        padding: 24px;
    }

    .filter-field {
        display: flex;
        flex: 1;
        flex-direction: column;
        gap: 7px;
        min-width: 0;
    }

    .filter-field label {
        color: #444;
        font-size: 14px;
        font-weight: 500;
    }

    .filter-field .filter-select,
    .filter-field .filter-date {
        width: 100%;
        box-sizing: border-box;
    }

    .filter-field-row {
        display: flex;
        gap: 15px;
    }

    .attendance-filter-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 24px;
        border-top: 1px solid #eee;
    }

    /* Pagination - mengikuti tampilan awal di GitHub */
    .pagination-container {
        position: relative;
        width: 100%;
        min-height: 40px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
    }

    .pagination-info {
        position: absolute;
        left: calc(50% + 150px);
        top: 50%;
        transform: translateY(-50%);
        white-space: nowrap;
        font-size: 13px;
        color: #555;
    }

    .pagination-button {
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        text-decoration: none;
        transition: 0.2s;
    }

    .pagination-button:hover:not(.disabled):not(.active) {
        border-color: #2563eb;
        color: #2563eb;
    }

    .pagination-button.active {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
        font-weight: 600;
    }

    .pagination-button.disabled {
        color: #c4c4c4;
        background: #f9fafb;
        cursor: not-allowed;
    }

    @media (max-width: 600px) {
        .pagination-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .pagination-info {
            position: static;
            transform: none;
            text-align: center;
        }
    }

    @media (max-width: 900px) {
        .filter-toolbar {
            flex-wrap: wrap;
            padding-right: 0;
        }

        .export-buttons {
            justify-content: flex-end;
            margin-left: auto;
        }
    }

    @media (max-width: 600px) {
        .search-toolbar {
            flex-wrap: wrap;
        }

        .search-toolbar .search-container {
            flex-basis: 100%;
        }

        .filter-toolbar,
        .filter-field-row {
            flex-direction: column;
            align-items: stretch;
        }

        .sort-control {
            flex-wrap: wrap;
        }

        .sort-select {
            width: 100%;
        }

        .export-buttons {
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-left: 0;
        }
    }

</style>

<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">
            Dashboard
        </h1>

        <p class="welcome-text">
            Selamat Datang, {{ Auth::user()->name }}
        </p>
    </div>

    @if(auth()->user()->role === 'admin')
        <button
            type="button"
            class="notification-button"
            onclick="openNotificationModal()">
            <i class="fa-solid fa-bell"></i>

            @if($pendingPengajuan > 0)
                <span class="notification-dot"></span>
            @endif
        </button>
    @endif
</div>

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
        <div class="filter-export-row">
            <form method="GET" action="{{ route('dashboard') }}" class="filter-form">
                {{-- Baris pertama: pencarian --}}
                <div class="search-toolbar">
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

                    <button type="submit" class="filter-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Cari
                    </button>

                    <a href="{{ route('dashboard') }}" class="reset-button">Atur Ulang</a>
                </div>

                {{-- Baris kedua: filter dan sorting --}}
                <div class="filter-toolbar">
                    <button
                        type="button"
                        class="filter-modal-button"
                        onclick="openAttendanceFilter()">
                        <i class="fa-solid fa-filter"></i>
                        Filter
                    </button>

                    <div class="sort-control">
                        <label for="sort">Urutkan:</label>
                        <select
                            name="sort"
                            id="sort"
                            class="filter-select sort-select"
                            onchange="this.form.submit()">
                            <option value="date_desc" {{ request('sort', 'date_desc') === 'date_desc' ? 'selected' : '' }}>
                                Terbaru
                            </option>
                            <option value="date_asc" {{ request('sort') === 'date_asc' ? 'selected' : '' }}>
                                Terlama
                            </option>
                            @if(auth()->user()->role === 'admin')
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>
                                    A ke Z
                                </option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>
                                    Z ke A
                                </option>
                            @endif
                        </select>
                    </div>

                    {{-- Tombol ekspor sejajar dengan Filter dan Urutkan --}}
                    @if(auth()->user()->role === 'admin')
                        <div class="export-buttons">
                            <a href="{{ route('presensi.export.pdf', request()->query()) }}" class="export-button export-pdf">
                                <i class="fa-solid fa-file-pdf"></i> Ekspor PDF
                            </a>
                            <a href="{{ route('presensi.export.excel', request()->query()) }}" class="export-button export-excel">
                                <i class="fa-solid fa-file-excel"></i> Ekspor Excel
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Modal filter: tetap di dalam form agar nilainya terkirim --}}
                <div id="attendanceFilterModal" class="attendance-filter-modal" aria-hidden="true">
                    <div class="attendance-filter-content" role="dialog" aria-modal="true" aria-labelledby="attendanceFilterTitle">
                        <div class="attendance-filter-header">
                            <div>
                                <h2 id="attendanceFilterTitle">Filter Data Presensi</h2>
                                <p>Pilih kriteria untuk menyaring data presensi.</p>
                            </div>
                            <button type="button" class="notification-close" onclick="closeAttendanceFilter()" aria-label="Tutup">&times;</button>
                        </div>

                        <div class="attendance-filter-body">
                            <div class="filter-field">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="filter-select">
                                    <option value="">Semua Status</option>
                                    <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    <option value="sakit" {{ request('status') === 'sakit' ? 'selected' : '' }}>Sakit</option>
                                    <option value="izin" {{ request('status') === 'izin' ? 'selected' : '' }}>Izin</option>
                                </select>
                            </div>

                            <div class="filter-field-row">
                                <div class="filter-field">
                                    <label for="month">Bulan</label>
                                    <select name="month" id="month" class="filter-select">
                                        <option value="">Semua Bulan</option>
                                        @foreach([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $number => $monthName)
                                            <option value="{{ $number }}" {{ (string) request('month') === (string) $number ? 'selected' : '' }}>{{ $monthName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-field">
                                    <label for="year">Tahun</label>
                                    <select name="year" id="year" class="filter-select">
                                        <option value="">Semua Tahun</option>
                                        @foreach(($years ?? collect()) as $year)
                                            <option value="{{ $year }}" {{ (string) request('year') === (string) $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="filter-field">
                                <label>Rentang Tanggal</label>
                                <div class="filter-field-row">
                                    <div class="filter-field">
                                        <label for="date_from">Tanggal Mulai</label>
                                        <input type="date" name="date_from" id="date_from" class="filter-date" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="filter-field">
                                        <label for="date_to">Tanggal Akhir</label>
                                        <input type="date" name="date_to" id="date_to" class="filter-date" value="{{ request('date_to') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="attendance-filter-footer">
                            <button type="button" class="back-button" onclick="closeAttendanceFilter()">Tutup</button>
                            <button type="submit" class="filter-button">Terapkan Filter</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
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

    @if(method_exists($presensis, 'hasPages') && $presensis->hasPages())
        <div class="pagination-container">
            <div class="pagination-buttons">
                {{-- Sebelumnya --}}
                @if ($presensis->onFirstPage())
                    <span class="pagination-button disabled">&laquo; Sebelumnya</span>
                @else
                    <a class="pagination-button" href="{{ $presensis->previousPageUrl() }}">&laquo; Sebelumnya</a>
                @endif

                {{-- Nomor halaman --}}
                @for ($page = 1; $page <= $presensis->lastPage(); $page++)
                    @if ($page == $presensis->currentPage())
                        <span class="pagination-button active">{{ $page }}</span>
                    @else
                        <a class="pagination-button" href="{{ $presensis->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Berikutnya --}}
                @if ($presensis->hasMorePages())
                    <a class="pagination-button" href="{{ $presensis->nextPageUrl() }}">Berikutnya &raquo;</a>
                @else
                    <span class="pagination-button disabled">Berikutnya &raquo;</span>
                @endif
            </div>

            <div class="pagination-info">
                Menampilkan {{ $presensis->firstItem() ?? 0 }} sampai {{ $presensis->lastItem() ?? 0 }}
                dari {{ $presensis->total() }} data
            </div>
        </div>
    @endif
</div>

@if(auth()->user()->role === 'admin')

<div
    id="notificationModal"
    class="notification-modal">

    <div class="notification-modal-content">

        <div class="notification-modal-header">

            <div>
                <h2>
                    Pengajuan Menunggu
                </h2>

                <p>
                    {{ $pendingPengajuan }} pengajuan menunggu pemeriksaan.
                </p>
            </div>

            <button
                type="button"
                class="notification-close"
                onclick="closeNotificationModal()">
                ×
            </button>

        </div>

        <div class="notification-list">

            @forelse($pengajuans as $pengajuan)

                <div
                    class="notification-item"
                    onclick="showPengajuanDetail(
                        {{ $pengajuan->id }},
                        @js($pengajuan->user->name),
                        @js($pengajuan->tanggal->format('d-m-Y')),
                        @js(ucfirst($pengajuan->mengajukan)),
                        @js($pengajuan->alasan ?? '-'),
                        @js($pengajuan->bukti ?? '')
                    )">

                    <div class="notification-item-info">

                        <strong>
                            {{ $pengajuan->user->name }}
                        </strong>

                        <span>
                            {{ ucfirst($pengajuan->mengajukan) }}
                            ·
                            {{ $pengajuan->tanggal->format('d-m-Y') }}
                        </span>

                    </div>

                    <i class="fa-solid fa-chevron-right"></i>

                </div>
            @empty
                <div class="notification-empty">

                    <i class="fa-solid fa-check"></i>

                    <p>
                        Tidak ada pengajuan yang menunggu.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="notification-modal-footer">
            <a
                href="{{ route('presensi') }}"
                class="view-all-button">
                Lihat Semua Pengajuan
            </a>
        </div>
    </div>
</div>

<div
    id="pengajuanDetailModal"
    class="notification-modal">

    <div class="pengajuan-detail-content">
        <div class="notification-modal-header">

            <h2>
                Detail Pengajuan
            </h2>

            <button
                type="button"
                class="notification-close"
                onclick="closePengajuanDetail()">
                ×
            </button>
        </div>

        <div class="pengajuan-detail">
            <div class="detail-row">
                <span>
                    Pengguna
                </span>

                <strong id="detailUser">
                    -
                </strong>
            </div>

            <div class="detail-row">
                <span>
                    Tanggal
                </span>

                <strong id="detailDate">
                    -
                </strong>
            </div>

            <div class="detail-row">
                <span>
                    Jenis Pengajuan
                </span>

                <strong id="detailType">
                    -
                </strong>
            </div>

            <div class="detail-row">
                <span>
                    Alasan
                </span>

                <strong id="detailReason">
                    -
                </strong>
            </div>

            <div class="detail-row">
                <span>
                    Bukti
                </span>

                <div id="detailProof" class="detail-proof">
                    <span class="no-proof">
                        Tidak ada bukti dilampirkan.
                    </span>

                    <img
                        id="detailProofImage"
                        class="detail-proof-image"
                        src=""
                        alt="Bukti pengajuan"
                        style="display: none;">

                    <a
                        id="detailProofLink"
                        class="detail-proof-link"
                        href="#"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="display: none;">
                        Buka bukti
                    </a>
                </div>
            </div>
        </div>

        <div class="notification-modal-footer">
            <button
                type="button"
                class="back-button"
                onclick="backToNotificationModal()">
                Kembali
            </button>

            <a
                href="{{ route('presensi') }}"
                class="view-all-button">
                Buka Halaman Presensi
            </a>
        </div>
    </div>
</div>

@endif
@endsection

<script>
function openAttendanceFilter() {
    const modal = document.getElementById('attendanceFilterModal');
    if (modal) {
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
    }
}

function closeAttendanceFilter() {
    const modal = document.getElementById('attendanceFilterModal');
    if (modal) {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
    }
}

    function openNotificationModal() {

    document
        .getElementById('notificationModal')
        .classList.add('active');

}

function closeNotificationModal() {

    document
        .getElementById('notificationModal')
        .classList.remove('active');

}

function showPengajuanDetail(
    id,
    user,
    date,
    type,
    reason,
    bukti
) {

    document.getElementById('detailUser').textContent = user;

    document.getElementById('detailDate').textContent = date;

    document.getElementById('detailType').textContent = type;

    document.getElementById('detailReason').textContent = reason;

    const proofImage = document.getElementById('detailProofImage');
    const proofLink = document.getElementById('detailProofLink');
    const noProof = document.querySelector('#detailProof .no-proof');

    if (bukti) {
        const proofUrl = '{{ asset('storage') }}/' + bukti;

        proofImage.src = proofUrl;
        proofImage.style.display = 'block';

        proofLink.href = proofUrl;
        proofLink.style.display = 'inline-block';

        noProof.style.display = 'none';
    } else {
        proofImage.src = '';
        proofImage.style.display = 'none';

        proofLink.href = '#';
        proofLink.style.display = 'none';

        noProof.style.display = 'inline';
    }

    closeNotificationModal();

    document
        .getElementById('pengajuanDetailModal')
        .classList.add('active');

}


function backToNotificationModal() {

    document
        .getElementById('pengajuanDetailModal')
        .classList.remove('active');

    document
        .getElementById('notificationModal')
        .classList.add('active');

}


function closePengajuanDetail() {

    document
        .getElementById('pengajuanDetailModal')
        .classList.remove('active');

}

window.addEventListener('click', function(event) {

    const notificationModal =
        document.getElementById('notificationModal');

    const detailModal =
        document.getElementById('pengajuanDetailModal');
    const attendanceFilterModal =
        document.getElementById('attendanceFilterModal');

    if (event.target === attendanceFilterModal) {
        closeAttendanceFilter();
    }

    if (event.target === notificationModal) {
        closeNotificationModal();
    }

    if (event.target === detailModal) {
        closePengajuanDetail();
    }

});
window.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAttendanceFilter();
        if (document.getElementById('notificationModal')) closeNotificationModal();
        if (document.getElementById('pengajuanDetailModal')) closePengajuanDetail();
    }
});
</script>
