<?php

namespace App\Services;

use App\Contracts\ImageManagerContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AwsImageManager implements ImageManagerContract
{
    public function uploadImage(UploadedFile $file, $uploadPath, $fileName): string
    {
        try {
            $path = Storage::disk('s3')->put($uploadPath . '/' . $fileName, $file, ['ACL' => 'public-read']);
            $imageUrl = Storage::disk('s3')->url($path);
        } catch (Exception $e) {
            Log::error($e);
            throw new HttpException(500, '画像ファイル送信中にエラーが発生しました。時間を置いて再度更新してください。');
        }
        return $imageUrl;
    }

    public function deleteImage($filePath, $fileName)
    {
        try {
            Log::debug("Deleting image...");
            Log::debug($filePath . '/' . $fileName);
            Storage::disk('s3')->delete($filePath . '/' . $fileName);
        } catch (Exception $e) {
            Log::error($e);
            throw new HttpException(500, '画像ファイル削除中にエラーが発生しました。時間を置いて再度更新してください。');
        }
    }
}
