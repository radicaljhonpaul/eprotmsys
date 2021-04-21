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
        return $this->hasMany(DocumentsStatusLogTbl::class, 'dtrack_id_fk', 'dtrack_no');
    }
    
}
