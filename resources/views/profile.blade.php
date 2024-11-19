<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
</head>
<body>

    {{-- Home Button --}}
    <div class="mb-4">
        <a href="{{ url('/home') }}" class="btn btn-success">Home</a>
    </div>

       <!-- Display Teacher's Information -->
<div class="teacher-table-info">
    <div class="teacher-info">
            <p><strong>Name:</strong> {{ $selectedTeacher->name }}</p>
            <p><strong>Academic Attainment:</strong> {{ $selectedTeacher->acad_attainment }}</p>
            <p><strong>Performance:</strong> {{ $selectedTeacher->performance }}</p>
            <p><strong>Experience:</strong> {{ $selectedTeacher->experience }}</p>
    </div>
</div>

    <div class="text-upload-search-container">
        <h1>Certificates Table</h1>

        <!-- Upload -->
        <div class="upload-button">
            <a href="{{ route('certificate.upload', ['teacher_id' => $teacher_id]) }}" class="btn btn-success">Upload New Certificate</a>
        </div>
        

        <!-- -->
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

</body>
</html>