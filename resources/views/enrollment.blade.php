@extends('layouts.app')

@section('title', 'Enrollment - Daience University')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/enrollment.css') }}">
@endpush

@section('content')
<section class="enrollment-section">
    <div class="enrollment-container">
        
        <div class="enrollment-grid">
            <div class="enrollment-form-wrapper">
                <div class="form-header">
                    <h1>Enroll Now</h1>
                    <p>Start your journey with Daience University</p>
                </div>

                <form action="{{ route('enrollment.submit') }}" method="POST" class="enrollment-form">
                    @csrf
                    @if(request('course'))
                        <div class="selected-course">
                            <span>Enrolling for:</span>
                            <strong>{{ request('course') }}</strong>
                        </div>
                        <input type="hidden" name="course" value="{{ request('course') }}">
                    @endif
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="hear_about">How did you hear about us?</label>
                        <select id="hear_about" name="hear_about" required>
                            <option value="" disabled selected>Select an option</option>
                            <option value="google">Google Search</option>
                            <option value="social_media">Social Media</option>
                            <option value="friend">Friend or Family</option>
                            <option value="advertisement">Advertisement</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">Submit Enrollment</button>
                </form>
            </div>

            <!-- Fees Column -->
            <div class="fees-wrapper">
                <div class="fees-card">
                    <h2>Course Fees</h2>
                    <p class="fees-subtitle">All Certificate and Professional Development/Seminar Courses</p>

                    <ul class="fees-list">
                        <li>
                            <span class="fee-label">Registration Fee</span>
                            <span class="fee-amount">$50</span>
                        </li>
                        <li>
                            <span class="fee-label">Tuition</span>
                            <span class="fee-amount">$150</span>
                        </li>
                        <li>
                            <span class="fee-label">Books & Materials Fee</span>
                            <span class="fee-amount">$100</span>
                        </li>
                        <li>
                            <span class="fee-label">Certification Exam</span>
                            <span class="fee-amount">$200</span>
                        </li>
                    </ul>

                    <div class="fees-total">
                        <span class="total-label">Total Cost</span>
                        <span class="total-amount">$500 <small>USD</small></span>
                    </div>

                    <p class="fees-note">Payment details will be provided after enrollment submission.</p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection