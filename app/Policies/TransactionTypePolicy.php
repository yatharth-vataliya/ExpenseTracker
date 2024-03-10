<?php

namespace App\Policies;

use App\Models\TransactionType;
use App\Models\User;

class TransactionTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TransactionType $transactionType): bool
    {
        return $user->id === $transactionType->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TransactionType $transactionType): bool
    {
        return $user->id === $transactionType->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TransactionType $transactionType): bool
    {
        return $user->id === $transactionType->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TransactionType $transactionType): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TransactionType $transactionType): bool
    {
        //
    }
}
