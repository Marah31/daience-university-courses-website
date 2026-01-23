@extends('layouts.app')

@section('title', $course->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/course-detail.css') }}">
@endpush

@section('content')
<section class="course-detail-section">
    <div class="course-detail-container">
        
        <a href="{{ route('home') }}#courses" class="back-link">
            <img src="{{ asset('images/arrow-left.png') }}" alt="" class="back-icon">
            Back to Courses
        </a>

        <div class="course-detail-grid">
            @include('courses.partials.sidebar')
            @include('courses.partials.content')
        </div>
        
    </div>
</section>
@endsection