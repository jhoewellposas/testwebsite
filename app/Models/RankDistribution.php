<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'rank',
        'productiveGroupAPercentage',
        'productiveGroupBPercentage',
        'communityGroupAPercentage',
        'communityGroupBPercentage',
    ];
}
