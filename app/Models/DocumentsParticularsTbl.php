<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsParticularsTbl extends Model
{
    use HasFactory;

    protected $table = 'particulars';
    public $timestamps = true;
}
