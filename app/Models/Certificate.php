<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
    'category',
    'type',
    'name',
    'title',
    'organization',
    'designation',
    'days',
    'date',
    'raw_text',
    'points',
    'teacher_id'//
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
