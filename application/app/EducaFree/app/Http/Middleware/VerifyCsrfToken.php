<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

     //Se añaden las siguientes rutas a la lista de exclusiones del LTI para una comunicacion con los LMS
    protected $except = [
        '/logout',
        '/lti',
        '/lti/*'
    ];
}
