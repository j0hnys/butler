<?php

namespace App\Policies\Trident;

use App\User;
use App\Trident\Workflows\Repositories\ProjectRepository as Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create trident project.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return \Auth::check();
    }

    /**
     * Determine whether the user can view the trident project.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ProjectRepository  $Project
     * @return mixed
     */
    public function view(User $user, Project $Project, int $id)
    {
        return $user->id == $Project->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can create trident project.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return \Auth::check();
    }

    /**
     * Determine whether the user can update the trident project.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ProjectRepository  $Project
     * @return mixed
     */
    public function update(User $user, Project $Project, int $id)
    {
        return $user->id == $Project->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can delete the trident project.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ProjectRepository  $Project
     * @return mixed
     */
    public function delete(User $user, Project $Project, int $id)
    {
        return $user->id == $Project->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can restore the trident project.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ProjectRepository  $Project
     * @return mixed
     */
    public function restore(User $user, Project $Project, int $id)
    {
        return $user->id == $Project->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trident project.
     *
     * @param  \App\User  $user
     * @param  \App\Trident\Workflows\Repositories\ProjectRepository  $Project
     * @return mixed
     */
    public function forceDelete(User $user, Project $Project, int $id)
    {
        return $user->id == $Project->findOrFail($id)->user_id;
    }

    /**
     * Determine whether the user can permanently getWithDefinitions the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\ProjectRepository $Project
     * @return mixed
     */
    public function getWithDefinitions(User $user, Project $project)
    {
        return \Auth::check();
    }




    /**
     * Determine whether the user can permanently getWithDefinitionsEntities the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\ProjectRepository $Project
     * @return mixed
     */
    public function getWithDefinitionsEntities(User $user, Project $project)
    {
        return \Auth::check();
    }




    /**
     * Determine whether the user can permanently make the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\ProjectRepository $Project
     * @return mixed
     */
    public function make(User $user, Project $project, int $id)
    {
        return $user->id == $project->findOrFail($id)->user_id;
    }




    /**
     * Determine whether the user can permanently getWithDefinitionsEntitiesTests the trident super_test.
     *
     * @param  \App\User  $user
     * @param  App\Trident\Workflows\Repositories\ProjectRepository $Project
     * @return mixed
     */
    public function getWithDefinitionsEntitiesTests(User $user, Project $project)
    {
        return \Auth::check();
    }



}
