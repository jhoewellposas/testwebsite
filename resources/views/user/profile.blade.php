<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/profile.css') }}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
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

        <div class="home-summary-container">
            {{-- Home Button --}}
            <div class="home-button">
                <a href="{{ url('/home') }}" class="btn btn-success">Home</a>
            </div>

            <div class="mb-4 view-summary">
                <a href="{{ route('summary', ['teacherId' => $teacher_id]) }}" class="btn btn-secondary">View Summary</a>
            </div>
        </div>

        <div class="teacher-table-info">
            <div class="teacher-info">
                <h1>PROFILE</h1>
        <!-- Display Teacher's Information -->
        <form action="{{ route('teachers.update', ['id' => $selectedTeacher->id]) }}" method="post">
            @csrf
            <div>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="{{ $selectedTeacher->name }}" required>
            </div>
            <div>
                <label for="acad_attainment">Highest Academic Attainment</label>
                <input type="text" name="acad_attainment" id="acad_attainment" value="{{ $selectedTeacher->acad_attainment }}" required>
            </div>
            <div>
                <label for="date">Date Hired</label>
                <input type="date" name="date" id="date" value="{{ $selectedTeacher->date }}">
            </div>
            <div>
                <label for="office">Office</label>
                <input type="text" name="office" id="office" value="{{ $selectedTeacher->office }}">
            </div>
            <div>
                <label for="performance">Performance</label>
                <input type="number" step="0.01" name="performance" id="performance" value="{{ $selectedTeacher->performance }}">
            </div>
            <div class="side-to-side">
                <label for="experience">Experience</label>
                <select name="experience" id="select-experience">
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
                <label for="present_rank">Present Rank</label>
                <select name="present_rank" id="present_rank">
                    <option value="Unranked" {{ $selectedTeacher->present_rank == 'Unranked' ? 'selected' : '' }}>Unranked</option>
                    <optgroup label="Basic Education Ranks">
                    <option value="Teacher 1" {{ $selectedTeacher->present_rank == 'Teacher 1' ? 'selected' : '' }}>Teacher 1</option>
                    <option value="Teacher 2" {{ $selectedTeacher->present_rank == 'Teacher 2' ? 'selected' : '' }}>Teacher 2</option>
                    <option value="Teacher 3" {{ $selectedTeacher->present_rank == 'Teacher 3' ? 'selected' : '' }}>Teacher 3</option>
                    <option value="Teacher 4" {{ $selectedTeacher->present_rank == 'Teacher 4' ? 'selected' : '' }}>Teacher 4</option>
                    <option value="Teacher 5" {{ $selectedTeacher->present_rank == 'Teacher 5' ? 'selected' : '' }}>Teacher 5</option>
                    <option value="Senior Teacher 1" {{ $selectedTeacher->present_rank == 'Senior Teacher 1' ? 'selected' : '' }}>Senior Teacher 1</option>
                    <option value="Senior Teacher 2" {{ $selectedTeacher->present_rank == 'Senior Teacher 2' ? 'selected' : '' }}>Senior Teacher 2</option>
                    <option value="Senior Teacher 3" {{ $selectedTeacher->present_rank == 'Senior Teacher 3' ? 'selected' : '' }}>Senior Teacher 3</option>
                    <option value="Senior Teacher 4" {{ $selectedTeacher->present_rank == 'Senior Teacher 4' ? 'selected' : '' }}>Senior Teacher 4</option>
                    <option value="Senior Teacher 5" {{ $selectedTeacher->present_rank == 'Senior Teacher 5' ? 'selected' : '' }}>Senior Teacher 5</option>
                    <option value="Master Teacher 1" {{ $selectedTeacher->present_rank == 'Master Teacher 1' ? 'selected' : '' }}>Master Teacher 1</option>
                    <option value="Master Teacher 2" {{ $selectedTeacher->present_rank == 'Master Teacher 2' ? 'selected' : '' }}>Master Teacher 2</option>
                    <option value="Master Teacher 3" {{ $selectedTeacher->present_rank == 'Master Teacher 3' ? 'selected' : '' }}>Master Teacher 3</option>
                    <option value="Master Teacher 4" {{ $selectedTeacher->present_rank == 'Master Teacher 4' ? 'selected' : '' }}>Master Teacher 4</option>
                    </optgroup>
                    <optgroup label="Higher Education Ranks">
                    <option value="Lecturer 1" {{ $selectedTeacher->present_rank == 'Lecturer 1' ? 'selected' : '' }}>Lecturer 1</option>
                    <option value="Lecturer 2" {{ $selectedTeacher->present_rank == 'Lecturer 2' ? 'selected' : '' }}>Lecturer 2</option>
                    <option value="Lecturer 3" {{ $selectedTeacher->present_rank == 'Lecturer 3' ? 'selected' : '' }}>Lecturer 3</option>
                    <option value="Assistant Instructor" {{ $selectedTeacher->present_rank == 'Assistant Instructor' ? 'selected' : '' }}>Assistant Instructor</option>
                    <option value="Instructor 1" {{ $selectedTeacher->present_rank == 'Instructor 1' ? 'selected' : '' }}>Instructor 1</option>
                    <option value="Instructor 2" {{ $selectedTeacher->present_rank == 'Instructor 2' ? 'selected' : '' }}>Instructor 2</option>
                    <option value="Instructor 3" {{ $selectedTeacher->present_rank == 'Instructor 3' ? 'selected' : '' }}>Instructor 3</option>
                    <option value="Assistant Professor 1" {{ $selectedTeacher->present_rank == 'Assistant Professor 1' ? 'selected' : '' }}>Assistant Professor 1</option>
                    <option value="Assistant Professor 2" {{ $selectedTeacher->present_rank == 'Assistant Professor 2' ? 'selected' : '' }}>Assistant Professor 2</option>
                    <option value="Associate Professor 1" {{ $selectedTeacher->present_rank == 'Associate Professor 1' ? 'selected' : '' }}>Associate Professor 1</option>
                    <option value="Associate Professor 2" {{ $selectedTeacher->present_rank == 'Associate Professor 2' ? 'selected' : '' }}>Associate Professor 2</option>
                    <option value="Full Professor 1" {{ $selectedTeacher->present_rank == 'Full Professor 1' ? 'selected' : '' }}>Full Professor 1</option>
                    <option value="Full Professor 2" {{ $selectedTeacher->present_rank == 'Full Professor 2' ? 'selected' : '' }}>Full Professor 2</option>
                    <option value="Full Professor 3" {{ $selectedTeacher->present_rank == 'Full Professor 3' ? 'selected' : '' }}>Full Professor 3</option>
                    </optgroup>
                </select>
            </div>

            <div class="requirement-table grid-item">
                <table class="table-rank" border="1">
                    <thead>
                        <tr>
                            <th>Next Rank</th>
                            <th>Requirements</th>
                        </tr>
                    </thead>
                <tr>
                <td>
                <select name="next_rank" id="next_rank">
                    <option value="">Select Rank</option>
                    <optgroup label="Basic Education Ranks">
                    <option value="Teacher 1" {{ $selectedTeacher->next_rank == 'Teacher 1' ? 'selected' : '' }}>Teacher 1</option>
                    <option value="Teacher 1 SQ" {{ $selectedTeacher->next_rank == 'Teacher 1 SQ' ? 'selected' : '' }}>Teacher 1 SQ</option>
                    <option value="Teacher 2" {{ $selectedTeacher->next_rank == 'Teacher 2' ? 'selected' : '' }}>Teacher 2</option>
                    <option value="Teacher 2 SQ" {{ $selectedTeacher->next_rank == 'Teacher 2 SQ' ? 'selected' : '' }}>Teacher 2 SQ</option>
                    <option value="Teacher 3" {{ $selectedTeacher->next_rank == 'Teacher 3' ? 'selected' : '' }}>Teacher 3</option>
                    <option value="Teacher 3 SQ" {{ $selectedTeacher->next_rank == 'Teacher 3 SQ' ? 'selected' : '' }}>Teacher 3 SQ</option>
                    <option value="Teacher 4" {{ $selectedTeacher->next_rank == 'Teacher 4' ? 'selected' : '' }}>Teacher 4</option>
                    <option value="Teacher 4 SQ" {{ $selectedTeacher->next_rank == 'Teacher 4 SQ' ? 'selected' : '' }}>Teacher 4 SQ</option>
                    <option value="Teacher 5" {{ $selectedTeacher->next_rank == 'Teacher 5' ? 'selected' : '' }}>Teacher 5</option>
                    <option value="Teacher 5 SQ" {{ $selectedTeacher->next_rank == 'Teacher 5 SQ' ? 'selected' : '' }}>Teacher 5 SQ</option>
                    <option value="Senior Teacher 1" {{ $selectedTeacher->next_rank == 'Senior Teacher 1' ? 'selected' : '' }}>Senior Teacher 1</option>
                    <option value="Senior Teacher 1 SQ" {{ $selectedTeacher->next_rank == 'Senior Teacher 1 SQ' ? 'selected' : '' }}>Senior Teacher SQ</option>
                    <option value="Senior Teacher 2" {{ $selectedTeacher->next_rank == 'Senior Teacher 2' ? 'selected' : '' }}>Senior Teacher 2</option>
                    <option value="Senior Teacher 2 SQ" {{ $selectedTeacher->next_rank == 'Senior Teacher 2 SQ' ? 'selected' : '' }}>Senior Teacher 2 SQ</option>
                    <option value="Senior Teacher 3" {{ $selectedTeacher->next_rank == 'Senior Teacher 3' ? 'selected' : '' }}>Senior Teacher 3</option>
                    <option value="Senior Teacher 3 SQ" {{ $selectedTeacher->next_rank == 'Senior Teacher 3 SQ' ? 'selected' : '' }}>Senior Teacher 3 SQ</option>
                    <option value="Senior Teacher 4" {{ $selectedTeacher->next_rank == 'Senior Teacher 4' ? 'selected' : '' }}>Senior Teacher 4</option>
                    <option value="Senior Teacher 4 SQ" {{ $selectedTeacher->next_rank == 'Senior Teacher 4 SQ' ? 'selected' : '' }}>Senior Teacher 4 SQ</option>
                    <option value="Senior Teacher 5" {{ $selectedTeacher->next_rank == 'Senior Teacher 5' ? 'selected' : '' }}>Senior Teacher 5</option>
                    <option value="Senior Teacher 5 SQ" {{ $selectedTeacher->next_rank == 'Senior Teacher 5 SQ' ? 'selected' : '' }}>Senior Teacher 5 SQ</option>
                    <option value="Master Teacher 1" {{ $selectedTeacher->next_rank == 'Master Teacher 1' ? 'selected' : '' }}>Master Teacher 1</option>
                    <option value="Master Teacher 1 SQ" {{ $selectedTeacher->next_rank == 'Master Teacher 1 SQ' ? 'selected' : '' }}>Master Teacher 1 SQ</option>
                    <option value="Master Teacher 2" {{ $selectedTeacher->next_rank == 'Master Teacher 2' ? 'selected' : '' }}>Master Teacher 2</option>
                    <option value="Master Teacher 2 SQ" {{ $selectedTeacher->next_rank == 'Master Teacher 2 SQ' ? 'selected' : '' }}>Master Teacher 2 SQ</option>
                    <option value="Master Teacher 3" {{ $selectedTeacher->next_rank == 'Master Teacher 3' ? 'selected' : '' }}>Master Teacher 3</option>
                    <option value="Master Teacher 3 SQ" {{ $selectedTeacher->next_rank == 'Master Teacher 3 SQ' ? 'selected' : '' }}>Master Teacher 3 SQ</option>
                    <option value="Master Teacher 4" {{ $selectedTeacher->next_rank == 'Master Teacher 4' ? 'selected' : '' }}>Master Teacher 4</option>
                    <option value="Master Teacher 4 SQ" {{ $selectedTeacher->next_rank == 'Master Teacher 4 SQ' ? 'selected' : '' }}>Master Teacher 4 SQ</option>
                    </optgroup>
                    <optgroup label="Higher Education Ranks">
                    <option value="Lecturer 1" {{ $selectedTeacher->next_rank == 'Lecturer 1' ? 'selected' : '' }}>Lecturer 1</option>
                    <option value="Lecturer 1 SQ" {{ $selectedTeacher->next_rank == 'Lecturer 1 SQ' ? 'selected' : '' }}>Lecturer 1 SQ</option>
                    <option value="Lecturer 2" {{ $selectedTeacher->next_rank == 'Lecturer 2' ? 'selected' : '' }}>Lecturer 2</option>
                    <option value="Lecturer 2 SQ" {{ $selectedTeacher->next_rank == 'Lecturer 2 SQ' ? 'selected' : '' }}>Lecturer 2 SQ</option>
                    <option value="Lecturer 3" {{ $selectedTeacher->next_rank == 'Lecturer 3' ? 'selected' : '' }}>Lecturer 3</option>
                    <option value="Lecturer 3 SQ" {{ $selectedTeacher->next_rank == 'Lecturer 3 SQ' ? 'selected' : '' }}>Lecturer 3 SQ</option>
                    <option value="Assistant Instructor" {{ $selectedTeacher->next_rank == 'Assistant Instructor' ? 'selected' : '' }}>Assistant Instructor</option>
                    <option value="Assistant Instructor SQ" {{ $selectedTeacher->next_rank == 'Assistant Instructor SQ' ? 'selected' : '' }}>Assistant Instructor SQ</option>
                    <option value="Instructor 1" {{ $selectedTeacher->next_rank == 'Instructor 1' ? 'selected' : '' }}>Instructor 1</option>
                    <option value="Instructor 1 SQ" {{ $selectedTeacher->next_rank == 'Instructor 1 SQ' ? 'selected' : '' }}>Instructor 1 SQ</option>
                    <option value="Instructor 2" {{ $selectedTeacher->next_rank == 'Instructor 2' ? 'selected' : '' }}>Instructor 2</option>
                    <option value="Instructor 2 SQ" {{ $selectedTeacher->next_rank == 'Instructor 2 SQ' ? 'selected' : '' }}>Instructor 2 SQ</option>
                    <option value="Instructor 3" {{ $selectedTeacher->next_rank == 'Instructor 3' ? 'selected' : '' }}>Instructor 3</option>
                    <option value="Instructor 3 SQ" {{ $selectedTeacher->next_rank == 'Instructor 3 SQ' ? 'selected' : '' }}>Instructor 3 SQ</option>
                    <option value="Assistant Professor 1" {{ $selectedTeacher->next_rank == 'Assistant Professor 1' ? 'selected' : '' }}>Assistant Professor 1</option>
                    <option value="Assistant Professor 1 SQ" {{ $selectedTeacher->next_rank == 'Assistant Professor 1 SQ' ? 'selected' : '' }}>Assistant Professor 1 SQ</option>
                    <option value="Assistant Professor 2" {{ $selectedTeacher->next_rank == 'Assistant Professor 2' ? 'selected' : '' }}>Assistant Professor 2</option>
                    <option value="Assistant Professor 2 SQ" {{ $selectedTeacher->next_rank == 'Assistant Professor 2 SQ' ? 'selected' : '' }}>Assistant Professor 2 SQ</option>
                    <option value="Associate Professor 1" {{ $selectedTeacher->next_rank == 'Associate Professor 1' ? 'selected' : '' }}>Associate Professor 1</option>
                    <option value="Associate Professor 1 SQ" {{ $selectedTeacher->next_rank == 'Associate Professor 1 SQ' ? 'selected' : '' }}>Associate Professor 1 SQ</option>
                    <option value="Associate Professor 2" {{ $selectedTeacher->next_rank == 'Associate Professor 2' ? 'selected' : '' }}>Associate Professor 2</option>
                    <option value="Associate Professor 2 SQ" {{ $selectedTeacher->next_rank == 'Associate Professor 2 SQ' ? 'selected' : '' }}>Associate Professor 2 SQ</option>
                    <option value="Full Professor 1" {{ $selectedTeacher->next_rank == 'Full Professor 1' ? 'selected' : '' }}>Full Professor 1</option>
                    <option value="Full Professor 1 SQ" {{ $selectedTeacher->next_rank == 'Full Professor 1 SQ' ? 'selected' : '' }}>Full Professor 1 SQ</option>
                    <option value="Full Professor 2" {{ $selectedTeacher->next_rank == 'Full Professor 2' ? 'selected' : '' }}>Full Professor 2</option>
                    <option value="Full Professor 2 SQ" {{ $selectedTeacher->next_rank == 'Full Professor 2 SQ' ? 'selected' : '' }}>Full Professor 2 SQ</option>
                    <option value="Full Professor 3" {{ $selectedTeacher->next_rank == 'Full Professor 3' ? 'selected' : '' }}>Full Professor 3</option>
                    <option value="Full Professor 3 SQ" {{ $selectedTeacher->next_rank == 'Full Professor 3 SQ' ? 'selected' : '' }}>Full Professor 3 SQ</option>
                    </optgroup>
                </select>
                </td>
                <td id="next-requirements">Select a rank</td>
                </tr>
                </table>
            </div>
            <button type="button" class="update-button">Update</button>
        </form>
        </div>
    </div>

    
        <div class="text-upload-search-container">
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
                        {{-- <th>Certificate ID:</th> --}}
                        <th>Category</th>
                        <th>Type</th>
                        {{-- <th>Name</th> --}}
                        <th>Title</th>
                        <th>Organization/Sponsor</th>
                        <th>Designation</th>
                        <th>Number of Days</th>
                        <th>Inclusive Date</th>
                        <th>OCR Output</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allCertificates as $certificate)
                    <tr>
                        <form action="{{ route('certificate.update', $certificate->id) }}" method="POST">
                            @csrf
                            {{-- <td>{{ $certificate->id }}</td> --}}
                            <td>
                                <select name="category" id="category" required>
                                    <option value="">Select a Category</option>
                                    <option value="seminar" {{ $certificate->category == 'seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="honors_awards" {{ $certificate->category == 'honors_awards' ? 'selected' : '' }}>Honors and Awards</option>
                                    <option value="membership" {{ $certificate->category == 'membership' ? 'selected' : '' }}>Membership</option>
                                    <option value="scholarship_activities_a" {{ $certificate->category == 'scholarship_activities_a' ? 'selected' : '' }}>Scholarship Activities & Creative Efforts_A</option>
                                    <option value="scholarship_activities_b" {{ $certificate->category == 'scholarship_activities_b' ? 'selected' : '' }}>Scholarship Activities & Creative Efforts_B</option>
                                    <option value="service_students" {{ $certificate->category == 'service_students' ? 'selected' : '' }}>Service to Students</option>
                                    <option value="service_department" {{ $certificate->category == 'service_department' ? 'selected' : '' }}>Service to Department</option>
                                    <option value="service_institution" {{ $certificate->category == 'service_institution' ? 'selected' : '' }}>Service to Institution</option>
                                    <option value="participation_organizations" {{ $certificate->category == 'participation_organizations' ? 'selected' : '' }}>Active Participation in Different Organizations</option>
                                    <option value="involvement_department" {{ $certificate->category == 'involvement_department' ? 'selected' : '' }}>Active Involvement in Department</option>
                                </select>
                            </td>
                            <td><textarea name="type">{{ $certificate->type }}</textarea> </td>
                            {{-- <td><textarea name="name">{{ $certificate->name }}</textarea></td> --}}
                            <td><textarea name="title">{{ $certificate->title }}</textarea></td>
                            <td><textarea name="organization">{{ $certificate->organization }}</textarea></td>
                            <td><textarea name="designation">{{ $certificate->designation }}</textarea></td>
                            <td><input type="text" name="days" value="{{ $certificate->days }}" required></td>
                            <td><input type="text" name="inclusive-date" value="{{ $certificate->date }}" required></td>
                            <td><button type="button" class="btn btn-info ocr-result-btn" data-ocr="{{ $certificate->raw_text }}">View OCR Output</button></td>
                            <td><input type="text" name="points" value="{{ $certificate->points }}" required></td>
                            <td>
                                <button type="submit-update">Update</button>
                        </form>
                        <form action="{{ route('certificate.delete', $certificate->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-button">Delete</button>
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
            <div class="mb-4 view-summary-bottom">
                <a href="{{ route('summary', ['teacherId' => $teacher_id]) }}" class="btn btn-secondary-bottom">View Summary</a>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
        </form>
        
    <!-- JavaScript -->
    {{-- <script src="{{ asset('javascript/autosizing.js') }}"></script> --}}
    <script src="{{ asset('javascript/popupwindow.js') }}"></script>
    <script>
    window.basicRequirements = @json($basicRequirements);
    window.higherRequirements = @json($higherRequirements);
    </script>
    <script src="{{ asset('javascript/rankRequirements.js') }}"></script>
    <script src="{{ asset('javascript/buttonConfirmations.js') }}"></script>
</body>
</html>