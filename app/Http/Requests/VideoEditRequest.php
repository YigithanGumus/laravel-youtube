<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoEditRequest extends FormRequest
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
            'video.title' => 'required|max:255',
            'video.description' => 'nullable|max:1000',
            'video.visibility' => 'required|in:private,public,unlisted',
        ];
    }
}
