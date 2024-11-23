<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/profile.css') }}">

    <title>Profile</title>
</head>
<body>
    <div class="fsuu-logo-container">
        <header class="site-header">
            <img src="{{ asset('FSUU Logo/fsuu2_1.png')}}" alt="University Logo" class="logo">
            <h2 class="site-title">Father Saturnino Urios University</h2>
        </header>
    </div>

    <h1>Teacher Profile</h1>

    <div class="teacher-table-info">
        <div class="teacher-info">
       <!-- Display Teacher's Information -->
       <form action="{{ route('teachers.update', ['id' => $selectedTeacher->id]) }}" method="post">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $selectedTeacher->name }}" required>
        </div>
        <div>
            <label for="acad_attainment">Academic Attainment:</label>
            <input type="text" name="acad_attainment" id="acad_attainment" value="{{ $selectedTeacher->acad_attainment }}" required>
        </div>
        <div>
            <label for="performance">Performance:</label>
            <input type="number" step="0.01" name="performance" id="performance" value="{{ $selectedTeacher->performance }}">
        </div>
        <div>
            <label for="experience">Experience:</label>
            <input type="text" name="experience" id="experience" value="{{ $selectedTeacher->experience }}" required>
        </div>
        <div>
            <label for="rank">Present Rank:</label>
            <select name="rank" id="rank">
                <option value="">Select Rank</option>
                <option value="Teacher 1" {{ $selectedTeacher->rank == 'Teacher 1' ? 'selected' : '' }}>Teacher 1</option>
                <option value="Teacher 2" {{ $selectedTeacher->rank == 'Teacher 2' ? 'selected' : '' }}>Teacher 2</option>
                <option value="Teacher 3" {{ $selectedTeacher->rank == 'Teacher 3' ? 'selected' : '' }}>Teacher 3</option>
                <option value="Teacher 4" {{ $selectedTeacher->rank == 'Teacher 4' ? 'selected' : '' }}>Teacher 4</option>
                <option value="Teacher 5" {{ $selectedTeacher->rank == 'Teacher 5' ? 'selected' : '' }}>Teacher 5</option>
                <option value="Senior Teacher 1" {{ $selectedTeacher->rank == 'Senior Teacher 1' ? 'selected' : '' }}>Senior Teacher 1</option>
                <option value="Senior Teacher 2" {{ $selectedTeacher->rank == 'Senior Teacher 2' ? 'selected' : '' }}>Senior Teacher 2</option>
                <option value="Senior Teacher 3" {{ $selectedTeacher->rank == 'Senior Teacher 3' ? 'selected' : '' }}>Senior Teacher 3</option>
                <option value="Senior Teacher 4" {{ $selectedTeacher->rank == 'Senior Teacher 4' ? 'selected' : '' }}>Senior Teacher 4</option>
                <option value="Senior Teacher 5" {{ $selectedTeacher->rank == 'Senior Teacher 5' ? 'selected' : '' }}>Senior Teacher 5</option>
                <option value="Master Teacher 1" {{ $selectedTeacher->rank == 'Master Teacher 1' ? 'selected' : '' }}>Master Teacher 1</option>
                <option value="Master Teacher 2" {{ $selectedTeacher->rank == 'Master Teacher 2' ? 'selected' : '' }}>Master Teacher 2</option>
                <option value="Master Teacher 3" {{ $selectedTeacher->rank == 'Master Teacher 3' ? 'selected' : '' }}>Master Teacher 3</option>
                <option value="Master Teacher 4" {{ $selectedTeacher->rank == 'Master Teacher 4' ? 'selected' : '' }}>Master Teacher 4</option>
                <option value="Master Teacher 5" {{ $selectedTeacher->rank == 'Master Teacher 5' ? 'selected' : '' }}>Master Teacher 5</option>
            </select>
        </div>
        <button type="submit">Update</button>
    </form>
    </div>
</div>

    <div class="text-upload-search-container">

        {{-- Home Button --}}
        <div class="home-button">
            <a href="{{ url('/home') }}" class="btn btn-success">Home</a>
        </div>

        <!-- Upload -->
        <div class="upload-button">
            <a href="{{ route('certificate.upload', ['teacher_id' => $teacher_id]) }}" class="btn btn-success">Upload New Certificate</a>
        </div>
        

        <!-- Search area -->
    <form action="{{ route('profile') }}" method="GET" class="mb-4">
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
            @forelse ($allCertificates as $certificate)
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
                    <td><button type="button" class="btn btn-info ocr-result-btn" data-ocr="{{ $certificate->raw_text }}">View OCR Output</button></td>
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
            @empty
            <tr>
                <td colspan="12">No certificates found for the selected teacher.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mb-4 view-summary">
    <a href="{{ route('summary', ['teacherId' => $teacher_id]) }}" class="btn btn-secondary">View Summary</a>
</div>
    <!-- JavaScript for Auto-Sizing Table Inputs -->
    <script src="{{ asset('javascript/autosizing.js') }}"></script>
    <script src="{{ asset('javascript/popupwindow.js') }}"></script>
</body>
</html>