<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/scss/login.scss'])
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('img/login.png') }}" alt="Porsche">
        </div>

        <div class="login-right">
            <h2>Login</h2>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Please Input Your Active E-Mail" required>

                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Input Your Username" required>

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Input Your Password" required>

                <div class="btn-group">
                    <button type="submit" class="btn btn-login">Login</button>
                    <a href="/register" class="btn btn-register">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
