<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /* Solo se evalua si esta autenticado */
    public function enrolled(User $user, Course $course)
    {
        return $user->courses_enrolled->contains($course);
    }
}
