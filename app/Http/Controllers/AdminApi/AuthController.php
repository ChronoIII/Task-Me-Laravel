<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Requests\UserLoginRequest;
use App\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    private $oAuthService;

    public function __construct(AuthService $oAuthService) {
        $this->oAuthService = $oAuthService;
    }

    public function login(UserLoginRequest $oRequest) {
        $oParams = $oRequest->validated();
        $oResponse = $this->oAuthService->loginUser($oParams);
        if ($oResponse['status'] !== 200) {
            return response()->json($oResponse['data'], $oResponse['status']);
        }
        $oCookie = cookie(config('auth.token.key'), $oResponse['data']['token'], config('auth.token.ttl'));
        return response()->json($oResponse['data'], $oResponse['status'])->withCookie($oCookie);
    }

    public function register(UserRegisterRequest $oRequest) {
        $oParams = $oRequest->validated();
        $oResponse = $this->oAuthService->registerUser($oParams);
        return response()->json($oResponse['data'], $oResponse['status']);
    }

    public function logout() {
        $oCookie = cookie(config('auth.token.key'), null, 0);
        return response()->json(null, 204)->withCookie($oCookie);
    }
}
