<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $sToken = $_COOKIE[config('auth.token.key')] ?? '';
        if (!$sToken) {
            return $next($request);
        }

        $sDecryptToken = Crypt::decryptString($sToken);
        $request->headers->add([
            'Authorization' => 'Bearer ' . $sToken,
        ]);

        if (auth('sanctum')->user()) {
            return redirect('/');
        }
        return $next($request);
    }
}
