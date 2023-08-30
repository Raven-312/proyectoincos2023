<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Camouflage
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
        if(!session('idSession')) {
            return Redirect::route('root');
        }
        if(session('accessSession')){
            $controllers = ['usuarios','fondos'];
            if(session('accessSession') != 'root'){
                $url = explode("/",url()->current());
                for($i=0; $i<count($controllers); $i++){
                    if($controllers[$i] == $url[3]){
                        return response()->view('errors.403', [], 403);
                        break;
                    }
                }
            }
        }
        return $next($request);
    }
}
