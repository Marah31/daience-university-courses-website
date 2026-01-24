@extends('admin.layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="admin-header">
    <h1>Users</h1>
    <div class="header-actions">
        <form action="{{ route('admin.users.index') }}" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Search users..." value="{{ $query ?? '' }}">
            <button type="submit">Search</button>
        </form>
    </div>
</div>

@if(isset($query) && $query)
    <p class="search-results-info">Showing results for "{{ $query }}" <a href="{{ route('admin.users.index') }}">Clear</a></p>
@endif

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Enrolled Courses</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->enrollments->count() }}</td>
                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                <td class="actions">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn-view">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection