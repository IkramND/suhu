<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $role = Role::find($request->role_id);
        $user = Auth::user();

        // if(Auth::check() && Auth::user()->$role && $role->role == 'Admin' || Auth::cek() && Auth::user()->$role->role == 'admin')  {
        // return $next($request);
        // }

        if ($user && $user->role && strtolower($user->role->role) === 'admin') {
            return $next($request);
        }

        return redirect('/login')->withErrors(['error' => '*You Dont Have Permission To Access Admins Page']);
    }
}
