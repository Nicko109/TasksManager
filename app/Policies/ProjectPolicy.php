<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $note): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $note): bool
    {


        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $note): bool
    {


        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $note): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $note): bool
    {
        if ($user->is_admin) {
            return true;
        }

        return false;
    }
}
