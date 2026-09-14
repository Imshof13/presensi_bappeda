<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Akun</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
        }

        .register-container {
            width: 650px;
            height: 550px;
            padding: 100px;

            background-color: white;

            border: 1px solid #ddd;
            border-radius: 8px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .register-container h1 {
            text-align: center;

            font-size: 32px;
            font-weight: 400;

            margin: 0 0 30px;
            margin-top: -10px;

            color: #111;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group input {
            width: 100%;
            height: 52px;

            padding: 0 13px;

            font-size: 20px;

            border: 1px solid #ccc;
            border-radius: 3px;

            background-color: #fff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #087cf0;
        }

        .register-button {
            width: 100%;
            height: 52px;

            border: none;
            border-radius: 3px;

            background-color: #087cf0;
            color: white;

            font-size: 19px;
            font-weight: bold;

            cursor: pointer;
        }

        .register-button:hover {
            background-color: #066fd8;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #087cf0;
            text-decoration: none;
            font-size: 17px;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            margin-bottom: 18px;
            padding: 10px 12px;

            color: #b91c1c;
            background-color: #fee2e2;

            border: 1px solid #fecaca;
            border-radius: 4px;

            font-size: 17px;
        }

        .input-error {
            border: 1px solid #dc2626 !important;
        }
    </style>
</head>

<body>

    <div class="register-container">

        <h1>Buat Akun</h1>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <input
                    type="text"
                    name="name"
                    placeholder="Nama"
                    value="{{ old('name') }}"
                    maxlength="255"
                    class="@error('name') input-error @enderror"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <input
                    type="text"
                    name="username"
                    placeholder="Username"  
                    value="{{ old('username') }}"
                    maxlength="255"
                    class="@error('username') input-error @enderror"
                    required
                >

            </div>

            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    maxlength="255"
                    class="@error('password') input-error @enderror"
                    required
                >
            </div>

            <button type="submit" class="register-button">
                Buat Akun
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}"> Masuk
            </a>
        </div>

    </div>

</body>
</html>