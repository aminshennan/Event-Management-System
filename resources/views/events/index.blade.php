@extends('layouts.layout')


@section('content')
    <link rel="stylesheet" href="{{ asset('eventsScreen/eventsStyle.css') }}">

    {{-- Banner Section with Filtering Options --}}
    <div class="events-banner">
        <h1 class="events-title">Events</h1>
        <form action="{{ route('events.index') }}" method="GET" class="event-filters">
            <select name="event_type" id="event_type">
                <option value="">Event Type</option>
                @foreach ($eventTypes as $type)
                    <option value="{{ $type }}" {{ request('event_type') == $type ? 'selected' : '' }}>
                        {{ ucwords($type) }}</option>
                @endforeach
            </select>

            <select name="age_group" id="age_group">
                <option value="">Age Group</option>
                @foreach ($ageGroups as $group)
                    <option value="{{ $group }}" {{ request('age_group') == $group ? 'selected' : '' }}>
                        {{ ucwords($group) }}</option>
                @endforeach
            </select>

            <select name="gender_group" id="gender_group">
                <option value="">Gender Group</option>
                @foreach ($genderGroups as $gender)
                    <option value="{{ $gender }}" {{ request('gender_group') == $gender ? 'selected' : '' }}>
                        {{ ucwords($gender) }}</option>
                @endforeach
            </select>

            <button type="submit" class="filter-button">Search</button>
        </form>
    </div>


    {{-- Events Grid Section --}}
    <div class="events-grid">
        <h2 class="section-title">Events</h2> {{-- The title could be dynamic based on the page or a selected category --}}
        <div class="event-cards">
            {{-- Dynamic Event Cards --}}
            @foreach ($events as $event)
                <div class="event-card" onclick="window.location.href='{{ route('events.show', $event->id) }}'">
                    <img src="{{ $event->event_picture ?: asset('/eventsScreen/images/no-image.jpg') }}"
                        alt="{{ $event->event_name }} class="event-image">
                    <div class="event-info">
                        <h3 class="event-name">{{ $event->event_name }}</h3>
                        <p class="event-description">{{ $event->event_description }}</p>
                        <br>
                        <p class="event-description">{{ $event->event_age_group }}</p>
                        <br>
                        <p class="event-description">{{ $event->event_type }}</p>
                        <br>
                        <p class="event-description">{{ $event->event_gender_group }}</p>
                        {{-- Additional details like date, location, etc. --}}

                    </div>
                    {{-- <button class="explore-button">Explore</button> --}}
                </div>
            @endforeach

            @if ($events->isEmpty())
                <p>No events found.</p>
            @endif
        </div>
    </div>



    <script src="{{ asset('eventsScreen/eventsScript.js') }}"></script>
@endsection
