<?php

namespace App\Repositories;

use App\Models\TaskFileModel;

class TaskFileRepository
{
    private $oTaskFileModel;

    public function __construct(TaskFileModel $oTaskFileModel) {
        $this->oTaskFileModel = $oTaskFileModel;
    }

    public function saveFile($oTaskFileData) {
        return $this->oTaskFileModel
            ->updateOrCreate([
                'task_file_id' => $oTaskFileData['task_file_id'] ?? null
            ], $oTaskFileData)
            ->toArray();
    }
}
