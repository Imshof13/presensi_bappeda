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
        cursor: pointer;
        transition: 0.2s;
    }

    .detail-proof-image:hover {
        opacity: 0.9;
    }

    .proof-image-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        padding: 50px;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .proof-image-modal.active {
        display: flex;
    }

    .proof-large-image {
        display: block;
        width: auto;
        height: auto;
        max-width: calc(100vw - 120px);
        max-height: calc(100vh - 120px);
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
    }

    .proof-image-close {
        position: absolute;
        top: 20px;
        right: 25px;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.9);
        color: #333;
        font-size: 20px;
        cursor: pointer;
        z-index: 10001;
    }

    .proof-image-close:hover {
        background-color: white;
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
            flex: 1;
            min-height: 0;
            padding: 28px 32px;
            overflow-y: auto;
        }
    }

    .pagination-container {
        position: relative;
        width: 100%;
        margin-top: 20px;
        min-height: 40px;
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
        background: white;
        color: #374151;
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
        color: white;
        font-weight: 600;
    }

    .pagination-button.disabled {
        color: #c4c4c4;
        background: #f9fafb;
        cursor: not-allowed;
    }
    

    @media (max-width: 600px) {
        .pagination-container {
            justify-content: center;
        }

        .pagination-info {
            width: 100%;
            text-align: center;
        }
    }

    .presensi-detail-content {
        width: 600px;
        max-width: calc(100% - 40px);
        height: 80vh;
        max-height: calc(100vh - 40px);
        display: flex;
        flex-direction: column;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
    }

    .detail-button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 14px;
        border: none;
        border-radius: 7px;
        background-color: #2563eb;
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
    }

    .detail-button:hover {
        background-color: #1d4ed8;
    }

    .presensi-detail-content .detail-row {
        margin-bottom: 22px;
    }

    .presensi-detail-content .detail-row:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 700px) {
        .presensi-detail-content {
            width: calc(100% - 30px);
            max-width: none;
            height: 80vh;
            max-height: calc(100vh - 30px);
        }
    
    @media (max-width: 600px) {
        .proof-image-modal {
            padding: 60px 20px 20px;
        }

        .proof-large-image {
            max-width: calc(100vw - 40px);
            max-height: calc(100vh - 80px);
        }

        .proof-image-close {
            top: 12px;
            right: 12px;
        }
    }
}
    
    .sortable-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        height: 100%;
        color: inherit;
        text-decoration: none;
        cursor: pointer;
    }

    .sortable-header:hover {
        color: inherit;
        text-decoration: none;
    }

    .sortable-header i {
        margin-left: 8px;
        font-size: 12px;
    }

    .sortable-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        height: 100%;
        min-height: 40px;
        color: inherit;
        text-decoration: none;
        cursor: pointer;
        box-sizing: border-box;
    }

    .export-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .export-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;

        padding: 10px 16px;

        border-radius: 7px;

        text-decoration: none;
        font-size: 14px;
        font-weight: 500;

        transition: 0.2s;
    }

    .export-pdf {
        background-color: #dc3545;
        color: white;
    }

    .export-pdf:hover {
        background-color: #c82333;
        color: white;
    }

    .export-excel {
        background-color: #198754;
        color: white;
    }

    .export-excel:hover {
        background-color: #157347;
        color: white;
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

    <div
        id="presensiDetailModal"
        class="notification-modal">
        <div class="presensi-detail-content">

            <div class="notification-modal-header">
                <h2>Detail Presensi</h2>

                <button
                    type="button"
                    class="notification-close"
                    onclick="closePresensiDetail()">
                    ×
                </button>
            </div>

            <div class="pengajuan-detail">

                <div class="detail-row">
                    <span>Nama</span>
                    <strong id="presensiDetailName">-</strong>
                </div>

                <div class="detail-row">
                    <span>Tanggal</span>
                    <strong id="presensiDetailDate">-</strong>
                </div>

                <div class="detail-row">
                    <span>Masuk</span>
                    <strong id="presensiDetailCheckIn">-</strong>
                </div>

                <div class="detail-row">
                    <span>Pulang</span>
                    <strong id="presensiDetailCheckOut">-</strong>
                </div>

                <div class="detail-row">
                    <span>Status</span>
                    <strong id="presensiDetailStatus">-</strong>
                </div>

                <div class="detail-row">
                    <span>Keterangan</span>
                    <strong id="presensiDetailNote">-</strong>
                </div>

                <div class="detail-row">
                    <span>Bukti</span>

                    <div id="presensiDetailProof" class="detail-proof">
                        <span id="presensiNoProof" class="no-proof">
                            Tidak ada bukti dilampirkan.
                        </span>

                        <img
                            id="presensiDetailProofImage"
                            class="detail-proof-image"
                            src=""
                            alt="Bukti presensi"
                            style="display: none;"
                            onclick="openPresensiProof()">
                    </div>
                </div>
            </div>

            <div class="notification-modal-footer">
                <button
                    type="button"
                    class="back-button"
                    onclick="closePresensiDetail()">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div
        id="presensiProofModal"
        class="proof-image-modal"
        onclick="closePresensiProof()">
        <button
            type="button"
            class="proof-image-close"
            onclick="closePresensiProof()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img
            id="presensiProofLargeImage"
            class="proof-large-image"
            src=""
            alt="Bukti presensi"
            onclick="event.stopPropagation()">
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

        @php
            $currentSortBy = request('sort_by', 'date');
            $currentSort = request('sort', 'desc');

            $nextNameSort = ($currentSortBy === 'name' && $currentSort === 'asc')
                ? 'desc'
                : 'asc';

            $nextDateSort = ($currentSortBy === 'date' && $currentSort === 'asc')
                ? 'desc'
                : 'asc';
        @endphp

        @if(auth()->user()->role === 'admin')
            <div class="export-buttons">

                <a
                    href="{{ route('presensi.export.pdf', request()->query()) }}"
                    class="export-button export-pdf"
                >
                    <i class="fa-solid fa-file-pdf"></i>
                    Export PDF
                </a>

                <a
                    href="{{ route('presensi.export.excel', request()->query()) }}"
                    class="export-button export-excel"
                >
                    <i class="fa-solid fa-file-excel"></i>
                    Export Excel
                </a>

            </div>
        @endif

        <table class="attendance-table">
            @php
                $currentSortBy = request('sort_by', 'date');
                $currentSort = request('sort', 'desc');

                $nextNameSort = ($currentSortBy === 'name' && $currentSort === 'asc')
                    ? 'desc'
                    : 'asc';

                $nextDateSort = ($currentSortBy === 'date' && $currentSort === 'asc')
                    ? 'desc'
                    : 'asc';
            @endphp

            <thead>
                <tr>

                    @if(auth()->user()->role === 'admin')
                        <th>
                            <a
                                href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'name',
                                    'sort' => $nextNameSort,
                                    'page' => 1
                                ]) }}"
                                class="sortable-header"
                            >
                                <span>Nama</span>

                                @if($currentSortBy === 'name')
                                    @if($currentSort === 'asc')
                                        <i class="fa-solid fa-arrow-up"></i>
                                    @else
                                        <i class="fa-solid fa-arrow-down"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                    @endif

                    <th>
                        <a
                            href="{{ request()->fullUrlWithQuery([
                                'sort_by' => 'date',
                                'sort' => $nextDateSort,
                                'page' => 1
                            ]) }}"
                            class="sortable-header"
                        >
                            <span>Tanggal</span>

                            @if($currentSortBy === 'date')
                                @if($currentSort === 'asc')
                                    <i class="fa-solid fa-arrow-up"></i>
                                @else
                                    <i class="fa-solid fa-arrow-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>

                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>

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

                        <td>
                            <button
                                type="button"
                                class="detail-button"
                                onclick="openPresensiDetail(this)"
                                data-name="{{ auth()->user()->role === 'admin' ? $presensi->user->name : auth()->user()->name }}"
                                data-date="{{ $presensi->date->format('d-m-Y') }}"
                                data-check-in="{{ $presensi->check_in ?? '-' }}"
                                data-check-out="{{ $presensi->check_out ?? '-' }}"
                                data-status="{{ ucfirst($presensi->status ?? '-') }}"
                                data-note="{{ $presensi->note ?? '-' }}"
                                data-bukti="{{ $presensi->PengajuanDiterima()?->bukti ?? '' }}">
                                <i class="fa-solid fa-eye"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                            class="empty-data">
                            Tidak ada data presensi ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($presensis->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Menampilkan {{ $presensis->firstItem() }}
                – {{ $presensis->lastItem() }}
                dari {{ $presensis->total() }} data
            </div>

            <div class="pagination-buttons">
                {{-- Previous page --}}
                @if($presensis->onFirstPage())
                    <span class="pagination-button disabled">
                        <i class="fa-solid fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $presensis->previousPageUrl() }}"
                    class="pagination-button">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                @foreach($presensis->getUrlRange(1, $presensis->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                    class="pagination-button {{ $presensis->currentPage() === $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($presensis->hasMorePages())
                    <a href="{{ $presensis->nextPageUrl() }}"
                    class="pagination-button">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-button disabled">
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif
    </div>
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


    if (event.target === notificationModal) {
        closeNotificationModal();
    }

    if (event.target === detailModal) {
        closePengajuanDetail();
    }

});

function openPresensiDetail(button) {
    document.getElementById('presensiDetailName').textContent =
        button.dataset.name;

    document.getElementById('presensiDetailDate').textContent =
        button.dataset.date;

    document.getElementById('presensiDetailCheckIn').textContent =
        button.dataset.checkIn;

    document.getElementById('presensiDetailCheckOut').textContent =
        button.dataset.checkOut;

    document.getElementById('presensiDetailStatus').textContent =
        button.dataset.status;

    document.getElementById('presensiDetailNote').textContent =
        button.dataset.note;

    const proofImage =
    document.getElementById('presensiDetailProofImage');

    const noProof =
        document.getElementById('presensiNoProof');

    if (button.dataset.bukti) {
        const proofUrl =
            '{{ asset('storage') }}/' + button.dataset.bukti;

        proofImage.src = proofUrl;
        proofImage.style.display = 'block';
        noProof.style.display = 'none';

    } else {
        proofImage.src = '';
        proofImage.style.display = 'none';
        noProof.style.display = 'inline';
    }
    
    document
        .getElementById('presensiDetailModal')
        .classList.add('active');
}

function openPresensiProof() {
    const image =
        document.getElementById('presensiDetailProofImage');

    const largeImage =
        document.getElementById('presensiProofLargeImage');

    if (!image.src) {
        return;
    }

    largeImage.src = image.src;

    document
        .getElementById('presensiProofModal')
        .classList.add('active');
}

function closePresensiDetail() {
    document
        .getElementById('presensiDetailModal')
        .classList.remove('active');
}

function closePresensiProof() {
    document
        .getElementById('presensiProofModal')
        .classList.remove('active');
}
</script>