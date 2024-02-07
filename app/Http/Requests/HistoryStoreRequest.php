<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'topic_id' => ['required', 'exists:topics,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
