<?php

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    # De esta forma solo permitirá los valores referentes en CourseStatus.php
    protected $casts = [
        'status' => CourseStatus::class,
    ];

    # Relación uno a muchos (inversa)
    public function teacher(){
        return $this->belongsTo(User::class);
    }

    public function level(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(User::class);
    }

    public function price(){
        return $this->belongsTo(User::class);
    }
}
