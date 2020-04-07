<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class UserPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $divisi , $posisi)
    { 
		if (strtolower(Auth::user()->divisi->name) == $divisi &&  strtolower(Auth::user()->posisi->name) == $posisi) {
				return $next($request);
		 }

		return redirect()->back()->with('info', 'halaman tidak dapat di akses');
    }
}
