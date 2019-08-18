<?php

namespace App\Policies\Trident;

use App\User;
use App\Trident\Workflows\Repositories\EntityRepository as Entity;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create trident entity.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the trident entity.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\EntityRepository  $Entity
     * @return mixed
     */
    public function view(User $user, Entity $Entity, int $id)
    {
        return $user->id == $Entity->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can create trident entity.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the trident entity.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\EntityRepository  $Entity
     * @return mixed
     */
    public function update(User $user, Entity $Entity, int $id)
    {
        return $user->id == $Entity->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can delete the trident entity.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\EntityRepository  $Entity
     * @return mixed
     */
    public function delete(User $user, Entity $Entity, int $id)
    {
        return $user->id == $Entity->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can restore the trident entity.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\EntityRepository  $Entity
     * @return mixed
     */
    public function restore(User $user, Entity $Entity, int $id)
    {
        return $user->id == $Entity->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trident entity.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\EntityRepository  $Entity
     * @return mixed
     */
    public function forceDelete(User $user, Entity $Entity, int $id)
    {
        return $user->id == $Entity->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently generate the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\EntityRepository $Entity
     * @return mixed
     */
    public function generate(User $user, Entity $entity, int $id)
    {
        return $user->id == $entity->findOrFail($id)->user_id;
    }



}
