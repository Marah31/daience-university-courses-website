@php use Illuminate\Support\Str; @endphp

<div class="course-card">
    <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}">
    <div class="card-content">
        <h3>{{ $course->title }}</h3>
        <p class="meta">
            <span>{{ $course->ref_code }}</span> •
            <span>{{ $course->duration }}</span>
        </p>
        <p class="description">
            {{ Str::limit($course->description, 100) }}
        </p>
    </div>
</div>
