<header class="site-header">
    <div class="container">
        <div class="header-top">
            <div class="logo">
                <img src="{{ asset('images/daience_university_cover.jpeg') }}" alt="Daience University Logo">
                <span class="logo-text">DAIENCE UNIVERSITY</span>
            </div>

            <div class="search-container">
                <div class="search-bar">
                    <span class="search-icon"><img src="{{ asset('images/search-icon2.png') }}" alt="search icon"></span>
                    <input type="text" class="search-input" placeholder="Search docs">
                </div>
            </div>
        </div>
    </div>
</header>

<div class="header-banner">
    <div class="container">
        <div class="banner-content">
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li><a href="#" class="nav-link">About Us</a></li>
                <li><a href="#" class="nav-link">Degree</a></li>
                <li><a href="{{ route('courses') }}" class="nav-link">Courses</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
                <li><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li><a href="#" class="nav-link">News</a></li>
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
            
            {{-- <div class="header-text">
                <h1>IT Certifcates - Online Courses</h1>
                <p>Data Science, Cyber Security, IT, Business & Language</p>
                        
            </div> --}}
</div>

    <div class="hero-section">
        <div class="container">
            <div class="hero-content">
                <p class="hero-subtitle">Learn Online</p>
                <h1 class="hero-title">Never <span class="highlight">miss</span> the opportunity again.</h1>
                <p class="hero-description">Master Data Science, Cyber Security, IT, Business & Language through our comprehensive online certification programs.</p>
                <div class="hero-buttons">
                    <a href="{{ route('courses') }}" class="btn btn-primary">Get Started</a>
                    <a href="#" class="btn btn-secondary">View Courses</a>
                </div>
            </div>
        </div>
    </div>


