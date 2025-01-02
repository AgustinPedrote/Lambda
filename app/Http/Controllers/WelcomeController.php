<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $courses = Course::take(8)
        ->latest('id')
        ->get();

        return view('welcome', compact('courses'));
    }
}
