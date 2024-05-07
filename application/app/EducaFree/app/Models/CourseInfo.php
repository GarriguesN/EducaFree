<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseInfo extends Model
{
    use HasFactory;

    protected $table = "course_info";

    protected $fillable = [
        'user_id',
        'course_id',
        'progress',
        'last_lesson_id',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
