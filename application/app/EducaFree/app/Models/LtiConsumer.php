<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LtiConsumer extends Model
{
    use HasFactory;

    protected $table = 'lti2_consumer';

    public $timestamps = true;

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
