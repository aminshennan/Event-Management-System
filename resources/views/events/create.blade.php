@extends('layouts.layout')


@section('content')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbvJ4Dg-uRLJVTtQ_2DW3lF5FFW3bIuCc&callback=initMap"></script>
    <link rel="stylesheet" href="{{ asset('createEventScreen/createEventStyle.css') }}">

    <div class="create-event-banner">
        <div class="container">
            <h1>Got an idea? Host an event with us!</h1>
        </div>
    </div>

    {{-- craete event form section --}}



    <div class="create-event-section">
        <h2>Create Your Event</h2>
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-row">
                <div class="left-column">
                    {{-- Left Column for Event Details --}}
                    {{-- Event Name --}}
                    <label for="event_name">Event Name</label>
                    <input type="text" id="event_name" name="event_name" placeholder="Enter event name" required>

                    {{-- Event Type --}}
                    <label for="event_type">Event Type</label>
                    <select id="event_type" name="event_type" required>
                        {{-- ... options ... --}}
                        <option value="">Select Event Type</option>
                        <option value="Sports">Sports</option>
                        <option value="Workshops">Workshops</option>
                        <option value="Festival">Festival</option>
                        <option value="Gaming">Gaming</option>
                        <option value="Volunteer">Volunteer</option>
                        <option value="Social">Social</option>
                    </select>

                    {{-- Gender Group --}}
                    <label for="event_gender_group">Target Gender Group</label>
                    <select id="event_gender_group" name="event_gender_group" required>
                        {{-- ... options ... --}}
                        <option value="">Select Gender Group</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Both">Both</option>
                    </select>

                    {{-- Age Group --}}
                    <label for="event_age_group">Target Age Group</label>
                    <select id="event_age_group" name="event_age_group" required>
                        {{-- ... options ... --}}
                        <option value="">Select Age Group</option>
                        <option value="12+">12+</option>
                        <option value="18+">18+</option>
                        <option value="21+">21+</option>
                    </select>


                    {{-- Capacity --}}
                    <label for="event_capacity">Capacity</label>
                    <input type="number" id="event_capacity" name="event_capacity" placeholder="Enter capacity"min="1"
                        required>



                    {{-- Start Date & Time --}}
                    <label for="start_date">Start Date and Time</label>
                    <input type="date" id="start_date" name="start_date" required>
                    <input type="time" id="start_time" name="start_time" required>

                    {{-- End Date & Time --}}
                    <label for="end_date">End Date and Time</label>
                    <input type="date" id="end_date" name="end_date" required>
                    <input type="time" id="end_time" name="end_time" required>

                </div>

                <div class="right-column">
                    {{-- Event Description --}}
                    <label for="event_description">Event Description</label>
                    <textarea id="event_description" name="event_description" placeholder="Enter your event details" required></textarea>

                    {{-- Event Address --}}
                    <label for="event_address">Address</label>
                    <textarea id="event_address" name="event_address" placeholder="Enter event address" required></textarea>

                    {{-- Location Map API --}}
                    <label for="event_location">Location Map API</label>

                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                    </div>
                    <div style="height: 400px;" id="map"></div>


                </div>
            </div>

            {{-- Section below for event picture and submit button will go here --}}
            <div class="event-picture-banner">
                <h2>Add an event picture</h2>
                <p>Make your event POP with exciting images</p>
                <div class="event-picture-upload">
                    <input type="file" name="event_picture" id="event_picture" onchange="previewImage(event)">
                    <img id="event_picture_preview" src="{{ asset('storage/events_pictures/no-image.jpg') }}"
                        alt="Event Image Preview" style="display:block;">
                </div>
            </div>


            {{-- ... previous form sections ... --}}

            <div class="submit-event-section">
                <button type="submit" class="submit-event-button">Submit</button>
            </div>


            <script>
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        var output = document.getElementById('event_picture_preview');
                        output.src = reader.result;
                        output.style.display = 'block';
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            </script>


            <script>
                function initMap() {
                    const initialPosition = {
                        lat: 4.2105,
                        lng: 101.9758
                    }; // Default location

                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 8,
                        center: initialPosition,
                    });

                    let marker = new google.maps.Marker({
                        position: initialPosition,
                        map: map,
                        draggable: true, // Allows the marker to be dragged to a new location
                    });

                    // Listen for map clicks to reposition the marker and update input fields
                    map.addListener("click", (e) => {
                        marker.setPosition(e.latLng);
                        document.getElementById('latitude').value = e.latLng.lat();
                        document.getElementById('longitude').value = e.latLng.lng();
                    });

                    // Optional: Listen for marker drag events to update input fields
                    marker.addListener("dragend", () => {
                        document.getElementById('latitude').value = marker.getPosition().lat();
                        document.getElementById('longitude').value = marker.getPosition().lng();
                    });
                }
            </script>

        </form>

    </div>
@endsection
