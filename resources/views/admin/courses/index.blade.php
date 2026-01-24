@extends('admin.layouts.app')

@section('title', 'Manage Courses')

@section('content')
<div class="admin-header">
    <h1>Courses</h1>
    <div class="header-actions">
        <form action="{{ route('admin.courses.index') }}" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Search courses..." value="{{ $query ?? '' }}">
            <button type="submit">Search</button>
        </form>
        <a href="{{ route('admin.courses.create') }}" class="btn-primary">Add Course</a>
    </div>
</div>


@if(isset($query) && $query)
    <p class="search-results-info">Showing results for "{{ $query }}" <a href="{{ route('admin.courses.index') }}">Clear</a></p>
@endif


<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Ref Code</th>
                <th>Category</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->ref_code }}</td>
                <td>{{ $course->category }}</td>
                <td>{{ $course->duration }}</td>
                <td class="actions">
                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn-edit">Edit</a>
                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection