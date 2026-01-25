<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function store(Request $request)
    {
        try {
            // validation
            $rules = [
                'title' => 'required|string|max:255',
                'ref_code' => 'required|string|max:50',
                'category' => 'required|string',
                'description' => 'required|string',
                'duration' => 'required|string',
                'level' => 'nullable|string',
                'objectives' => 'nullable|string',
                'requirements' => 'nullable|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:51200', // 50MB
            ];

            $validated = $request->validate($rules);

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

                // save to public/images/courses
                $file->move(public_path('images/courses'), $filename);

                $validated['thumbnail'] = $filename;
                Log::info('File uploaded: ' . $validated['thumbnail']);
            }

            // save to database
            Course::create($validated);

            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');

        } catch (\Exception $e) {
            Log::error('Error creating course: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed: ' . $e->getMessage())->withInput();
        }
    }


    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ref_code' => 'required|string|max:50',
            'category' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|string',
            'level' => 'nullable|string',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:51200', // 50MB
        ]);

        $course->update($validated);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $destination = public_path('images/courses');

            if (!is_dir($destination)) mkdir($destination, 0777, true);

            if ($course->thumbnail && file_exists($destination . '/' . $course->thumbnail)) {
                unlink($destination . '/' . $course->thumbnail);
            }

            $file->move($destination, $filename);
            $course->thumbnail = $filename;
            $course->save();
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

}
