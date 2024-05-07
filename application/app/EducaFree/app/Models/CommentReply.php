<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;
    
    protected $table = "comment_replies";

    protected $fillable = [
        'comment_id',
        'user_id',
        'comment',
    ];

    // Relación con el comentario al que responde esta respuesta
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Relación con el usuario que escribió esta respuesta
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
