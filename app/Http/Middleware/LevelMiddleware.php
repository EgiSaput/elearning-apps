<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Auth as Auth;

class LevelMiddleware
{    
    public function handle($request, Closure $next, $level)
    {
    	$user = Auth::user();

        if ($user && $user->level != $level) {
            // Allow admins (11) and teachers (12) to access student routes (13) for testing purposes
            if ($level == '13' && in_array($user->level, ['11', '12'])) {
                return $next($request);
            }
            // Allow admins (11) and teachers (12) to access teacher routes (12)
            if ($level == '12' && in_array($user->level, ['11', '12'])) {
                return $next($request);
            }
            // Allow admins (11) and teachers (12) to access admin routes (11)
            if ($level == '11' && in_array($user->level, ['11', '12'])) {
                return $next($request);
            }

            return App::abort(Auth::check() ? 403 : 401, Auth::check() ? 'Forbidden' : 'Unauthorized');
            //return redirect()->back();

        }

        return $next($request);
    }
}
