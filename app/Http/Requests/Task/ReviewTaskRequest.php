<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class ReviewTaskRequest extends FormRequest
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
//            'status' => 'required|in:0,1,2',
//            'title' => 'nullable|string',
//            'deadline' => 'nullable|date',
//            'file' => 'nullable', // возможно, нужны дополнительные правила валидации для файла
//            'project_id' => 'nullable|integer|exists:projects,id',
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
