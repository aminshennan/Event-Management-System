<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingEvents = Event::where('event_status', 'pending')->get();
        $rejectedEvents = Event::where('event_status', 'rejected')->get();

        return view('dashboard.admin', compact('pendingEvents', 'rejectedEvents'));
    }
}

