<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationEventsTbl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notification_events';
    public $timestamps = true;

    public function NotificationsTbl()
    {
        return $this->hasMany(NotificationsTbl::class, 'event_id_fk', 'id');
    }
}
