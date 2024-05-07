<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relacion para obtener el curso al que pertenece la leccion
    public function courses(){
        return $this->belongsTo(Course::class);
    }

    // Relacion para obtener los puntos de la leccion
    public function points(){
        return $this->hasMany(Point::class);
    }
}
