<?php 

namespace App\Trident\Workflows\Repositories;

use App\Trident\Base\Repositories\DbRepository;
use App\Trident\Interfaces\Workflows\Repositories\DefinitionRepositoryInterface;

class DefinitionRepository extends DbRepository implements DefinitionRepositoryInterface
{    
    public function model()
    {
        return 'App\Models\Definition';
    }
}