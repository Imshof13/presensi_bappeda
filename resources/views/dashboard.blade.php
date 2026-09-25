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
</script>