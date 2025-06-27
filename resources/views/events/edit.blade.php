@extends('layouts.layout')

@section('content')
    <style>
        .edit-event-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #a6d0ff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 7%
        }

        .edit-event-container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .edit-event-container .form-group {
            margin-bottom: 15px;
        }

        .edit-event-container .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .edit-event-container .form-group input[type="text"],
        .edit-event-container .form-group input[type="textfield"],
        .edit-event-container .form-group input[type="number"],
        .edit-event-container .form-group select,
        .edit-event-container .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .edit-event-container .btn {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
            margin-right: 10px;
        }

        .edit-event-container .btn-primary {
            background-color: #007bff;
            color: #ffffff;
        }

        .edit-event-container .btn-primary:hover {
            background-color: #0056b3;
        }

        .edit-event-container .btn-warning {
            margin-top: 10px;
            background-color: #ffc107;
            color: #212529;
        }

        .edit-event-container .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
    <div class="container edit-event-container"> <!-- Added unique class here -->
        <h1>Edit Event</h1>
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Add form fields here for each editable attribute of the event --}}
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <input type="text" class="form-control" id="event_name" name="event_name" value="{{ $event->event_name }}"
                    required>
            </div>
            <div class="form-group">
                <label for="event_description">Event Description</label>
                <input type="textfield" class="form-control" id="event_description" name="event_description"
                    value="{{ $event->event_description }}" required>
            </div>
            <div class="form-group">
                <label for="event_capacity">Event Capacity</label>
                <input type="number" class="form-control" id="event_capacity" name="event_capacity"
                    value="{{ $event->event_capacity }}" required>
            </div>
            <div class="form-group">
                <label for="event_address">Event Address</label>
                <input type="textfield" class="form-control" id="event_address" name="event_address"
                    value="{{ $event->event_address }}" required>
            </div>
            {{-- Repeat for other attributes: event_description, event_description, etc. --}}

            {{-- Submit button --}}
            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>

        {{-- Place this inside your edit.blade.php file --}}
        {{-- ... after the form or at an appropriate place in the UI --}}
        <form action="{{ route('events.cancel', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-warning"
                onclick="return confirm('Are you sure you want to cancel this event?');">Cancel Event</button>
        </form>

    </div>
@endsection
