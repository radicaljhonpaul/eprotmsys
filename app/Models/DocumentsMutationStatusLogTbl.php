<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsMutationStatusLogTbl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'documents_mutation_status_logs';
    public $timestamps = true;

    public function DocumentsMutationTbl(){
        return $this->hasOne(DocumentsMutationTbl::class, 'dtrack_no', 'dtrack_id_fk');
    }
    
    public function ImgLogsTbl(){
        return $this->hasMany(ImgLogsTbl::class, 'document_status_logs_id_fk', 'id');
    }
}
