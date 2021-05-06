<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $data = NotificationsTbl::with('NotificationEventsTbl')
        ->with(['UsersDetails' => function($e){
            return $e->select('id','fname','lname','gender')->where('id', Auth::id())->get();
        }])
        ->where('from', Auth::id())
        ->orWhere('to', Auth::id())
        // ->limit(5)
        ->get();
        
        return $data;
    }

    public function readNotifications(Request $request)
    {
        DB::beginTransaction();
        try {
            NotificationsTbl::where('id', $request->notif_id)->update(['is_open' => 'read']);
            DB::commit();
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
