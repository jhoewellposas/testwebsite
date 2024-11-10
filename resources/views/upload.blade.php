<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Certificate</title>
</head>
<body>
    <h1>Upload Certificate for Text Extraction</h1>

    <form action="{{ route('extractCertificateData') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="certificate">Upload Certificate Image:</label>
        <input type="file" name="certificate" id="certificate" accept="image/*" required>

          <!-- Teacher Selection Dropdown -->
          <label for="teacher_id">Select Teacher:</label>
          <select name="teacher_id" id="teacher_id" required>
              <option value="">-- Select a Teacher --</option>
              @foreach($allTeachers as $teacher)
                  <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
              @endforeach
          </select>

        <button type="submit">Extract Data</button>
    </form>
</body>
</html>
