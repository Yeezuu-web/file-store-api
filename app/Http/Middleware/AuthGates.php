<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        $roles           = Role::with('permissions')->get();
        $permissionArray = [];

        foreach ($roles as $role) {
            foreach ( $role->permissions as $permissions) {
                $permissionArray[$permissions->title][] = $role->id;
            }
        }

        foreach ($permissionArray as $title => $roles) {
            Gate::define($title, fn ($user) => count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0);
        }

        return $next($request);
    }
}
