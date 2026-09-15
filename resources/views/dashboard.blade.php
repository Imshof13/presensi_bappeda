<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;

            width: 240px;
            height: 100vh;

            background-color: #ffffff;
            border-right: 1px solid #ddd;

            display: flex;
            flex-direction: column;
        }

        .sidebar-title {
            padding: 25px 20px;

            font-size: 24px;
            font-weight: bold;

            border-bottom: 1px solid #ddd;
        }

        .navigation {
            padding: 15px 10px;
        }

        .navigation a {
            display: block;

            padding: 12px 15px;
            margin-bottom: 5px;

            color: #333;
            text-decoration: none;

            border-radius: 5px;

            font-size: 16px;
        }

        .navigation a:hover {
            background-color: #f0f0f0;
        }

        .navigation a.active {
            background-color: #087cf0;
            color: white;
        }

        /* Logout */
        .sidebar-bottom {
            margin-top: auto;
            padding: 15px 10px;

            border-top: 1px solid #ddd;
        }

        .logout-button {
            width: 100%;

            padding: 12px 15px;

            border: none;
            border-radius: 5px;

            background-color: #ffffff;
            color: #333;

            text-align: left;
            font-size: 16px;

            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #f0f0f0;
        }

        /* Main content */
        .main-content {
            margin-left: 240px;
            padding: 40px;
        }

        .page-title {
            margin: 0 0 10px;

            font-size: 30px;
            font-weight: 400;
        }

        .welcome-text {
            margin-bottom: 30px;

            color: #666;
            font-size: 16px;
        }

        /* Summary cards */
        .summary-container {
            display: flex;
            gap: 20px;

            flex-wrap: wrap;
        }

        .summary-card {
            width: 200px;
            padding: 20px;

            background-color: white;

            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .summary-card h3 {
            margin: 0 0 10px;

            font-size: 15px;
            font-weight: normal;
            color: #666;
        }

        .summary-card p {
            margin: 0;

            font-size: 28px;
            font-weight: bold;
            color: #222;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="sidebar-title">
            Presensi
        </div>

        <nav class="navigation">

            <a href="{{ route('dashboard') }}" class="active">
                Dashboard
            </a>

            <a href="{{ route('presensi') }}">
                Presensi
            </a>

        </nav>

        <div class="sidebar-bottom">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>

        </div>

    </aside>


    <!-- Main Content -->
    <main class="main-content">

        <h1 class="page-title">
            Dashboard
        </h1>

        <p class="welcome-text">
            Welcome, {{ Auth::user()->name }}
        </p>


        <!-- Attendance Summary -->
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

    </main>

</body>
</html>