<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'comment'
    ];

    // Relación con el usuario que escribió este comentario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el curso al que pertenece este comentario
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relación con las respuestas de este comentario
    public function replies()
    {
        return $this->hasMany(CommentReply::class);
    }

    // Relación con los likes de este comentario
    public function favorites()
    {
        return $this->hasMany(CommentLike::class);
    }
}
