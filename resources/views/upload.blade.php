<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/upload.css') }}">
    <title>Upload Certificate</title>
</head>
<body>

    <div class="fsuu-logo-container">
        <img src="{{ asset('FSUU Logo/fsuu2_1.png') }}" alt="University Logo" class="logo">
        <div class="logo-title-container">
            <h1 class="main-title">FSUU</h1>
            <h2 class="subtitle">Father Saturnino Urios University</h2>
        </div>
    </div>

    <div class="upload-container">
    <h1>Upload Certificate for Text Extraction</h1>

    <form action="{{ route('extractCertificateData') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="certificate">Upload Certificate Image:</label>
        <input type="file" name="certificate" id="certificate" accept="image/*" required>

         <!-- Hidden input for teacher_id -->
        <input type="hidden" name="teacher_id" value="{{ $teacher_id }}">

        <button type="submit">Extract Data</button>
    </form>
    </div>
</body>
</html>