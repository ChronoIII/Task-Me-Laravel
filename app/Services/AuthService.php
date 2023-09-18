<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\UserModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthService extends Service
{
    protected $oUserRepository;

    public function __construct(UserRepository $oUserRepository) {
        $this->oUserRepository = $oUserRepository;
    }

    public function loginUser(array $oParams) {
        $oUserData = $this->oUserRepository->getUserData(['email' => $oParams['email']]);
        if ($oUserData === null) {
            $aErrors = ['email' => ['Email address not found']];
            return $this->returnError('Email address not found.', $aErrors, 404);
        }

        if (!Hash::check($oParams['password'], $oUserData->password)) {
            $aErrors = ['email' => ['Authentication failed']];
            return $this->returnError('Invalid email and/or password.', $aErrors, 422);
        }

        $oTokenData = $this->createSession($oUserData);
        return $this->returnSuccess($oTokenData, 200);
    }

    public function registerUser(array $oParams) {
        $oParams['password'] = Hash::make($oParams['password']);
        $oUserData = $this->oUserRepository->saveUserData($oParams);
        $oTokenData = $this->createSession($oUserData);
        return $this->returnSuccess($oTokenData, 200);
    }

    private function createSession(UserModel $oUserData, bool $bRemember = false) {
        $oToken = $oUserData->createToken('token of ' . $oUserData->name);
        $sHashedToken = Crypt::encryptString($oToken->plainTextToken);

        return [
            'user'  => $oUserData,
            'token' => $sHashedToken,
        ];
    }
}
