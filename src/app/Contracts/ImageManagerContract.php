<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageManagerContract
{
    public function uploadImage(UploadedFile $file, string $uploadPath, string $fileName): string;
    public function deleteImage(string $filePath, string $fileName);
}
