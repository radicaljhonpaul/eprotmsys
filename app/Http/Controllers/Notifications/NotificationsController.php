<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationsTbl;
use App\Models\NotificationEventsTbl;
use App\Models\User;

class NotificationsController extends Controller
{
    //
    public function getUserNotifications()
    {
        $data = NotificationsTbl::where('from', Auth::id())
        ->orWhere('to', Auth::id())
        ->get();

        $array_id = [];
        foreach ($data as $key) {
            array_push($array_id, $key->id);
        }

        return NotificationsTbl::with('NotificationEventsTbl')
        ->with(['UsersDetails' => function($e){
            return $e->select('id','fname','lname','gender')->where('id', Auth::id())->get();
        }])
        ->whereIn('id', $array_id)
        ->where('is_open', 0)
        ->get();
    }

    public function readNotifications(Request $request)
    {
        DB::beginTransaction();
        try {
            NotificationsTbl::where('id', $request->notif_id)->update(['is_open' => 1]);
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
