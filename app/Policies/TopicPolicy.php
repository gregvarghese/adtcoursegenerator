<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the topic can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the topic can view the model.
     */
    public function view(User $user, Topic $model): bool
    {
        return true;
    }

    /**
     * Determine whether the topic can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the topic can update the model.
     */
    public function update(User $user, Topic $model): bool
    {
        return true;
    }

    /**
     * Determine whether the topic can delete the model.
     */
    public function delete(User $user, Topic $model): bool
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
     * Determine whether the topic can restore the model.
     */
    public function restore(User $user, Topic $model): bool
    {
        return false;
    }

    /**
     * Determine whether the topic can permanently delete the model.
     */
    public function forceDelete(User $user, Topic $model): bool
    {
        return false;
    }
}
