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
                    <img src="{{ asset('images/check.png') }}" alt="" class="list-icon">
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
            <img src="{{ asset('images/arrow-right.png') }}" alt="" class="btn-icon">
        </a>
        <a href="{{ route('contact') }}" class="btn btn-secondary">
            Ask a Question
        </a>
    </div>
</div>