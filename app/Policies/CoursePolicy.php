<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the course can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the course can view the model.
     */
    public function view(User $user, Course $model): bool
    {
        return true;
    }

    /**
     * Determine whether the course can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the course can update the model.
     */
    public function update(User $user, Course $model): bool
    {
        return true;
    }

    /**
     * Determine whether the course can delete the model.
     */
    public function delete(User $user, Course $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the course can restore the model.
     */
    public function restore(User $user, Course $model): bool
    {
        return false;
    }

    /**
     * Determine whether the course can permanently delete the model.
     */
    public function forceDelete(User $user, Course $model): bool
    {
        return false;
    }
}
