<div class="course-detail-media">
    <div class="course-image-wrapper">
        <img src="{{ asset('images/courses/' . $course->thumbnail) }}" alt="{{ $course->title }}">
        <span class="course-category-badge">{{ $course->category }}</span>
    </div>

    <div class="course-quick-info">
        <div class="info-item">
            <img src="{{ asset('images/clock.png') }}" alt="" class="info-icon">
            <div>
                <span class="info-label">Duration</span>
                <span class="info-value">{{ $course->duration }}</span>
            </div>
        </div>
        <div class="info-item">
            <img src="{{ asset('images/book.png') }}" alt="" class="info-icon">
            <div>
                <span class="info-label">Reference</span>
                <span class="info-value">{{ $course->ref_code }}</span>
            </div>
        </div>
        <div class="info-item">
            <img src="{{ asset('images/graduation.png') }}" alt="" class="info-icon">
            <div>
                <span class="info-label">Level</span>
                <span class="info-value">{{ $course->level ?? 'All Levels' }}</span>
            </div>
        </div>
    </div>
</div>