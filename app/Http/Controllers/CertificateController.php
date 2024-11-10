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
    }

    public function updateCertificate(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->update($request->only('type', 'name', 'title', 'date', 'points'));

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

  /*  public function debugExtract(Request $request)
{
    if ($request->hasFile('certificate')) {
        return response()->json(['message' => 'File uploaded successfully', 'data' => $request->all()]);
    } else {
        return response()->json(['message' => 'File not uploaded', 'data' => $request->all()]);
    }
}*/
}