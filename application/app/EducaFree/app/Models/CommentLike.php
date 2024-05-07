<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'comment_likes';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'comment_id',
        'liked_at'
    ];

    public $timestamps = false;

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Comment model
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
