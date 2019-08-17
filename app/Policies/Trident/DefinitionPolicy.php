<?php

namespace App\Policies\Trident;

use App\User;
use App\Trident\Workflows\Repositories\DefinitionRepository as Definition;
use Illuminate\Auth\Access\HandlesAuthorization;

class DefinitionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create trident definition.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the trident definition.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\DefinitionRepository  $Definition
     * @return mixed
     */
    public function view(User $user, Definition $Definition, int $id)
    {
        return $user->id == $Definition->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can create trident definition.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the trident definition.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\DefinitionRepository  $Definition
     * @return mixed
     */
    public function update(User $user, Definition $Definition, int $id)
    {
        return $user->id == $Definition->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can delete the trident definition.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\DefinitionRepository  $Definition
     * @return mixed
     */
    public function delete(User $user, Definition $Definition, int $id)
    {
        return $user->id == $Definition->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can restore the trident definition.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\DefinitionRepository  $Definition
     * @return mixed
     */
    public function restore(User $user, Definition $Definition, int $id)
    {
        return $user->id == $Definition->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trident definition.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\DefinitionRepository  $Definition
     * @return mixed
     */
    public function forceDelete(User $user, Definition $Definition, int $id)
    {
        return $user->id == $Definition->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently get the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\DefinitionRepository $Definition
     * @return mixed
     */
    public function get(User $user, Definition $definition, int $id)
    {
        return $user->id == $definition->findOrFail($id)->user_id;
    }




    /**
     * Determine whether the user can permanently getDatabaseTables the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\DefinitionRepository $Definition
     * @return mixed
     */
    public function getDatabaseTables(User $user, Definition $definition, int $id)
    {
        return $user->id == $definition->findOrFail($id)->user_id;
    }



}
