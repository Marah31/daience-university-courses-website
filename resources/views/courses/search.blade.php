@extends('layouts.app')

@section('title', 'Search Results - Daience University')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/courses-page.css') }}">
@endpush

@section('content')
<section class="courses-page">
    <div class="courses-page-header" id="courses-start">
        <h1>Search Results</h1>
        <p>
            @if($courses->count() > 0)
                Found {{ $courses->count() }} course(s) for "{{ $query }}"
            @else
                No courses found for "{{ $query }}"
            @endif
        </p>
    </div>

    @if($courses->count() > 0)
    <div class="category-section">
        <div class="courses-grid">
            @foreach ($courses as $course)
                <div class="course-card">
                    <div class="card-image">
                        <img
                            src="{{ asset('images/courses/' . $course->thumbnail) }}"
                            alt="{{ $course->title }}"
                            loading="lazy"
                        >
                        <span class="card-badge">{{ $course->duration }}</span>
                    </div>

                    <div class="card-content">
                        <span class="card-ref">{{ $course->ref_code }}</span>
                        <h3 class="card-title">{{ $course->title }}</h3>
                        <p class="card-description">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show', $course->id) }}" class="card-link">
                            Learn More
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="no-results">
        <p>Try searching for a different term or browse our courses.</p>
        <a href="{{ route('courses') }}" class="btn-browse">Browse All Courses</a>
    </div>
    @endif
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const target = document.getElementById('courses-start');
        if (target) {
            setTimeout(function() {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    });
</script>
@endsection