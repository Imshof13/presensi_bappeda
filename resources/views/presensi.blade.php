@extends('layout.app')

@section('title', 'Presensi')

@section('content')

<style>
    .presensi-title {
        margin: 0 0 8px;
        font-size: 36px;
        font-weight: 600;
    }

    .presensi-date {
        margin: 0 0 35px;
        color: #666;
        font-size: 17px;
    }

    .presensi-card {
        max-width: 700px;
        padding: 30px;

        background-color: white;

        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .attendance-status {
        margin-bottom: 25px;
    }

    .attendance-status p {
        margin: 8px 0;
        font-size: 16px;
    }

    .attendance-actions {
        display: flex;
        gap: 15px;
    }

    .attendance-button {
        padding: 14px 24px;

        border: none;
        border-radius: 7px;

        background-color: #9915da;
        color: white;

        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;

        cursor: pointer;
    }

    .attendance-button:disabled {
        background-color: #ccc;
        color: #777;
        cursor: not-allowed;
    }

    .message {
        margin-bottom: 20px;
        padding: 12px 16px;

        border-radius: 7px;
    }

    .message-success {
        background-color: #e7f7ed;
        color: #218838;
    }

    .message-error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<h1 class="presensi-title">
    Presensi
</h1>

<p class="presensi-date">
    {{ now()->translatedFormat('l, d F Y') }}
</p>

@if(session('success'))
    <div class="message message-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="message message-error">
        {{ session('error') }}
    </div>
@endif

<div class="presensi-card">
    <div class="attendance-status">
        <h2>Status Presensi Hari Ini</h2>

        @if($presensi)
            <p>
                <strong>Masuk:</strong>
                {{ $presensi->check_in
                    ? $presensi->check_in->format('H:i')
                    : '-'
                }}
            </p>

            <p>
                <strong>Pulang:</strong>
                {{ $presensi->check_out
                    ? $presensi->check_out->format('H:i')
                    : '-'
                }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ $presensi->status
                    ? ucfirst($presensi->status)
                    : '-'
                }}
            </p>

            <p>
                <strong>Keterangan:</strong>
                {{ $presensi->note ?? '-' }}
            </p>
        @else
            <p>
                Anda belum melakukan presensi hari ini.
            </p>
        @endif
    </div>

    <div class="attendance-actions">
        <form
            method="POST"
            action="{{ route('presensi.checkIn') }}">
            @csrf

            <button
                type="submit"
                class="attendance-button"
                {{ $presensi ? 'disabled' : '' }}>
                Presensi Masuk
            </button>
        </form>

        <form
            method="POST"
            action="{{ route('presensi.checkOut') }}">
            @csrf

            <button
                type="submit"
                class="attendance-button"
                {{ !$presensi || $presensi->check_out ? 'disabled' : '' }}>
                Presensi Pulang
            </button>
        </form>
    </div>
</div>
@endsection