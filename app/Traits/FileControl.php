<?php
namespace App\Traits;

use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Str;
use File;
use Response;
use Storage;

trait FileControl {

    public function file_upload($file, $subFolder, $thumb) {
        $def_wid = config('const.file.def_wid');
        $def_hei = config('const.file.def_hei');
        $thumb_wid = config('const.file.thumb_wid');
        $thumb_hei = config('const.file.thumb_hei');
        $mimeTypes=['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
        $mimeContentType = mime_content_type($file->getPathName());
        $physicalPath = storage_path('app/public/');
        $physicalFullPath = $physicalPath.$subFolder;
        $image_info;
        if (in_array($mimeContentType, $mimeTypes))
            $image_info = getimagesize($file);
        //  앞뒤로 붙은 슬러쉬 제거
        $tmp_subFolder = $subFolder;
        if(substr($tmp_subFolder, 0, 1) == '/')    $tmp_subFolder = substr($tmp_subFolder, 1);
        if(substr($tmp_subFolder, -1, 1) == '/')    $tmp_subFolder = substr($tmp_subFolder, 0, -1);
        $path = explode("/", $tmp_subFolder);
        foreach ($path as $key => $f_name) {
            if (isset($path[$key+1]))
                $path[$key+1] = $path[$key].'/'.$path[$key+1];
            $this->mkDir($physicalPath.$path[$key]);
        }
        if (isset($image_info)) {
            if($image_info[0]>$def_wid||$image_info[1]>$def_hei)
                $this->imageResizeSave($file, $physicalFullPath, $def_wid, $def_hei);
            else
                $file->storeAs("public/".$subFolder, $file->hashName());
            if ($thumb) {
                $this->mkDir($physicalFullPath.'thumbnails/');
                $this->imageResizeSave($file, $physicalFullPath.'thumbnails/', $thumb_wid, $thumb_hei);
            }
        } else {
            $file->storeAs("public/".$subFolder, $file->hashName());
        }
    }

    public function imageResizeSave($file, $filePath, $width, $height) {
        try {
            Image::make($file)->resize($width, $height, function ($constraint) {
                  $constraint->aspectRatio();
            })->save($filePath.$file->hashName());
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    public function getImage($folderNm, $filename) {
        $path = public_path('storage/'.$folderNm.$filename);
        if (!File::exists($path))
            abort(500, '잘못된 이미지 경로');

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    // 글 보기 중 첨부파일 다운로드
    public function download(Request $request, $boardName, $writeId, $fileNo) {
        $file = $this->boardFileModel->where([
            'board_id' => $this->writeModel->board->id,
            'write_id' => $writeId,
            'board_file_no' => $fileNo,
        ])->first();



        return response()->download(public_path('storage/'. $request->boardName. '/'. $file->file), $file->source);
    }

    public function phyFileDel($path, $f_nm) {// 파일 삭제
        if(Storage::exists($path.'/'.$f_nm)) Storage::delete($path.'/'.$f_nm);
        if(Storage::exists($path.'/thumbnails/'.$f_nm)) Storage::delete($path.'/thumbnails/'.$f_nm);
    }

    public function mkDir($path) {
        if(!File::isDirectory($path)) File::makeDirectory($path);
    }
}
