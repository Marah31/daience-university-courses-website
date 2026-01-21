<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $courses = DB::table('courses')->get();
        return view('courses.index', compact('courses'));
    }
}
