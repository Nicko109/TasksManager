<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'deadline' => 'required|date',
            'file' => 'nullable',
            'project_id' => 'required|integer|exists:projects,id',
            'performer_id' => 'required|string|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Это поле необходимо для заполнения',
            'title.string' => 'Данные должны соответствовать строчному типу',
            'deadline.required' => 'Это поле необходимо для заполнения',
            'deadline.date' => 'Данные должны соответствовать типу даты',
            'file.file' => 'Необходимо выбрать файл',
            'project_id.required' => 'Это поле необходимо для заполнения',
            'project_id.integer' => 'Id проекта должен быть числом',
            'project_id.exists' => 'Id проекта должен быть в базе данных',
        ];
    }
}
