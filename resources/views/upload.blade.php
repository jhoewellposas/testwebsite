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

    <form action="/extract" method="post" enctype="multipart/form-data">
        @csrf
        <label for="certificate">Upload Certificate Image:</label>
        <input type="file" name="certificate" id="certificate" accept="image/*">
        <button type="submit">Extract Data</button>
    </form>
</body>
</html>
