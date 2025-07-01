<?php
namespace App\Policies;

use App\Models\Division;
use App\Models\User;

class DivisionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage divisions');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Division $division): bool
    {
        return $user->hasPermissionTo('manage divisions');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage divisions');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Division $division): bool
    {
        return $user->hasPermissionTo('manage divisions');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Division $division): bool
    {
        return $user->hasPermissionTo('manage divisions');
    }
}
