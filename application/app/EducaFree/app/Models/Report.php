<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = "comment_reports";

    // Relacion para obtener los comentarios reportados
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relacion para obtener las respuestas reportadas
    public function replies()
    {
        return $this->hasMany(CommentReply::class);
    }
}
