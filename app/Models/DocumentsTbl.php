<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsTbl extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $table = 'documents';
    public $timestamps = true;

    public function UsersDetails(){
        return $this->hasOne(UsersDetails::class, 'user_id_fk', 'doc_end_user');
    }
    
    public function DocumentsParticularsTbl(){
        return $this->hasMany(DocumentsParticularsTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }

    public function DocumentsStatusLogTbl(){
        return $this->hasMany(DocumentsStatusLogTbl::class, 'doc_id', 'id');
    }

    public function DocumentsMutationLogTbl(){
        return $this->hasOne(DocumentsMutationLogTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }

    public function DocumentsMutationTbl(){
        return $this->hasOne(DocumentsMutationTbl::class, 'dtrack_no', 'dtrack_no');
    }

}
