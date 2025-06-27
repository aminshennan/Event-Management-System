@extends('layouts.layout')


@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <link rel="stylesheet" href="{{ asset('eventdetailsScreen/eventdetailsStyle.css') }}">

    <div class="event-details-container">

        {{-- Left side of the page --}}
        <div class="left-side">
            {{-- Event Picture Section --}}
            <h2>Event Picture</h2>
            <div class="event-picture-box">
                <img src="{{ $event->event_picture ?: asset('storage/events_pictures/no-image.jpg') }}" alt="{{ $event->event_name }}"
                    class="event-picture">
            </div>

            {{-- Event Details Section --}}
            <h2>Event Details</h2>
            <div class="event-details-box">
                {{-- Loop through event details --}}
                <div class="detail">Event Name: {{ $event->event_name }}</div>
                <div class="detail">Event Type: {{ $event->event_type }}</div>
                <div class="detail">Gender Group: {{ $event->event_gender_group }}</div>
                <div class="detail">Age Group: {{ $event->event_age_group }}</div>
                <div class="detail">Status: {{ $event->event_status }}</div>
                <div class="detail">Capacity: {{ $event->event_capacity }}</div>
                <div class="detail">Participants: {{ $event->event_number_of_participants }}</div>
                <div class="detail">Start Time: {{ $event->eventDate->start_time }}</div>
                <div class="detail">End Time: {{ $event->eventDate->end_time }}</div>
                <div class="detail">Start Date: {{ $event->eventDate->start_date }}</div>
                <div class="detail">End Date: {{ $event->eventDate->end_date }}</div>
                <div class="detail">Description: {{ $event->event_description }}</div>
                <div class="detail">Address: {{ $event->event_address }}</div>
                {{-- Add more details as necessary --}}
            </div>

            {{--  Participants Section --}}
            <h2>Participants</h2>
            <div class="participants-box">
                {{-- Loop through participants --}}
                @foreach ($event->participants as $participant)
                    <div class="participant">
                        @php
                            // Check if the picture is an external URL
                            $isExternalUrl = Str::startsWith($participant->picture, ['http://', 'https://']);
                            $imageUrl = $isExternalUrl ? $participant->picture : asset('storage/' . $participant->picture);
                            $defaultImageUrl = asset('storage/profile_pictures/no-image.jpg');
                        @endphp

                        <img src="{{ $participant->picture ? $imageUrl : $defaultImageUrl }}"
                            alt="{{ $participant->name }}" class="participant-picture">
                        <span>{{ $participant->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>







        {{-- Right side of the page --}}
        <div class="right-side">
            {{-- Event Creator Section --}}
            <div class="event-creator-box">
                @if ($event->creator)
                    @php
                        // Check if the picture is an external URL
                        $isExternalUrl = Str::startsWith($event->creator->picture, ['http://', 'https://']);
                        $imageUrl = $isExternalUrl ? $event->creator->picture : asset('storage/' . $event->creator->picture);
                        $defaultImageUrl = asset('storage/profile_pictures/no-image.jpg');
                    @endphp

                    <img src="{{ $event->creator->picture ? $imageUrl : $defaultImageUrl }}"
                        alt="{{ $event->creator->name }}" class="participant-picture">
                    <span>{{ $event->creator->name }}</span>
                @else
                    <img src="{{ asset('images/default-user.jpg') }}" alt="No Creator" class="creator-picture">
                    <span>No Creator</span>
                @endif

                <span>{{ $event->creator->name }}</span>
            </div>



            {{-- Google Maps API Location Section --}}
            <div class="location-map-box">
                {{-- Placeholder for Google Maps API integration --}}
                <div id="event-location-map">
                    <div id="map"></div>

                </div>
            </div>

            {{-- Join Event Section --}}
            <div class="join-event-box">
                {{-- Check if the authenticated user is the creator of the event --}}


                @if(auth()->check()) {{-- Check if user is authenticated once at the top --}}
                @if(auth()->user()->role == 'admin')
                    @if($event->event_status === 'pending')
                        {{-- Approve and Reject buttons --}}
                        <form action="{{ route('events.approve', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="join-event-button">Approve</button>
                        </form>
                        <form action="{{ route('events.reject', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="leave-event-button">Reject</button>
                        </form>
                    @endif
                    {{-- Delete Event button (for admin) --}}
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="leave-event-button">Delete Event</button>
                    </form>
                @elseif(auth()->user()->id === $event->creator->id)
                    {{-- Edit Event button (for creator) --}}
                    <div class="edit-event-button-container">
                        <a href="{{ route('events.edit', $event->id) }}" class="edit-event-button">Edit Event</a>
                    </div>
                @else
                    {{-- Join or Leave Event button (for participants) --}}
                    @if(!$event->participants->contains(auth()->id()))
                        <form action="{{ route('events.join', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="join-event-button">Join Event</button>
                        </form>
                    @else
                        <form action="{{ route('events.leave', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="leave-event-button">Leave Event</button>
                        </form>
                    @endif
                @endif
            @endif







            </div>
        </div>
    </div>



    <script>
        function initMap() {
            var location = {
                lat: {{ $event->latitude }},
                lng: {{ $event->longitude }}
            };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT3W2CR-RW-bWUh46SQAKmb-6LHgVBUTE&callback=initMap"></script>
    <script src="{{ asset('eventdetailsScreen/eventdetailsScript.js') }}"></script>
@endsection
