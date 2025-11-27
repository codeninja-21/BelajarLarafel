<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan sudah login dulu (admin_id ada di session)
        if (!session()->has('admin_id')) {
            return redirect()->route('login');
        }

        $userRole = session('admin_role');

        // Jika role dibatasi dan role user tidak termasuk di dalamnya, tolak akses
        if (!empty($roles) && !in_array($userRole, $roles)) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
