@extends('layouts.app')

@section('title', 'All Courses')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/courses-page.css') }}">
@endpush

@section('content')
@php
    use Illuminate\Support\Str;

    $categories = [
        'Cyber Security Courses' => 'Cyber Security Certificate Courses',
        'Data Science Certificate Courses' => 'Data Science Certificate Courses',
        'Language Certificate Courses' => 'Language Certificate Courses',
        'Business Certificate Courses' => 'Business Certificate Courses',
    ];
@endphp

<section class="courses-page">
    <div class="courses-page-header" id="courses-start">
        <h1>All Courses</h1>
        <p>Explore our comprehensive certification programs</p>
    </div>

    @foreach ($categories as $dbCategory => $title)
        @if($courses->where('category', $dbCategory)->count() > 0)
        <div class="category-section">
            <div class="category-heading">
                <h2>{{ $title }}</h2>
                <span class="course-count">{{ $courses->where('category', $dbCategory)->count() }} Courses</span>
            </div>

            <div class="courses-grid">
                @foreach ($courses->where('category', $dbCategory) as $course)
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
        @endif
    @endforeach
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