<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
       

        if (auth()->user()->admin != true) {
            return redirect('home')->with('menssagem','Voce nao pode cadastrar contacte o administrador');
        }


        return $next($request);
    }
}
