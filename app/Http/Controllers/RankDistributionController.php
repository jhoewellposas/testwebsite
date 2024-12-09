<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RankDistribution;

class RankDistributionController extends Controller
{
    public function index()
    {
        $rankDistributions = RankDistribution::all();
        return view('rankDistributions', compact('rankDistributions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'distributions.*.rank' => 'required|string',
            'distributions.*.productiveGroupAPercentage' => 'required|numeric|between:0,1',
            'distributions.*.productiveGroupBPercentage' => 'required|numeric|between:0,1',
            'distributions.*.communityGroupAPercentage' => 'required|numeric|between:0,1',
            'distributions.*.communityGroupBPercentage' => 'required|numeric|between:0,1',
        ]);

        foreach ($request->input('distributions') as $distribution) {
            RankDistribution::updateOrCreate(
                ['rank' => $distribution['rank']],
                $distribution
            );
        }

        return back()->with('success', 'Distributions updated successfully!');
    }
}
