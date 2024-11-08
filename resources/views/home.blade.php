<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css')}}">
    <title>Home</title>
</head>
<body>
  <div class="container">
    <h1>Extracted Certificate Data</h1>

    <!-- Upload Button -->
    <div class="mb-4">
      <a href="{{ url('/upload') }}" class="btn btn-success">Upload New Certificate</a>
    </div>

    <form action="{{ route('home') }}" method="GET" class="mb-4">
      <div class="input-group">
          <input type="text" name="query" class="form-control" placeholder="Search..." value="{{ request('query') }}">
          <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

        <table class="table" border="1">
        <thead>
            <tr>
                <th>Document Number:</th>
                <th>Type:</th>
                <th>Name:</th>
                <th>Title:</th>
                <th>Date:</th>
                <th>OCR Output:</th>
                <th>Points:</th>
                <th>Actions:</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($allCertificates as $certificate)
          <tr>
              <form action="{{ route('certificate.update', $certificate->id) }}" method="POST">
                  @csrf
                  <td><input type="text" name="id" value="{{ $certificate->id }}"></td>
                  <td><input type="text" name="type" value="{{ $certificate->type }}"></td>
                  <td><input type="text" name="name" value="{{ $certificate->name }}"></td>
                  <td><input type="text" name="title" value="{{ $certificate->title }}"></td>
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
          @endforeach
        </tbody>
    </table>
</div>

<div class="mb-4">
  <a href="{{ url('/summary') }}" class="btn btn-success">Ranking Summary</a>
</div>
</div>

</body>
</html>