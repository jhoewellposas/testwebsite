<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
    'name',
    'role',
    'school_id',
    'acad_attainment',
    'performance',
    'experience',
    'date',
    'office',
    'points',
    'present_rank',
    'next_rank',
    ];

    public function certificates()
    {
    return $this->hasMany(Certificate::class);
    }
}
