<?php

namespace App\Policies\Trident;

use App\User;
use App\Trident\Workflows\Repositories\ViewRepository as View;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create trident view.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the trident view.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ViewRepository  $View
     * @return mixed
     */
    public function view(User $user, View $View, int $id)
    {
        return $user->id == $View->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can create trident view.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the trident view.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ViewRepository  $View
     * @return mixed
     */
    public function update(User $user, View $View, int $id)
    {
        return $user->id == $View->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can delete the trident view.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ViewRepository  $View
     * @return mixed
     */
    public function delete(User $user, View $View, int $id)
    {
        return $user->id == $View->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can restore the trident view.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ViewRepository  $View
     * @return mixed
     */
    public function restore(User $user, View $View, int $id)
    {
        return $user->id == $View->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trident view.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ViewRepository  $View
     * @return mixed
     */
    public function forceDelete(User $user, View $View, int $id)
    {
        return $user->id == $View->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently generate the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\ViewRepository $View
     * @return mixed
     */
    public function generate(User $user, View $view, int $id)
    {
        return $user->id == $view->findOrFail($id)->user_id;
    }



}
