<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\FileControl;
use App\Models\{FileInfo};

class CommonController extends Controller {
    use FileControl;    //  trait

    public function upload(Request $req) {
        $file = $req->file;
        if($file) {
            $this->file_upload($file, $req->fi_type.'/'.$req->fi_path.'/', $req->is_thumb);
            $finfo = new FileInfo;
            $finfo->fi_type         = $req->fi_type;
            $finfo->fi_path         = $req->fi_path;
            $finfo->fi_original     = $file->getClientOriginalName();
            $finfo->fi_new          = $file->hashName();
            $finfo->size            = $file->getSize();
            $finfo->type            = $file->getClientOriginalExtension();
            $finfo->created_id      = auth()->guard('api')->user()->id;
            $finfo->ip              = $req->ip();
            if($finfo->save()){
                if ($req->path == 'goods/description')  return response()->json(['fi_new'=>$finfo->fi_new, 'fi_id'=>$finfo->fi_id], 200);
                else                                    return response()->json($finfo->fi_id, 200);
            }
        }
    }

    public function deleteFiles($fi_id) {
        $fi = FileInfo::findOrFail($fi_id);
        $final_path = "public/".$fi->fi_type.'/'.$fi->fi_path;
        $this->phyFileDel($final_path, $fi->fi_new);
        $fi->delete();
    }

    public function makeImage($id, $type, $path=NULL, $is_thumb=false) {
        if ($type == 'fi_id') {
            $fi = FileInfo::find($id);
        } else {
            $path = $type.'/'.$path;
            $fi = FileInfo::Fi_parent_id($id)->Fi_type($type)->Fi_path($path)->first();
        }
        $noimg_id = NULL;
        if (!isset($fi)) {
            //  상품 이미지가 없으면 no-img 이미지 리턴
            if ($is_thumb) $noimg_id = cache('config.common.image')->noimage_thumb;
            else  $noimg_id = cache('config.common.image')->noimage;
            $fi = FileInfo::find($noimg_id);
        }
        $path = $fi->fi_path.'/';
        if (!$noimg_id && $is_thumb) $path.='thumbnails/';

        return $this->getImage($path, $fi->fi_new);
    }

    public function download($fi_id) {
        $fi = FileInfo::findOrFail($fi_id);
        $fi->increment('down');
        return response()->download(storage_path('app/public/'. $fi->fi_path. '/'. $fi->fi_new), $fi->fi_original);
    }
}
