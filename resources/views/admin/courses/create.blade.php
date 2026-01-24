@extends('admin.layouts.app')

@section('title', 'Add Course')

@section('content')
<div class="admin-header">
    <h1>Add New Course</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Back</a>
</div>

<div class="admin-form-wrapper">
    <form action="{{ route('admin.courses.store') }}" method="POST" class="admin-form">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label for="title">Course Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="ref_code">Reference Code</label>
                <input type="text" id="ref_code" name="ref_code" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="Cyber Security Courses">Cyber Security Courses</option>
                    <option value="Data Science Certificate Courses">Data Science Certificate Courses</option>
                    <option value="Language Certificate Courses">Language Certificate Courses</option>
                    <option value="Business Certificate Courses">Business Certificate Courses</option>
                </select>
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" id="duration" name="duration" placeholder="e.g. 8 weeks" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="level">Level</label>
                <input type="text" id="level" name="level" placeholder="e.g. Beginner">
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail Filename</label>
                <input type="text" id="thumbnail" name="thumbnail" placeholder="e.g. course-image.jpg">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="objectives">Objectives (one per line)</label>
            <textarea id="objectives" name="objectives" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label for="requirements">Requirements (one per line)</label>
            <textarea id="requirements" name="requirements" rows="4"></textarea>
        </div>

        <button type="submit" class="btn-primary">Create Course</button>
    </form>
</div>
@endsection