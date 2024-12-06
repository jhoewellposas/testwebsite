<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/summary.css')}}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
    <title>Summary</title>
</head>
<body>

     {{-- Logo Header Container --}}
     <div class="fsuu-logo-container">
        <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="University Logo" class="logo">
        <div class="logo-title-container">
            <h1 class="main-title">FSUU</h1>
            <h2 class="subtitle">Father Saturnino Urios University</h2>
        </div>
    </div>


    {{-- Buttons --}}
    <div class="button-container">
            {{-- Home Button --}}
        <div class="mb-4">
            <a href="{{ url('/home') }}" class="btn btn-success">Home</a>
        </div>

        <div class="mb-4 view-summary">
            <a href="{{ route('profile', ['teacher_id' => $teacher->id]) }}" class="btn btn-secondary">Profile</a>
        </div>
    </div>   

    <h1 class="sub-header">RANKING SUMMARY</h1>

    <!-- Display Selected Teacher's Information -->
    <div class="teacher-table-info">
        <div class="teacher-info">
            <p><strong>Name:</strong> {{ $teacher->name }}</p>
            <p><strong>Highest Academic Attainment:</strong> {{ $teacher->acad_attainment }}</p>
            <p><strong>Experience:</strong> {{ $experience }}</p>
            <p><strong>Office:</strong> {{ $teacher->office }}</p>
            <p><strong>Rank:</strong> {{ $teacher->next_rank }}</p>
        </div>

            <!-- Table for Ranking Criteria and Points -->
        <div class="table-content">
            <table class="R-C-table" border="1">
                <thead>
                    <tr>
                        <th>Ranking Criteria</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Performance</td>
                        <td>{{ $performance }}</td>
                    </tr>
                    <tr>
                        <td>Productive Scholarship</td>
                        <td>{{ $productiveScholarshipPoints }}</td>
                    </tr>
                    <tr>
                        <td>Experience</td>
                        <td>{{ $experience }}</td>
                    </tr>
                    <tr>
                        <td>Community Extension Services</td>
                        <td>{{ $communityExtensionPoints }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>{{ $totalPoints }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    {{-- Signature Form --}}
    <div class="signature-form">
        <h2 class="title">Signature Form</h2>
        <div class="grid-container">
            <!-- Row 1 -->
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
    
            <!-- Row 2 -->
            <div class="grid-item prepared-by-container">
                <span>Prepared by</span>
                <!-- Line will be added here by CSS -->
            </div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            
    
            <!-- Row 3 -->
            <div class="grid-item"></div>
            <div class="grid-item centered">Verified and Reviewed by Rank and Tenure Committee</div>
            <div class="grid-item"></div>
    
            <!-- Row 4 -->
            <div class="grid-item name-signature1">Name & Signature of Member</div>
            <div class="grid-item"></div>
            <div class="grid-item name-signature2">Name & Signature of Member</div>
             
            <!-- Row 5 -->
            <div class="grid-item"></div>
            <div class="grid-item name-signature3">Name & Signature of Chair</div>
            <div class="grid-item"></div>
    
            <!-- Row 6 -->
            <div class="grid-item approved-container">
                <span>Approved by the President</span>
                <!-- Line will be added here by CSS -->
            </div>
            <div class="grid-item"></div>
            <div class="grid-item approved-date-container">
                <span>Date</span>
                <!-- Line will be added here by CSS -->
            </div>

            <!-- Row 7 -->
            {{-- <div class="grid-item president">President</div>
            <div class="grid-item"></div>
            <div class="grid-item"></div> --}}
        </div>
    </div>

</body>
</html>