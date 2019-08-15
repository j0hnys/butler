<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\DefinitionRepositoryInterface;
//use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class DefinitionRepository extends DbRepository implements DefinitionRepositoryInterface
{
    //use WorkflowTrait;
    
    // needed to select appropriate data source
    public function model()
    {
        return 'App\Models\Definition';
    }

}