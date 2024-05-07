<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    //Relacion de las lecciones de este curso

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }

    //Relacion de los usuarios que han accedido a este curso
    public function users(){
        return $this->hasMany(User::class);
    }
}
