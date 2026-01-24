@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<div class="admin-header">
    <h1>{{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Back</a>
</div>

<div class="user-details">
    <div class="detail-card">
        <h3>User Information</h3>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
        <p><strong>Admin:</strong> {{ $user->is_admin ? 'Yes' : 'No' }}</p>
    </div>

    <div class="detail-card">
        <h3>Assign Course</h3>
        <form action="{{ route('admin.users.enroll', $user->id) }}" method="POST" class="inline-form">
            @csrf
            <select name="course_id" required>
                <option value="">Select Course</option>
                @foreach($courses as $course)
                    @if(!$user->enrollments->contains($course->id))
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Assign</button>
        </form>
    </div>
</div>

<div class="admin-table-wrapper">
    <h3>Enrolled Courses</h3>
    @if($user->enrollments->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Ref Code</th>
                <th>Enrolled At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->enrollments as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->ref_code }}</td>
                <td>{{ $course->pivot->created_at->format('M d, Y') }}</td>
                <td class="actions">
                    <form action="{{ route('admin.users.unenroll', [$user->id, $course->id]) }}" method="POST" onsubmit="return confirm('Remove this course?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="no-data">No courses enrolled.</p>
    @endif
</div>
@endsection