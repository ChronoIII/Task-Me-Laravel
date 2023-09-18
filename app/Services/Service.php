<?php

namespace App\Services;

class Service
{
    protected function returnSuccess(array $aResponse, int $iCode = 200) {
        return [
            'data'      => $aResponse,
            'status'    => $iCode,
        ];
    }

    protected function returnError(string $sMessage, array $aErrors = [], int $iCode = 500) {
        return [
            'data'      => [
                'message'   => $sMessage,
                'errors'    => $aErrors,
            ],
            'status'    => $iCode,
        ];
    }
}
