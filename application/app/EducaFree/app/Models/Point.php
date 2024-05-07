<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Point extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $cast = [
        'explanation' => PurifyHtmlOnGet::class
    ];
    //Relacion para obtener a que leccion pertenece
    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
}
