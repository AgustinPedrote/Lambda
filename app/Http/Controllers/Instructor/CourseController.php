<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Level;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('user_id', auth()->id())->get();

        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $levels = Level::all();
        $prices = Price::all();

        return view('instructor.courses.create', compact('categories', 'levels', 'prices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* return $request->all(); */ # Comprobación que los inputs mandan la información correcta

        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses',
            'category_id' => 'required|exists:categories,id',
            'level_id' => 'required|exists:levels,id',
            'price_id' => 'required|exists:prices,id',
        ]);

        $data['user_id'] = auth()->id();

        $course = Course::create($data);

        return redirect()->route('instructor.courses.edit', $course);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        $levels = Level::all();
        $prices = Price::all();

        return view('instructor.courses.edit', compact('course', 'categories', 'levels', 'prices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        /* return $request->all(); */

        $data = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:courses,slug, ' . $course->id, /* No cuenta este registro en la verificación */
            'summary' => 'nullable|max:1000',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
            'level_id' => 'required|exists:levels,id',
            'price_id' => 'required|exists:prices,id',
        ]);

        if ($request->hasFile('image')) {
            // Si ya existe una imagen, la borramos
            if ($course->image_path) {
                Storage::delete($course->image_path);
            }

            // Guardamos la nueva imagen en el disco 'public' y almacenamos la ruta
            $data['image_path'] = Storage::put('courses/images', $request->file('image'));
        }

        $course->update($data);

        session()->flash('flash.banner', 'El curso se actualizó con exito'); // Variable de sesión de components/banner

        return redirect()->route('instructor.courses.edit', $course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }

    public function video(Course $course)
    {
        return view('instructor.courses.video', compact('course'));
    }

    public function uploadVideo(Request $request, Course $course)
    {
        $request->validate([
            'video' => 'required|file'
        ]);

        // Si ya existe un video, lo borramos
        if ($course->video_path) {
            Storage::delete($course->video_path);
        }

        // Guardamos el nuevo video y almacenamos la ruta
        $course->video_path = $request->file('video')->store('courses/promotional-videos');
        $course->save();

        return redirect()->route('instructor.courses.video', $course)->with('success', 'Video subido exitosamente.');
    }

    public function goals(Course $course)
    {
        return view('instructor.courses.goals', compact('course'));
    }
}
