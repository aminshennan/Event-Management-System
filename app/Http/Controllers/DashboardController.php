<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;




class DashboardController extends Controller
{
    public function index()
    {

        
        // Retrieve the events created by the user
        $myEvents = auth()->user()->eventsCreated()->get();

        // Retrieve the events the user has joined
        $joinedEvents = auth()->user()->eventsJoined()->get();

        // Return the dashboard view with the events data
        return view('dashboard.user', [
            'myEvents' => $myEvents,
            'joinedEvents' => $joinedEvents,
        ]);
    }
}

