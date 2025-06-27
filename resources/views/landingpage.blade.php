@extends('layouts.layout')


@section('content')
    <link rel="stylesheet" href="{{ asset('landingScreen/landingStyle.css') }}">

    <!-- The rest of the page content will go here -->
    <div class="banner">
        <div class="container">
            <h1>Plan your next adventure</h1>
        </div>
    </div>


    <!-- Browse by Popular Type Section -->
    <section class="popular-types">
        <div class="container">
            <h2>Browse by Popular Event Type</h2>
            <div class="type-grid">
                @foreach ($popularEventTypes as $type)
                    <!-- Dynamic type Box -->
                    <div class="type-box"
                        onclick="location.href='{{ route('events.index', ['event_type' => $type->event_type]) }}';">
                        {{-- Here we need a way to determine an image based on the event type --}}
                        <img src="{{ asset('landingScreen/images/' . $type->event_type . '.jpg') }}"
                            alt="{{ ucwords($type->event_type) }}">
                        <p>{{ ucwords($type->event_type) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <!-- Second Banner Section -->
    <section class="host-event-banner">
        <div class="container">
            <div class="host-event-content">
                <img src="{{ asset('landingScreen/images/events.jpg') }}" alt="Host your own event"
                    class="host-event-image">
                <div class="host-event-text">
                    <h2>Host your own event</h2>
                    <p>Looking for attendees for your next event? Join our community and host an event with us today.</p>
                    @if (auth()->check())
                        <button onclick="location.href='{{ route('events.create') }}';" class="host-event-button">Host
                            Event</button>
                    @else
                        <button onclick="location.href='{{ route('register') }}';" class="host-event-button">Host
                            Event</button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="upcoming-events">
        <div class="container">
            <h2>Upcoming Events</h2>
            <div class="events-grid">
                @foreach ($upcomingEvents as $event)
                    <div class="event-box" onclick="location.href='{{ route('events.show', $event->id) }}';">
                        <img src="{{ $event->event_picture ?: asset('landingScreen/images/default-event.jpg') }}"
                            alt="{{ $event->event_name }}">
                        <p>{{ $event->event_name }}</p>
                    </div>
                @endforeach
            </div>
            <button onclick="location.href='{{ route('events.index') }}';" class="expand-events">View All Events</button>
        </div>
    </section>
@endsection
