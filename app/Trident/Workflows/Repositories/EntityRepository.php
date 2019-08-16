<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\EntityRepositoryInterface;
//use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class EntityRepository extends DbRepository implements EntityRepositoryInterface
{
    //use WorkflowTrait;
    
    // needed to select appropriate data source
    public function model()
    {
        return 'App\Models\Entity';
    }

}