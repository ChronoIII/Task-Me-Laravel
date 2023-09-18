<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Services\TaskService;

class ArchiveController extends Controller
{
    private $oTaskService;

    public function __construct(TaskService $oTaskService) {
        $this->oTaskService = $oTaskService;
    }

    public function index() {
        $oParams = request()->all();
        $oParams['user_id'] = auth('sanctum')->user()->user_id;
        $oResponse = $this->oTaskService->getArchivedTask($oParams);
        return response()->json($oResponse['data'], $oResponse['status']);
    }

    public function update(int $iTaskId) {
        $oResponse = $this->oTaskService->archiveTask($iTaskId);
        return response()->json($oResponse['data'], $oResponse['status']);
    }

    public function destroy(int $iTaskId) {
        $oResponse = $this->oTaskService->restoreTask($iTaskId);
        return response()->json($oResponse['data'], $oResponse['status']);
    }
}
