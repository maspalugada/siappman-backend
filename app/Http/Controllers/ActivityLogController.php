<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        return response()->json(
            ActivityLog::latest('created_at')->take(200)->get()
        );
    }
}
