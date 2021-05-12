<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficesDivision extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $table = 'offices_division';
    public $timestamps = true;

    protected $fillable = [
        'name',
    ];

    public function OfficesCluster(){
        return $this->hasMany(OfficesCluster::class, 'offices_division_id_fk', 'id');
    }

    public function OfficesOffice(){
        return $this->hasMany(OfficesOffice::class, 'offices_division_id_fk', 'id');
    }
}
