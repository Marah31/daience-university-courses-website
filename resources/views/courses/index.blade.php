@php
    use Illuminate\Support\Str;

    $categories = [
        'Cyber Security Courses' => 'Cyber Security Certificate Courses',
        'Data Science Certificate Courses' => 'Data Science Certificate Courses',
        'Language Certificate Courses' => 'Language Certificate Courses',
        'Business Certificate Courses' => 'Business Certificate Courses',
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IT Certificates - Online Courses</title>
    <link rel="stylesheet" href="{{ asset('css/courses.css') }}">
</head>
<body>

<div class="container">

    @foreach ($categories as $dbCategory => $title)
        <h1>{{ $title }}</h1>

        <div class="courses-grid">
            @foreach ($courses->where('category', $dbCategory) as $course)
                <div class="course-card">

                    <img
                        src="{{ asset('images/courses/' . $course->thumbnail) }}"
                        alt="{{ $course->title }}"
                    >

                    <div class="card-content">
                        <h3>{{ $course->title }}</h3>

                        <p class="meta">
                            <span>{{ $course->ref_code }}</span> •
                            <span>{{ $course->duration }}</span>
                        </p>

                        <p class="description">
                            {{ Str::limit($course->description, 120) }}
                        </p>
                    </div>

                </div>
            @endforeach
        </div>
    @endforeach

</div>

</body>
</html>
