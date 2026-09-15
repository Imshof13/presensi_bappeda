<style>
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;

        width: 280px;
        height: 100vh;

        background-color: white;
        border-right: 1px solid #ddd;

        display: flex;
        flex-direction: column;
    }

    .sidebar-title {
        padding: 28px 30px;

        font-size: 28px;
        font-weight: 600;

        border-bottom: 1px solid #ddd;
    }

    .navigation {
        padding: 28px 16px;
    }

    .navigation a {
        display: block;

        padding: 18px 20px;
        margin-bottom: 10px;

        color: #333;
        text-decoration: none;

        border-radius: 7px;

        font-size: 18px;
        font-weight: 500;

        transition: background-color 0.2s, color 0.2s;
    }

    .navigation a:hover {
        background-color: #f0f0f0;
    }

    .navigation a.active {
        background-color: #087cf0;
        color: white;
    }

    .sidebar-bottom {
        margin-top: auto;
        padding: 16px;
    }

    .logout-button {
        width: 100%;

        padding: 18px 20px;

        border: none;
        border-radius: 7px;

        background-color: #dc3545;
        color: white;

        display: flex;
        align-items: center;
        gap: 12px;

        font-family: 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 500;

        cursor: pointer;

        transition: background-color 0.2s;
    }

    .logout-button:hover {
        background-color: #c82333;
    }

</style>

<aside class="sidebar">

    <div class="sidebar-title">
        Presensi
    </div>

    <nav class="navigation">

        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('presensi') }}"
           class="{{ request()->routeIs('presensi') ? 'active' : '' }}">
            Presensi
        </a>

    </nav>

    <div class="sidebar-bottom">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="logout-button">
                <span class="material-symbols-outlined">
                logout</span>
                Logout
            </button>
        </form>

    </div>

</aside>