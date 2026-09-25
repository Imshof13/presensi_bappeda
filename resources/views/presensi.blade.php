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
</style>

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

    window.addEventListener('click', function(event) {

        const modal = document.getElementById('pengajuanModal');
        if (event.target === modal) {
            closePengajuanModal();
        }
    });
</script>
@endsection