<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Certificate;
use App\Models\Teacher;
use OpenAI;

class CertificateController extends Controller
{
    public function extractCertificateData(Request $request)
    {
        // Step 1: Validate and save the uploaded files
        $request->validate([
            'certificates.*' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validate multiple files
            'teacher_id' => 'required|exists:teachers,id', // Validate teacher_id
        ]);
    
        $certificates = $request->file('certificates');
        $teacherId = $request->input('teacher_id');
    
        foreach ($certificates as $certificate) {
            $path = $certificate->store('certificates', 'public');
            $processedImagePath = storage_path("app/public/{$path}");
    
            // Step 2: Perform OCR on the processed image
            $tesseract = new TesseractOCR($processedImagePath);
            $text = $tesseract->run();
    
            if (empty($text)) {
                return back()->with('error', "Failed to extract text from certificate: {$certificate->getClientOriginalName()}");
            }
    
            // Step 3: Use OpenAI API to extract details
            $openaiApiKey = env('OPENAI_API_KEY'); // Add your API key to the .env file
            $openai = OpenAI::client($openaiApiKey);
    
            $response = $openai->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that extracts structured data from certificate text.',
                    ],
                    [
                        'role' => 'user',
                        'content' => "Extract the following details from this certificate text:\n\nText: {$text}\n\n1. Certificate Type\n2. Recipient Name\n3. Certificate Title\n4. Certificate Organization or Sponsor\n5. Recipient Designation or Role\n6. Count the number of days\n7. Date\n\nReturn the data in JSON format with keys: type, name, title, organization, designation, days and date.",
                    ],
                ],
            ]);
    
            $output = $response['choices'][0]['message']['content'] ?? '';
    
            // Parse OpenAI response
            $parsedData = json_decode($output, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', "Failed to parse OpenAI response for certificate: {$certificate->getClientOriginalName()}");
            }
    
            // Categorize Certificates
            $category = $this->categorizeCertificate($text);

            // Step 4: Prepare and save the extracted data
            $data = [
                'type' => $parsedData['type'] ?? 'Unknown',
                'name' => $parsedData['name'] ?? 'Unknown',
                'title' => $parsedData['title'] ?? 'Unknown',
                'organization' => $parsedData['organization'] ?? 'Unknown',
                'designation' => $parsedData['designation'] ?? 'Unknown',
                'days' => is_numeric($parsedData['days']) ? $parsedData['days'] : 0,
                'date' => $parsedData['date'] ?? 'Unknown',
                'category' => $category,
                'raw_text' => $text,
                'teacher_id' => $teacherId,
            ];
    
            Certificate::create($data);
        }
    
        // Step 5: Redirect to the profile page with success message
        return redirect()->route('profile', ['teacher_id' => $teacherId])
            ->with('success', 'Certificates uploaded and processed successfully.');
    }
    


/*
    public function extractCertificateData(Request $request)
    {

        // Step 1: Validate and save the uploaded file
        $request->validate([
            'certificate' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'teacher_id' => 'required|exists:teachers,id' // Validate teacher_id
        ]);

        $image = $request->file('certificate');
        $path = $image->store('certificates', 'public');
        $processedImagePath = storage_path("app/public/{$path}");

        // Step 2: Perform OCR on the processed image
        $tesseract = new TesseractOCR($processedImagePath);
        $text = $tesseract->run();

        if (empty($text)) {
            return back()->with('error', 'Failed to extract text from the certificate.');
        }

        // Step 3: Use OpenAI API to extract details
        $openaiApiKey = env('OPENAI_API_KEY'); // Add your API key to the .env file
        $openai = OpenAI::client($openaiApiKey);


        $response = $openai->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant that extracts structured data from certificate text.',
                ],
                [
                    'role' => 'user',
                    'content' => "Extract the following details from this certificate text:\n\nText: {$text}\n\n1. Certificate Type\n2. Recipient Name\n3. Certificate Title\n4. Certificate Organization or Sponsor\n5. Recipient Designation or Role\n6. Date\n\nReturn the data in JSON format with keys: type, name, title, organization, designation and date.",
                ],
            ],
        ]);

        $output = $response['choices'][0]['message']['content'] ?? '';

        // Parse OpenAI response
        $parsedData = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->with('error', 'Failed to parse OpenAI response.');
        }

        //Cetgorize Certificates
        $category = $this->categorizeCertificate($text);

        // Step 4: Prepare and save the extracted data
        $data = [
            'type' => $parsedData['type'] ?? 'Unknown',
            'name' => $parsedData['name'] ?? 'Unknown',
            'title' => $parsedData['title'] ?? 'Unknown',
            'organization' => $parsedData['organization'] ?? 'Unknown',
            'designation' => $parsedData['designation'] ?? 'Unknown',
            'date' => $parsedData['date'] ?? 'Unknown',
            'category' => $category,
            'raw_text' => $text,
            'teacher_id' => $request->input('teacher_id'),
        ];

        Certificate::create($data);

        // Step 5: Redirect to the profile page with success message
        return redirect()->route('profile', ['teacher_id' => $request->input('teacher_id')])
            ->with('success', 'Certificate uploaded and processed successfully.');
    }
*/

    private function categorizeCertificate($text)
{
    $text = strtolower($text);

    if (preg_match('/attendance|completion|conferences|congress|trainings|participation/', $text)) {
        return 'seminar';
    }

    if (preg_match('/runner-up|placer/', $text)) {
        return 'honors_awards';
    }

    if (preg_match('/member|officer/', $text)) {
        return 'membership';
    }

    if (preg_match('/adviser|panelist|workbook/', $text)) {
        return 'scholarship_activities_a';
    }

    if (preg_match('/book|judge|coach|consultant|trainer|facilitator|researcher|speaker/', $text)) {
        return 'scholarship_activities_b';
    }

    if (preg_match('/student service|service to students|organization/', $text)) {
        return 'service_students';
    }

    if (preg_match('/department service|service to department/', $text)) {
        return 'service_department';
    }

    if (preg_match('/institutional service|service to institution|organized by|sponsored by/', $text)) {
        return 'service_institution';
    }

    if (preg_match('/active participation|organizations/', $text)) {
        return 'participation_organizations';
    }

    if (preg_match('/involvement in department|run and row|gk build|bike and plant/', $text)) {
        return 'involvement_department';
    }

    return 'unknown';
}








/*
    public function extractCertificateData(Request $request)
    {
        // Step 1: Validate and save the uploaded file
        $request->validate([
            'certificate' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'teacher_id' => 'required|exists:teachers,id' // Validate teacher_id////
        ]);

        $image = $request->file('certificate');
        $path = $image->store('certificates', 'public');
        $processedImagePath = storage_path("app/public/{$path}");
        
        // Step 3: Perform OCR on the processed image
        $tesseract = new TesseractOCR($processedImagePath);
        $text = $tesseract->run();

        // Step 4: Extract relevant information using regex patterns
        $typePattern = "/certificate of (achievement|completion|attendance|participation|appreciation|recognition)/i";
        $namePattern = "/(?:to|that)\s+([A-Z\s]+?)\s+(?:has|for)/i";
        $titlePattern = "/(?:completed|participation on|completed the|attended)\s+(.+?)(?:\s@\s|\s\(|\.)/i";
        $datePattern = "/(?:date completed|given this|valid until|given on|completed on)[:\s]+([0-9\/\-]+)/i";

        preg_match($typePattern, $text, $typeMatch);
        preg_match($namePattern, $text, $nameMatch);
        preg_match($titlePattern, $text, $titleMatch);
        preg_match($datePattern, $text, $dateMatch);

        // Prepare the extracted data
        $data = [
            'type' => $typeMatch[1] ?? 'Unknown',
            'name' => $nameMatch[1] ?? 'Unknown',
            'title' => $titleMatch[1]?? 'Unknown',
            'date' => $dateMatch[1] ?? 'Unknown',
            'raw_text' => $text,
            'teacher_id' => $request->input('teacher_id'),//
        ];

        $certificate = Certificate::create($data);

        //return redirect()->route('profile');
        return redirect()->route('profile', ['teacher_id' => $request->input('teacher_id')])
        ->with('success', 'Certificate uploaded and processed successfully.');
    }
*/

    public function showCertificates(Request $request)
    {
    $query = $request->input('query');
    $teacherId = $request->input('teacher_id');

    // Initialize the certificate query
    $certificateQuery = Certificate::query();

    // Filter by search query if provided
    if ($query) {
        $certificateQuery->where(function ($q) use ($query) {
            $q->where('id', 'like', "%{$query}%")
              ->orWhere('category', 'like', "%{$query}%")
              ->orWhere('type', 'like', "%{$query}%")
              ->orWhere('name', 'like', "%{$query}%")
              ->orWhere('title', 'like', "%{$query}%")
              ->orWhere('organization', 'like', "%{$query}%")
              ->orWhere('designation', 'like', "%{$query}%")
              ->orWhere('date', 'like', "%{$query}%")
              ->orWhere('raw_text', 'like', "%{$query}%")
              ->orWhere('points', 'like', "%{$query}%");
        });
    }

    // Filter by teacher_id if a teacher is selected
    if ($teacherId) {
        $certificateQuery->where('teacher_id', $teacherId);
        $selectedTeacher = Teacher::findOrFail($teacherId); // Get the teacher's details
    } else {
        $selectedTeacher = null;
    }

    // Requirements for ranks
    $basicRequirements = [
        'Teacher 1' => [
            'Must have earned 25% of MA academic requirements on his/her specialization',
            'Must have a very good/very satisfactory efficiency rating',
            'At least three (3) years of teaching experience',
            'Must have met all the requirements of Teacher 1',
        ],
        'Teacher 2' => [
            'Must have earned 25% of MA academic requirements on his/her specialization',
            'Must have a very good/very satisfactory efficiency rating',
            'At least three (3) years of teaching experience',
            'Must have met all the requirements of Teacher 1',
        ],
        'Teacher 3' => [
            'Must have earned 75% of MA academic requirements on his/her specialization',
            'Must have a very good/very satisfactory efficiency rating',
            'At least three (3) years teaching experience',
            'Must have met all the requirements of Teacher 2',
        ],
        'Teacher 4' => [
                'Must be a Masters Degree holder',
                'Must have a very good/very satisfactory efficiency rating',
                'At least three (3) years teaching experience',
                'Must have met all the requirements of Teacher 3'
        ],
        'Teacher 5' => [
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 4 years teaching experience',
                'Must have earned atleast one (1) point of productive scholarship',
                'Must have met all the requirements of Teacher 4'
        ],
        'Senior Teacher 1' => [
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 5 years teaching experience',
                'Must have earned atleast two (2) points of productive scholarship',
                'Must have met all the requirements of Teacher 5'
            ],
        'Senior Teacher 2' => [
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 6 years teaching experience',
                'Must have earned atleast three (3) points of productive scholarship',
                'Must have met all the requirements of Senior Teacher 1'
            ],
        'Senior Teacher 3' => [
                'Must have taken 25% of Doctoral academic requirements in his/her specialization',
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 7 years teaching experience',
                'Must have conducted at least one research approved/recognized by the administration',
                'Must have met all the requirements of Senior Teacher 2'
        ],
        'Senior Teacher 4' => [
                'Must have taken 50% of Doctoral academic requirements in his/her specialization',
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 8 years teaching experience',
                'Must have shown consistent interest in conducting & publishing research or articles relevant to his/her field of specialization',
                'Must have met all the requirements of Senior Teacher 3'
        ],
        'Senior Teacher 5' => [
                'Must have completed the academic requirements for Doctoral Degree',
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 9 years teaching experience',
                'Must exhibit continued interest in the conduct of researches, innovative and creative efforts',
                'Must have met all the requirements of Senior Teacher 4'
        ],
        'Master Teacher 1' => [
                'Must be a Doctoral Degree holder',
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 10 years teaching experience',
                'Must have conducted atleast one (1) research work outside dissertation work and other articles consistent to education or field of specialization in a refereed journal',
                'Must have met all the requirements of Senior Teacher 5'
        ],
        'Master Teacher 2' => [
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 11 years teaching experience',
                'Must have shown consistent interest in the conduct of researches, and other articles consistent to education or field of specialization in a refereed journal',
                'Must have met all the requirements of Master Teacher 1'
        ],
        'Master Teacher 3' => [
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 12 years teaching experience',
                'Must have earned general recognition among scholars and educators',
                'Must have published books, articles in recognized journal or similar scholarships',
                'Must have participated in the activities of the learned societies',
                'Must have met all the requirements of Master Teacher 2'
        ],
        'Master Teacher 4' => [
                'Must have a very good/very satisfactory efficiency rating',
                'Must have atleast 13 years teaching experience',
                'Must have met all the requirements of Master Teacher 3'
        ],
    ];

    $higherRequirements = [
        'Lecturer 1' => [
                'BS Degree Holder',
                'Must have a Very Good/Very Satisfactory efficiency rating',
                'Must have passed three years of probationary period'
        ],
        'Lecturer 2' => [
                'Must have earned 25% MA units',
                'Must have a Very Good/Very Satisfactory efficiency rating',
                'Must have passed three years of probationary period'
        ],
        'Lecturer 3' => [
                'Must have earned 75% MA units',
                'Must have a Very Good/Very Satisfactory efficiency rating',
                'Must have passed three years of probationary period'
        ],
        'Assistant Instructor' => [
                'Must be a Masters Degree holder',
                'Must have a Very Good/Very Satisfactory efficiency rating',
                'Must have passed three years of probationary period'
        ],
        'Instructor 1' => [
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 4 years teaching experience',
                'Must have earned at least one (1) point of productive scholarship',
                'Must have met all the requirements of Assistant Instructor'
        ],
        'Instructor 2' => [
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 6 years teaching experience',
                'Must have earned at least two (2) point of productive scholarship',
                'Must have met all the requirements of Instructor 1'
        ],
        'Instructor 3' => [
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 6 years teaching experience',
                'Must have earned at least three (3) point of productive scholarship',
                'Must have met all the requirements of Instructor 2'
        ],
        'Assistant Professor 1' => [
                'Must have taken 25% of Doctoral academic requirements in his or her specialization',
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 7 years teaching experience',
                'Must have conducted at least one research',
                'Must have met all the requirements of Instructor 3'
        ],
        'Assistant Professor 2' => [
                'Must have taken 50% of Doctoral academic requirements in his or her specialization',
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 8 years teaching experience',
                'Must have shown consistent interest in conducting & publishing research or articles relevant to his/her field of specialization',
                'Must have met all the requirements of Assistant Professor 1'
        ],
        'Associate Professor 1' => [
                'Must have completed the acedemic requirements for Doctoral Degree',
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 9 years teaching experience',
                'Must exhibit continued interest in the conduct of researches, innovative and creative efforts',
                'Must have met all the requirements of Assistant Professor 2'
        ],
        'Associate Professor 2' => [
                'Must be a Doctoral Degree holder',
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 10 years teaching experience',
                'Must have conducted atleast one (1) research work outside dissertation work and other articles consistent to education or field of specialization in a refereed journal',
                'Must have met all the requirements of Associate Professor 1'
        ],
        'Full Professor 1' => [
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 12 years teaching experience',
                'Must have shown consistent interest in the conduct of researches and other articles consistent to education or field of specialization in a refereed journal',
                'Must have met all the requirements of Associate Professor 2'
        ],
        'Full Professor 2' => [
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have at least 12 years teaching experience',
                'Must have earned general recognition among scholars and educators',
                'Must have published books, articles, researches in recognized journal or similar scholarships',
                'Must have participated in the activities of the learned societies',
                'Must have met all the requirements of Full Professor 1'
        ],
        'Full Professor 3' => [
                'Must have a Very Good/ Very Satisfactory efficiency rating',
                'Must have atleast 12 years of teaching experience',
                'Must have published books, articles, researches in international journals',
                'Must have met all the requirements of Full Professor 2'
        ],
    ];

    // Get certificates
    $allCertificates = $certificateQuery->get();

    // Retrieve all teachers for the dropdown
    $allTeachers = Teacher::all();

    return view('profile', [
        'allCertificates' => $allCertificates,
        'allTeachers' => $allTeachers,
        'selectedTeacher' => $selectedTeacher, // Pass selected teacher's details
        'query' => $query,
        'teacher_id' => $teacherId, // Pass teacher_id for default selection
        'basicRequirements' => $basicRequirements, // Pass rank basic requirements
        'higherRequirements' => $higherRequirements, // Pass rank higher requirements
    ]);
    }


    public function updateCertificate(Request $request, $id)
    {
    $certificate = Certificate::findOrFail($id);
    $certificate->update($request->only('category', 'type', 'name', 'title', 'organization', 'designation', 'days', 'date', 'points'));

    // Redirect back to the profile page with the teacher_id
    return redirect()->route('profile', ['teacher_id' => $certificate->teacher_id])
                     ->with('success', 'Certificate updated successfully.');
    }

    public function deleteCertificate($id)
    {
    $certificate = Certificate::findOrFail($id);
    $teacherId = $certificate->teacher_id;
    $certificate->delete();

    // Redirect back to the profile page with the teacher_id
    return redirect()->route('profile', ['teacher_id' => $teacherId])
                     ->with('success', 'Certificate deleted successfully.');
    }

    public function createTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'acad_attainment' => 'required|string',
            'date' => 'required|string',
            'office' => 'required|string',
            'performance' => 'nullable|numeric',
            'experience' => 'required|string',
        ]);

        $teacher = Teacher::create([
            'name' => $request->input('name'),
            'acad_attainment' => $request->input('acad_attainment'),
            'date' => $request->input('date'),
            'office' => $request->input('office'),
            'performance' => $request->input('performance', 0),
            'experience' => $request->input('experience'),
        ]);

        return redirect()->route('home')->with('teacher', $teacher);
    }

    public function updateTeacher(Request $request, $id)
    {
    $teacher = Teacher::findOrFail($id);
    $teacher->update($request->only('name', 'acad_attainment', 'performance', 'date', 'office', 'experience', 'rank'));

    // Redirect back to the profile page with the teacher_id
    return redirect()->route('profile', ['teacher_id' => $teacher->id])
                     ->with('success', 'Teacher updated successfully.');
    }

    public function showUploadForm(Request $request)
    {
    $teacherId = $request->input('teacher_id');

    if (!$teacherId) {
        return redirect()->route('profile')->with('error', 'No teacher selected.');
    }

    return view('upload', ['teacher_id' => $teacherId]);
    }

/*
    public function showSummary($teacherId)
{
    // Retrieve the selected teacher
    $teacher = Teacher::with('certificates')->findOrFail($teacherId);

    // Calculate points for Productive Scholarship categories
    $productiveGroupAPoints = $teacher->certificates
        ->whereIn('category', ['seminar', 'membership'])
        ->sum('points');

    $productiveGroupBPoints = $teacher->certificates
        ->whereIn('category', ['honors_awards', 'scholarship_activities'])
        ->sum('points');

    // Scale Productive Scholarship Points to a maximum of 15.0
    $productiveGroupAPercentage = 0.8; // 80%
    $productiveGroupBPercentage = 0.2; // 20%
    $productiveMaxPoints = 15.0;

    $scaledProductiveGroupAPoints = $productiveGroupAPoints * $productiveGroupAPercentage;
    $scaledProductiveGroupBPoints = $productiveGroupBPoints * $productiveGroupBPercentage;

    $productiveScholarshipPoints = min(
        $productiveMaxPoints,
        $scaledProductiveGroupAPoints + $scaledProductiveGroupBPoints
    );

    // Calculate points for Community Extension Services categories
    $communityGroupAPoints = $teacher->certificates
        ->whereIn('category', ['service_students', 'service_department', 'service_institution'])
        ->sum('points');

    $communityGroupBPoints = $teacher->certificates
        ->whereIn('category', ['participation_organizations', 'involvement_department'])
        ->sum('points');

    // Scale Community Extension Points to a maximum of 10.0
    $communityGroupAPercentage = 0.7; // 70%
    $communityGroupBPercentage = 0.3; // 30%
    $communityMaxPoints = 10.0;

    $scaledCommunityGroupAPoints = $communityGroupAPoints * $communityGroupAPercentage;
    $scaledCommunityGroupBPoints = $communityGroupBPoints * $communityGroupBPercentage;

    $communityExtensionPoints = min(
        $communityMaxPoints,
        $scaledCommunityGroupAPoints + $scaledCommunityGroupBPoints
    );

    // Use teacher's individual performance and experience
    $performance = $teacher->performance;
    $experience = $teacher->experience;

    // Calculate the total points
    $totalPoints = $performance + $productiveScholarshipPoints + $experience + $communityExtensionPoints;

    // Pass data to the view
    return view('summary', [
        'teacher' => $teacher,
        'performance' => $performance,
        'productiveScholarshipPoints' => $productiveScholarshipPoints,
        'productiveGroupAPoints' => $productiveGroupAPoints,
        'productiveGroupBPoints' => $productiveGroupBPoints,
        'scaledProductiveGroupAPoints' => $scaledProductiveGroupAPoints,
        'scaledProductiveGroupBPoints' => $scaledProductiveGroupBPoints,
        'experience' => $experience,
        'communityExtensionPoints' => $communityExtensionPoints,
        'communityGroupAPoints' => $communityGroupAPoints,
        'communityGroupBPoints' => $communityGroupBPoints,
        'scaledCommunityGroupAPoints' => $scaledCommunityGroupAPoints,
        'scaledCommunityGroupBPoints' => $scaledCommunityGroupBPoints,
        'totalPoints' => $totalPoints,
    ]);
}
*/
    public function showSummary($teacherId)
    {
    // Retrieve the selected teacher
    $teacher = Teacher::with('certificates')->findOrFail($teacherId);

    // Define percentage distributions for each rank
    $commonDistribution = [
        'productiveGroupAPercentage' => 0.8, // 80%
        'productiveGroupBPercentage' => 0.2, // 20%
        'communityGroupAPercentage' => 0.7, // 70%
        'communityGroupBPercentage' => 0.3, // 30%
    ];
    
    $rankDistributions = [
        'Teacher 1' => $commonDistribution,
        'Teacher 2' => $commonDistribution,
        'Teacher 3' => $commonDistribution,
        'Lecturer 1' => $commonDistribution,
        'Lecturer 2' => $commonDistribution,
        'Lecturer 3' => $commonDistribution,
        
        'Teacher 4' => [
            'productiveGroupAPercentage' => 0.75,
            'productiveGroupBPercentage' => 0.25,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Teacher 4 SQ' => [
            'productiveGroupAPercentage' => 0.8,
            'productiveGroupBPercentage' => 0.2,
            'communityGroupAPercentage' => 0.7,
            'communityGroupBPercentage' => 0.3,
        ],
        'Assistant Instructor' => [
            'productiveGroupAPercentage' => 0.75,
            'productiveGroupBPercentage' => 0.25,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Assistant Instructor SQ' => [
            'productiveGroupAPercentage' => 0.8,
            'productiveGroupBPercentage' => 0.2,
            'communityGroupAPercentage' => 0.7,
            'communityGroupBPercentage' => 0.3,
        ],
        'Teacher 5' => [
            'productiveGroupAPercentage' => 0.7,
            'productiveGroupBPercentage' => 0.3,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Teacher 5 SQ' => [
            'productiveGroupAPercentage' => 0.75,
            'productiveGroupBPercentage' => 0.25,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Instructor 1' => [
            'productiveGroupAPercentage' => 0.7,
            'productiveGroupBPercentage' => 0.3,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Instructor 1 SQ' => [
            'productiveGroupAPercentage' => 0.75,
            'productiveGroupBPercentage' => 0.25,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Senior Teacher 1' => [
            'productiveGroupAPercentage' => 0.65,
            'productiveGroupBPercentage' => 0.35,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Senior Teacher 1 SQ' => [
            'productiveGroupAPercentage' => 0.7,
            'productiveGroupBPercentage' => 0.3,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Instructor 2' => [
            'productiveGroupAPercentage' => 0.65,
            'productiveGroupBPercentage' => 0.35,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Instructor 2 SQ' => [
            'productiveGroupAPercentage' => 0.7,
            'productiveGroupBPercentage' => 0.3,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Senior Teacher 2' => [
            'productiveGroupAPercentage' => 0.6,
            'productiveGroupBPercentage' => 0.4,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Senior Teacher 2 SQ' => [
            'productiveGroupAPercentage' => 0.65,
            'productiveGroupBPercentage' => 0.35,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Instructor 3' => [
            'productiveGroupAPercentage' => 0.6,
            'productiveGroupBPercentage' => 0.4,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Instructor 3 SQ' => [
            'productiveGroupAPercentage' => 0.65,
            'productiveGroupBPercentage' => 0.35,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
        ],
        'Senior Teacher 3' => [
            'productiveGroupAPercentage' => 0.55,
            'productiveGroupBPercentage' => 0.45,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Senior Teacher 3 SQ' => [
            'productiveGroupAPercentage' => 0.6,
            'productiveGroupBPercentage' => 0.4,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Assistant Professor 1' => [
            'productiveGroupAPercentage' => 0.55,
            'productiveGroupBPercentage' => 0.45,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Assistant Professor 1 SQ' => [
            'productiveGroupAPercentage' => 0.6,
            'productiveGroupBPercentage' => 0.4,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Senior Teacher 4' => [
            'productiveGroupAPercentage' => 0.5,
            'productiveGroupBPercentage' => 0.5,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Senior Teacher 4 SQ' => [
            'productiveGroupAPercentage' => 0.55,
            'productiveGroupBPercentage' => 0.45,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Assistant Professor 2' => [
            'productiveGroupAPercentage' => 0.5,
            'productiveGroupBPercentage' => 0.5,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Assistant Professor 2 SQ' => [
            'productiveGroupAPercentage' => 0.55,
            'productiveGroupBPercentage' => 0.45,
            'communityGroupAPercentage' => 0.6,
            'communityGroupBPercentage' => 0.4,
        ],
        'Senior Teacher 5' => [
            'productiveGroupAPercentage' => 0.45,
            'productiveGroupBPercentage' => 0.55,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Senior Teacher 5 SQ' => [
            'productiveGroupAPercentage' => 0.5,
            'productiveGroupBPercentage' => 0.5,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Associate Professor 1' => [
            'productiveGroupAPercentage' => 0.45,
            'productiveGroupBPercentage' => 0.55,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Associate Professor 1 SQ' => [
            'productiveGroupAPercentage' => 0.5,
            'productiveGroupBPercentage' => 0.5,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 1' => [
            'productiveGroupAPercentage' => 0.4,
            'productiveGroupBPercentage' => 0.6,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 1 SQ' => [
            'productiveGroupAPercentage' => 0.45,
            'productiveGroupBPercentage' => 0.55,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Associate Professor 2' => [
            'productiveGroupAPercentage' => 0.4,
            'productiveGroupBPercentage' => 0.6,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Associate Professor 2 SQ' => [
            'productiveGroupAPercentage' => 0.45,
            'productiveGroupBPercentage' => 0.55,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 2' => [
            'productiveGroupAPercentage' => 0.35,
            'productiveGroupBPercentage' => 0.65,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 2 SQ' => [
            'productiveGroupAPercentage' => 0.4,
            'productiveGroupBPercentage' => 0.6,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Full Professor 1' => [
            'productiveGroupAPercentage' => 0.35,
            'productiveGroupBPercentage' => 0.65,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Full Professor 1 SQ' => [
            'productiveGroupAPercentage' => 0.4,
            'productiveGroupBPercentage' => 0.6,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 3' => [
            'productiveGroupAPercentage' => 0.3,
            'productiveGroupBPercentage' => 0.7,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 3 SQ' => [
            'productiveGroupAPercentage' => 0.35,
            'productiveGroupBPercentage' => 0.65,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Full Professor 2' => [
            'productiveGroupAPercentage' => 0.3,
            'productiveGroupBPercentage' => 0.7,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Full Professor 2 SQ' => [
            'productiveGroupAPercentage' => 0.35,
            'productiveGroupBPercentage' => 0.65,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 4' => [
            'productiveGroupAPercentage' => 0.3,
            'productiveGroupBPercentage' => 0.7,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Master Teacher 4 SQ' => [
            'productiveGroupAPercentage' => 0.3,
            'productiveGroupBPercentage' => 0.7,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Full Professor 3' => [
            'productiveGroupAPercentage' => 0.3,
            'productiveGroupBPercentage' => 0.7,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
        'Full Professor 3 SQ' => [
            'productiveGroupAPercentage' => 0.3,
            'productiveGroupBPercentage' => 0.7,
            'communityGroupAPercentage' => 0.5,
            'communityGroupBPercentage' => 0.5,
        ],
    ];

    // Get the current rank percentages (default to 0 if not set)
    $rank = $teacher->rank ?? 'Unknown';
    $distributions = $rankDistributions[$rank] ?? [
        'productiveGroupAPercentage' => 0.8,
        'productiveGroupBPercentage' => 0.2,
        'communityGroupAPercentage' => 0.7,
        'communityGroupBPercentage' => 0.3,
    ];

    // Calculate points for Productive Scholarship categories
    $productiveGroupAPoints = $teacher->certificates
        ->whereIn('category', ['seminar', 'membership', 'scholarship_activities_a'])
        ->sum('points');

    $productiveGroupBPoints = $teacher->certificates
        ->whereIn('category', ['honors_awards', 'scholarship_activities_b'])
        ->sum('points');

    // Scale Productive Scholarship Points to a maximum of 15.0
    $productiveMaxPoints = 15.0;
    $scaledProductiveGroupAPoints = $productiveGroupAPoints * $distributions['productiveGroupAPercentage'];
    $scaledProductiveGroupBPoints = $productiveGroupBPoints * $distributions['productiveGroupBPercentage'];
    $productiveScholarshipPoints = min(
        $productiveMaxPoints,
        $scaledProductiveGroupAPoints + $scaledProductiveGroupBPoints
    );

    // Calculate points for Community Extension Services categories
    $communityGroupAPoints = $teacher->certificates
        ->whereIn('category', ['service_students', 'service_department', 'service_institution'])
        ->sum('points');

    $communityGroupBPoints = $teacher->certificates
        ->whereIn('category', ['participation_organizations', 'involvement_department'])
        ->sum('points');

    // Scale Community Extension Points to a maximum of 10.0
    $communityMaxPoints = 10.0;
    $scaledCommunityGroupAPoints = $communityGroupAPoints * $distributions['communityGroupAPercentage'];
    $scaledCommunityGroupBPoints = $communityGroupBPoints * $distributions['communityGroupBPercentage'];
    $communityExtensionPoints = min(
        $communityMaxPoints,
        $scaledCommunityGroupAPoints + $scaledCommunityGroupBPoints
    );

    // Use teacher's individual performance and experience
    $performance = $teacher->performance;
    $experience = $teacher->experience;

    // Calculate the total points
    $totalPoints = $performance + $productiveScholarshipPoints + $experience + $communityExtensionPoints;

    // Pass data to the view
    return view('summary', [
        'teacher' => $teacher,
        'performance' => $performance,
        'productiveScholarshipPoints' => $productiveScholarshipPoints,
        'productiveGroupAPoints' => $productiveGroupAPoints,
        'productiveGroupBPoints' => $productiveGroupBPoints,
        'scaledProductiveGroupAPoints' => $scaledProductiveGroupAPoints,
        'scaledProductiveGroupBPoints' => $scaledProductiveGroupBPoints,
        'experience' => $experience,
        'communityExtensionPoints' => $communityExtensionPoints,
        'communityGroupAPoints' => $communityGroupAPoints,
        'communityGroupBPoints' => $communityGroupBPoints,
        'scaledCommunityGroupAPoints' => $scaledCommunityGroupAPoints,
        'scaledCommunityGroupBPoints' => $scaledCommunityGroupBPoints,
        'totalPoints' => $totalPoints,
    ]);
    }

}