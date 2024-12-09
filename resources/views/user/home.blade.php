<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/home.css') }}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
    <title>Home</title>
</head>
<body>
    
    <div class="fsuu-logo-container">
        <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="University Logo" class="logo">
        <div class="logo-title-container">
            <h1 class="main-title">FSUU</h1>
            <h2 class="subtitle">Father Saturnino Urios University</h2>
        </div>
    </div>

    <div class="teacher-choices-container">
        <form action="{{ route('user/profile') }}" method="GET">
            <label for="teacher_id">Select Teacher:</label>
            <select name="teacher_id" id="teacher_id" class="form-control" onchange="this.form.submit()">
                <option value="">Select a Teacher</option>
                @foreach($allTeachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <a href="{{ route('user') }}">User Profile</a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

        <!-- JavaScript for Auto-Sizing Table Inputs -->
        <script src="{{ asset('js/autosizing.js') }}"></script>
            
        
</body>
</html>