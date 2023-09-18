<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class VerifyToken
{
    public function handle(Request $oRequest, Closure $oNext) {
        $sToken = $_COOKIE[config('auth.token.key')] ?? '';
        if (!$sToken) {
            return abort('401');
        }

        $sDescryptToken = Crypt::decryptString($sToken);
        $oRequest->headers->add([
            'Authorization' => 'Bearer ' . $sDescryptToken,
        ]);
        if (!auth('sanctum')->user()) {
            return abort('401');
        }
        return $this->refreshCookieLife($oNext($oRequest), $sToken);
    }

    private function refreshCookieLife($oResponse, $sEncryptToken) {
        $oCookie = cookie(config('auth.token.key'), $sEncryptToken, config('auth.token.ttl'));
        return $oResponse->withCookie($oCookie);
    }
}
