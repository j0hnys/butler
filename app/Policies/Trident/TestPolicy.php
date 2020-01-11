<?php

namespace App\Policies\Trident;

use App\User;
use App\Trident\Workflows\Repositories\TestRepository as Test;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create trident test.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return \Auth::check();
    }

    /**
     * Determine whether the user can view the trident test.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\TestRepository  $Test
     * @return mixed
     */
    public function view(User $user, Test $Test, int $id)
    {
        return $user->id == $Test->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can create trident test.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return \Auth::check();
    }

    /**
     * Determine whether the user can update the trident test.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\TestRepository  $Test
     * @return mixed
     */
    public function update(User $user, Test $Test, int $id)
    {
        return $user->id == $Test->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can delete the trident test.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\TestRepository  $Test
     * @return mixed
     */
    public function delete(User $user, Test $Test, int $id)
    {
        return $user->id == $Test->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can restore the trident test.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\TestRepository  $Test
     * @return mixed
     */
    public function restore(User $user, Test $Test, int $id)
    {
        return $user->id == $Test->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trident test.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\TestRepository  $Test
     * @return mixed
     */
    public function forceDelete(User $user, Test $Test, int $id)
    {
        return $user->id == $Test->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently generate the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\TestRepository $Test
     * @return mixed
     */
    public function generate(User $user, Test $test, int $id)
    {
        return $user->id == $test->findOrFail($id)->user_id;
    }



}
