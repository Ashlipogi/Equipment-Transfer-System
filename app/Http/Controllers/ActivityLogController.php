<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::orderBy('created_at', 'desc')->get();
        return view('activity-history', compact('activities'));
    }

    public static function log($action, $description)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'action' => $action,
            'description' => $description,
        ]);
    }
}
