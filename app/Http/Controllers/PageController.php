<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDate;


use Illuminate\Http\Request;

class PageController extends Controller
{
    public function landingpage()
    {
        // Retrieve the four most common event types and their count
        $popularEventTypes = Event::groupBy('event_type')
            ->selectRaw('event_type, count(*) as count')
            ->orderBy('count', 'DESC')
            ->take(4)
            ->get();

        // Get the nearest 4 upcoming and approved events
        $upcomingEvents = Event::join('event_dates', 'events.id', '=', 'event_dates.eventID')
            ->where('isApproved', true)
            ->orderBy('event_dates.start_date')
            ->orderBy('event_dates.start_time')
            ->take(4)
            ->get(['events.*', 'event_dates.start_date', 'event_dates.start_time']);


        // Pass this data to the view
        return view('landingpage', compact('popularEventTypes', 'upcomingEvents'));
    }



    public function index()
    {
        return view('index');
    }

    public function eventdetailspage()
    {
        return view('eventdetailspage');
    }

    public function createEventPage()
    {
        return view('createEventPage');
    }

    public function adminRequestsPage()
    {
        return view('adminRequestsPage');
    }

    public function adminDetailedRequestPage()
    {
        return view('adminDetailedRequestPage');
    }
}
