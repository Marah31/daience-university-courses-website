<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\EnrollmentSubmission;
use App\Models\User;



// public routes
///////////////////////////////////////////////////////////

Route::get('/', function () {
    $courses = Course::all();
    return view('home', compact('courses'));
})->name('home');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// course routes
////////////////////////////////////////////////////////////////


Route::get('/courses', function () {
    $courses = Course::all();
    return view('courses.index', compact('courses'));
})->name('courses');

Route::get('/courses/search', function (Request $request) {
    $query = $request->input('q');
    
    $courses = Course::where('title', 'LIKE', "%{$query}%")
        ->orWhere('category', 'LIKE', "%{$query}%")
        ->orWhere('ref_code', 'LIKE', "%{$query}%")
        ->get();
    
    return view('courses.search', compact('courses', 'query'));
})->name('courses.search');

Route::get('/courses/{id}', function ($id) {
    $course = Course::findOrFail($id);
    return view('courses.show', compact('course'));
})->name('courses.show');


// enrollment routes for users non registered 
///////////////////////////////////////////////////


Route::get('/enrollment', function () {
    return view('enrollment');
})->name('enrollment');

Route::post('/enrollment', function (Request $request) {
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'hear_about' => 'nullable|string',
        'course_id' => 'required|exists:courses,id'
    ]);
    
    EnrollmentSubmission::create($validated);
    
    if (auth()->check()) {
        $user = User::find(auth()->id());
        
        if (!$user->enrollments()->where('course_id', $validated['course_id'])->exists()) {
            $user->enrollments()->attach($validated['course_id'], ['status' => 'active']);
        }
    }
    
    return redirect()->route('enrollment')->with('success', 'Enrollment submitted successfully!');
})->name('enrollment.submit');


// authenticated user routes
/////////////////////////////////////////////////////////


Route::middleware(['auth', 'verified'])->group(function () {
    
    // profile page
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $enrolledCourses = $user->enrollments;
        return view('dashboard', compact('user', 'enrolledCourses'));
    })->name('dashboard');
    
    // profile breez controller
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // profile info update
    Route::put('/profile/update', function (Request $request) {
        $user = User::find(auth()->id());
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $user->name = $validated['name'];
        
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        
        $user->save();
        
        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    })->name('profile.update.info');
});


// admin routes
///////////////////////////////////////////////////////


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    

    // admin dashboard
    ////////////////////////////////////////////////
    
    Route::get('/', function () {
        $stats = [
            'courses' => Course::count(),
            'users' => User::count(),
            'enrollments' => \DB::table('enrollments')->count(),
            'submissions' => EnrollmentSubmission::where('status', 'pending')->count(),
        ];
        return view('admin.layouts.dashboard', compact('stats'));
    })->name('dashboard');


    // admin courses management
    //////////////////////////////////////////


    Route::get('/courses', function (Request $request) {
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

   Route::post('/courses', function (Request $request) {
        // Debug: Log all input
        \Log::info('Course creation attempt', $request->all());
        
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'ref_code' => 'required|string|max:50',
                'category' => 'required|string',
                'description' => 'required|string',
                'duration' => 'required|string',
                'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'level' => 'nullable|string',
                'objectives' => 'nullable|string',
                'requirements' => 'nullable|string',
            ]);
            
            \Log::info('Validation passed', $validated);
            
            // unset($validated['thumbnail']);
    
            // if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            //     $file = $request->file('thumbnail');
            //     $filename = time() . '_' . $file->getClientOriginalName();
                
            //     // Store directly in public folder instead of storage
            //     $file->move(public_path('uploads/courses'), $filename);
            //     $validated['thumbnail'] = 'uploads/courses/' . $filename;
            // }
            unset($validated['thumbnail']);

            if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                
                $destinationPath = public_path('uploads/courses');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                $file->move($destinationPath, $filename);
                $validated['thumbnail'] = 'uploads/courses/' . $filename;
            }


            $course = Course::create($validated);
            \Log::info('Course created with ID: ' . $course->id);
            
            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Course creation failed: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed: ' . $e->getMessage())->withInput();
        }
    })->name('courses.store');

    Route::get('/courses/{id}/edit', function ($id) {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    })->name('courses.edit');

    Route::put('/courses/{id}', function (Request $request, $id) {
        $course = Course::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ref_code' => 'required|string|max:50',
            'category' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'level' => 'nullable|string',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                \Storage::disk('public')->delete($course->thumbnail);
            }
            $path = $request->file('thumbnail')->store('courses', 'public');
            $validated['thumbnail'] = $path;
        } else {
            unset($validated['thumbnail']);
        }
        
        $course->update($validated);
        
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    })->name('courses.update');

    Route::delete('/courses/{id}', function ($id) {
        $course = Course::findOrFail($id);
        
        if ($course->thumbnail) {
            \Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();
        
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    })->name('courses.destroy');


    // admin users management
    ////////////////////////////////////////////////////////
    
    Route::get('/users', function (Request $request) {
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

    Route::post('/users/{id}/enroll', function (Request $request, $id) {
        $user = User::findOrFail($id);
        $user->enrollments()->attach($request->course_id, ['status' => 'active']);
        return redirect()->route('admin.users.show', $id)->with('success', 'Course assigned successfully.');
    })->name('users.enroll');

    Route::delete('/users/{userId}/unenroll/{courseId}', function ($userId, $courseId) {
        $user = User::findOrFail($userId);
        $user->enrollments()->detach($courseId);
        return redirect()->route('admin.users.show', $userId)->with('success', 'Course removed successfully.');
    })->name('users.unenroll');

    Route::put('/users/{userId}/enrollment/{courseId}/status', function (Request $request, $userId, $courseId) {
        $user = User::findOrFail($userId);
        $newStatus = $request->status; // 'active' or 'suspended'
        
        $user->enrollments()->updateExistingPivot($courseId, ['status' => $newStatus]);
        
        return redirect()->route('admin.users.show', $userId)->with('success', 'Enrollment status updated.');
    })->name('users.enrollment.status');


    // admin enrollment submissions
    ///////////////////////////////////////////////
    
    Route::get('/submissions', function () {
        $submissions = EnrollmentSubmission::orderBy('created_at', 'desc')->get();
        return view('admin.submissions.index', compact('submissions'));
    })->name('submissions.index');

    Route::put('/submissions/{id}/status', function (Request $request, $id) {
        $submission = EnrollmentSubmission::findOrFail($id);

        if ($request->status === 'approved') {
            $user = User::where('email', $submission->email)->first();

            if ($user && $submission->course_id) {
                $user->enrollments()->syncWithoutDetaching([
                    $submission->course_id => ['status' => 'active']
                ]);
            }
        }

        $submission->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated.');
    })->name('submissions.status');

    Route::delete('/submissions/{id}', function ($id) {
        EnrollmentSubmission::findOrFail($id)->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted.');
    })->name('submissions.destroy');
});

require __DIR__.'/auth.php';