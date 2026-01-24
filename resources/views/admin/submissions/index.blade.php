@extends('admin.layouts.app')

@section('title', 'Enrollment Submissions')

@section('content')
<div class="admin-header">
    <h1>Enrollment Submissions</h1>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
            <tr>
                <td>{{ $submission->id }}</td>
                <td>{{ $submission->first_name }} {{ $submission->last_name }}</td>
                <td>{{ $submission->email }}</td>
                <td>{{ $submission->phone }}</td>
                <td>{{ $submission->course ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.submissions.status', $submission->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()" class="status-select status-{{ $submission->status }}">
                            <option value="pending" {{ $submission->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="reviewed" {{ $submission->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="approved" {{ $submission->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </form>
                </td>
                <td>{{ $submission->created_at->format('M d, Y') }}</td>
                <td class="actions">
                    <form action="{{ route('admin.submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Delete this submission?')">
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