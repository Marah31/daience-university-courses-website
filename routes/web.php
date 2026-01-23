<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Models\Course;

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
    // for now, just redirect back with success, later save to database
    return redirect()->route('enrollment')->with('success', 'Enrollment submitted successfully!');
})->name('enrollment.submit');

require __DIR__.'/auth.php';