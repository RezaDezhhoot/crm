<?php

namespace App\Http\Requests\Departments;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required','string','max:150'],
            'description' => ['nullable','string','max:300'],
            'projects' => ['array','max:10','nullable'],
            'projects.*' => ['exists:projects,project_id']
        ];
    }
}
