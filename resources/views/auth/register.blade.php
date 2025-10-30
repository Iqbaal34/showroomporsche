<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porsche Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/scss/login.scss'])
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('img/login.png') }}" alt="Porsche">
        </div>

        <div class="login-right">
            <h2><br><br>Register</h2>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <label>Full Name</label>
                <input type="text" name="nama" placeholder="Enter your full name" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password" required>

                <label>Phone Number</label>
                <input type="text" name="no_hp" placeholder="Enter your phone number" required>

                <div class="btn-group">
                    <button type="submit" class="btn btn-login">Register</button>
                    <a href="/login" class="btn btn-register">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
