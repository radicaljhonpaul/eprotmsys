<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

	protected $table = 'division';
    public $timestamps = true;

    protected $fillable = [
        'name',
    ];

    public function Section(){
        return $this->hasMany(Section::class, 'division_id_fk', 'id');
    }
}