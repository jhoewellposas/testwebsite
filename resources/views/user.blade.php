<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>
<body>
    <h1>User Profile</h1>

    <!-- Success Message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Update User Form -->
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
        <button type="submit">Update User</button>
    </form>

    <hr>

    <!-- Delete User Form -->
    <form action="{{ route('user.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
        @csrf
        <button type="submit" style="color: red;">Delete Account</button>
    </form>

    <a href="{{ route('home') }}">Back to Home</a>
</body>
</html>
