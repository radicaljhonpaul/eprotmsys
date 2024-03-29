<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $table = 'section';
    public $timestamps = true;

	protected $fillable = [
		'division_id_fk',
        'name',
    ];

    public function Division(){

        return $this->belongsTo(Division::class, 'id', 'division_id_fk');
    }

    public function Cluster(){

        return $this->hasMany(Cluster::class, 'id', 'section_id_fk');
    }
}
