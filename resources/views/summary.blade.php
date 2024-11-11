<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/summary.css')}}">
    <title>Summary</title>
</head>
<body>
    <div class="header">
    <h1>SUMMARY</h1></div>  

    <div class="mb-4">
        <a href="{{ url('/home') }}" class="btn btn-success">Home</a>
      </div>

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



  <div class="signature-form">
    <h2>Rank:</h2>
    <h3>Prepared by:</h3>
    <h3>Verified and Reviewed by Rank and Tenure COmmittee</h3>
    <h3>Date:</h3>
    <h3>Name & signiture of member</h3>
    <h3>Name & signiture of chair</h3>

        <div class="approved-section">
            <h3>Approved</h3>
            <h3>Date:</h3>
            <h3>President</h3>
        </div>
  </div>

</body>
</html>