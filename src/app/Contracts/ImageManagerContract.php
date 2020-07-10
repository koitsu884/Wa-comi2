<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageManagerContract
{
    public function uploadImage(UploadedFile $file, string $uploadPath): string;
    public function getImageFullUrl(string $path) : string;
    public function deleteImage(string $url) : bool;
}
