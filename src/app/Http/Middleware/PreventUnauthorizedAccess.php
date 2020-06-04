<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PreventUnauthorizedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $email = $request->session()->get('user_email');
        $human = $request->session()->get('human');
        $user = Auth::user();
        $admin = false;

        if ($user) {
            $admin = $user->is_admin;
        }

        if ($admin) {
            return $next($request);
        } else if (!$email || !$human) {
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
