<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentNotificationController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index(){
        $user = Auth::user();
        $notifications = $user->notifications;
        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    public function read($id){
        $user = Auth::user();
        $notification = $user->unreadNotifications()->where('id',$id)->first();
        $notification->markAsRead();
        return redirect(url($notification->data['url']));
    }
}
