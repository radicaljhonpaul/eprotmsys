<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationsTbl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notifications';
    public $timestamps = true;
    
    public function NotificationEventsTbl()
    {
        return $this->hasOne(NotificationEventsTbl::class, 'event_id_fk', 'id');
    }

    public function UsersDetails()
    {
        return $this->hasOne(UsersDetails::class, 'id', 'from');
    }
}
