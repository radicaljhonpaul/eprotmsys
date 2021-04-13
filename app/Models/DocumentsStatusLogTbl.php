<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsStatusLogTbl extends Model
{
    use HasFactory;

    protected $table = 'documents_status_logs';
    public $timestamps = true;

    public function ImgLogsTbl(){
        return $this->hasMany(ImgLogsTbl::class, 'document_status_logs_id_fk', 'id');
    }
}
