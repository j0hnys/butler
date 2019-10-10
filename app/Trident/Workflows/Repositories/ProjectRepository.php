<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\ProjectRepositoryInterface;

class ProjectRepository extends DbRepository implements ProjectRepositoryInterface
{    
    public function model()
    {
        return 'App\Models\Project';
    }
}