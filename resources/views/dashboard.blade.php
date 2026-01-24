@extends('layouts.app')

@section('title', 'My Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<section class="dashboard-section">
    <div class="dashboard-container">
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="dashboard-header">
            <h1>Welcome, {{ $user->name }}</h1>
            <p>Manage your profile and enrolled courses</p>
        </div>

        <div class="dashboard-grid">
            <div class="profile-card">
                <div class="card-header">
                    <h2>My Profile</h2>
                    <button type="button" class="btn-edit-profile" onclick="toggleEditForm()">Edit</button>
                </div>
                <div class="card-body">
                    <div id="profile-view" class="profile-view">
                        <div class="profile-avatar">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="profile-info">
                            <div class="info-row">
                                <span class="info-label">Name</span>
                                <span class="info-value">{{ $user->name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $user->email }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Member Since</span>
                                <span class="info-value">{{ $user->created_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <form id="profile-edit" class="profile-edit" action="{{ route('profile.update.info') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        @method('PUT')
                        
                        <div class="edit-avatar-section">
                            <div class="current-avatar">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" id="avatar-preview">
                                @else
                                    <div class="avatar-placeholder" id="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <img src="/placeholder.svg" alt="" id="avatar-preview" style="display: none;">
                                @endif
                            </div>
                            <div class="avatar-upload">
                                <label for="avatar" class="btn-upload">Choose Image</label>
                                <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                                <span class="upload-hint">JPG, JPEG or PNG. Max 2MB.</span>
                            </div>
                        </div>

                        <div class="edit-form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div class="edit-form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $user->email }}" disabled>
                            <span class="input-hint">Email cannot be changed</span>
                        </div>

                        <div class="edit-actions">
                            <button type="button" class="btn-cancel" onclick="toggleEditForm()">Cancel</button>
                            <button type="submit" class="btn-save">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="courses-card">
                <div class="card-header">
                    <h2>My Courses</h2>
                    <span class="course-count">{{ $enrolledCourses->count() }} Enrolled</span>
                </div>
                <div class="card-body">
                    @if($enrolledCourses->count() > 0)
                        <div class="enrolled-courses-list">
                            @foreach($enrolledCourses as $course)
                                <div class="enrolled-course-item">
                                    <div class="course-thumbnail">
                                        <img src="{{ asset('storage/courses/' . $course->thumbnail) }}" alt="{{ $course->title }}" onerror="this.src='{{ asset('images/courses/' . $course->thumbnail) }}'">
                                    </div>
                                    <div class="course-info">
                                        <span class="course-ref">{{ $course->ref_code }}</span>
                                        <h3 class="course-title">{{ $course->title }}</h3>
                                        <span class="course-category">{{ $course->category }}</span>
                                    </div>
                                    <div class="course-status">
                                        <span class="status-badge status-{{ $course->pivot->status }}">
                                            {{ ucfirst($course->pivot->status) }}
                                        </span>
                                    </div>
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn-view-course">View</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-courses">
                            <p>You are not enrolled in any courses yet.</p>
                            <a href="{{ route('courses') }}" class="btn-browse">Browse Courses</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

<script>
function toggleEditForm() {
    const viewMode = document.getElementById('profile-view');
    const editMode = document.getElementById('profile-edit');
    
    if (editMode.style.display === 'none') {
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
    } else {
        viewMode.style.display = 'flex';
        editMode.style.display = 'none';
    }
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const preview = document.getElementById('avatar-preview');
        const placeholder = document.getElementById('avatar-placeholder');
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection