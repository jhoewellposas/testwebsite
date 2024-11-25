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
        <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="University Logo" class="logo">
        <div class="logo-title-container">
            <h1 class="main-title">FSUU</h1>
            <h2 class="subtitle">Father Saturnino Urios University</h2>
        </div>
    </div>


    <div class="teacher-table-info">
        <div class="teacher-info">
            <h1>Teacher Profile</h1>
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
            <label for="date">Date Hired:</label>
            <input type="date" name="date" id="date" value="{{ $selectedTeacher->date }}">
        </div>
        <div>
            <label for="office">Office:</label>
            <input type="text" name="office" id="office" value="{{ $selectedTeacher->office }}">
        </div>
        <div>
            <label for="performance">Performance:</label>
            <input type="number" step="0.01" name="performance" id="performance" value="{{ $selectedTeacher->performance }}">
        </div>
        <div>
            <label for="experience">Experience:</label>
            <input type="text" name="experience" id="experience" value="{{ $selectedTeacher->experience }}" required>
            <select name="experience" id="experience">
                <option value="">Select Experience</option>
                <option value="0.83" {{ $selectedTeacher->experience == '0.83' ? 'selected' : '' }}>1 Year</option>
                <option value="1.666" {{ $selectedTeacher->experience == '1.666' ? 'selected' : '' }}>2 Years</option>
                <option value="2.499" {{ $selectedTeacher->experience == '2.499' ? 'selected' : '' }}>3 Years</option>
                <option value="3.332" {{ $selectedTeacher->experience == '3.332' ? 'selected' : '' }}>4 Years</option>
                <option value="4.165" {{ $selectedTeacher->experience == '4.165' ? 'selected' : '' }}>5 Years</option>
                <option value="4.998" {{ $selectedTeacher->experience == '4.998' ? 'selected' : '' }}>6 Years</option>
                <option value="5.831" {{ $selectedTeacher->experience == '5.831' ? 'selected' : '' }}>7 Years</option>
                <option value="6.664" {{ $selectedTeacher->experience == '6.664' ? 'selected' : '' }}>8 Years</option>
                <option value="7.497" {{ $selectedTeacher->experience == '7.497' ? 'selected' : '' }}>9 Years</option>
                <option value="8.33" {{ $selectedTeacher->experience == '8.33' ? 'selected' : '' }}>10 Years</option>
                <option value="9.163" {{ $selectedTeacher->experience == '9.163' ? 'selected' : '' }}>11 Years</option>
                <option value="10.00" {{ $selectedTeacher->experience == '10.00' ? 'selected' : '' }}>12 Years</option>
            </select>
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
                <option value="Lecturer 1" {{ $selectedTeacher->rank == 'Lecturer 1' ? 'selected' : '' }}>Lecturer 1</option>
                <option value="Lecturer 2" {{ $selectedTeacher->rank == 'Lecturer 2' ? 'selected' : '' }}>Lecturer 2</option>
                <option value="Lecturer 3" {{ $selectedTeacher->rank == 'Lecturer 3' ? 'selected' : '' }}>Lecturer 3</option>
                <option value="Assistant Instructor" {{ $selectedTeacher->rank == 'Assistant Instructor' ? 'selected' : '' }}>Assistant Instructor</option>
                <option value="Instructor 1" {{ $selectedTeacher->rank == 'Instructor 1' ? 'selected' : '' }}>Instructor 1</option>
                <option value="Instructor 2" {{ $selectedTeacher->rank == 'Instructor 2' ? 'selected' : '' }}>Instructor 2</option>
                <option value="Instructor 3" {{ $selectedTeacher->rank == 'Instructor 3' ? 'selected' : '' }}>Instructor 3</option>
                <option value="Assistant Professor 1" {{ $selectedTeacher->rank == 'Assistant Professor 1' ? 'selected' : '' }}>Assistant Professor 1</option>
                <option value="Assistant Professor 2" {{ $selectedTeacher->rank == 'Assistant Professor 2' ? 'selected' : '' }}>Assistant Professor 2</option>
                <option value="Associate Professor 1" {{ $selectedTeacher->rank == 'Associate Professor 1' ? 'selected' : '' }}>Associate Professor 1</option>
                <option value="Associate Professor 2" {{ $selectedTeacher->rank == 'Associate Professor 2' ? 'selected' : '' }}>Associate Professor 2</option>
                <option value="Full Professor 1" {{ $selectedTeacher->rank == 'Full Professor 1' ? 'selected' : '' }}>Full Professor 1</option>
                <option value="Full Professor 2" {{ $selectedTeacher->rank == 'Full Professor 2' ? 'selected' : '' }}>Full Professor 2</option>
                <option value="Full Professor 3" {{ $selectedTeacher->rank == 'Full Professor 3' ? 'selected' : '' }}>Full Professor 3</option>
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
            <input type="hidden" name="teacher_id" value="{{ $teacher_id }}">
            <input type="text" name="query" class="form-control" placeholder="Search..." value="{{ request('query') }}">
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