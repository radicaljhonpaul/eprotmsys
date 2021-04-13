<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImgLogsTbl extends Model
{
    use HasFactory;

    protected $table = 'img_logs';
    public $timestamps = true;
}
