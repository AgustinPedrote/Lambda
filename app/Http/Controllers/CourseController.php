<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('courses.index');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function status()
    {
        return view('courses.status');
    }
}
