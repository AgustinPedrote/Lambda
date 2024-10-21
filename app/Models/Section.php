<?php

namespace App\Models;

use App\Observers\SectionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([SectionObserver::class])]
class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'course_id', 'position'];

    # Relación uno a muchos inversa
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

