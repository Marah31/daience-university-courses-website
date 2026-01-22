@extends('layouts.app')

@section('title', $course->title)

@section('content')
<section class="course-detail-section">
    <div class="course-detail-container">
        
        <a href="{{ route('home') }}#courses" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Courses
        </a>

        <div class="course-detail-grid">
            
            <div class="course-detail-media">
                <div class="course-image-wrapper">
                    <img 
                        src="{{ asset('images/courses/' . $course->thumbnail) }}" 
                        alt="{{ $course->title }}"
                    >
                    <span class="course-category-badge">{{ $course->category }}</span>
                </div>

                <div class="course-quick-info">
                    <div class="info-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <div>
                            <span class="info-label">Duration</span>
                            <span class="info-value">{{ $course->duration }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        <div>
                            <span class="info-label">Reference</span>
                            <span class="info-value">{{ $course->ref_code }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                        </svg>
                        <div>
                            <span class="info-label">Level</span>
                            <span class="info-value">{{ $course->level ?? 'All Levels' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="course-detail-content">
                <span class="course-ref">{{ $course->ref_code }}</span>
                <h1 class="course-title">{{ $course->title }}</h1>
                
                <div class="course-description">
                    <h2>About This Course</h2>
                    <p>{{ $course->description }}</p>
                </div>

                @if($course->objectives)
                <div class="course-objectives">
                    <h2>What You'll Learn</h2>
                    <ul>
                        @foreach(explode("\n", $course->objectives) as $objective)
                            @if(trim($objective))
                            <li>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                {{ trim($objective) }}
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($course->requirements)
                <div class="course-requirements">
                    <h2>Requirements</h2>
                    <ul>
                        @foreach(explode("\n", $course->requirements) as $requirement)
                            @if(trim($requirement))
                            <li>{{ trim($requirement) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="course-actions">
                    <a href="{{ route('contact') }}?course={{ $course->ref_code }}" class="btn btn-primary">
                        Enroll Now
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-secondary">
                        Ask a Question
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection