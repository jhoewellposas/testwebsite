<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/user.css') }}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
    <title>User</title>
</head>
<body>
    <h1>Admin Profile</h1>

    <!-- Success Message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Update User Form -->
    <div class="user-profile-container">
        <form action="{{ route('user.update') }}" method="POST">
            @csrf
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div>
                <label for="password">New Password (optional)</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <div class="update-button">
                <button type="submit" class="update">Update Admin</button>
            </div>
        </form>

        <!-- Delete User Form -->
        {{-- <div class="delete-home-container"> --}}
            <div class="delete-home">
                <form action="{{ route('user.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                    @csrf
                    <div class="delete-button">
                        <button type="submit" class="delete">Delete Account</button>
                    </div>
                    <div class="back-home">
                        <a href="{{ route('home') }}" class="btn btn-success">Back to Home</a>
                    </div>
                </form>
            </div>
        {{-- </div> --}}
    </div>
</body>
</html>
