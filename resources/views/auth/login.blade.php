<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/login.css') }}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="head-logo">
            <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="FSUU Logo">
            <h1>FSUU Ranking System</h1>
        </div>
        <div class="login-box">
            <h1>Login</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <a href="{{ route('register') }}">No Account? Register</a>
        </div>
    </div>
</body>
</html>