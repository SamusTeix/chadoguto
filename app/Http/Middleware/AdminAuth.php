<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\AdminController;

class AdminAuth
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
        $controller = new AdminController();
        if ($controller->hasAdminPermission()) 
        {
            return $next($request);
        }
        return redirect('/admin')->with('Você precisa fazer login para acessar esta área!');
    }
}
