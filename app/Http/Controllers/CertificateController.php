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
                    'content' => "Extract the following details from this certificate text:\n\nText: {$text}\n\n1. Certificate Type\n2. Recipient Name\n3. Certificate Title\n4. Date\n\nReturn the data in JSON format with keys: type, name, title, and date.",
                ],
            ],
        ]);

        $output = $response['choices'][0]['message']['content'] ?? '';

        // Parse OpenAI response
        $parsedData = json_decode($output, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return back()->with('error', 'Failed to parse OpenAI response.');
        }

        // Step 4: Prepare and save the extracted data
        $data = [
            'type' => $parsedData['type'] ?? 'Unknown',
            'name' => $parsedData['name'] ?? 'Unknown',
            'title' => $parsedData['title'] ?? 'Unknown',
            'date' => $parsedData['date'] ?? 'Unknown',
            'raw_text' => $text,
            'teacher_id' => $request->input('teacher_id'),
        ];

        Certificate::create($data);

        // Step 5: Redirect to the profile page with success message
        return redirect()->route('profile', ['teacher_id' => $request->input('teacher_id')])
            ->with('success', 'Certificate uploaded and processed successfully.');
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
              ->orWhere('type', 'like', "%{$query}%")
              ->orWhere('name', 'like', "%{$query}%")
              ->orWhere('title', 'like', "%{$query}%")
              ->orWhere('organization', 'like', "%{$query}%")
              ->orWhere('designation', 'like', "%{$query}%")
              ->orWhere('sponsor', 'like', "%{$query}%")
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
    ]);
    }


    public function updateCertificate(Request $request, $id)
    {
    $certificate = Certificate::findOrFail($id);
    $certificate->update($request->only('category', 'type', 'name', 'title', 'organization', 'designation', 'sponsor', 'date', 'points'));

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
            'performance' => 'nullable|numeric',
            'experience' => 'required|string',
        ]);

        $teacher = Teacher::create([
            'name' => $request->input('name'),
            'acad_attainment' => $request->input('acad_attainment'),
            'performance' => $request->input('performance', 0),
            'experience' => $request->input('experience'),
        ]);

        return redirect()->route('home')->with('teacher', $teacher);
    }

    public function updateTeacher(Request $request, $id)
    {
    $teacher = Teacher::findOrFail($id);
    $teacher->update($request->only('name', 'acad_attainment', 'performance', 'experience', 'rank'));

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


    public function showSummary($teacherId)
    {
    // Retrieve the selected teacher
    $teacher = Teacher::with('certificates')->findOrFail($teacherId);

    // Calculate points for Productive Scholarship categories
    $productiveScholarshipPoints = $teacher->certificates
        ->whereIn('category', ['seminar', 'honors_awards', 'membership', 'scholarship_activities'])
        ->sum('points');

    // Calculate points for Community Extension Services categories
    $communityExtensionPoints = $teacher->certificates
        ->whereIn('category', ['service_students', 'service_department', 'service_institution', 'participation_organizations', 'involvement_department'])
        ->sum('points');

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
        'experience' => $experience,
        'communityExtensionPoints' => $communityExtensionPoints,
        'totalPoints' => $totalPoints,
    ]);
    }
}