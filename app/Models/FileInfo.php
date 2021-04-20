<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileInfo extends Model {
    use HasFactory;

    protected $primaryKey = 'fi_id';
    protected $table = 'file_info';
    public $timestamps = false;
    protected $fillable = ['down']; // 수정가능 필드 입력


    public function fileable() { return $this->morphTo(); }

    public function scopeFi_key($query, int $fi_key) { return $query->where('fi_key', $fi_key); }
    public function scopeFi_type($query, string $fi_type) { return $query->where('fi_type', $fi_type); }
    public function scopeFi_path($query, string $fi_path) { return $query->where('fi_path', $fi_path); }

    public function getSrc($sub=NULL) {
        $src = "/storage";
        $src .= "/".$this->fi_type;
        $src .= "/".$this->fi_path;
        if ($sub)
            $src .= "/".$sub;
        $src .= "/".$this->fi_new;
        return $src;
    }
}
