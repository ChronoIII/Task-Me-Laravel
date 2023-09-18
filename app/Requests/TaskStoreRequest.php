<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'task_id'       => ['nullable', 'integer'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'type'          => ['nullable', 'string'],
            'status'        => ['nullable', 'integer'],
            'due_date'      => ['nullable', 'date_format:Y-m-d H:i:s'],
            'labels'        => ['nullable', 'string'],
            'files'         => ['nullable', 'array'],
            'files.*'       => ['required'],
        ];
    }
}
