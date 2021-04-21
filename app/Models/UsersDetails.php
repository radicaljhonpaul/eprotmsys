<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $table = 'users_details';
    public $timestamps = true;

	protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contact',
		'office',
		'office_unit',
		'position',
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id_fk');
    }

    public function Division()
    {
        return $this->hasOne(Division::class, 'id', 'division');
    }

    public function Section()
    {
        return $this->hasOne(Section::class, 'id', 'section');
    }
    
    public function Cluster()
    {
        return $this->hasOne(Cluster::class, 'id', 'cluster');
    }
}
