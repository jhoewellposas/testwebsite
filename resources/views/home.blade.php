<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/home.css') }}">
    <title>Home</title>
</head>
<body>
    
    <div class="fsuu-logo-container">
        <header class="site-header">
            <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="University Logo" class="logo">
            <h2 class="site-title">Father Saturnino Urios University</h2>
        </header>
    </div>

    <div class="create-teacher-container">
        <form action="{{ route('teachers.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="acad_attainment" class="form-label">Academic Attainment</label>
                <input type="text" class="form-control" id="acad_attainment" name="acad_attainment">
            </div>
            <div class="mb-3">
                <label for="performance" class="form-label">Performance</label>
                <input type="number" step="0.1" class="form-control" id="performance" name="performance">
            </div>
            <div class="mb-3">
                <label for="experience" class="form-label">Experience</label>
                <input type="text" class="form-control" id="experience" name="experience">
            </div>
            <button type="submit" class="btn btn-primary">Add Teacher</button>
        </form>
    </div>

    <div class="teacher-choices-container">
        <form action="{{ route('profile') }}" method="GET">
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


        <!-- JavaScript for Auto-Sizing Table Inputs -->
        <script src="{{ asset('js/autosizing.js') }}"></script>
            
</body>
</html>