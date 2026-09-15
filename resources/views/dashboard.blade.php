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
            <p>0</p>
        </div>

        <div class="summary-card">
            <h3>Telat</h3>
            <p>0</p>
        </div>

        <div class="summary-card">
            <h3>Sakit</h3>
            <p>0</p>
        </div>

        <div class="summary-card">
            <h3>Izin</h3>
            <p>0</p>
        </div>

    </div>

@endsection