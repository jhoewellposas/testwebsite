<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RankDistribution;

class RankDistributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Default percentage distributions
        $defaultDistributions = [
            'productiveGroupAPercentage' => 0.8,
            'productiveGroupBPercentage' => 0.2,
            'communityGroupAPercentage' => 0.7,
            'communityGroupBPercentage' => 0.3,
        ];

         // Custom distributions for specific ranks
         $customDistributions = [
            'Teacher 5' => [
                'productiveGroupAPercentage' => 0.75,
                'productiveGroupBPercentage' => 0.25,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Teacher 5 SQ' => [
                'productiveGroupAPercentage' => 0.75,
                'productiveGroupBPercentage' => 0.25,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Instructor 1' => [
            'productiveGroupAPercentage' => 0.75,
            'productiveGroupBPercentage' => 0.25,
            'communityGroupAPercentage' => 0.65,
            'communityGroupBPercentage' => 0.35,
            ],
            'Instructor 1 SQ' => [
                'productiveGroupAPercentage' => 0.75,
                'productiveGroupBPercentage' => 0.25,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Senior Teacher 1' => [
                'productiveGroupAPercentage' => 0.7,
                'productiveGroupBPercentage' => 0.3,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Senior Teacher 1 SQ' => [
                'productiveGroupAPercentage' => 0.7,
                'productiveGroupBPercentage' => 0.3,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Instructor 2' => [
                'productiveGroupAPercentage' => 0.7,
                'productiveGroupBPercentage' => 0.3,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Instructor 2 SQ' => [
                'productiveGroupAPercentage' => 0.7,
                'productiveGroupBPercentage' => 0.3,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Senior Teacher 2' => [
                'productiveGroupAPercentage' => 0.65,
                'productiveGroupBPercentage' => 0.35,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Senior Teacher 2 SQ' => [
                'productiveGroupAPercentage' => 0.65,
                'productiveGroupBPercentage' => 0.35,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Instructor 3' => [
                'productiveGroupAPercentage' => 0.65,
                'productiveGroupBPercentage' => 0.35,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Instructor 3 SQ' => [
                'productiveGroupAPercentage' => 0.65,
                'productiveGroupBPercentage' => 0.35,
                'communityGroupAPercentage' => 0.65,
                'communityGroupBPercentage' => 0.35,
            ],
            'Senior Teacher 3' => [
                'productiveGroupAPercentage' => 0.6,
                'productiveGroupBPercentage' => 0.4,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Senior Teacher 3 SQ' => [
                'productiveGroupAPercentage' => 0.6,
                'productiveGroupBPercentage' => 0.4,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Assistant Professor 1' => [
                'productiveGroupAPercentage' => 0.6,
                'productiveGroupBPercentage' => 0.4,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Assistant Professor 1 SQ' => [
                'productiveGroupAPercentage' => 0.6,
                'productiveGroupBPercentage' => 0.4,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Senior Teacher 4' => [
                'productiveGroupAPercentage' => 0.55,
                'productiveGroupBPercentage' => 0.45,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Senior Teacher 4 SQ' => [
                'productiveGroupAPercentage' => 0.55,
                'productiveGroupBPercentage' => 0.45,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Assistant Professor 2' => [
                'productiveGroupAPercentage' => 0.55,
                'productiveGroupBPercentage' => 0.45,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Assistant Professor 2 SQ' => [
                'productiveGroupAPercentage' => 0.55,
                'productiveGroupBPercentage' => 0.45,
                'communityGroupAPercentage' => 0.6,
                'communityGroupBPercentage' => 0.4,
            ],
            'Senior Teacher 5' => [
                'productiveGroupAPercentage' => 0.5,
                'productiveGroupBPercentage' => 0.5,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Senior Teacher 5 SQ' => [
                'productiveGroupAPercentage' => 0.5,
                'productiveGroupBPercentage' => 0.5,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Associate Professor 1' => [
                'productiveGroupAPercentage' => 0.5,
                'productiveGroupBPercentage' => 0.5,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Associate Professor 1 SQ' => [
                'productiveGroupAPercentage' => 0.5,
                'productiveGroupBPercentage' => 0.5,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 1' => [
                'productiveGroupAPercentage' => 0.45,
                'productiveGroupBPercentage' => 0.55,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 1 SQ' => [
                'productiveGroupAPercentage' => 0.45,
                'productiveGroupBPercentage' => 0.55,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Associate Professor 2' => [
                'productiveGroupAPercentage' => 0.45,
                'productiveGroupBPercentage' => 0.55,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Associate Professor 2 SQ' => [
                'productiveGroupAPercentage' => 0.45,
                'productiveGroupBPercentage' => 0.55,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 2' => [
                'productiveGroupAPercentage' => 0.4,
                'productiveGroupBPercentage' => 0.6,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 2 SQ' => [
                'productiveGroupAPercentage' => 0.4,
                'productiveGroupBPercentage' => 0.6,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Full Professor 1' => [
                'productiveGroupAPercentage' => 0.4,
                'productiveGroupBPercentage' => 0.6,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Full Professor 1 SQ' => [
                'productiveGroupAPercentage' => 0.4,
                'productiveGroupBPercentage' => 0.6,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 3' => [
                'productiveGroupAPercentage' => 0.35,
                'productiveGroupBPercentage' => 0.65,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 3 SQ' => [
                'productiveGroupAPercentage' => 0.35,
                'productiveGroupBPercentage' => 0.65,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Full Professor 2' => [
                'productiveGroupAPercentage' => 0.35,
                'productiveGroupBPercentage' => 0.65,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Full Professor 2 SQ' => [
                'productiveGroupAPercentage' => 0.35,
                'productiveGroupBPercentage' => 0.65,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 4' => [
                'productiveGroupAPercentage' => 0.3,
                'productiveGroupBPercentage' => 0.7,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Master Teacher 4 SQ' => [
                'productiveGroupAPercentage' => 0.3,
                'productiveGroupBPercentage' => 0.7,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Full Professor 3' => [
                'productiveGroupAPercentage' => 0.3,
                'productiveGroupBPercentage' => 0.7,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
            'Full Professor 3 SQ' => [
                'productiveGroupAPercentage' => 0.3,
                'productiveGroupBPercentage' => 0.7,
                'communityGroupAPercentage' => 0.5,
                'communityGroupBPercentage' => 0.5,
            ],
        ];

        $ranks = [
            'Teacher 1', 'Teacher 1 SQ',
            'Teacher 2', 'Teacher 2 SQ',
            'Teacher 3', 'Teacher 3 SQ',
            'Teacher 4', 'Teacher 4 SQ',
            'Teacher 5', 'Teacher 5 SQ',
            'Senior Teacher 1', 'Senior Teacher 1 SQ',
            'Senior Teacher 2', 'Senior Teacher 2 SQ',
            'Senior Teacher 3', 'Senior Teacher 3 SQ',
            'Senior Teacher 4', 'Senior Teacher 4 SQ',
            'Senior Teacher 5', 'Senior Teacher 5 SQ',
            'Master Teacher 1', 'Master Teacher 1 SQ',
            'Master Teacher 2', 'Master Teacher 2 SQ',
            'Master Teacher 3', 'Master Teacher 3 SQ',
            'Master Teacher 4', 'Master Teacher 4 SQ',
            'Lecturer 1', 'Lecturer 1 SQ',
            'Lecturer 2', 'Lecturer 2 SQ',
            'Lecturer 3', 'Lecturer 3 SQ',
            'Assistant Instructor', 'Assistant Instructor SQ',
            'Instructor 1', 'Instructor 1 SQ',
            'Instructor 2', 'Instructor 2 SQ',
            'Instructor 3', 'Instructor 3 SQ',
            'Assistant Professor 1', 'Assistant Professor 1 SQ',
            'Assistant Professor 2', 'Assistant Professor 2 SQ',
            'Associate Professor 1', 'Associate Professor 1 SQ',
            'Associate Professor 2', 'Associate Professor 2 SQ',
            'Full Professor 1', 'Full Professor 1 SQ',
            'Full Professor 2', 'Full Professor 2 SQ',
            'Full Professor 3', 'Full Professor 3 SQ',
        ];

        foreach ($ranks as $rank) {
            $distribution = $customDistributions[$rank] ?? $defaultDistributions;

            RankDistribution::updateOrCreate(
                ['rank' => $rank],
                $distribution
            );
        }
    }
}
