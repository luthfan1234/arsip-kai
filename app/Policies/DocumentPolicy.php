<?php
namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view documents');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('view documents');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create documents');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('edit documents') ||
               ($user->hasPermissionTo('create documents') && $document->uploaded_by === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('delete documents') ||
               ($user->hasPermissionTo('create documents') && $document->uploaded_by === $user->id);
    }

    /**
     * Determine whether the user can download the model.
     */
    public function download(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('download documents');
    }
}
