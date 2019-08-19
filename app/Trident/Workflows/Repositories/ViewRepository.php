<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\ViewRepositoryInterface;
//use Brexis\LaravelWorkflow\Traits\WorkflowTrait;

class ViewRepository extends DbRepository implements ViewRepositoryInterface
{
    //use WorkflowTrait;
    
    // needed to select appropriate data source
    public function model()
    {
        return 'App\Models\View';
    }

}