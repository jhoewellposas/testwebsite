<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/register.css') }}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box">
            <h1>Register</h1>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div>
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <a href="{{ route('login') }}">Have an exisiting account? Login</a>
        </div>
    </div>
</body>
</html>
