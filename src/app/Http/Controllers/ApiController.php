<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        // $this->middleware('client.credentials')->only(['index', 'show']);
    }

    protected function _uploadImageFromRequest(&$request, &$data, $uploadPath, $swap = false, $fileColumnName = 'main_image')
    {
        if ($request->hasFile($fileColumnName)) {
            try {
                if ($swap && $data->{$fileColumnName}) {
                    Storage::delete($data->{$fileColumnName});
                    Log::error('Deleted ' . $data->{$fileColumnName});
                }
                $path = Storage::disk('s3')->put($uploadPath, $request[$fileColumnName], ['ACL' => 'public-read']);
                $data[$fileColumnName] = Storage::disk('s3')->url($path);
            } catch (Exception $e) {
                Log::error($e);
                throw new HttpException('画像ファイル送信中にエラーが発生しました。時間を置いて再度更新してください。');
            }
        }
    }

    protected function _deleteImageFromRequest(&$data, $fileColumnName = 'main_image')
    {
        try {
            Storage::delete($data->{$fileColumnName});
            $data->{$fileColumnName} = null;
        } catch (Exception $e) {
            Log::error($e);
            throw new HttpException('画像ファイル削除中にエラーが発生しました。時間を置いて再度更新してください。');
        }
    }
}
