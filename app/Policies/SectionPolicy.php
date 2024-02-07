<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Section;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the section can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the section can view the model.
     */
    public function view(User $user, Section $model): bool
    {
        return true;
    }

    /**
     * Determine whether the section can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the section can update the model.
     */
    public function update(User $user, Section $model): bool
    {
        return true;
    }

    /**
     * Determine whether the section can delete the model.
     */
    public function delete(User $user, Section $model): bool
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
     * Determine whether the section can restore the model.
     */
    public function restore(User $user, Section $model): bool
    {
        return false;
    }

    /**
     * Determine whether the section can permanently delete the model.
     */
    public function forceDelete(User $user, Section $model): bool
    {
        return false;
    }
}
