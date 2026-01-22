@php
    use Illuminate\Support\Str;

    $categories = [
        'Cyber Security Courses' => 'Cyber Security Certificate Courses',
        'Data Science Certificate Courses' => 'Data Science Certificate Courses',
        'Language Certificate Courses' => 'Language Certificate Courses',
        'Business Certificate Courses' => 'Business Certificate Courses',
    ];
@endphp

<section class="courses-section" id="courses">
    @foreach ($categories as $dbCategory => $title)
        <div class="category-block">
            <div class="category-header">
                <div class="category-title-wrapper">    
                    <h2 class="category-title">{{ $title }}</h2>
                    <span class="category-count">{{ $courses->where('category', $dbCategory)->count() }} Courses</span>
                </div>
                <div class="slider-controls">
                        <button class="slider-btn slider-prev" data-category="{{ Str::slug($dbCategory) }}" aria-label="Previous">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button class="slider-btn slider-next" data-category="{{ Str::slug($dbCategory) }}" aria-label="Next">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                </div>
            </div>

            <div class="course-slider-wrapper">
                <div class="courses-slider" id="slider-{{ Str::slug($dbCategory) }}">
                    @foreach ($courses->where('category', $dbCategory) as $course)
                        <div class="course-card">
                            <div class="card-image" >
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
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @endforeach
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.courses-slider');
    
    sliders.forEach(slider => {
        const categoryId = slider.id;
        const prevBtn = document.querySelector(`.slider-prev[data-category="${categoryId.replace('slider-', '')}"]`);
        const nextBtn = document.querySelector(`.slider-next[data-category="${categoryId.replace('slider-', '')}"]`);
        
        const cardWidth = 340; 
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -cardWidth, behavior: 'smooth' });
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
            });
        }
    });
});
</script>