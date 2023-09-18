<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskModel extends Model
{
    use SoftDeletes;

    protected $table = 't_tasks';

    protected $primaryKey = 'task_id';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'status',
        'labels',
        'due_date',
        'deleted_at'
    ];

    public function user() {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }

    public function files() {
        return $this->hasMany(TaskFileModel::class, 'task_id', 'task_id');
    }
}
