<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" 
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=logout" />
        
    <title>@yield('title', 'Presensi')</title>

    <style>
        * {
            box-sizing: border-box;
        }

       body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
        }

        .main-content {
            margin-left: 280px;
            padding: 60px 70px;
        }
    </style>
</head>

<body>

    @include('sidebar.sidebar')

    <main class="main-content">
        @yield('content')
    </main>

</body>

</html>