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
    
    
    
    public function OfficesDivision()
    {
        return $this->hasOne(OfficesDivision::class, 'id', 'division');
    }

    public function OfficesCluster()
    {
        return $this->hasOne(OfficesCluster::class, 'id', 'section');
    }
    
    public function OfficesOffice()
    {
        return $this->hasOne(OfficesOffice::class, 'id', 'cluster');
    }
}
