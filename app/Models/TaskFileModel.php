<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFileModel extends Model
{
    protected $table = 't_task_files';

    protected $primaryKey = 'task_file_id';

    protected $fillable = [
        'task_id',
        'file_path',
        'file_name',
    ];
}
