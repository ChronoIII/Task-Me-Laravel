<?php

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository
{
    private $oUserModel;

    public function __construct(UserModel $oUserModel) {
        $this->oUserModel = $oUserModel;
    }

    public function getUserData($aFilter) {
        $oUserData = $this->oUserModel->where($aFilter);
        if (empty($oUserData)) {
            return null;
        }
        return $oUserData->first();
    }

    public function saveUserData($oUserData) {
        return $this->oUserModel->updateOrCreate([
            'email' => $oUserData['email'],
        ], $oUserData);
    }
}
