<?php

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'status',
        'image_path',
        'video_path',
        'welcome_message',
        'goodbye_message',
        'observation',
        'user_id',
        'level_id',
        'category_id',
        'price_id',
        'published_at',
    ];

    # De esta forma solo permitirá los valores referentes en CourseStatus.php
    protected $casts = [
        'status' => CourseStatus::class,
        'published_at' => 'datetime',
    ];

    /* Utiliza el slug en la URI */
    public function getRouteKeyName():string
    {
        return 'slug';
    }

    # Accesor que te permite transformar un atributo de tu modelo al momento de acceder a él
    protected function image(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->image_path ? Storage::url($this->image_path) : asset('img/no-image.jpg');

                # Usar APP_URL para construir la URL correctamente
                return config('app.url') . '/storage/courses/images/' . basename($this->image_path);
            }
        );
    }

    protected function dateOfAcquisition(): Attribute
    {
        return new Attribute(
            get: function () {
                # Formatear un valor como si fuera una fecha
                return now()->parse(
                    DB::table('course_user')
                        ->where('course_id', $this->id)
                        ->where('user_id', auth()->id())
                        ->first()
                        ->created_at
                )->format('d/m/Y');
            }
        );
    }

    # Relación uno a muchos (inversa)
    public function teacher()
    {
        # Relación es 'teacher' y modelo es 'User', da conflicto por la FK así que se la especificamos
        return $this->belongsTo(User::class, 'user_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    # Relación uno a muchos
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    # Relación muchos a muchos
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')
            ->withTimestamps();
    }
}
