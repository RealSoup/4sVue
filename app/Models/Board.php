<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model {
    use HasFactory;
    use SoftDeletes;
    protected $table;
    protected $primaryKey = 'bo_id';
    protected $dates = [ 'created_at', 'updated_at', 'deleted_at' ];
    // public $timestamps = false;
    protected $guarded = [];

    public function setTableName($tableName) { $this->table = 'board_'. $tableName; }
    public function fileInfo() { return $this->morphMany(FileInfo::class, 'fileable', 'fi_type', 'fi_key'); }
    public function fileInfo_bo() { return $this->fileInfo()->where("fi_path", cache('board')['code']); }

    public function scopeSchSubject($query, $txt) { return $query->where('bo_subject', $txt); }
    public function scopeSchContent($query, $txt) { return $query->where('bo_content', $txt); }    
    public function scopeSchWriter($query, $id) { return $query->where('created_id', $id); }

    public function getComment(){
        return $this->where('bo_group', $this->bo_id)->orderByRaw('bo_co_seq, bo_co_seq_cd')->get();
    }
}
