<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cluster extends Model
{
    use HasFactory;
    use SoftDeletes;
    
	protected $table = 'cluster';
    public $timestamps = true;

	protected $fillable = [
		'section_id_fk',
        'name',
    ];

    public function Section(){

        return $this->belongsTo(Section::class, 'id', 'section_id_fk');
    }


}
