<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use App\Requests\TaskStoreRequest;

class TaskController extends Controller
{
    private $oTaskService;

    public function __construct(TaskService $oTaskService) {
        $this->oTaskService = $oTaskService;
    }

    public function index() {
        $oParams = request()->all();
        $oParams['user_id'] = auth('sanctum')->user()->user_id;
        $oResponse = $this->oTaskService->getTasks($oParams);
        return response()->json($oResponse['data'], $oResponse['status']);
    }

    public function show(int $iTaskId) {
        $oResponse = $this->oTaskService->getTask($iTaskId);
        return response()->json($oResponse['data'], $oResponse['status']);
    }

    public function store(TaskStoreRequest $oRequest) {
        $oParams = $oRequest->validated();
        $oParams['user_id'] = auth('sanctum')->user()->user_id;
        $oResponse = $this->oTaskService->saveTask($oParams);
        return response()->json($oResponse['data'], $oResponse['status']);
    }
}
