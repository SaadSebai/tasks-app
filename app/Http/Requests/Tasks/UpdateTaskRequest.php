<?php

namespace App\Http\Requests\Tasks;

use App\Enums\EstimationType;
use App\Enums\Priorities;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'                 => ['required', 'string', 'min:3', 'max:121'],
            'description'           => ['nullable', 'string', 'min:3', 'max:1000'],
            'status'                => ['required', 'string', new Enum(TaskStatus::class)],
            'priority'              => ['required', 'string', new Enum(Priorities::class)],
            'progression'           => ['required', 'integer', 'min:0', 'max:100'],
            'estimated_duration'    => ['nullable', 'required_with:estimation_type', 'integer', 'min:0', 'max:1000'],
            'estimation_type'       => ['nullable', 'required_with:estimated_duration', 'string', new Enum(EstimationType::class)],
            'deadline'              => ['nullable', 'date'],
            'started_at'            => ['nullable', 'date', 'after_or_equal:finished_at'],
            'finished_at'           => ['nullable', 'date'],
        ];
    }
}
