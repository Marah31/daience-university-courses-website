@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <h1>Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-number">{{ $stats['courses'] }}</span>
        <span class="stat-label">Total Courses</span>
    </div>
    <div class="stat-card">
        <span class="stat-number">{{ $stats['users'] }}</span>
        <span class="stat-label">Total Users</span>
    </div>
    <div class="stat-card">
        <span class="stat-number">{{ $stats['enrollments'] }}</span>
        <span class="stat-label">Active Enrollments</span>
    </div>
    <div class="stat-card highlight">
        <span class="stat-number">{{ $stats['submissions'] }}</span>
        <span class="stat-label">Pending Submissions</span>
    </div>
</div>
@endsection