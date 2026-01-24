<header class="site-header">
    <div class="container">
        <div class="header-top">
            <div class="logo">
                <img src="{{ asset('images/daience_university_cover.jpeg') }}" alt="Daience University Logo">
                <span class="logo-text">DAIENCE UNIVERSITY</span>
            </div>

            <div class="search-container">
                <form action="{{ route('courses.search') }}" method="GET" class="search-bar">
                    <span class="search-icon"><img src="{{ asset('images/search-icon2.png') }}" alt="search icon"></span>
                    <input type="text" name="q" class="search-input" placeholder="Search courses..." value="{{ request('q') }}">
                </form>
            </div>
        </div>
    </div>
</header>

<div class="header-banner">
    <div class="container">
        <div class="banner-content">
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li><a href="{{ route('courses') }}" class="nav-link">Courses</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                <li><a href="#" class="nav-link">News</a></li>
                <li><a href="#" class="nav-link">About Us</a></li>
                <li><a href="#" class="nav-link">Degree</a></li>
                @guest
                <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @endguest

                @auth
                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                    @endif

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn-link">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth
                    
            </ul>

            <div class="social-icons">
                <a href="https://facebook.com" target="_blank">
                    <img src="{{ asset('images/header-icons/facebook-icon.png') }}" class="social-icon">
                </a>
                <a href="https://instagram.com" target="_blank">
                    <img src="{{ asset('images/header-icons/instagram-icon.png') }}" class="social-icon">
                </a>
                <a href="https://linkedin.com" target="_blank">
                    <img src="{{ asset('images/header-icons/linkedin-icon.png') }}" class="social-icon">
                </a>
                <a href="https://youtube.com" target="_blank">
                    <img src="{{ asset('images/header-icons/youtube-icon.png') }}" class="social-icon">
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="hero-section">
        <div class="container">
            <div class="hero-content">
                <p class="hero-subtitle">Learn Online</p>
                <h1 class="hero-title">IT Certifcates - <span class="highlight">Online</span> Course</h1>
                <p class="hero-description">Data Science, Cyber Security, IT, Business & Language.</p>
                <br>
                <div class="hero-buttons">
                    <a href="{{ route('courses') }}" class="btn btn-primary">Enroll Now</a>
                    <a href="{{ route('courses') }}" class="btn btn-secondary">Explore Courses</a>
                </div>
            </div>
        </div>
        <div class="hero-divider">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#0a1628"/>
            </svg>
        </div>
    </div>


