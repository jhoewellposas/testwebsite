<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Models\Certificate;
use App\Models\Teacher;


class CertificateController extends Controller
{
    public function extractCertificateData(Request $request)
    {
        //dd($request->all);
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
        $typePattern = "/certificate of (completion|attendance|participation)/i";
        $namePattern = "/(?:to|that)\s+([A-Z\s]+?)\s+(?:has|for)/i";
        $titlePattern = "/(?:completed|participation on|completed the)\s+(.+?)(?:\s@\s|\s\(|\.)/i";
        $datePattern = "/(?:date completed|given this|valid until|given on)[:\s]+([0-9\/\-]+)/i";

        preg_match($typePattern, $text, $typeMatch);
        preg_match($namePattern, $text, $nameMatch);
        preg_match($titlePattern, $text, $titleMatch);
        preg_match($datePattern, $text, $dateMatch);

        // Prepare the extracted data
        $data = [
            'type' => $typeMatch[1] ?? 'Unknown',
            'name' => $nameMatch[1] ?? 'Unknown',
            'title' => $titleMatch[1] ?? 'Unknown',
            'date' => $dateMatch[1] ?? 'Unknown',
            'raw_text' => $text,
            'teacher_id' => $request->input('teacher_id'),//
        ];

        $certificate = Certificate::create($data);

        return redirect()->route('home');
    }

    public function showCertificates(Request $request)
{
    $query = $request->input('query');
    $teacherId = $request->input('teacher_id');

    $allCertificates = Certificate::query();

    // Filter by search query if provided
    if ($query) {
        $allCertificates->where(function ($q) use ($query) {
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
        $allCertificates->where('teacher_id', $teacherId);
        $selectedTeacher = Teacher::find($teacherId);
    } else {
        $selectedTeacher = null;
    }
    
    $allCertificates = $allCertificates->get();

    // Retrieve all teachers for the dropdown
    $allTeachers = Teacher::all();

    return view('home', [
        'allCertificates' => $allCertificates,
        'allTeachers' => $allTeachers,
        'selectedTeacher' => $selectedTeacher,
        'query' => $query,
        'teacher_id' => $teacherId,
    ]);
}


/*    public function showCertificates(Request $request)
    {
    $query = $request->input('query');

    if ($query) {
        // Search by type, name, title, or date using LIKE to allow partial matches
        $allCertificates = Certificate::where('id', 'like', "%{$query}%")
            ->orWhere('type', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('title', 'like', "%{$query}%")
            ->orWhere('date', 'like', "%{$query}%")
            ->orWhere('raw_text', 'like', "%{$query}%")
            ->orWhere('points', 'like', "%{$query}%")
            ->get();
    } else {
        $allCertificates = Certificate::all();
    }

    //teacher
    $allTeachers = Teacher::all();
    $latestTeacher = Teacher::latest()->first(); // Retrieve the latest teacher

    return view('home', ['allCertificates' => $allCertificates,
        'allTeachers' => $allTeachers,
        'latestTeacher' => $latestTeacher,
        'query' => $query]);
    }*/

    public function updateCertificate(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->update($request->only('category', 'type', 'name', 'title', 'organization', 'designation', 'sponsor', 'date', 'points'));

        return redirect()->route('home');
    }

    public function deleteCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return redirect()->route('home');
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

    public function showUploadForm()
    {
    $allTeachers = Teacher::all(); // Retrieve all teachers for the dropdown
    return view('upload', ['allTeachers' => $allTeachers]);
    }

    public function showSummary()
{
    // Sum points for Productive Scholarship categories
    $productiveScholarshipPoints = Certificate::whereIn('category', [
        'seminar',
        'honors_awards',
        'membership',
        'scholarship_activities'
    ])->sum('points');

    // Sum points for Community Extension Services categories
    $communityExtensionPoints = Certificate::whereIn('category', [
        'service_students',
        'service_department',
        'service_institution',
        'participation_organizations',
        'involvement_department'
    ])->sum('points');

    // Retrieve values for Performance and Experience from the Teacher model
    $performance = Teacher::sum('performance'); // Sum all teachers' performance points
    $experience = Teacher::sum('experience');   // Sum all teachers' experience points

    // Calculate the Total
    $totalPoints = $performance + $productiveScholarshipPoints + $experience + $communityExtensionPoints;

    // Pass data to the view
    return view('summary', [
        'performance' => $performance,
        'productiveScholarshipPoints' => $productiveScholarshipPoints,
        'experience' => $experience,
        'communityExtensionPoints' => $communityExtensionPoints,
        'totalPoints' => $totalPoints,
    ]);
}

}