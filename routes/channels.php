<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|

NOTE TO NEXT DEVELOPER - OPTIMIZE AND IMPROVE THE SECURITY
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
    // return true;
});

Broadcast::channel('UsersArray_{id}', function () {
    return true;
});

Broadcast::channel('CreateDocument_{id}', function () {
    return true;
});

Broadcast::channel('LogDocument_{id}', function () {
    return true;
});

Broadcast::channel('RouteDocument_{id}', function () {
    return true;
});

Broadcast::channel('UpdateDocument_{id}', function () {
    return true;
});

Broadcast::channel('UpdateProfile_{id}', function () {
    return true;
});