<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
	protected $table = 'cluster';
    public $timestamps = true;

	protected $fillable = [
		'section_id_fk',
        'name',
    ];

    public function Division(){

        return $this->belongsTo(Section::class, 'id', 'section_id_fk');
    }
}
