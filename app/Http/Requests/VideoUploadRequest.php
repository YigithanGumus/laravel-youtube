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
            'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private,unlisted',
            'thumbnail_image' => 'nullable|file|mimes:jpg,bmp,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            "video.required"=>"Video yüklenmesi zorunludur!",
            "video.file"=>"Dosya biçiminde olmalıdır!",
            "video.mimetypes"=>"Video MP4, AVI veya MOV  formatında olmalıdır!",
            "video.max"=>"Videoyu maksimum 1.17 GB olarak yükleyebilirsiniz!",
            "title.required"=>"Video başlığı zorunludur!",
            "title.max"=>"Video maksimum 255 karakter olmak zorundadır!",
            "title.min"=>"Video minimum 3 karakter olmak zorundadır!",
            "visibility.required"=>"Video görünürlüğü seçilmesi zorunludur!",
            "visibility.in"=>"Video görünürlüğü seçeneklerinden herhangi bir başkası seçeneğini seçemezsiniz!",
            "thumbnail_image.file"=>"Küçük resim dosya formatında olması zorundadır!",
            "thumbnail_image.mimes"=>"Küçük resim JPG, BMP veya PNG olması zorundadır!",
            "thumbnail_image.max"=>"Küçük resim maksimum 2 MB olması zorundadır!",
        ];
    }
}
