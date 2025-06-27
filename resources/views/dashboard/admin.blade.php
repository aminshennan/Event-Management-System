@extends('layouts.layout')

@section('content')




<style>
    .user-profile-section {
        text-align: center;
        padding: 20px;
        background-color: #fff;
        /* Adjust the background color as needed */
        margin-bottom: 30px;
        /* Space between sections */
    }

    .user-picture-box {
        display: inline-block;
        width: 150px;
        /* Adjust the width as needed */
        height: 150px;
        /* Adjust the height as needed */
        margin-bottom: 20px;
        border-radius: 50%;
        /* Makes the image round */
        overflow: hidden;
        /* Ensures the image doesn't spill outside the border-radius */
        line-height: 0;
        /* Removes the gap below the image */
        border: 3px solid #dee2e6;
        /* Adjust border color as needed */
    }

    .user-picture-box img {
        width: 100%;
        height: 100%;
    }

    .user-name {
        font-size: 1.5em;
        color: #333;
        /* Adjust the text color as needed */
        margin-top: 0;
    }

    .my-events-section {
        padding: 20px;
        background-color: #f8f9fa;
        /* Adjust the background color as needed */
        border-radius: 5px;
        margin-bottom: 30px;
        /* Space between sections */
    }

    .section-title {
        text-align: left;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 25px;
    }

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .event-box {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .event-box:hover {
        transform: translateY(-5px);
        /* Slight lift effect on hover */
    }

    .event-picture {
        width: 100%;
        height: 150px;
        /* Adjust height as needed */
        object-fit: cover;
        /* Ensures the image covers the area nicely */
    }

    .event-name {
        padding: 10px;
        font-size: 1em;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .events-grid {
            grid-template-columns: repeat(auto-fill, minmax(100%, 1fr));
        }
    }


    .joined-events-section {
        padding: 20px;
        background-color: #f8f9fa;
        /* Adjust the background color as needed */
        border-radius: 5px;
        margin-bottom: 30px;
        /* Space between sections */
    }
    </style>



<div class="events-section">
    <h3 class="section-title">Pending Events</h3>
    <div class="events-grid">
        @forelse ($pendingEvents as $event)
            <div class="event-box" onclick="location.href='{{ route('events.show', $event->id) }}'">
                <img src="{{ $event->event_picture ?: asset('storage/events_pictures/no-image.jpg') }}" alt="{{ $event->event_name }}" class="event-picture">
                <p class="event-name">{{ $event->event_name }}</p>
            </div>
        @empty
            <p>No pending events found.</p>
        @endforelse
    </div>
</div>



<div class="events-section">
    <h3 class="section-title">Rejected Events</h3>
    <div class="events-grid">
        @forelse ($rejectedEvents as $event)
            <div class="event-box" onclick="location.href='{{ route('events.show', $event->id) }}'">
                <img src="{{ $event->event_picture ?: asset('storage/events_pictures/no-image.jpg') }}" alt="{{ $event->event_name }}" class="event-picture">
                <p class="event-name">{{ $event->event_name }}</p>
            </div>
        @empty
            <p>No Rejected events found.</p>
        @endforelse
    </div>
</div>

@endsection
