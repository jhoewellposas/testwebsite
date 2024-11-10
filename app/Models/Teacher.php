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
    'acad_attainment',
    'performance',
    'experience',
    ];

    public function certificates()
    {
    return $this->hasMany(Certificate::class);
    }
}
