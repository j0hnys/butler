<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\ProjectRepositoryInterface;
//use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class ProjectRepository extends DbRepository implements ProjectRepositoryInterface
{
    //use WorkflowTrait;
    
    // needed to select appropriate data source
    public function model()
    {
        return 'App\Models\Project';
    }

}