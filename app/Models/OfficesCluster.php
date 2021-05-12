<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficesCluster extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $table = 'offices_cluster';
    public $timestamps = true;

	protected $fillable = [
        'name',
    ];

    public function OfficesOffice(){
        return $this->hasMany(OfficesOffice::class, 'offices_cluster_id_fk', 'id');
    }
}
