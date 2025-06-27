<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head Contents like CSS links, Title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('layoutsStyling/layoutStyle.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Link to your stylesheet -->
</head>

<body>
    <header>
        <!-- Top bar for login/signup -->
        @if (auth()->check())
            <div class="top-bar">
                <div class="container">
                    <div class="login-signup">
                        <form action="{{ route('logout') }}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" name="logout">Logout</button>
                        </form>
                        <div class="usernamebtn">{{ Auth::user()->name }}</div>
                        @php
                            // Check if the picture is an external URL
                            $isExternalUrl = Str::startsWith(Auth::user()->picture, ['http://', 'https://']);
                            $imageUrl = $isExternalUrl ? Auth::user()->picture : asset('storage/' . Auth::user()->picture);
                            $defaultImageUrl = asset('storage/profile_pictures/no-image.jpg');
                        @endphp

                        <img src="{{ Auth::user()->picture ? $imageUrl : $defaultImageUrl }}"
                            alt="{{ Auth::user()->picture }}" class="user-picture">
                    </div>
                </div>
            </div>
        @else
            <div class="top-bar">
                <div class="container">
                    <div class="login-signup">
                        @csrf
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Signup</a>
                    </div>
                </div>
            </div>
        @endif


        <!-- Main navigation bar -->
        <nav class="main-nav">
            <div class="container">
                <!-- Website name or logo -->
                <div class="website-name">
                    <a href="{{ url('/landingpage') }}">{{ config('app.name', 'Laravel') }}</a>
                </div>

                <!-- Navigation links -->
                <div class="nav-links">
                    <a href="{{ url('/landingpage') }}">Home</a>
                    <a href="{{ route('events.index') }}">Events</a>
                    @if(auth()->user() && auth()->user()->role == 'admin' )
                    <a href="{{ route('dashboard.admin') }}">Dashboard</a>
                    @else <a href="{{ route('dashboard.user') }}">Dashboard</a>
                    @endif
                    <a href="#footer">About</a>
                    <a href="#footer">Contact Us</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('content') {{-- Content will be injected here --}}
    </main>
    <!-- Footer Section -->
    <footer id="footer"class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About {{ config('app.name', 'Laravel') }}</h4>
                    <p>This event booking system allows users to find, join, and host events effortlessly. Join our
                        community today!</p>
                </div>
                <div class="footer-section">
                    <h4>Contact Us</h4>
                    <ul>
                        <li>Email: 1191302190@gmail.com</li>
                        <li>Phone: +60173493290</li>
                        <li>Address: Cyberjaya</li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/landingpage') }}">Home</a></li>
                        <li><a href="{{ route('events.index') }}">Events</a></li>
                        <li><a href="#footer">About Us</a></li>
                        <li><a href="#footer">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>
