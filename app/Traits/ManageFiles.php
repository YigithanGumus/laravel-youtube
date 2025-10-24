<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait ManageFiles
{
    public function uploadFile($file, $directory)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalName . '_' . time() . '.' . $file->extension();

        $file->move(public_path($directory), $fileName);

        return str_replace('\\', '/', $directory . '/' . $fileName);
    }

    public function deleteFile($filePath)
    {
        $file = public_path($filePath);
        return File::delete($file);
    }
}

