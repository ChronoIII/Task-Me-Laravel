<?php

namespace App\Repositories;

use App\Models\TaskModel;

class TaskRepository
{
    private $oTaskModel;

    public function __construct(TaskModel $oTaskModel) {
        $this->oTaskModel = $oTaskModel;
    }

    public function getTasks(array $aFilter, array $aPaginate = []) {
        return $this->oTaskModel
            ->where(array_filter($aFilter))
            ->when(!empty($aPaginate['keyword']), function($query) use ($aPaginate) {
                return $query->where($aPaginate['search'], 'like', '%' . $aPaginate['keyword'] . '%');
            })
            ->when(!empty($aPaginate['start_date']), function($query) use ($aPaginate) {
                return $query->where('due_date', '>', $aPaginate['start_date']);
            })
            ->when(!empty($aPaginate['end_date']), function($query) use ($aPaginate) {
                return $query->where('due_date', '<', $aPaginate['end_date']);
            })
            ->with([
                'user',
                'files'
            ])
            ->orderBy('created_at', 'DESC')
            ->paginate($aPaginate['count'] ?? 10)
            ->toArray();
    }

    public function getTask(int $iTaskId) {
        $oTask = $this->oTaskModel
            ->where('task_id', $iTaskId);

        if (empty($oTask)) {
            return null;
        }
        return $oTask
            ->with([
                'user',
                'files'
            ])
            ->first()
            ->toArray();
    }

    public function saveTask(array $oTaskData) {
        return $this->oTaskModel
            ->updateOrCreate([
                'task_id' => $oTaskData['task_id'] ?? null
            ], $oTaskData)
            ->toArray();
    }

    public function getArchivedTasks(array $aFilter, array $aPaginate = []) {
        return $this->oTaskModel
            ->onlyTrashed()
            ->where(array_filter($aFilter))
            ->when(!empty($aPaginate['keyword']), function($query) use ($aPaginate) {
                return $query->where($aPaginate['search'], 'like', '%' . $aPaginate['keyword'] . '%');
            })
            ->when(!empty($aPaginate['start_date']), function($query) use ($aPaginate) {
                return $query->where('due_date', '>', $aPaginate['start_date']);
            })
            ->when(!empty($aPaginate['end_date']), function($query) use ($aPaginate) {
                return $query->where('due_date', '<', $aPaginate['end_date']);
            })
            ->with([
                'user',
                'files'
            ])
            ->paginate($aPaginate['count'] ?? 10)
            ->toArray();
    }

    public function archiveTask(int $iTaskId) {
        $oTask = $this->oTaskModel->where('task_id', $iTaskId);
        if (empty($oTask)) {
            return null;
        }
        return $oTask->delete();
    }

    public function restoreTask(int $iTaskId) {
        $oTask = $this->oTaskModel->onlyTrashed()->where('task_id', $iTaskId);
        if (empty($oTask)) {
            return null;
        }
        return $oTask->restore();
    }

    public function deleteListTask(array $aArchivedIds) {
        return $this->oTaskModel->onlyTrashed()->whereIn('task_id', $aArchivedIds)->forceDelete();
    }
}
