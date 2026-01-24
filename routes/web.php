<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Models\Course;
use App\Models\EnrollmentSubmission;
use App\Models\User;


Route::get('/', function () {
    $courses = Course::all();
    return view('home', compact('courses'));
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/courses', function () {
    $courses = \App\Models\Course::all();
    return view('courses.index', compact('courses'));
})->name('courses');

Route::get('/courses/search', function (\Illuminate\Http\Request $request) {
    $query = $request->input('q');
    
    $courses = \App\Models\Course::where('title', 'LIKE', "%{$query}%")
        ->orWhere('category', 'LIKE', "%{$query}%")
        ->orWhere('ref_code', 'LIKE', "%{$query}%")
        ->get();
    
    return view('courses.search', compact('courses', 'query'));
})->name('courses.search');

Route::get('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    return view('courses.show', compact('course'));
})->name('courses.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/enrollment', function () {
    return view('enrollment');
})->name('enrollment');

Route::post('/enrollment', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'hear_about' => 'nullable|string',
        'course' => 'nullable|string',
    ]);
    
    EnrollmentSubmission::create($validated);
    
    return redirect()->route('enrollment')->with('success', 'Enrollment submitted successfully!');
})->name('enrollment.submit');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // dashboard
    Route::get('/', function () {
        $stats = [
            'courses' => Course::count(),
            'users' => User::count(),
            'enrollments' => \DB::table('enrollments')->count(),
            'submissions' => EnrollmentSubmission::where('status', 'pending')->count(),
        ];
        return view('admin.layouts.dashboard', compact('stats'));
    })->name('dashboard');

    // courses
    Route::get('/courses', function (\Illuminate\Http\Request $request) {
        $query = $request->input('q');
        
        if ($query) {
            $courses = Course::where('title', 'LIKE', "%{$query}%")
                ->orWhere('ref_code', 'LIKE', "%{$query}%")
                ->orWhere('category', 'LIKE', "%{$query}%")
                ->get();
        } else {
            $courses = Course::all();
        }
        
        return view('admin.courses.index', compact('courses', 'query'));
    })->name('courses.index');


    Route::get('/courses/create', function () {
        return view('admin.courses.create');
    })->name('courses.create');

    Route::post('/courses', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ref_code' => 'required|string|max:50',
            'category' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|string',
            'thumbnail' => 'nullable|string',
            'level' => 'nullable|string',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);
        Course::create($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    })->name('courses.store');

    Route::get('/courses/{id}/edit', function ($id) {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    })->name('courses.edit');

    Route::put('/courses/{id}', function (\Illuminate\Http\Request $request, $id) {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ref_code' => 'required|string|max:50',
            'category' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|string',
            'thumbnail' => 'nullable|string',
            'level' => 'nullable|string',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);
        $course->update($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    })->name('courses.update');

    Route::delete('/courses/{id}', function ($id) {
        Course::findOrFail($id)->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    })->name('courses.destroy');


    // users
    Route::get('/users', function (\Illuminate\Http\Request $request) {
        $query = $request->input('q');
        
        if ($query) {
            $users = User::with('enrollments')
                ->where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->get();
        } else {
            $users = User::with('enrollments')->get();
        }
        
        return view('admin.users.index', compact('users', 'query'));
    })->name('users.index');

    Route::get('/users/{id}', function ($id) {
        $user = User::with('enrollments')->findOrFail($id);
        $courses = Course::all();
        return view('admin.users.show', compact('user', 'courses'));
    })->name('users.show');

    Route::post('/users/{id}/enroll', function (\Illuminate\Http\Request $request, $id) {
        $user = User::findOrFail($id);
        $user->enrollments()->attach($request->course_id);
        return redirect()->route('admin.users.show', $id)->with('success', 'Course assigned successfully.');
    })->name('users.enroll');

    Route::delete('/users/{userId}/unenroll/{courseId}', function ($userId, $courseId) {
        $user = User::findOrFail($userId);
        $user->enrollments()->detach($courseId);
        return redirect()->route('admin.users.show', $userId)->with('success', 'Course removed successfully.');
    })->name('users.unenroll');


    // enrollment submissions
    Route::get('/submissions', function () {
        $submissions = EnrollmentSubmission::orderBy('created_at', 'desc')->get();
        return view('admin.submissions.index', compact('submissions'));
    })->name('submissions.index');

    Route::put('/submissions/{id}/status', function (\Illuminate\Http\Request $request, $id) {
        $submission = EnrollmentSubmission::findOrFail($id);
        $submission->update(['status' => $request->status]);
        return redirect()->route('admin.submissions.index')->with('success', 'Status updated.');
    })->name('submissions.status');

    Route::delete('/submissions/{id}', function ($id) {
        EnrollmentSubmission::findOrFail($id)->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted.');
    })->name('submissions.destroy');
});



require __DIR__.'/auth.php';