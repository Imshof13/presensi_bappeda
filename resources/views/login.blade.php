<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

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

        .login-container {
            width: 650px;
            height: 550px;
            padding: 100px;

            background-color: white;

            border: 1px solid #ddd;
            border-radius: 8px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .login-container h1 {
            text-align: center;

            font-size: 32px;
            font-weight: 400;

            margin: 0 0 30px;
            margin-top: 20px;

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

        .login-button {
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

        .login-button:hover {
            background-color: #066fd8;
        }

        .create-account {
            text-align: center;
            margin-top: 20px;
        }

        .create-account a {
            color: #087cf0;
            text-decoration: none;
            font-size: 17px;
        }

        .create-account a:hover {
            text-decoration: underline;
        }

        .error-message {
            margin-top: 6px;
            color: #dc2626;
            font-size: 15px;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h1>Login</h1>

        <form method="POST" action="{{ route('login.authenticate') }}">
            @csrf

            <div class="form-group">
                <input
                    type="text"
                    name="username"
                    placeholder="Username"
                    value="{{ old('username') }}"
                    class="@error('username') input-error @enderror"
                    required
                    autofocus
                >
                @error('username')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="@error('password') input-error @enderror"
                    required
                >
                @error('password')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="login-button">
                Masuk
            </button>
        </form>

        <div class="create-account">
            Belum punya akun?
            <a href="{{ route('register') }}"> Buat Akun
            </a>
        </div>

    </div>

</body>
</html>