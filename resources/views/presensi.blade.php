@extends('layout.app')

@section('title', 'Presensi')

@section('content')

<style>
    .presensi-header {
        margin-bottom: 0;
    }

    .presensi-header-top {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .presensi-header-bottom {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
        margin-top: 18px;
        margin-bottom: 20px;
    }

    .presensi-title {
        margin: 0;
        font-size: 36px;
        font-weight: 600;
    }

    .presensi-date {
        margin: 4px 0 0;
        color: #777;
        font-size: 14px;
    }

    .pengajuan-button {
        padding: 12px 18px;
        border: none;
        border-radius: 7px;
        background-color: #2563eb;
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    .pengajuan-button:hover {
        opacity: 0.9;
    }

    .presensi-card {
        width: 100%;
        box-sizing: border-box;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .user-section {
        padding: 24px 30px;
        border-bottom: 1px solid #eee;
    }

    .user-label {
        margin: 0 0 5px;
        color: #888;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .user-name {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .status-section {
        padding: 28px 30px 30px;
    }

    .status-title {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .status-subtitle {
        margin: 4px 0 22px;
        color: #888;
        font-size: 13px;
    }

    .attendance-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .info-box {
        min-height: 76px;
        padding: 14px;
        box-sizing: border-box;
        background-color: #f7f9fc;
        border-radius: 7px;
    }

    .info-label {
        margin: 0 0 7px;
        color: #718096;
        font-size: 10px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        margin: 0;
        color: #172033;
        font-size: 14px;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border: 1px solid #f0b429;
        border-radius: 6px;
        background-color: #fff8e6;
        color: #c47a00;
        font-size: 12px;
        font-weight: 600;
    }

    .status-hadir {
        border-color: #35a66f;
        background-color: #eaf8f0;
        color: #218653;
    }

    .status-telat {
        border-color: #f0b429;
        background-color: #fff8e6;
        color: #c47a00;
    }

    .status-sakit,
    .status-izin {
        border-color: #e05a5a;
        background-color: #fff0f0;
        color: #c03939;
    }

    .attendance-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 30px;
        padding-top: 28px;
        border-top: 1px solid #eee;
    }

    .attendance-button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 7px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
    }

    .check-in-button {
        background-color: #2563eb;
        color: white;
    }

    .check-in-button:hover {
        background-color: #1d4ed8;
    }

    .check-in-button:disabled {
        background-color: #eef2f7;
        color: #9aa6b5;
        cursor: not-allowed;
    }

    .check-out-button {
        background-color: #2563eb;
        color: white;
    }

    .attendance-button:disabled {
        cursor: not-allowed;
    }

    .check-out-button:disabled {
        background-color: #eef2f7;
        color: #9aa6b5;
    }


    .admin-presensi-section {
        margin-top: 25px;
    }

    .admin-section-header {
        margin-bottom: 20px;
    }

    .admin-section-header h2 {
        margin: 0 0 5px;
        font-size: 24px;
        font-weight: 600;
    }

    .admin-section-header p {
        margin: 0;
        color: #777;
        font-size: 15px;
    }

    .admin-pengajuan-card {
        width: 100%;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    .admin-pengajuan-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .admin-pengajuan-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-pengajuan-table th,
    .admin-pengajuan-table td {
        padding: 16px 18px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 15px;
        vertical-align: middle;
    }

    .admin-pengajuan-table th {
        font-weight: 600;
        color: #555;
        background-color: #eeeeee;
    }

    .admin-pengajuan-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pengajuan-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .pengajuan-status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .pengajuan-status-diterima {
        background-color: #e7f7ed;
        color: #218838;
    }

    .pengajuan-status-ditolak {
        background-color: #f8d7da;
        color: #721c24;
    }

    .admin-action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .admin-action-button {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
    }

    .admin-detail-button {
        background-color: #eef2f7;
        color: #333;
    }

    .admin-detail-button:hover {
        background-color: #e2e8f0;
    }

    .admin-accept-button {
        background-color: #16a34a;
        color: white;
    }

    .admin-accept-button:hover {
        background-color: #15803d;
    }

    .admin-reject-button {
        background-color: #dc3545;
        color: white;
    }

    .admin-reject-button:hover {
        background-color: #bb2d3b;
    }

    .admin-empty {
        padding: 40px 20px;
        text-align: center;
        color: #777;
        font-size: 15px;
    }

    .admin-empty i {
        display: block;
        margin-bottom: 10px;
        color: #35a66f;
        font-size: 28px;
    }

    .admin-modal {
        display: none;
        position: fixed;
        z-index: 1100;
        inset: 0;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        background-color: rgba(0, 0, 0, 0.45);
    }

    .admin-modal.active {
        display: flex;
    }

    .admin-modal-content {
        width: 700px;
        max-width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        background-color: white;
        border-radius: 10px;
    }

    .admin-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 24px 30px;
        border-bottom: 1px solid #eee;
    }

    .admin-modal-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .admin-modal-close {
        border: none;
        background: none;
        color: #777;
        font-size: 26px;
        cursor: pointer;
    }

    .admin-modal-body {
        padding: 26px 30px;
    }

    .admin-detail-row {
        margin-bottom: 20px;
    }

    .admin-detail-row:last-child {
        margin-bottom: 0;
    }

    .admin-detail-label {
        display: block;
        margin-bottom: 6px;
        color: #777;
        font-size: 13px;
    }

    .admin-detail-value {
        display: block;
        color: #222;
        font-size: 15px;
        line-height: 1.6;
    }

    .admin-proof-image {
        display: block;
        max-width: 100%;
        max-height: 350px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 7px;
        object-fit: contain;
    }

    .admin-proof-link {
        display: inline-block;
        margin-top: 10px;
        color: #2563eb;
        font-size: 15px;
        text-decoration: none;
    }

    .admin-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 30px;
        border-top: 1px solid #eee;
    }

    .admin-back-button {
        padding: 11px 18px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: white;
        color: #444;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        cursor: pointer;
    }

    .admin-modal-footer form {
        margin: 0;
    }

    @media (max-width: 700px) {
        .admin-pengajuan-table th,
        .admin-pengajuan-table td {
            padding: 13px 14px;
        }

        .admin-modal-content {
            max-height: 95vh;
        }

        .admin-modal-header,
        .admin-modal-body,
        .admin-modal-footer {
            padding-left: 20px;
            padding-right: 20px;
        }
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        inset: 0;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.45);
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        width: 500px;
        max-width: calc(100% - 40px);
        padding: 30px;
        box-sizing: border-box;
        background-color: white;
        border-radius: 10px;
    }

    .modal-title {
        margin: 0 0 25px;
        font-size: 24px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 14px;
        font-weight: 500;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 11px 13px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        outline: none;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #2563eb;
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .modal-close {
        padding: 11px 18px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: white;
        color: #444;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
    }

    .modal-submit {
        padding: 11px 18px;
        border: none;
        border-radius: 6px;
        background-color: #2563eb;
        color: white;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
    }

    .error-message {
        margin-top: 5px;
        color: #dc3545;
        font-size: 13px;
    }

    @media (max-width: 700px) {

        .presensi-header {
            flex-direction: column;
            gap: 15px;
        }

        .attendance-info {
            grid-template-columns: 1fr;
        }

        .attendance-actions {
            grid-template-columns: 1fr;
        }
    }

    .alert-popup {
        position: fixed;
        top: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;

        min-width: 350px;
        max-width: 500px;
        padding: 16px 20px;

        background: white;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);

        display: flex;
        align-items: flex-start;
        gap: 12px;

        animation: alertSlideDown 0.3s ease;
    }

    .alert-popup.success {
        border-left: 5px solid #22c55e;
    }

    .alert-popup.error {
        border-left: 5px solid #ef4444;
    }

    .alert-popup-icon {
        font-size: 20px;
        margin-top: 2px;
    }

    .alert-popup.success .alert-popup-icon {
        color: #22c55e;
    }

    .alert-popup.error .alert-popup-icon {
        color: #ef4444;
    }

    .alert-popup-content {
        flex: 1;
    }

    .alert-popup-title {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .alert-popup-message {
        font-size: 15px;
        color: #555;
    }

    .alert-popup-close {
        border: none;
        background: none;
        font-size: 18px;
        color: #777;
        cursor: pointer;
    }

    .alert-popup-close:hover {
        color: #333;
    }

    @keyframes alertSlideDown {
        from {
            opacity: 0;
            transform: translate(-50%, -20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }
</style>

@if(session('success'))
    <div class="alert-popup success" id="alertPopup">
        <i class="fa-solid fa-circle-check alert-popup-icon"></i>

        <div class="alert-popup-content">
            <div class="alert-popup-title">
                Berhasil
            </div>

            <div class="alert-popup-message">
                {{ session('success') }}
            </div>
        </div>

        <button type="button"
                class="alert-popup-close"
                onclick="closeAlert()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if($errors->any())
    <div class="alert-popup error" id="alertPopup">
        <i class="fa-solid fa-circle-exclamation alert-popup-icon"></i>

        <div class="alert-popup-content">
            <div class="alert-popup-title">
                Pengajuan Gagal
            </div>

            <div class="alert-popup-message">
                {{ $errors->first() }}
            </div>
        </div>

        <button type="button"
                class="alert-popup-close"
                onclick="closeAlert()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<div class="presensi-header">
    <div class="presensi-header-top">
        <h1 class="presensi-title">
            Presensi
        </h1>

        <p class="presensi-date">
            {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    @if(auth()->user()->role === 'user')
        <div class="presensi-header-bottom">
            <button
                type="button"
                class="pengajuan-button"
                onclick="openPengajuanModal()">
                Pengajuan Izin / Sakit
            </button>
        </div>
    @endif
</div>

@if(auth()->user()->role === 'admin')

    <div class="admin-presensi-section">

        <div class="admin-section-header">
            <h2>Pengajuan Izin / Sakit</h2>
            <p>Kelola pengajuan izin dan sakit yang diajukan oleh pegawai.</p>
        </div>

        <div class="admin-pengajuan-card">
            <div class="admin-pengajuan-table-container">
                <table class="admin-pengajuan-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Alasan</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse(($pengajuans ?? collect()) as $pengajuan)
                            <tr>
                                <td>{{ $pengajuan->user->name }}</td>

                                <td>
                                    {{ $pengajuan->tanggal->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ ucfirst($pengajuan->mengajukan) }}
                                </td>

                                <td>
                                    {{ $pengajuan->alasan ?? '-' }}
                                </td>

                                <td>
                                    @if($pengajuan->bukti)
                                        <button
                                            type="button"
                                            class="admin-action-button admin-detail-button"
                                            onclick="showAdminPengajuanDetail(
                                                @js($pengajuan->user->name),
                                                @js($pengajuan->tanggal->format('d-m-Y')),
                                                @js(ucfirst($pengajuan->mengajukan)),
                                                @js($pengajuan->alasan ?? '-'),
                                                @js($pengajuan->bukti),
                                                @js($pengajuan->status)
                                            )">
                                            Lihat
                                        </button>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <span class="pengajuan-status pengajuan-status-{{ $pengajuan->status }}">
                                        {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="admin-action-buttons">

                                        <button
                                            type="button"
                                            class="admin-action-button admin-detail-button"
                                            onclick="showAdminPengajuanDetail(
                                                @js($pengajuan->user->name),
                                                @js($pengajuan->tanggal->format('d-m-Y')),
                                                @js(ucfirst($pengajuan->mengajukan)),
                                                @js($pengajuan->alasan ?? '-'),
                                                @js($pengajuan->bukti ?? ''),
                                                @js($pengajuan->status)
                                            )">
                                            Detail
                                        </button>

                                        @if($pengajuan->status === 'pending')

                                            <form
                                                method="POST"
                                                action="{{ route('pengajuan.accept', $pengajuan->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="admin-action-button admin-accept-button">
                                                    Terima
                                                </button>
                                            </form>

                                            <form
                                                method="POST"
                                                action="{{ route('pengajuan.reject', $pengajuan->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="admin-action-button admin-reject-button">
                                                    Tolak
                                                </button>
                                            </form>

                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="admin-empty">
                                    <i class="fa-solid fa-check"></i>
                                    Tidak ada pengajuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@else

    <div class="presensi-card">

        <div class="user-section">

            <p class="user-label">
                Pengguna
            </p>

            <p class="user-name">
                {{ auth()->user()->name }}
            </p>

        </div>

        <div class="status-section">

            <h2 class="status-title">
                Status Presensi Hari Ini
            </h2>

            <p class="status-subtitle">
                Informasi rekam waktu kehadiran kerja Anda
            </p>

            <div class="attendance-info">

                <div class="info-box">

                    <p class="info-label">
                        Masuk
                    </p>

                    <p class="info-value">
                        {{ $presensi?->check_in ?? '-' }}
                    </p>

                </div>

                <div class="info-box">

                    <p class="info-label">
                        Pulang
                    </p>

                    <p class="info-value">
                        {{ $presensi?->check_out ?? '-' }}
                    </p>

                </div>

                <div class="info-box">

                    <p class="info-label">
                        Status
                    </p>

                    @if($presensi?->status)

                        <span class="status-badge status-{{ $presensi->status }}">
                            {{ ucfirst($presensi->status) }}
                        </span>

                    @else

                        <p class="info-value">
                            -
                        </p>

                    @endif

                </div>

                <div class="info-box">

                    <p class="info-label">
                        Keterangan
                    </p>

                    <p class="info-value">
                        {{ $presensi?->note ?? '-' }}
                    </p>

                </div>

            </div>

            <div class="attendance-actions">

                <form
                    method="POST"
                    action="{{ route('presensi.checkIn') }}">
                    @csrf

                    <button
                        type="submit"
                        class="attendance-button check-in-button"
                        {{ $presensi ? 'disabled' : '' }}>
                        ✓ &nbsp; Presensi Masuk
                    </button>

                </form>

                <form
                    method="POST"
                    action="{{ route('presensi.checkOut') }}">
                    @csrf

                    <button
                        type="submit"
                        class="attendance-button check-out-button"
                        {{ !$presensi || $presensi->check_out ? 'disabled' : '' }}>
                        ⇥ &nbsp; Presensi Pulang
                    </button>

                </form>

            </div>

        </div>

    </div>

@endif


@if(auth()->user()->role === 'admin')

<div
    id="adminPengajuanDetailModal"
    class="admin-modal">

    <div class="admin-modal-content">

        <div class="admin-modal-header">
            <h2>Detail Pengajuan</h2>

            <button
                type="button"
                class="admin-modal-close"
                onclick="closeAdminPengajuanDetail()">
                ×
            </button>
        </div>

        <div class="admin-modal-body">

            <div class="admin-detail-row">
                <span class="admin-detail-label">Pengguna</span>
                <span id="adminDetailUser" class="admin-detail-value">-</span>
            </div>

            <div class="admin-detail-row">
                <span class="admin-detail-label">Tanggal</span>
                <span id="adminDetailDate" class="admin-detail-value">-</span>
            </div>

            <div class="admin-detail-row">
                <span class="admin-detail-label">Jenis Pengajuan</span>
                <span id="adminDetailType" class="admin-detail-value">-</span>
            </div>

            <div class="admin-detail-row">
                <span class="admin-detail-label">Alasan</span>
                <span id="adminDetailReason" class="admin-detail-value">-</span>
            </div>

            <div class="admin-detail-row">
                <span class="admin-detail-label">Status</span>
                <span id="adminDetailStatus" class="admin-detail-value">-</span>
            </div>

            <div class="admin-detail-row">
                <span class="admin-detail-label">Bukti</span>

                <div id="adminDetailProof">
                    <span id="adminNoProof" class="admin-detail-value">
                        Tidak ada bukti dilampirkan.
                    </span>

                    <img
                        id="adminProofImage"
                        class="admin-proof-image"
                        src=""
                        alt="Bukti pengajuan"
                        style="display: none;">

                    <a
                        id="adminProofLink"
                        class="admin-proof-link"
                        href="#"
                        target="_blank"
                        rel="noopener noreferrer"
                        style="display: none;">
                        Buka bukti
                    </a>
                </div>
            </div>

        </div>

        <div class="admin-modal-footer">

            <button
                type="button"
                class="admin-back-button"
                onclick="closeAdminPengajuanDetail()">
                Kembali
            </button>

            <a
                href="{{ route('presensi') }}"
                class="admin-action-button admin-detail-button">
                Halaman Presensi
            </a>

        </div>

    </div>

</div>

@endif

@if(auth()->user()->role === 'user')

<div
    id="pengajuanModal"
    class="modal"
>

    <div class="modal-content">

        <h2 class="modal-title">
            Pengajuan Izin / Sakit
        </h2>

        <form
            method="POST"
            action="{{ route('pengajuan.store') }}"
            enctype="multipart/form-data">

            @csrf

            <div class="form-group">

                <label for="tanggal">
                    Tanggal
                </label>

                <input
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    class="form-input"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    required>

                @error('tanggal')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label for="mengajukan">
                    Jenis Pengajuan
                </label>

                <select
                    id="mengajukan"
                    name="mengajukan"
                    class="form-select"
                    required>

                    <option value="">
                        Pilih jenis pengajuan
                    </option>

                    <option
                        value="sakit"
                        {{ old('mengajukan') === 'sakit' ? 'selected' : '' }}>
                        Sakit
                    </option>

                    <option
                        value="izin"
                        {{ old('mengajukan') === 'izin' ? 'selected' : '' }}>
                        Izin
                    </option>
                </select>

                @error('mengajukan')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">

                <label for="alasan">
                    Alasan
                </label>

                <textarea
                    id="alasan"
                    name="alasan"
                    class="form-textarea"
                    placeholder="Masukkan alasan pengajuan..."
                >{{ old('alasan') }}</textarea>

                @error('alasan')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">

                <label for="bukti">
                    Bukti (Opsional)
                </label>

                <input
                    type="file"
                    id="bukti"
                    name="bukti"
                    class="form-input"
                    accept="image/png,image/jpeg">
                @error('bukti')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="modal-buttons">
                <button
                    type="button"
                    class="modal-close"
                    onclick="closePengajuanModal()">
                    Batal
                </button>

                <button
                    type="submit"
                    class="modal-submit">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endif


<script>
    function closeAlert() {
        const alert = document.getElementById('alertPopup');

        if (alert) {
            alert.remove();
        }
    }

    setTimeout(() => {
        closeAlert();
    }, 5000);

    function openPengajuanModal() {
        document
            .getElementById('pengajuanModal') 
            .classList.add('active');
    }

    function closePengajuanModal() {
        document
            .getElementById('pengajuanModal')
            .classList.remove('active');
    }

    function showAdminPengajuanDetail(
        user,
        date,
        type,
        reason,
        bukti,
        status
    ) {
        document.getElementById('adminDetailUser').textContent = user;
        document.getElementById('adminDetailDate').textContent = date;
        document.getElementById('adminDetailType').textContent = type;
        document.getElementById('adminDetailReason').textContent = reason;
        document.getElementById('adminDetailStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);

        const proofImage = document.getElementById('adminProofImage');
        const proofLink = document.getElementById('adminProofLink');
        const noProof = document.getElementById('adminNoProof');

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

            noProof.style.display = 'block';
        }

        document
            .getElementById('adminPengajuanDetailModal')
            .classList.add('active');
    }

    function closeAdminPengajuanDetail() {
        document
            .getElementById('adminPengajuanDetailModal')
            .classList.remove('active');
    }

    window.addEventListener('click', function(event) {

        const pengajuanModal =
            document.getElementById('pengajuanModal');

        const adminDetailModal =
            document.getElementById('adminPengajuanDetailModal');

        if (pengajuanModal && event.target === pengajuanModal) {
            closePengajuanModal();
        }

        if (adminDetailModal && event.target === adminDetailModal) {
            closeAdminPengajuanDetail();
        }

    });
</script>
@endsection