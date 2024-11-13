<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/home.css') }}">
    <title>Home</title>
</head>
<body>
    
    <div class="header">
        <header class="site-header">
            <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="University Logo" class="logo">
            <h2 class="site-title">Father Saturnino Urios University</h2>
        </header>
    </div>

    <form action="{{ route('teachers.create') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $selectedTeacher ? $selectedTeacher->name : '' }}" required>
        </div>

        <div class="mb-3">
            <label for="acad_attainment" class="form-label">A. Academic Attainment and Growth</label>
            <input type="text" class="form-control" id="acad_attainment" name="acad_attainment" value="{{ $selectedTeacher ? $selectedTeacher->acad_attainment : '' }}">
        </div>

        <div class="mb-3">
            <label for="performance" class="form-label">B. Performance</label>
            <input type="text" step="0.1" class="form-control" id="performance" name="performance" value="{{ $selectedTeacher ? $selectedTeacher->performance : '' }}" placeholder="Enter performance score">
        </div>

        <div class="mb-3">
            <label for="experience" class="form-label">D. Experience</label>
            <input type="text" class="form-control" id="experience" name="experience" value="{{ $selectedTeacher ? $selectedTeacher->experience : '' }}" placeholder="Enter experience score">
        </div>

        <button type="submit" class="btn btn-primary">Add Teacher</button>
    </form>

    <!-- Teacher Selection Dropdown for Populating Form -->
    <div>
        <form action="{{ route('home') }}" method="GET" class="mb-4">
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

    <h1>Certificates Table:</h1>

    <div class="upload-search-container">

        <!-- Upload -->
    <div class="upload-button">
        <a href="{{ url('/upload') }}" class="btn btn-success">Upload New Certificate</a>
    </div>

    <!-- Home -->
    <form action="{{ route('home') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="query" class="form-control" placeholder="Search..." value="{{ request('query') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
    

    <!-- Certificates Table Container with Scroll -->
    <div class="table-container">
        <table class="table" border="1">
            <thead>
                <tr>
                    <th>Certificate ID:</th>
                    <th>Category</th>
                    <th>Type:</th>
                    <th>Name:</th>
                    <th>Title:</th>
                    <th>Organization:</th>
                    <th>Designation:</th>
                    <th>Sponsor:</th>
                    <th>Date:</th>
                    <th>OCR Output:</th>
                    <th>Points:</th>
                    <th>Actions:</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allCertificates as $certificate)
                <tr>
                    <form action="{{ route('certificate.update', $certificate->id) }}" method="POST">
                        @csrf
                        <td>{{ $certificate->id }}</td>
                        <td>
                            <select name="category" id="category">
                                <option value="">Select a Category</option>
                                <option value="seminar" {{ $certificate->category == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="honors_awards" {{ $certificate->category == 'honors_awards' ? 'selected' : '' }}>Honors and Awards</option>
                                <option value="membership" {{ $certificate->category == 'membership' ? 'selected' : '' }}>Membership</option>
                                <option value="scholarship_activities" {{ $certificate->category == 'scholarship_activities' ? 'selected' : '' }}>Scholarship Activities and Creative Efforts</option>
                                <option value="service_students" {{ $certificate->category == 'service_students' ? 'selected' : '' }}>Service to Students</option>
                                <option value="service_department" {{ $certificate->category == 'service_department' ? 'selected' : '' }}>Service to Department</option>
                                <option value="service_institution" {{ $certificate->category == 'service_institution' ? 'selected' : '' }}>Service to Institution</option>
                                <option value="participation_organizations" {{ $certificate->category == 'participation_organizations' ? 'selected' : '' }}>Active Participation in Different Organizations</option>
                                <option value="involvement_department" {{ $certificate->category == 'involvement_department' ? 'selected' : '' }}>Active Involvement in Department/School Sponsored CES</option>
                            </select>
                        </td>
                        <td><input type="text" name="type" value="{{ $certificate->type }}"></td>
                        <td><input type="text" name="name" value="{{ $certificate->name }}"></td>
                        <td><input type="text" name="title" value="{{ $certificate->title }}"></td>
                        <td><input type="text" name="organization" value="{{ $certificate->organization }}"></td>
                        <td><input type="text" name="designation" value="{{ $certificate->designation }}"></td>
                        <td><input type="text" name="sponsor" value="{{ $certificate->sponsor }}"></td>
                        <td><input type="text" name="date" value="{{ $certificate->date }}"></td>
                        <td><textarea name="raw_text">{{ $certificate->raw_text }}</textarea></td>
                        <td><input type="text" name="points" value="{{ $certificate->points }}"></td>
                        <td>
                            <button type="submit">Update</button>
                    </form>
                    <form action="{{ route('certificate.delete', $certificate->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4 view-summary">
        <a href="{{ route('summary', ['teacherId' => $teacher->id]) }}" class="btn btn-secondary">View Summary</a>
    </div>

    <!-- JavaScript for Auto-Sizing Table Inputs -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to resize input fields based on content
            function autoSizeInput(input) {
                input.style.width = "auto"; // Reset width
                input.style.width = (input.scrollWidth + 2) + "px"; // Set to content width with slight padding
            }

            // Select only text inputs in the table
            const tableInputs = document.querySelectorAll(".table input[type='text']");
            
            // Initial size adjustment and event listener for each input
            tableInputs.forEach(input => {
                autoSizeInput(input); // Initial sizing based on content
                input.addEventListener("input", function() {
                    autoSizeInput(input); // Resize on input
                });
            });
        });
    </script>
</body>
</html>
