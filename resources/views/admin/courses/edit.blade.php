@extends('admin.layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="admin-header">
    <h1>Edit Course</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Back</a>
</div>

<div class="admin-form-wrapper">
    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        
        <div class="form-row">
            <div class="form-group">
                <label for="title">Course Title</label>
                <input type="text" id="title" name="title" value="{{ $course->title }}" required>
            </div>
            <div class="form-group">
                <label for="ref_code">Reference Code</label>
                <input type="text" id="ref_code" name="ref_code" value="{{ $course->ref_code }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="Cyber Security Courses" {{ $course->category == 'Cyber Security Courses' ? 'selected' : '' }}>Cyber Security Courses</option>
                    <option value="Data Science Certificate Courses" {{ $course->category == 'Data Science Certificate Courses' ? 'selected' : '' }}>Data Science Certificate Courses</option>
                    <option value="Language Certificate Courses" {{ $course->category == 'Language Certificate Courses' ? 'selected' : '' }}>Language Certificate Courses</option>
                    <option value="Business Certificate Courses" {{ $course->category == 'Business Certificate Courses' ? 'selected' : '' }}>Business Certificate Courses</option>
                </select>
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" id="duration" name="duration" value="{{ $course->duration }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="level">Level</label>
                <input type="text" id="level" name="level" value="{{ $course->level }}">
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail Filename</label>
                <input type="text" id="thumbnail" name="thumbnail" value="{{ $course->thumbnail }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required>{{ $course->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="objectives">Objectives (one per line)</label>
            <textarea id="objectives" name="objectives" rows="4">{{ $course->objectives }}</textarea>
        </div>

        <div class="form-group">
            <label for="requirements">Requirements (one per line)</label>
            <textarea id="requirements" name="requirements" rows="4">{{ $course->requirements }}</textarea>
        </div>

        <button type="submit" class="btn-primary">Update Course</button>
    </form>
</div>
@endsection