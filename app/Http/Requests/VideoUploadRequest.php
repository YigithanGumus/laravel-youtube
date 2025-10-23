<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoUploadRequest extends FormRequest
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
            'video' => 'required|file|mimetypes:video/mp4,video/avi,video/mov|max:1228800',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'nullable|in:public,private,unlisted',
        ];
    }
}
