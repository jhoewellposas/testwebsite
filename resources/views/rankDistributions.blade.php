<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('styling/rank.css') }}">
    <link rel="icon" href="{{ asset('FSUU Logo/fsuu2_1.png') }}" type="image/png">
    <title>Distribution Points</title>
</head>
<body>

    <div class="upper-container">
        <a href="{{ route('home') }}" class="btn btn-home">Home</a>
    </div>

<div class="container">
    <h1>Rank Distributions</h1>
    <form action="{{ route('rankDistributions.update') }}" method="POST">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Productive Scholarship_A (%)</th>
                    <th>Productive Scholarship_B (%)</th>
                    <th>Community Extension Services_A (%)</th>
                    <th>Community Extension Services_A (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rankDistributions as $distribution)
                <tr>
                    <td>
                        <input type="text" name="distributions[{{ $loop->index }}][rank]" value="{{ $distribution->rank }}" readonly>
                    </td>
                    <td>
                        <input type="number" step="0.01" name="distributions[{{ $loop->index }}][productiveGroupAPercentage]" value="{{ $distribution->productiveGroupAPercentage }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="distributions[{{ $loop->index }}][productiveGroupBPercentage]" value="{{ $distribution->productiveGroupBPercentage }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="distributions[{{ $loop->index }}][communityGroupAPercentage]" value="{{ $distribution->communityGroupAPercentage }}">
                    </td>
                    <td>
                        <input type="number" step="0.01" name="distributions[{{ $loop->index }}][communityGroupBPercentage]" value="{{ $distribution->communityGroupBPercentage }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

    

</body>
</html>