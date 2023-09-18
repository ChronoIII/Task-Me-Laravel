<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Repositories\TaskFileRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TaskService extends Service
{
    protected $oTaskRepository;

    protected $oTaskFileRepository;

    public function __construct(TaskRepository $oTaskRepository, TaskFileRepository $oTaskFileRepository) {
        $this->oTaskRepository = $oTaskRepository;
        $this->oTaskFileRepository = $oTaskFileRepository;
    }

    public function getTasks(array $oParams) {
        $aFilter = Arr::only($oParams, ['user_id', 'status', 'type']);
        $oTaskList = $this->oTaskRepository->getTasks($aFilter, $oParams);
        return $this->returnSuccess($oTaskList, 200);
    }

    public function getTask(int $iTaskId) {
        $oTaskData = $this->oTaskRepository->getTask($iTaskId);
        if (empty($oTaskData)) {
            $aErrors = ['task' => ['Task Id not found.']];
            return $this->returnError('Task Id not found', $aErrors, 404);
        }
        if ($oTaskData['user_id'] !== auth('sanctum')->user()->user_id) {
            $aErrors = ['task' => ['Unauthorized']];
            return $this->returnError('You do not own the task', $aErrors, 401);
        }
        return $this->returnSuccess($oTaskData, 200);
    }

    public function saveTask(array $oTaskData) {
        $oTaskResponse = $this->oTaskRepository->saveTask($oTaskData);
        $aFiles = $oTaskData['files'] ?? [];
        foreach ($aFiles as $oFile) {
            $this->saveTaskFile($oTaskResponse, $oFile);
        }
        return $this->returnSuccess($oTaskResponse, 200);
    }

    public function getArchivedTask(array $oParams = []) {
        // Delete first expired archived tasks
        $this->deleteExpiredArchives();

        $aFilter = Arr::only($oParams, ['user_id', 'status', 'type']);
        $oTaskList = $this->oTaskRepository->getArchivedTasks($aFilter, $oParams);
        return $this->returnSuccess($oTaskList, 200);
    }

    public function restoreTask(int $iTaskId) {
        $bTaskData = $this->oTaskRepository->restoreTask($iTaskId);
        if (!$bTaskData) {
            $aErrors = ['task' => ['Task Id not found.']];
            return $this->returnError('Task Id not found', $aErrors, 404);
        }
        return $this->returnSuccess(['result' => $bTaskData], 200);
    }

    public function archiveTask(int $iTaskId) {
        $bTaskData = $this->oTaskRepository->archiveTask($iTaskId);
        if (!$bTaskData) {
            $aErrors = ['task' => ['Task Id not found.']];
            return $this->returnError('Task Id not found', $aErrors, 404);
        }
        return $this->returnSuccess(['task' => $bTaskData], 200);
    }

    private function saveTaskFile(array $oTaskData, $oFile) {
        $sFilename = sprintf('%s/%s', 'task_files', $oTaskData['task_id']);
        $sFilePath = Storage::put($sFilename, $oFile);

        return $this->oTaskFileRepository->saveFile([
            'task_id'   => $oTaskData['task_id'],
            'file_path' => $sFilePath,
            'file_name' => basename($sFilePath)
        ]);
    }

    private function deleteExpiredArchives() {
        $aExpiredArchives = $this->oTaskRepository->getArchivedTasks([
            ['deleted_at', '<', Carbon::now()->subDays(7)]
        ]);
        if (empty($aExpiredArchives['data'])) {
            return true;
        }

        $aExpiredIdList = Arr::pluck($aExpiredArchives['data'], 'task_id');
        return $this->oTaskRepository->deleteListTask($aExpiredIdList);
    }
}
