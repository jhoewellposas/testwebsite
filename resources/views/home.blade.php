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

    <div class="create-teacher-container">
        <form action="{{ route('teachers.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="acad_attainment" class="form-label">Highest Academic Attainment</label>
                <input type="text" class="form-control" id="acad_attainment" name="acad_attainment" required>
            </div>
            <div class="mb-3">
                <label for="date">Date Hired</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="office">Office</label>
                <input type="text" class="form-control" id="office" name="office" required>
            </div>
            <div class="mb-3">
                <label for="performance" class="form-label">Performance</label>
                <input type="number" step="0.1" class="form-control" id="performance" name="performance" required>
            </div>
            <div class="mb-3">
                <label for="experience" class="form-label">Experience</label> 
                
                <select name="experience" id="experience">
                    <option value="">Select Experience</option>
                    <option value="0.83">1 Year</option>
                    <option value="1.666">2 Years</option>
                    <option value="2.499">3 Years</option>
                    <option value="3.332">4 Years</option>
                    <option value="4.165">5 Years</option>
                    <option value="4.998">6 Years</option>
                    <option value="5.831">7 Years</option>
                    <option value="6.664">8 Years</option>
                    <option value="7.497">9 Years</option>
                    <option value="8.33">10 Years</option>
                    <option value="9.163">11 Years</option>
                    <option value="10.00">12 Years</option>
                </select>
                
            </div>
            <div class="submit-button">
                <button type="submit" class="btn btn-primary">Add Teacher</button>
            </div>
        </form>
    </div>

    <div class="teacher-choices-container">
        <form action="{{ route('profile') }}" method="GET">
            <label for="teahcer_id">Select Teacher:</label>
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

    <div class="user-logout-container">
        <button class="user-logout-button">Admin Options</button>
    </div>

    <div class="popup-window">
        <button class="close-btn">&times;</button>
        <div class="popup-content">
            <div class="rank-distribution">
                <a href="{{ route('rankDistributions.index') }}" class="btn-success-2">Rank Distributions</a>
            </div>
            <div class="user-info">
                <a href="{{ route('user') }}" class="btn btn-success">Admin Profile</a>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="third-btn">Logout</button>
            </form>
        </div>
    </div>

        <!-- JavaScript for Auto-Sizing Table Inputs -->
        {{-- <script src="{{ asset('js/autosizing.js') }}"></script> --}}
        <script src="{{ asset('javascript/option.js') }}"></script>
            
        
</body>
</html>