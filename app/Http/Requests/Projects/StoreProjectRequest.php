<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'name'          => ['required', 'string', 'min:3', 'max:121'],
            'description'   => ['required', 'string', 'max:255'],
            'started_at'    => ['nullable', 'date'],
            'finished_at'   => ['nullable', 'date'],
        ];
    }
}
