<?php

namespace App\Services;

use App\Contracts\ImageManagerContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AwsImageManager implements ImageManagerContract
{
    public function uploadImage(UploadedFile $file, $uploadPath): string
    {
        try {
            return Storage::disk('s3')->put($uploadPath , $file, ['ACL' => 'public-read']);
        } catch (Exception $e) {
            Log::error($e);
            throw new HttpException(500, '画像ファイル送信中にエラーが発生しました。時間を置いて再度更新してください。');
        }
    }

    public function getImageFullUrl($path) : string
    {
        return  Storage::disk('s3')->url($path);
    }

    public function uploadImages(array $files, $uploadPath)
    {
        
    }

    public function deleteImage($url) : bool
    {
        return Storage::disk('s3')->delete($url);
    }
}
