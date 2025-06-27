<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use App\Models\EventDate; // If you're using EventDate in the controller
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Display a listing of the events.
    public function index(Request $request)
    {
        // Start with a base query to fetch events, possibly already filtering approved ones
        $query = Event::where('isApproved', true);

        // Apply additional filters based on the request's query parameters
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('age_group')) {
            $query->where('event_age_group', $request->age_group);
        }

        if ($request->filled('gender_group')) {
            $query->where('event_gender_group', $request->gender_group);
        }
        // Get unique values for the dropdowns
        $eventTypes = Event::select('event_type')->distinct()->pluck('event_type');
        $ageGroups = Event::select('event_age_group')->distinct()->pluck('event_age_group');
        $genderGroups = Event::select('event_gender_group')->distinct()->pluck('event_gender_group');
        // Execute the query and get the results
        $events = $query->get();

        // Return the view with the filtered (or unfiltered, if no filters were applied) events
        return view('events.index', compact('events', 'eventTypes', 'ageGroups', 'genderGroups'));
    }


    // Display the specified event.
    public function show($id)
    {
        $event = Event::with('creator')->findOrFail($id);
        return view('events.show', compact('event'));
    }
    


    // Inside EventController.php

    public function join(Request $request, $eventId)
    {
        $event = Event::with('participants')->findOrFail($eventId);
        $userId = auth()->id(); // Get the currently authenticated user's ID

        // Prevent event creators from joining their own event
        if ($event->creatorID == $userId) {
            return back()->with('error', 'You cannot join your own event.');
        }

        // Check if the event has reached its capacity
        if ($event->participants->count() >= $event->event_capacity) {
            return back()->with('error', 'This event has reached its capacity and cannot accept more participants.');
        }

        // Check if the event is upcoming and not canceled
        if (!$event->isApproved  || $event->isCancelled) {
            return back()->with('error', 'This event is not available for joining.');
        }

        // Check if the user is already a participant
        if ($event->participants->contains($userId)) {
            return back()->with('error', 'You are already a participant of this event.');
        }

        // Attach the user to the event participants
        $event->participants()->attach($userId);
        $event->increment('event_number_of_participants');
        return back()->with('success', 'You have successfully joined the event.');
    }



    public function leave(Request $request, $eventId)
    {
        $event = Event::with('participants')->findOrFail($eventId);
        $userId = auth()->id(); // Get the currently authenticated user's ID

        // Check if the user is actually a participant
        if ($event->participants->contains($userId)) {
            $event->participants()->detach($userId);
            $event->decrement('event_number_of_participants');
            return back()->with('success', 'You have left the event.');
        }

        return back()->with('error', 'You are not a participant of this event.');
    }


    public function edit(Event $event)
    {
        // Authorization check to ensure the authenticated user is the creator of the event
        if (auth()->id() !== $event->creator->id) {
            abort(403); // If not the creator, abort with a 403 Forbidden code
        }

        return view('events.edit', compact('event'));
    }


    public function update(Request $request, Event $event)
    {
        // Authorization check (similar to the edit method)
        if (auth()->id() !== $event->creator->id) {
            abort(403);
        }

        // Validation and update logic
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'required|string|max:255',
            'event_address' => 'required|string|max:255',
            'event_capacity' => 'required|integer|min:1',
            // Include other validation rules for the event attributes
        ]);

        // Perform the update
        $event->update($validatedData);

        // Redirect back or to another page with a success message
        return redirect()->route('events.show', $event->id)->with('success', 'Event updated successfully.');
    }


    public function cancel(Request $request, Event $event)
    {
        // Authorization check
        if (auth()->id() !== $event->creator->id) {
            abort(403);
        }

        // Update the event to indicate it has been cancelled
        $event->update([
            'isCancelled' => true,
            'cancelled_at' => now(),
            'event_status' => 'cancelled', // Or any other status you're using for cancelled events
        ]);

        // Redirect back with a success message
        return redirect()->route('events.show', $event->id)->with('success', 'Event Cancelled successfully.');
    }



    public function create()
    {
        return view('events.create');
    }




    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'required|string',
            'event_gender_group' => 'required|string',
            'event_age_group' => 'required|string',
            'event_capacity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'event_description' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'event_address' => 'required|string',
            'event_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ]);

        // Handle file upload
        if ($request->hasFile('event_picture')) {
            $path = $request->file('event_picture')->store('public/events_pictures');
            $pictureUrl = Storage::url($path);
        } else {
            $pictureUrl = '/storage/events_pictures/no-image.jpg'; // Or set a default image path
        }

        // Create the event
        $event = Event::create([
            'event_name' => $request->event_name,
            'event_type' => $request->event_type,
            'event_gender_group' => $request->event_gender_group,
            'event_age_group' => $request->event_age_group,
            'event_capacity' => $request->event_capacity,
            'event_description' => $request->event_description,
            'event_address' => $request->event_address,
            'event_picture' => $pictureUrl,
            'creatorID' => Auth::id(),
            'event_status' => 'pending',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'isApproved' => false,
            'isCancelled' => false,
        ]);

        // Create the event dates
        EventDate::create([
            'eventID' => $event->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('events.show', $event->id)
            ->with('success', 'Event created successfully and is pending approval.');
    }


    public function approve($eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->update([
            'event_status' => 'approved',
            'isApproved' => true,
        ]);
    
        return redirect()->route('events.index')->with('success', 'Event approved successfully.');
    }


    public function reject($eventId)
    {
        $event = Event::findOrFail($eventId);
        $event->update([
            'event_status' => 'rejected',
            'isApprove' => false,
        ]);
    
        return redirect()->route('events.index')->with('success', 'Event rejected successfully.');
    }


    // Remove the specified event from storage.
    public function destroy($eventId)
    {
        $event = Event::findOrFail($eventId);
    
        // Assuming the relation is named eventDate() for a single EventDate related to an Event
        $event->eventDate()->delete(); // Delete related event date
    
        // Detach all participants from the event
        $event->participants()->detach(); 
    
        $event->delete(); // Then delete the event
    
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
