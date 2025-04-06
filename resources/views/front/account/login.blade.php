<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Central Jaya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #8B1C2D;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background-color: #fff;
            border-radius: 1rem;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }
        .left-panel {
            padding: 3rem;
        }
        .right-panel {
            background-color: #8B1C2D;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #8B1C2D;
        }
        .btn-login {
            background-color: #8B1C2D;
            color: white;
        }
        .btn-login:hover {
            background-color: #a82a3c;
        }
        .form-text a {
            color: #8B1C2D;
            text-decoration: none;
        }
        .invalid-feedback {
            font-size: 0.875em;
            color: red;
        }
    </style>
</head>
<body>

<div class="login-container d-flex flex-column flex-md-row">
    <div class="col-md-6 left-panel">
        <div class="d-flex align-items-center mb-4">
            <img src="/front-assets/images/Logo.png" alt="Logo" style="max-height: 30px; margin-right: 10px;">
            <h3 class="text-danger fw-bold mb-0">Central Jaya Stationery</h3>
        </div>

        <h4 class="mb-3 text-center">Login</h4>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        <form action="{{ route('account.authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-text">
                <a href="{{ route('front.forgotPassword') }}">Lupa password kamu?</a>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login">Login</button>
            </div>
        </form>

        <div class="mt-4 text-center form-text">
            Belum punya akun? <a href="{{ route('account.register') }}">Buat akun dulu, yuk!</a>
        </div>
    </div>

    <div class="col-md-6 right-panel text-center">
        <div>
            <h2 class="fw-bold">Welcome Back!</h2>
            <p>to keep connected with us please login<br>with your personal info</p>
        </div>
    </div>
</div>

</body>
</html>
