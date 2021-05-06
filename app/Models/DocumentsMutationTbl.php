<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentsMutationTbl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'documents_mutation';
    public $timestamps = true;

    public function UsersDetails(){
        return $this->hasOne(UsersDetails::class, 'user_id_fk', 'doc_end_user');
    }
    
    public function DocumentsTbl(){
        return $this->hasOne(DocumentsTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }
    
    public function DocumentsMutationLogTbl(){
        return $this->hasMany(DocumentsMutationLogTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }

    public function DocumentsMutationStatusLogTbl(){
        return $this->hasMany(DocumentsMutationStatusLogTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }

    public function DocumentsParticularsTbl(){
        return $this->hasMany(DocumentsParticularsTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }
}
