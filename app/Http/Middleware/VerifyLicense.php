<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Installer\LicenseBoxController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Routing\UrlGenerator;

use Session;



class VerifyLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {         
              return $next($request);
           

        
    }
}
